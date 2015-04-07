<?php namespace Ninjaparade\Slack\Providers;

use Cartalyst\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

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
		// Register the event handler
		$this->bindIf('ninjaparade.slack.slackevents.handler.event', 'Ninjaparade\Slack\Handlers\Events\EventHandler');

		
	}

}
