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
	
	Route::fallback(function () {
		$prefix_url = \Illuminate\Support\Facades\Config::get('admin.prefix_url');
		return redirect("/$prefix_url/page-not-found");
	});
});

