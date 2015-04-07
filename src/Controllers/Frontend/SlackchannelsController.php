<?php namespace Ninjaparade\Slack\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;

class SlackchannelsController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('ninjaparade/slack::index');
	}

}
