<?php namespace Spescina\WebfactionCommands;

use Illuminate\Support\ServiceProvider;
use Spescina\WebfactionCommands\Commands\Install;
use Spescina\WebfactionCommands\Commands\Update;

/**
 * Class WebfactionCommandsServiceProvider
 * @package Spescina\WebfactionCommands
 */
class WebfactionCommandsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('spescina/webfaction-commands');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['command.wf.install'] = $this->app->share(function($app)
        {
            return new Install;
        });
        $this->commands('command.wf.install');

        $this->app['command.wf.update'] = $this->app->share(function($app)
        {
            return new Update;
        });
        $this->commands('command.wf.update');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['command.wf.install'];
	}

}
