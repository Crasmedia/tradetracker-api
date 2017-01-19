<?php namespace Crasmedia\TradeTracker;

use Illuminate\Support\ServiceProvider;

class TradeTrackerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([__DIR__ . '/../config/tradetracker.php' => config_path('tradetracker.php')]);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/tradetracker.php', 'tradetracker');

		$config = config('tradetracker');
		$this->app->singleton(TradeTrackerApi::class, function() use ($config)
		{
			return new TradeTrackerApi($config);
		});

	}
}