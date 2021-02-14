<?php

namespace Oka6\DouApi\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Oka6\Admin\Http\Library\ResourceAdmin;
use Oka6\Admin\Library\MongoUtils;
use Oka6\Admin\Models\User;
use Oka6\DouApi\Models\DouCategory;
use Oka6\DouApi\Models\DouType;
use Oka6\DouApi\Models\Plan;
use Oka6\DouApi\Models\Subscription;
use Stripe\Stripe;
use Yajra\DataTables\DataTables;

class SubscriptionController extends DouApiController  {
	use ValidatesRequests;
	
	public function index(Request $request) {
		$user = Auth::user();
		if ($request->ajax()) {
			$query = Subscription::withUser($user);
			return DataTables::of($query)
				->addColumn('validate_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})->addColumn('created_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})->addColumn('updated_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})->addColumn('configure_url', function ($row) {
					return route('douapi.subscription.edit', [$row->_id]);
				})
				->toJson(true);
		}
		$hasSubscription = Subscription::withUser($user)->count();
		if(!$hasSubscription){
			return $this->create();
		}
		return $this->renderView('DouApi::backend.subscription.index');
	}
	
	public function create() {
		$data = Plan::getAllActives();
		return $this->renderView('DouApi::backend.subscription.plans', ['data' => $data]);
	}
	public function edit($id) {
		$user = Auth::user();
		$data = Subscription::getBy_id($id, $user->id);
		$plan = Plan::getBy_id($data->plan_id);
		return $this->renderView('DouApi::backend.subscription.edit', ['data' => $data, 'plan'=>$plan, 'user'=> $user]);
	}
	public function update(Request $request, $id) {
		$user       = Auth::user();
		$data       = Subscription::getBy_id($id, $user->id);
		$categories = DouCategory::getToSaveFilter($request->get('categories', []));
		$types      = DouType::getToSaveFilter($request->get('type', []));
		$filter = [
			'categories'    => $categories,
			'type'          => $types,
			'subject'       => $request->get('subject', []),
			'content'       => $request->get('content', []),
			'pub'           => $request->get('pub', []),
		];
		$data->api_notify   = $request->get('api_notify');
		$data->email_notify = $request->get('email_notify');
		$data->filter       = $filter;
		$data->configured   = 1;
		$data->save();
		toastr()->success("Assinatura atualizada com sucesso", 'Sucesso');
		return redirect(route('douapi.subscription.index'));
	}
	
	public function checkout($stripeId) {
		return $this->renderView('DouApi::backend.subscription.checkout', ['priceId' => $stripeId]);
	}
	public function cancel(Request $request) {
		$subscription = Subscription::getBySubscriptionId($request->get('subscription_id'));
		if(!$subscription){
			if ($request->ajax()) {
				return response()->json(['message' => 'Assinatura nao encontrada', 'error'=>500], 500);
			}
			toastr()->error("Assinatura não encontrada", 'Error');
			return redirect(route('douapi.subscription.index'));
		}
		if($subscription->status != 1){
			if ($request->ajax()) {
				return response()->json(['message' => 'Assinatura já foi cancelada','error'=>500], 500);
			}
			toastr()->error("Assinatura já foi cancelada", 'Error');
			return redirect(route('douapi.subscription.index'));
		}
		try {
			Stripe::setApiKey(Config::get('stripe.secret_key'));
			$subscriptionStripe = \Stripe\Subscription::retrieve($subscription->subscription_id);
			$subscriptionStripe->cancel();
		}catch (\Exception $e){
			Log::error('SubscriptionController cancel, exception stripe', ['request'=>$request->all(), 'e'=>$e->getMessage()]);
			if ($request->ajax()) {
				return response()->json(['message' => 'Erro ao solicitar o cancelamento', 'error'=>500], 500);
			}
			toastr()->error("Erro ao solicitar o canecelamento", 'Error');
			return redirect(route('douapi.subscription.index'));
		}
		$subscription->status    = 0;
		$subscription->cancel_at = MongoUtils::convertDatePhpToMongo(date('Y-m-d H:i:s'));
		$subscription->save();
		
		if ($request->ajax()) {
			return response()->json(['message' => 'Assinatura cancelada com sucesso', 'error'=>200]);
		}
		toastr()->success("Assinatura cancelada com sucesso", 'Sucesso');
		return redirect(route('douapi.subscription.index'));
	}
	
	public function createCheckoutSession(Request $request) {
		Stripe::setApiKey(Config::get('stripe.secret_key'));
		$user = Auth::user();
		$plan = Plan::getByStripeId($request->get('priceId'));
		try {
			$checkout_session = \Stripe\Checkout\Session::create([
				'success_url'   => route('douapi.subscription.success').'?session_id={CHECKOUT_SESSION_ID}&user_id='.$user->_id.'&plan_id='.$plan->_id,
				'cancel_url'    => route('douapi.subscription.create'),
				'payment_method_types' => ['card'],
				'mode' => 'subscription',
				'line_items' => [[
					'price' => $plan->stripe_id,
					'quantity' => 1,
				]],
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => ['message'=>$e->getError()->message]], 400);
		}
		return response()->json(['sessionId' => $checkout_session['id'], 'publicKey'=>Config::get('stripe.public_key')]);
		
	}
	
	public function success(Request $request){
		Log::info('SubscriptionController success', ['request'=>$request->all()]);
		$user = Auth::user();
		$userFromRequest = User::getBy_Id($request->get('user_id'));
		$planFromRequest = Plan::getBy_Id($request->get('plan_id'));
		$sessionId       = $request->get('session_id');
		
		if(!isset($userFromRequest->id) || $user->id!=$userFromRequest->id ){
			Log::error('SubscriptionController success, user other than authenticated', ['request'=>$request->all(), 'auth'=>$user]);
			return $this->renderView('DouApi::backend.errors.500', ['title' => 'Erro ao finalizar sua assinatura', 'message'=> 'O usuário que está logado é diferente do retornado pelo stripe.']);
		}
		
		$subscriptionHasExist = Subscription::getBySessionId($sessionId);
		if($subscriptionHasExist){
			Log::error('SubscriptionController success, session id already exist', ['request'=>$request->all(), 'auth'=>$user]);
			return $this->edit($subscriptionHasExist->_id);
		}
		
		Stripe::setApiKey(Config::get('stripe.secret_key'));
		try {
			$checkout_session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
		}catch (\Exception $e){
			Log::error('SubscriptionController success, invalid session_id', ['request'=>$request->all(), 'auth'=>$user]);
			return $this->renderView('DouApi::backend.errors.500', ['title' => 'Erro ao finalizar sua assinatura', 'message'=> 'O sessao[<b>'.$sessionId.'</b>] não é válida.']);
		}
		
		
		try {
			$stripe_subscription = \Stripe\Subscription::retrieve($checkout_session->subscription);
		}catch (\Exception $e){
			Log::error('SubscriptionController success, invalid session_id', ['request'=>$request->all(), 'auth'=>$user]);
			return $this->renderView('DouApi::backend.errors.500', ['title' => 'Erro ao finalizar sua assinatura', 'message'=> 'Não foi possivel repurerar sua assinatura']);
		}
		/** Cria uma linha no subscription */
		$dataSave = [
			'status'                => 1,
			'validate_at'           => MongoUtils::convertDatePhpToMongo(date('Y-m-d H:i:s', $stripe_subscription->current_period_end)),
			'description'           => '',
			'subscription_id'       => $checkout_session->subscription,
			'billing_amount'        => 1,
			'plan_id'               => $planFromRequest->_id,
			'plan_name'             => $planFromRequest->name,
			'user_id'               => $user->id,
			'email'                 => $planFromRequest->email_notify,
			'email_notify'          => '',
			'notify_email_pdf'      => $planFromRequest->notify_email_pdf,
			'notify_email_50_news'  => $planFromRequest->notify_email_50_news,
			
			'api'                   => $planFromRequest->api_notify,
			'api_notify'            => '',
			'notify_api_xml'        => $planFromRequest->notify_api_xml,
			'notify_api_all_news'   => $planFromRequest->notify_api_all_news,
			'notify_api_50_news'    => $planFromRequest->notify_api_50_news,
			
			'session_id'            => $sessionId,
			'filter'                => '',
			'configured'            => false,
		];
		$subscription = Subscription::create($dataSave);
		toastr()->success('Assinatura efetuada com sucesso', 'Sucesso');
		return $this->edit($subscription->_id);
		
	}
	
	
	
}