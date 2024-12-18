<?php

namespace Oka6\DouApi;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;


class DouApiServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		setlocale(LC_ALL, "pt_BR.utf8");
		Carbon::setLocale(config('app.locale'));
		
		$this->loadViewsFrom(__DIR__ . '/Resources/views', 'DouApi');
		$this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
		$this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
		

		$this->publishes([
			__DIR__ . '/../vendor' => public_path('vendor'),
		], 'public');
		
		$this->publishes([
			__DIR__ . '/../storage/douapi' => public_path('../storage/douapi'),
		], 'public');
		
		$this->publishes([
			__DIR__ . '/automation' => public_path('../automation'),
		], 'public');

		$this->mergeConfigFrom(
			__DIR__ . '/Config/database.php', 'database.connections'
		);
		$this->mergeConfigFrom(
			__DIR__ . '/Config/stripe.php', 'stripe'
		);
		
		$this->mergeConfigFrom(
			__DIR__ . '/Config/profile_type.php', 'admin.profile_type'
		);
		$this->mergeConfigFrom(
			__DIR__ . '/Config/profile_type.php', 'douapi.profile_type'
		);
		
		if (php_sapi_name() != 'cli') {
			$this->setObservers();
		}
		
	}
	
	protected function setObservers() {
	
	}
	
	/**
	 * Merge the given configuration with the existing configuration.
	 *
	 * @param string $path
	 * @param string $key
	 * @return void
	 */
	protected function mergeConfigFrom($path, $key) {
		$config = $this->app['config']->get($key, []);
		if ($key == 'database.connections' && !isset($config['oka6_douapi'])) {
			$this->app['config']->set($key, array_merge($config, require $path));
		}elseif ($key == 'admin.profile_type') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}elseif ($key == 'douapi.profile_type') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}elseif ($key == 'stripe' && !isset($config['public_key'])) {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
	}
	
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
	
	}
}
