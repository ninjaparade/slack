<?php namespace Ninjaparade\Slack\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Cartalyst\Support\Traits\NamespacedEntityTrait;

class Slackevent extends Model implements EntityInterface {

	use EntityTrait, NamespacedEntityTrait;

	/**
	 * {@inheritDoc}
	 */
	protected $table = 'slackevents';

	/**
	 * {@inheritDoc}
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $with = [
		'values.attribute',
		'channels'
	];

	/**
	 * {@inheritDoc}
	 */
	protected static $entityNamespace = 'ninjaparade/slack.slackevent';

	public function channels()
	{
     	return $this->belongsToMany('Ninjaparade\Slack\Models\Slackchannel');
    }
}	
