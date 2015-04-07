<?php namespace Ninjaparade\Slack\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface;
use Ninjaparade\Slack\Repositories\Slackchannel\SlackchannelRepositoryInterface;
use Event;

class SlackeventsController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Slack repository.
	 *
	 * @var \Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface
	 */
	protected $slackevents;

	/**
	 * The Slack repository.
	 *
	 * @var \Ninjaparade\Slack\Repositories\Slackchannel\SlackchannelRepositoryInterface
	 */
	protected $slackchannels;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Ninjaparade\Slack\Repositories\Slackevent\SlackeventRepositoryInterface  $slackevents
	 * @return void
	 */
	public function __construct(SlackeventRepositoryInterface $slackevents, SlackchannelRepositoryInterface $slackchannels)
	{
		parent::__construct();

		$this->slackevents   = $slackevents;

		$this->slackchannels = $slackchannels;
	}

	/**
	 * Display a listing of slackevent.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('ninjaparade/slack::slackevents.index');	
	}

	/**
	 * Datasource for the slackevent Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->slackevents->grid();

		$columns = [
			'id',
			'name',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.ninjaparade.slack.slackevents.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new slackevent.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new slackevent.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating slackevent.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating slackevent.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified slackevent.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->slackevents->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("ninjaparade/slack::slackevents/message.{$type}.delete")
		);

		return redirect()->route('admin.ninjaparade.slack.slackevents.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->slackevents->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a slackevent identifier?
		if (isset($id))
		{
			if ( ! $slackevent = $this->slackevents->find($id))
			{
				$this->alerts->error(trans('ninjaparade/slack::slackevents/message.not_found', compact('id')));

				return redirect()->route('admin.ninjaparade.slack.slackevents.all');
			}
		}
		else
		{
			$slackevent = $this->slackevents->createModel();
		}

		$slackchannels = $this->slackchannels->findAll();
		// Show the page
		return view('ninjaparade/slack::slackevents.form', compact('mode', 'slackevent', 'slackchannels'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the slackevent
		list($messages) = $this->slackevents->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("ninjaparade/slack::slackevents/message.success.{$mode}"));

			return redirect()->route('admin.ninjaparade.slack.slackevents.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}
