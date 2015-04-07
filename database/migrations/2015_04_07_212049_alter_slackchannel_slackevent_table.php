<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSlackchannelSlackeventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slackchannel_slackevent', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('slackchannel_id')->unsigned()->index();
			$table->integer('slackevent_id')->unsigned()->index();
			$table->foreign('slackchannel_id')->references('id')->on('slackchannels')->onDelete('cascade');
			$table->foreign('slackevent_id')->references('id')->on('slackevents')->onDelete('cascade');
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
		Schema::drop('slackchannel_slackevent');
	}

}
