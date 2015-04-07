<?php namespace Ninjaparade\Slack\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Ninjaparade\Slack\Repositories\Slackchannel\SlackchannelRepositoryInterface;

class SlackchannelsController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

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
	 * @param  \Ninjaparade\Slack\Repositories\Slackchannel\SlackchannelRepositoryInterface  $slackchannels
	 * @return void
	 */
	public function __construct(SlackchannelRepositoryInterface $slackchannels)
	{
		parent::__construct();

		$this->slackchannels = $slackchannels;
	}

	/**
	 * Display a listing of slackchannel.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('ninjaparade/slack::slackchannels.index');
	}

	/**
	 * Datasource for the slackchannel Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->slackchannels->grid();

		$columns = [
			'id',
			'name',
			'webhook',
			'send_as',
			'expand_media',
			'expand_urls',
			'slug',
			'default',
			'active',
			'created_at',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.ninjaparade.slack.slackchannels.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new slackchannel.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new slackchannel.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating slackchannel.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating slackchannel.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified slackchannel.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->slackchannels->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("ninjaparade/slack::slackchannels/message.{$type}.delete")
		);

		return redirect()->route('admin.ninjaparade.slack.slackchannels.all');
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
				$this->slackchannels->{$action}($row);
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
		// Do we have a slackchannel identifier?
		if (isset($id))
		{
			if ( ! $slackchannel = $this->slackchannels->find($id))
			{
				$this->alerts->error(trans('ninjaparade/slack::slackchannels/message.not_found', compact('id')));

				return redirect()->route('admin.ninjaparade.slack.slackchannels.all');
			}
		}
		else
		{
			$slackchannel = $this->slackchannels->createModel();
		}

		// Show the page
		return view('ninjaparade/slack::slackchannels.form', compact('mode', 'slackchannel'));
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
		// Store the slackchannel
		list($messages) = $this->slackchannels->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("ninjaparade/slack::slackchannels/message.success.{$mode}"));

			return redirect()->route('admin.ninjaparade.slack.slackchannels.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}
