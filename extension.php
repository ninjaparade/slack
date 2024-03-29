<?php

use Illuminate\Foundation\Application;
use Cartalyst\Extensions\ExtensionInterface;
use Cartalyst\Settings\Repository as Settings;
use Cartalyst\Permissions\Container as Permissions;

return [

	/*
	|--------------------------------------------------------------------------
	| Name
	|--------------------------------------------------------------------------
	|
	| This is your extension name and it is only required for
	| presentational purposes.
	|
	*/

	'name' => 'Slack',

	/*
	|--------------------------------------------------------------------------
	| Slug
	|--------------------------------------------------------------------------
	|
	| This is your extension unique identifier and should not be changed as
	| it will be recognized as a new extension.
	|
	| Ideally, this should match the folder structure within the extensions
	| folder, but this is completely optional.
	|
	*/

	'slug' => 'ninjaparade/slack',

	/*
	|--------------------------------------------------------------------------
	| Author
	|--------------------------------------------------------------------------
	|
	| Because everybody deserves credit for their work, right?
	|
	*/

	'author' => 'Ninjaparade Digital Inc.',

	/*
	|--------------------------------------------------------------------------
	| Description
	|--------------------------------------------------------------------------
	|
	| One or two sentences describing the extension for users to view when
	| they are installing the extension.
	|
	*/

	'description' => 'A Platform 3 Slack extension',

	/*
	|--------------------------------------------------------------------------
	| Version
	|--------------------------------------------------------------------------
	|
	| Version should be a string that can be used with version_compare().
	| This is how the extensions versions are compared.
	|
	*/

	'version' => '0.1.0',

	/*
	|--------------------------------------------------------------------------
	| Requirements
	|--------------------------------------------------------------------------
	|
	| List here all the extensions that this extension requires to work.
	| This is used in conjunction with composer, so you should put the
	| same extension dependencies on your main composer.json require
	| key, so that they get resolved using composer, however you
	| can use without composer, at which point you'll have to
	| ensure that the required extensions are available.
	|
	*/

	'require' => [
		'platform/access',
	],

	/*
	|--------------------------------------------------------------------------
	| Autoload Logic
	|--------------------------------------------------------------------------
	|
	| You can define here your extension autoloading logic, it may either
	| be 'composer', 'platform' or a 'Closure'.
	|
	| If composer is defined, your composer.json file specifies the autoloading
	| logic.
	|
	| If platform is defined, your extension receives convetion autoloading
	| based on the Platform standards.
	|
	| If a Closure is defined, it should take two parameters as defined
	| bellow:
	|
	|	object \Composer\Autoload\ClassLoader      $loader
	|	object \Illuminate\Foundation\Application  $app
	|
	| Supported: "composer", "platform", "Closure"
	|
	*/

	'autoload' => 'composer',

	/*
	|--------------------------------------------------------------------------
	| Service Providers
	|--------------------------------------------------------------------------
	|
	| Define your extension service providers here. They will be dynamically
	| registered without having to include them in app/config/app.php.
	|
	*/

	'providers' => [

		'Ninjaparade\Slack\Providers\SlackchannelServiceProvider',
		'Ninjaparade\Slack\Providers\SlackeventServiceProvider',
		'Ninjaparade\Slack\Providers\SlackClientServiceProvider',
		'Ninjaparade\Slack\Providers\EventServiceProvider',

	],

	/*
	|--------------------------------------------------------------------------
	| Routes
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| any custom routing logic here.
	|
	| The closure parameters are:
	|
	|	object \Cartalyst\Extensions\ExtensionInterface  $extension
	|	object \Illuminate\Foundation\Application        $app
	|
	*/

	'routes' => function(ExtensionInterface $extension, Application $app)
	{
		Route::group(['prefix'    => admin_uri().'/slack/slackchannels', 'namespace' => 'Ninjaparade\Slack\Controllers\Admin',], function()
		{
			Route::get('/' , ['as' => 'admin.ninjaparade.slack.slackchannels.all', 'uses' => 'SlackchannelsController@index']);
			Route::post('/', ['as' => 'admin.ninjaparade.slack.slackchannels.all', 'uses' => 'SlackchannelsController@executeAction']);

			Route::get('grid', ['as' => 'admin.ninjaparade.slack.slackchannels.grid', 'uses' => 'SlackchannelsController@grid']);

			Route::get('create' , ['as' => 'admin.ninjaparade.slack.slackchannels.create', 'uses' => 'SlackchannelsController@create']);
			Route::post('create', ['as' => 'admin.ninjaparade.slack.slackchannels.create', 'uses' => 'SlackchannelsController@store']);

			Route::get('{id}'   , ['as' => 'admin.ninjaparade.slack.slackchannels.edit'  , 'uses' => 'SlackchannelsController@edit']);
			Route::post('{id}'  , ['as' => 'admin.ninjaparade.slack.slackchannels.edit'  , 'uses' => 'SlackchannelsController@update']);

			Route::delete('{id}', ['as' => 'admin.ninjaparade.slack.slackchannels.delete', 'uses' => 'SlackchannelsController@delete']);
		});

		Route::group(['prefix'    => admin_uri().'/slack/slackevents','namespace' => 'Ninjaparade\Slack\Controllers\Admin',], function()
		{
			Route::get('/' , ['as' => 'admin.ninjaparade.slack.slackevents.all', 'uses' => 'SlackeventsController@index']);
			Route::post('/', ['as' => 'admin.ninjaparade.slack.slackevents.all', 'uses' => 'SlackeventsController@executeAction']);

			Route::get('grid', ['as' => 'admin.ninjaparade.slack.slackevents.grid', 'uses' => 'SlackeventsController@grid']);

			Route::get('create' , ['as' => 'admin.ninjaparade.slack.slackevents.create', 'uses' => 'SlackeventsController@create']);
			Route::post('create', ['as' => 'admin.ninjaparade.slack.slackevents.create', 'uses' => 'SlackeventsController@store']);

			Route::get('{id}'   , ['as' => 'admin.ninjaparade.slack.slackevents.edit'  , 'uses' => 'SlackeventsController@edit']);
			Route::post('{id}'  , ['as' => 'admin.ninjaparade.slack.slackevents.edit'  , 'uses' => 'SlackeventsController@update']);

			Route::delete('{id}', ['as' => 'admin.ninjaparade.slack.slackevents.delete', 'uses' => 'SlackeventsController@delete']);
		});

		Route::group(['prefix'    => '/slack/slackevents','namespace' => 'Ninjaparade\Slack\Controllers\Frontend',], function()
		{
			Route::get('/' , ['as' => 'admin.ninjaparade.slack.slackevents.all', 'uses' => 'SlackeventsController@index']);
		});
	},

	/*
	|--------------------------------------------------------------------------
	| Database Seeds
	|--------------------------------------------------------------------------
	|
	| Platform provides a very simple way to seed your database with test
	| data using seed classes. All seed classes should be stored on the
	| `database/seeds` directory within your extension folder.
	|
	| The order you register your seed classes on the array below
	| matters, as they will be ran in the exact same order.
	|
	| The seeds array should follow the following structure:
	|
	|	Vendor\Namespace\Database\Seeds\FooSeeder
	|	Vendor\Namespace\Database\Seeds\BarSeeder
	|
	*/

	'seeds' => [

	],

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	|
	| Register here all the permissions that this extension has. These will
	| be shown in the user management area to build a graphical interface
	| where permissions can be selected to allow or deny user access.
	|
	| For detailed instructions on how to register the permissions, please
	| refer to the following url https://cartalyst.com/manual/permissions
	|
	*/

	'permissions' => function(Permissions $permissions)
	{
		$permissions->group('slackchannel', function($g)
		{
			$g->name = 'Slackchannels';

			$g->permission('slackchannel.index', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackchannels/permissions.index');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackchannelsController', 'index, grid');
			});

			$g->permission('slackchannel.create', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackchannels/permissions.create');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackchannelsController', 'create, store');
			});

			$g->permission('slackchannel.edit', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackchannels/permissions.edit');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackchannelsController', 'edit, update');
			});

			$g->permission('slackchannel.delete', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackchannels/permissions.delete');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackchannelsController', 'delete');
			});
		});

		$permissions->group('slackevent', function($g)
		{
			$g->name = 'Slackevents';

			$g->permission('slackevent.index', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackevents/permissions.index');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackeventsController', 'index, grid');
			});

			$g->permission('slackevent.create', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackevents/permissions.create');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackeventsController', 'create, store');
			});

			$g->permission('slackevent.edit', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackevents/permissions.edit');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackeventsController', 'edit, update');
			});

			$g->permission('slackevent.delete', function($p)
			{
				$p->label = trans('ninjaparade/slack::slackevents/permissions.delete');

				$p->controller('Ninjaparade\Slack\Controllers\Admin\SlackeventsController', 'delete');
			});
		});
	},

	/*
	|--------------------------------------------------------------------------
	| Widgets
	|--------------------------------------------------------------------------
	|
	| Closure that is called when the extension is started. You can register
	| all your custom widgets here. Of course, Platform will guess the
	| widget class for you, this is just for custom widgets or if you
	| do not wish to make a new class for a very small widget.
	|
	*/

	'widgets' => function()
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Settings
	|--------------------------------------------------------------------------
	|
	| Register any settings for your extension. You can also configure
	| the namespace and group that a setting belongs to.
	|
	*/

	'settings' => function(Settings $settings, Application $app)
	{

	},

	/*
	|--------------------------------------------------------------------------
	| Menus
	|--------------------------------------------------------------------------
	|
	| You may specify the default various menu hierarchy for your extension.
	| You can provide a recursive array of menu children and their children.
	| These will be created upon installation, synchronized upon upgrading
	| and removed upon uninstallation.
	|
	| Menu children are automatically put at the end of the menu for extensions
	| installed through the Operations extension.
	|
	| The default order (for extensions installed initially) can be
	| found by editing app/config/platform.php.
	|
	*/

	'menus' => [

		'admin' => [
			[
				'slug' => 'admin-ninjaparade-slack',
				'name' => 'Slack',
				'class' => 'fa fa-slack',
				'uri' => 'slack',
				'regex' => '/:admin\/slack/i',
				'children' => [
					[
						'slug' => 'admin-ninjaparade-slack-slackchannel',
						'name' => 'Slack Channels',
						'class' => 'fa fa-bullhorn',
						'uri' => 'slack/slackchannels',
					],
					[
						'slug' => 'admin-ninjaparade-slack-slackevent',
						'name' => 'Events',
						'class' => 'fa fa-rss',
						'uri' => 'slack/slackevents',
					],
				],
			],
		],
		'main' => [
			
		],
	],

];
