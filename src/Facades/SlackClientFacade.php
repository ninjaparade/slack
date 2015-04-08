<?php namespace Ninjaparade\Slack\Facades;

use Illuminate\Support\Facades\Facade;

class SlackClientFacade extends Facade {

  /**
   * 
   *
   * @return string
   */
  protected static function getFacadeAccessor() { 
  
  	return 'ninjaparade.slack';
  }

}
