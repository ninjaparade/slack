<?php namespace Ninjaparade\Slack\Repositories\Slackchannel;

use Validator;
use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;
use Ninjaparade\Slack\Models\Slackchannel;

class SlackchannelRepository implements SlackchannelRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Ninjaparade\Slack\Handlers\DataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent slack model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['ninjaparade.slack.slackchannel.handler.data'];

		$this->setValidator($app['ninjaparade.slack.slackchannel.validator']);

		$this->setModel(get_class($app['Ninjaparade\Slack\Models\Slackchannel']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('ninjaparade.slack.slackchannel.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('ninjaparade.slack.slackchannel.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new slackchannel
		$slackchannel = $this->createModel();

		// Fire the 'ninjaparade.slack.slackchannel.creating' event
		if ($this->fireEvent('ninjaparade.slack.slackchannel.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the slackchannel
			$slackchannel->fill($data)->save();

			// Fire the 'ninjaparade.slack.slackchannel.created' event
			$this->fireEvent('ninjaparade.slack.slackchannel.created', [ $slackchannel ]);
		}

		return [ $messages, $slackchannel ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the slackchannel object
		$slackchannel = $this->find($id);

		// Fire the 'ninjaparade.slack.slackchannel.updating' event
		if ($this->fireEvent('ninjaparade.slack.slackchannel.updating', [ $slackchannel, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($slackchannel, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the slackchannel
			$slackchannel->fill($data)->save();

			// Fire the 'ninjaparade.slack.slackchannel.updated' event
			$this->fireEvent('ninjaparade.slack.slackchannel.updated', [ $slackchannel ]);
		}

		return [ $messages, $slackchannel ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the slackchannel exists
		if ($slackchannel = $this->find($id))
		{
			// Fire the 'ninjaparade.slack.slackchannel.deleted' event
			$this->fireEvent('ninjaparade.slack.slackchannel.deleted', [ $slackchannel ]);

			// Delete the slackchannel entry
			$slackchannel->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}
