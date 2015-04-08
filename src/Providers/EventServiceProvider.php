<?php namespace Ninjaparade\Slack\Providers;

use Cartalyst\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		$this->app['events']->subscribe('ninjaparade.slack.slackevents.handler.event');
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
