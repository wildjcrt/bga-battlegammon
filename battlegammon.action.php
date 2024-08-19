<?php
/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * Battlegammon implementation : © <wildjcrt> <wildjcrt@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on https://boardgamearena.com.
 * See http://en.doc.boardgamearena.com/Studio for more information.
 * -----
 *
 * battlegammon.action.php
 *
 * Battlegammon main action entry point
 *
 *
 * In this file, you are describing all the methods that can be called from your
 * user interface logic (javascript).
 *
 * If you define a method "myAction" here, then you can call it from your javascript code with:
 * this.ajaxcall( "/battlegammon/battlegammon/myAction.html", ...)
 *
 */


class action_battlegammon extends APP_GameAction
{
  // Constructor: please do not modify
  public function __default()
  {
    if( self::isArg( 'notifwindow') )
    {
      $this->view = "common_notifwindow";
      $this->viewArgs['table'] = self::getArg( "table", AT_posint, true );
    }
    else
    {
      $this->view = "battlegammon_battlegammon";
      self::trace( "Complete reinitialization of board game" );
    }
  }

  public function actMove()
  {
      self::setAjaxMode();
      $token_id    = self::getArg( "token_id", AT_alphanum, true );
      $from_step   = self::getArg( "from_step", AT_alphanum, true );
      $to_step     = self::getArg( "to_step", AT_alphanum, true );
      $dice_number = self::getArg( "dice_number", AT_alphanum, true );
      $this->game->actMove([$token_id, $from_step, $to_step, $dice_number]);
      self::ajaxResponse( );
  }

  public function sendPassToServer()
  {
      self::setAjaxMode();
      $this->game->savePassFromClient();
      self::ajaxResponse( );
  }

  /*

  Example:

  public function myAction()
  {
  self::setAjaxMode();

  // Retrieve arguments
  // Note: these arguments correspond to what has been sent through the javascript "ajaxcall" method
  $arg1 = self::getArg( "myArgument1", AT_posint, true );
  $arg2 = self::getArg( "myArgument2", AT_posint, true );

  // Then, call the appropriate method in your game logic, like "playCard" or "myAction"
  $this->game->myAction( $arg1, $arg2 );

  self::ajaxResponse( );
  }

  */

}
