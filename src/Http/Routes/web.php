<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefix_url = \Illuminate\Support\Facades\Config::get('admin.prefix_url');
Route::group(['prefix' => $prefix_url, 'middleware' => ['web', 'auth', 'Oka6\Admin\Http\Middleware\MiddlewareAdmin']], function () {
	Route::get('/dou', 'Oka6\DouApi\Http\Controllers\DouController@index')->name('dou.index')->where(['iconAdmin' => 'mdi mdi-book-open-page-variant', 'menuAdmin' => "DOU", 'parentRouteNameAdmin' => 'Dou', 'nameAdmin' => 'DOU', 'isDefaultAdmin' => '1']);
	
	/*Plans admin */
	Route::get('/plans', 'Oka6\DouApi\Http\Controllers\PlanController@index')->name('douapi.plan.index')->where(['iconAdmin' => 'fas fa-money-bill-alt', 'menuAdmin' => "Plans", 'parentRouteNameAdmin' => 'System Admin', 'nameAdmin' => 'Plans Listing', 'isDefaultAdmin' => '1']);
	Route::get('/plans/create', 'Oka6\DouApi\Http\Controllers\PlanController@create')->name('douapi.plan.create')->where(['iconAdmin' => 'fas fa-plus-square', 'parentRouteNameAdmin' => 'douapi.plan.index', 'nameAdmin' => 'Plans Create',]);
	Route::post('/plans', 'Oka6\DouApi\Http\Controllers\PlanController@store')->name('douapi.plan.store')->where(['iconAdmin' => 'fas fa-floppy-o', 'nameAdmin' => 'Save Plans']);
	Route::get('/plans/{id}', 'Oka6\DouApi\Http\Controllers\PlanController@edit')->name('douapi.plan.edit')->where(['iconAdmin' => 'fas fa-edit', 'parentRouteNameAdmin' => 'douapi.plan.index', 'nameAdmin' => 'Plans Edit']);
	Route::post('/plans/{id}', 'Oka6\DouApi\Http\Controllers\PlanController@update')->name('douapi.plan.update')->where(['iconAdmin' => 'fas fa-edit', 'parentRouteNameAdmin' => 'admin.plan.index', 'nameAdmin' => 'Plans Update']);
	
	Route::get('/subscription', 'Oka6\DouApi\Http\Controllers\SubscriptionController@index')->name('douapi.subscription.index')->where(['iconAdmin' => 'mdi mdi-bell-ring', 'menuAdmin' => "Assinaturas", 'parentRouteNameAdmin' => 'douapi.Configuration', 'nameAdmin' => 'Assinaturas', 'isDefaultAdmin' => '1']);
	Route::get('/subscription/create', 'Oka6\DouApi\Http\Controllers\SubscriptionController@create')->name('douapi.subscription.create')->where(['iconAdmin' => 'fas fa-plus-square', 'parentRouteNameAdmin' => 'douapi.subscription.index', 'nameAdmin' => 'Subscription Create',]);
	Route::any('/subscription/checkout/{stripId}', 'Oka6\DouApi\Http\Controllers\SubscriptionController@checkout')->name('douapi.subscription.checkout')->where(['parentRouteNameAdmin' => 'douapi.subscription.index', 'nameAdmin' => 'Subscription checkout',]);
	Route::any('/subscription/create-checkout-session', 'Oka6\DouApi\Http\Controllers\SubscriptionController@createCheckoutSession')->name('douapi.subscription.create.checkout.session')->where(['parentRouteNameAdmin' => 'douapi.subscription.index', 'nameAdmin' => 'Subscription Create checkout session',]);
	Route::any('/subscription/success', 'Oka6\DouApi\Http\Controllers\SubscriptionController@success')->name('douapi.subscription.success')->where(['parentRouteNameAdmin' => 'douapi.subscription.index', 'nameAdmin' => 'Subscription success',]);
	
	Route::get('/subscription/{id}', 'Oka6\DouApi\Http\Controllers\SubscriptionController@edit')->name('douapi.subscription.edit')->where(['iconAdmin' => 'fas fa-edit', 'parentRouteNameAdmin' => 'douapi.subscription.index', 'nameAdmin' => 'Subscription Edit']);
	Route::post('/subscription/{id}', 'Oka6\DouApi\Http\Controllers\SubscriptionController@update')->name('douapi.subscription.update')->where(['iconAdmin' => 'fas fa-edit', 'parentRouteNameAdmin' => 'admin.subscription.index', 'nameAdmin' => 'Subscription Update']);
	
	Route::fallback(function () {
		$prefix_url = \Illuminate\Support\Facades\Config::get('admin.prefix_url');
		return redirect("/$prefix_url/page-not-found");
	});
});

Route::any('/subscription/cancel', 'Oka6\DouApi\Http\Controllers\SubscriptionController@cancel')->name('douapi.subscription.cancel');

