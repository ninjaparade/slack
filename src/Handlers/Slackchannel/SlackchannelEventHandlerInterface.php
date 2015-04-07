<?php namespace Ninjaparade\Slack\Handlers\Slackchannel;

use Ninjaparade\Slack\Models\Slackchannel;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface SlackchannelEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a slackchannel is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a slackchannel is created.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackchannel  $slackchannel
	 * @return mixed
	 */
	public function created(Slackchannel $slackchannel);

	/**
	 * When a slackchannel is being updated.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackchannel  $slackchannel
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Slackchannel $slackchannel, array $data);

	/**
	 * When a slackchannel is updated.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackchannel  $slackchannel
	 * @return mixed
	 */
	public function updated(Slackchannel $slackchannel);

	/**
	 * When a slackchannel is deleted.
	 *
	 * @param  \Ninjaparade\Slack\Models\Slackchannel  $slackchannel
	 * @return mixed
	 */
	public function deleted(Slackchannel $slackchannel);

}
