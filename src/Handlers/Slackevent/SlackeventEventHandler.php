<?php namespace Ninjaparade\Slack\Handlers\Slackevent;

use Illuminate\Events\Dispatcher;
use Ninjaparade\Slack\Models\Slackevent;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class SlackeventEventHandler extends BaseEventHandler implements SlackeventEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('ninjaparade.slack.slackevent.creating', __CLASS__.'@creating');
		$dispatcher->listen('ninjaparade.slack.slackevent.created', __CLASS__.'@created');

		$dispatcher->listen('ninjaparade.slack.slackevent.updating', __CLASS__.'@updating');
		$dispatcher->listen('ninjaparade.slack.slackevent.updated', __CLASS__.'@updated');

		$dispatcher->listen('ninjaparade.slack.slackevent.deleted', __CLASS__.'@deleted');
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
	public function created(Slackevent $slackevent)
	{
		$this->flushCache($slackevent);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Slackevent $slackevent, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Slackevent $slackevent)
	{
		$this->flushCache($slackevent);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Slackevent $slackevent)
	{
		$this->flushCache($slackevent);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackevent  $slackevent
	 * @return void
	 */
	protected function flushCache(Slackevent $slackevent)
	{
		$this->app['cache']->forget('ninjaparade.slack.slackevent.all');
		
		$this->app['cache']->forget('ninjaparade.slack.slackevent.active');

		$this->app['cache']->forget('ninjaparade.slack.slackevent.'.$slackevent->id);

		$this->app['cache']->forget('ninjaparade.slack.slackevent.name.'.$slackevent->name);
	}

}
