<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlackchannelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slackchannels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('slug')->unique();
			$table->text('webhook');
			$table->string('send_as');
			$table->string('default_icon');
			$table->tinyInteger('expand_media')->default('1')->unsigned();
			$table->tinyInteger('expand_urls')->default('1')->unsigned();
			$table->tinyInteger('default')->default('0')->unsigned();
			$table->tinyInteger('active')->default('1')->unsigned();
			$table->timestamps();
			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slackchannels');
	}

}
