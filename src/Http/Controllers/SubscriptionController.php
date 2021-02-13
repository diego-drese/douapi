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
use Oka6\DouApi\Models\Plan;
use Oka6\DouApi\Models\Subscription;
use Stripe\Stripe;
use Yajra\DataTables\DataTables;

class SubscriptionController extends DouApiController  {
	use ValidatesRequests;
	
	public function index(Request $request) {
		if ($request->ajax()) {
			$user = Auth::user();
			$query = Subscription::withUser($user);
			return DataTables::of($query)
				->addColumn('validate_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})->addColumn('created_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})->addColumn('updated_at', function ($row) {
					return $row->validate_at->format('d/m/Y H:i');
				})
				->toJson(true);
		}
		return $this->renderView('DouApi::backend.subscription.index');
	}
	
	public function create(Plan $data) {
		$data = Plan::getAllActives();
		return $this->renderView('DouApi::backend.subscription.plans', ['data' => $data]);
	}
	public function checkout($stripeId) {
		return $this->renderView('DouApi::backend.subscription.checkout', ['priceId' => $stripeId]);
	}
	
	public function createCheckoutSession(Request $request) {
		Stripe::setApiKey(Config::get('stripe.secret_key'));
		$user = Auth::user();
		$plan = Plan::getByStripeId($request->get('priceId'));
		try {
			$checkout_session = \Stripe\Checkout\Session::create([
				'success_url' => route('douapi.subscription.success').'?session_id={CHECKOUT_SESSION_ID}&user_id='.$user->_id.'&plan_id='.$plan->_id,
				'cancel_url' => route('douapi.subscription.cancel'),
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
			return $this->renderView('DouApi::backend.errors.500', ['title' => 'Erro ao finalizar sua assinatura', 'message'=> 'A sessao[<b>'.$sessionId.'</b>] ja esta cadastrada.']);
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
			'status'        => 1,
			'validate_at'   => MongoUtils::convertDatePhpToMongo(date('Y-m-d H:i:s', $stripe_subscription->current_period_end)),
			'description'   => '',
			'billing_amount'=> 1,
			'plan_id'       => $planFromRequest->_id,
			'plan_name'     => $planFromRequest->name,
			'user_id'       => $user->id,
			'email'         => '',
			'api'           => '',
			'session_id'    => $sessionId,
			'filter'        => '',
		];
		Subscription::create($dataSave);
		
		toastr()->success('Assinatura confirmada com sucesso', 'Sucesso');
		return $this->renderView('DouApi::backend.subscription.index');
		
	}
	
	
	
}