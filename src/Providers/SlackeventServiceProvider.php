<?php namespace Ninjaparade\Slack\Providers;

use Cartalyst\Support\ServiceProvider;

class SlackeventServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Ninjaparade\Slack\Models\Slackevent']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('ninjaparade.slack.slackevent.handler.event');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('ninjaparade.slack.slackevent', 'Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepository');

		// Register the data handler
		$this->bindIf('ninjaparade.slack.slackevent.handler.data', 'Ninjaparade\Slack\Handlers\Slackevent\SlackeventDataHandler');

		// Register the event handler
		$this->bindIf('ninjaparade.slack.slackevent.handler.event', 'Ninjaparade\Slack\Handlers\Slackevent\SlackeventEventHandler');

		// Register the validator
		$this->bindIf('ninjaparade.slack.slackevent.validator', 'Ninjaparade\Slack\Validator\Slackevent\SlackeventValidator');
	}

}
