<?php namespace Ninjaparade\Slack\Providers;

use Cartalyst\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Ninjaparade\Slack\Client\SlackClient;

class SlackClientServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		$this->app['ninjaparade.slack'] = $this->app->share(function($app)
   		{
      		return new SlackClient( $this->app['ninjaparade.slack.slackevent'] );
      	});

		$loader = AliasLoader::getInstance();

		$loader->alias('Slack',  'Ninjaparade\Slack\Facades\SlackClientFacade');
	
	}

}
