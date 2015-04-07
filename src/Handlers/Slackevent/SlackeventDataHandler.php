<?php namespace Ninjaparade\Slack\Handlers\Slackevent;

class SlackeventDataHandler implements SlackeventDataHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function prepare(array $data)
	{
		return array_except($data, ['channel'] );
	}

}
