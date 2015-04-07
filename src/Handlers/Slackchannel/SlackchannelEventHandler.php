<?php namespace Ninjaparade\Slack\Handlers\Slackchannel;

use Illuminate\Events\Dispatcher;
use Ninjaparade\Slack\Models\Slackchannel;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class SlackchannelEventHandler extends BaseEventHandler implements SlackchannelEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('ninjaparade.slack.slackchannel.creating', __CLASS__.'@creating');
		$dispatcher->listen('ninjaparade.slack.slackchannel.created', __CLASS__.'@created');

		$dispatcher->listen('ninjaparade.slack.slackchannel.updating', __CLASS__.'@updating');
		$dispatcher->listen('ninjaparade.slack.slackchannel.updated', __CLASS__.'@updated');

		$dispatcher->listen('ninjaparade.slack.slackchannel.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Slackchannel $slackchannel)
	{
		$this->flushCache($slackchannel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Slackchannel $slackchannel, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Slackchannel $slackchannel)
	{
		$this->flushCache($slackchannel);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Slackchannel $slackchannel)
	{
		$this->flushCache($slackchannel);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackchannel  $slackchannel
	 * @return void
	 */
	protected function flushCache(Slackchannel $slackchannel)
	{
		$this->app['cache']->forget('ninjaparade.slack.slackchannel.all');

		$this->app['cache']->forget('ninjaparade.slack.slackchannel.'.$slackchannel->id);
	}

}
