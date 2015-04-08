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
	 * The Slack Cleint.
	 *
	 * @var \Ninjaparade\Slack\Client\SlackClient
	 */
	protected $client;

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

		$this->slackevents = $this->app['ninjaparade.slack.slackevent'];

		$this->client = $this->app['ninjaparade.slack'];
    }

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$events = $this->slackevents->findAll();

		foreach($events as $event)
		{
			$dispatcher->listen("{$event->name}", function($data) use ($event) {

				$this->handle($event, $data);
			});
		}
	}


	protected function handle($event, $data)
	{
		foreach ($event->channels as $channel)
		{
			$config = [
				'username'     => $channel->send_as,
				'unfurl_links' => $channel->expand_urls,
				'unfurl_media' => $channel->expand_media,
			];

			$message = array_merge($data, $config);

			$this->client->notify($channel->webhook, $message);			
		}
		
	}
}
