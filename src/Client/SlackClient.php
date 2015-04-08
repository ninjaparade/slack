<?php namespace Ninjaparade\Slack\Client;

use GuzzleHttp\Client;
use Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface;
use Event;

class SlackClient
{

	/**
	 * The Slack repository.
	 *
	 * @var \Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface
	 */
	protected $slackevents;

	public function __construct(SlackeventRepositoryInterface $slackevents)
	{
		$this->client = new Client;

		$this->slackevents = $slackevents;
	}


	/**
   * Send a notification
   *
   * @param $webhook String, $message Array
   * @return response
   */
	public function notify($webhook, $message)
	{
	
		return $this->client->post($webhook, ['body' => json_encode($message)]);
	}

	/**
   * Send a notification
   *
   * @param $event String, $message mixed
   * @return response
   */
	public function ping($event, $data)
	{
	
		$slackevent = $this->slackevents->findByName($event);
		
		

		foreach ($slackevent->channels as $channel)
		{

			$config = [
				'username'     => $channel->send_as,
				'unfurl_links' => $channel->expand_urls,
				'unfurl_media' => $channel->expand_media,
			];

			if( is_array($data) )
			{
				$data = head($data);
				$message = array_merge($data, $config);
			}else{
				$config['text']  = $data;
				$message = $config;
			}


			$this->client->post($channel->webhook, ['body' => json_encode($message)]);
		}

		die;
		// return $this->client->post($webhook, ['body' => json_encode($message)]);
	}


}