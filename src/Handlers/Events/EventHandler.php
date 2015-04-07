<?php namespace Ninjaparade\Slack\Handlers\Events;

use Illuminate\Events\Dispatcher;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;
use Illuminate\Container\Container;

class EventHandler extends BaseEventHandler implements EventHandlerInterface {

	/**
	 * The Slack repository.
	 *
	 * @var \Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface
	 */
	protected $slackevents;

	 /**
     * Constructor.
     *
     * @param  \Illuminate\Container\Container  $app
     * @return void
     */
    public function __construct(Container $app)
    {
        parent::__construct($app);

        $this->app = $app;

        $this->slackevents = $app['ninjaparade.slack.slackevent'];
    }

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$events = $this->slackevents->findAll();

		foreach($events as $event)
		{
			$dispatcher->listen($event->name, 'Ninjaparade\Slack\Handlers\Events@handle');
		}

		$dispatcher->listen('ninjaparade.test.event', 'Ninjaparade\Slack\Handlers\Events@handle');
	}

	/**
	 * {@inheritDoc}
	 */
	public function handle()
	{
		dd('Handler');
		
		// $dispatcher->listen('ninjaparade.slack.slackevent.creating', __CLASS__.'@creating');
		// $dispatcher->listen('ninjaparade.slack.slackevent.created', __CLASS__.'@created');

		// $dispatcher->listen('ninjaparade.slack.slackevent.updating', __CLASS__.'@updating');
		// $dispatcher->listen('ninjaparade.slack.slackevent.updated', __CLASS__.'@updated');

		// $dispatcher->listen('ninjaparade.slack.slackevent.deleted', __CLASS__.'@deleted');
	}



}
