<?php namespace Ninjaparade\Slack\Repositories\Slackevent;

use Validator;
use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;
use Ninjaparade\Slack\Models\Slackevent;

class SlackeventRepository implements SlackeventRepositoryInterface {

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

		$this->data = $app['ninjaparade.slack.slackevent.handler.data'];

		$this->setValidator($app['ninjaparade.slack.slackevent.validator']);

		$this->setModel(get_class($app['Ninjaparade\Slack\Models\Slackevent']));
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
		return $this->container['cache']->rememberForever('ninjaparade.slack.slackevent.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		$this->fireEvent('ninjaparade.test.event');
		die;
		return $this->container['cache']->rememberForever('ninjaparade.slack.slackevent.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function findActive()
	{
		return $this->container['cache']->rememberForever('ninjaparade.slack.slackevent.active', function()
		{
			return $this->createModel()->where(['active' => 1])->get();
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
		// Create a new slackevent
		$slackevent = $this->createModel();

		// Fire the 'ninjaparade.slack.slackevent.creating' event
		if ($this->fireEvent('ninjaparade.slack.slackevent.creating', [ $input ]) === false)
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
			// Save the slackevent
			$slackevent->fill($data)->save();

			$slackevent->channels()->attach($input['channel']);

			// Fire the 'ninjaparade.slack.slackevent.created' event
			$this->fireEvent('ninjaparade.slack.slackevent.created', [ $slackevent ]);
		}

		return [ $messages, $slackevent ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the slackevent object
		$slackevent = $this->find($id);

		// Fire the 'ninjaparade.slack.slackevent.updating' event
		if ($this->fireEvent('ninjaparade.slack.slackevent.updating', [ $slackevent, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($slackevent, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the slackevent
			$slackevent->fill($data)->save();

			$slackevent->channels()->detach();

			$slackevent->channels()->attach($input['channel']);
			// Fire the 'ninjaparade.slack.slackevent.updated' event
			$this->fireEvent('ninjaparade.slack.slackevent.updated', [ $slackevent ]);
		}

		return [ $messages, $slackevent ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the slackevent exists
		if ($slackevent = $this->find($id))
		{
			// Fire the 'ninjaparade.slack.slackevent.deleted' event
			$this->fireEvent('ninjaparade.slack.slackevent.deleted', [ $slackevent ]);

			// Delete the slackevent entry
			$slackevent->delete();

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
