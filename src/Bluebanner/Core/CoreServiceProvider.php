<?php namespace Bluebanner\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	
	public function boot()
	{
		$this->package('bluebanner/core');
		
		$app = $this->app;
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['core'] = $this->app->share(function($app) {
			return new CoreService;
		});
		
		$this->app['item'] = $this->app->share(function($app) {
			return new ItemService;
		});
		
		$this->app['inventory'] = $this->app->share(function($app) {
			return new InventoryService;
		});
		
		$this->app['storage'] = $this->app->share(function($app) {
			return new StorageService;
		});
		
		$this->app['purchase'] = $this->app->share(function($app) {
			return new PurchaseService;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('auth', 'item', 'inventory', 'storage', 'purchase');
	}

}