<?php namespace Ninjaparade\Slack\Handlers\Slackchannel;

interface SlackchannelDataHandlerInterface {

	/**
	 * Prepares the given data for being stored.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function prepare(array $data);

}
