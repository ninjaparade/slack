<?php namespace Ninjaparade\Slack\Handlers\Slackevent;

interface SlackeventDataHandlerInterface {

	/**
	 * Prepares the given data for being stored.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function prepare(array $data);

}
