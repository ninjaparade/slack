<?php namespace Ninjaparade\Slack\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;
use Slack;
use Event;

class SlackeventsController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		// $payload = [
		// 	'text'         => 'this is my custom message',
  //   	];

		// Event::fire('ninjaparade.test.event', [  $payload ]  );
		// Slack::ping('ninjaparade.test.event', 'The message http://www.google.com' );
		// Event::fire('')
		// Slack::notify();
	}

}
