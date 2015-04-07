<?php namespace Ninjaparade\Slack\Repositories\Slackchannel;

interface SlackchannelRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Ninjaparade\Slack\Models\Slackchannel
	 */
	public function grid();

	/**
	 * Returns all the slack entries.
	 *
	 * @return \Ninjaparade\Slack\Models\Slackchannel
	 */
	public function findAll();

	/**
	 * Returns a slack entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Ninjaparade\Slack\Models\Slackchannel
	 */
	public function find($id);

	/**
	 * Determines if the given slack is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given slack is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given slack.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a slack entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Ninjaparade\Slack\Models\Slackchannel
	 */
	public function create(array $data);

	/**
	 * Updates the slack entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Ninjaparade\Slack\Models\Slackchannel
	 */
	public function update($id, array $data);

	/**
	 * Deletes the slack entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}
