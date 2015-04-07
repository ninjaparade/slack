<?php namespace Ninjaparade\Slack\Providers;

use Cartalyst\Support\ServiceProvider;

class SlackchannelServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Ninjaparade\Slack\Models\Slackchannel']
		);

		// Subscribe the registered event handler
		$this->app['events']->subscribe('ninjaparade.slack.slackchannel.handler.event');
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('ninjaparade.slack.slackchannel', 'Ninjaparade\Slack\Repositories\Slackchannel\SlackchannelRepository');

		// Register the data handler
		$this->bindIf('ninjaparade.slack.slackchannel.handler.data', 'Ninjaparade\Slack\Handlers\Slackchannel\SlackchannelDataHandler');

		// Register the event handler
		$this->bindIf('ninjaparade.slack.slackchannel.handler.event', 'Ninjaparade\Slack\Handlers\Slackchannel\SlackchannelEventHandler');

		// Register the validator
		$this->bindIf('ninjaparade.slack.slackchannel.validator', 'Ninjaparade\Slack\Validator\Slackchannel\SlackchannelValidator');
	}

}
