<?php
 /**
  *------
  * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
  * Battlegammon implementation : © <wildjcrt> <wildjcrt@gmail.com>
  *
  * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
  * See http://en.boardgamearena.com/#!doc/Studio for more information.
  * -----
  *
  * battlegammon.game.php
  *
  * This is the main file for your game logic.
  *
  * In this PHP file, you are going to defines the rules of the game.
  *
  */


require_once( APP_GAMEMODULE_PATH.'module/table/table.game.php' );

function print_msg($txt, $color = 'black')
{

  if (is_array($txt)) {
    echo "<textarea style='color: $color; width:50%; height:100px;background-color: #f3f3f3 '>";
    print_r($txt);
    echo "</textarea><br>";
  } else {
    echo "<pre style='color: $color'>";
    print_r($txt);
    echo "</pre>";
  }
}


class Battlegammon extends Table
{
  function __construct( )
  {
    // Your global variables labels:
    //  Here, you can assign labels to global variables you are using for this game.
    //  You can use any number of global variables with IDs between 10 and 99.
    //  If your game has options (variants), you also have to associate here a label to
    //  the corresponding ID in gameoptions.inc.php.
    // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
    parent::__construct();

    self::initGameStateLabels( array(
      //  "my_first_global_variable" => 10,
      //  "my_second_global_variable" => 11,
      //  ...
      //  "my_first_game_variant" => 100,
      //  "my_second_game_variant" => 101,
      //  ...
    ) );
  }

  protected function getGameName( )
  {
    // Used for translations and stuff. Please do not modify.
    return "battlegammon";
  }

  /*
  setupNewGame:

  This method is called only once, when a new game is launched.
  In this method, you must setup the game according to the game rules, so that
  the game is ready to be played.
  */
  protected function setupNewGame( $players, $options = array() )
  {
    // Set the colors of the players with HTML color code
    // The default below is red/green/blue/orange/brown
    // The number of colors defined here must correspond to the maximum number of players allowed for the gams
    $gameinfos = self::getGameinfos();
    $default_colors = $gameinfos['player_colors'];

    // Create players
    // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
    $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
    $values = array();
    foreach( $players as $player_id => $player )
    {
      $color = array_shift( $default_colors );
      $values[] = "('".$player_id."','$color','".$player['player_canal']."','".addslashes( $player['player_name'] )."','".addslashes( $player['player_avatar'] )."')";

      if ($color == 'ffffff') {
        $white_player_id = $player_id;
      } else {
        $black_player_id = $player_id;
      }
    }
    $sql .= implode( ',', $values );
    self::DbQuery( $sql );
    self::reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
    self::reloadPlayersBasicInfos();

    /************ Start the game initialization *****/

    // Init global values with their initial values
    //self::setGameStateInitialValue( 'my_first_global_variable', 0 );

    // Insert dice record in dice_result table
    $sql = "INSERT INTO dice_result (dice1, dice2) VALUES (0, 0) ";
    self::DbQuery( $sql );

    // Init game statistics
    // (note: statistics used in this file must be defined in your stats.inc.php file)
    //self::initStat( 'table', 'table_teststat1', 0 );  // Init a table statistics
    //self::initStat( 'player', 'player_teststat1', 0 );  // Init a player statistics (for all players)
    // init statistics
    self::initStat("table", "turns_number", 0);
    self::initStat("player", "turns_number", 0);
    self::initStat("player", "dice1", 0);
    self::initStat("player", "dice2", 0);
    self::initStat("player", "dice3", 0);
    self::initStat("player", "dice4", 0);
    self::initStat("player", "dice5", 0);
    self::initStat("player", "dice6", 0);
    self::initStat("player", "number_of_pass", 0);

    // Insert steps record in steps table
    self::createStepsRecord( 1, 5, $white_player_id);
    self::createStepsRecord( 2, 0, 0);
    self::createStepsRecord( 3, 0, 0);
    self::createStepsRecord( 4, 0, 0);
    self::createStepsRecord( 5, 1, $white_player_id);
    self::createStepsRecord( 6, 0, 0);
    self::createStepsRecord( 7, 0, 0);
    self::createStepsRecord( 8, 2, $white_player_id);
    self::createStepsRecord( 9, 2, $white_player_id);
    self::createStepsRecord(10, 0, 0);
    self::createStepsRecord(11, 0, 0);
    self::createStepsRecord(12, 0, 0);
    self::createStepsRecord(13, 0, 0);
    self::createStepsRecord(14, 0, 0);
    self::createStepsRecord(15, 0, 0);
    self::createStepsRecord(16, 1, $black_player_id);
    self::createStepsRecord(17, 0, 0);
    self::createStepsRecord(18, 0, 0);
    self::createStepsRecord(19, 2, $black_player_id);
    self::createStepsRecord(20, 2, $black_player_id);
    self::createStepsRecord(21, 0, 0);
    self::createStepsRecord(22, 0, 0);
    self::createStepsRecord(23, 0, 0);
    self::createStepsRecord(24, 5, $black_player_id);

    // Activate first player (which is in general a good idea :) )
    $this->activeNextPlayer();

    /************ End of the game initialization *****/
  }

  /*
  getAllDatas:

  Gather all informations about current game situation (visible by the current player).

  The method is called each time the game interface is displayed to a player, ie:
  _ when the game starts
  _ when a player refreshes the game page (F5)
  */
  protected function getAllDatas()
  {
    $result = array();

    $current_player_id = self::getCurrentPlayerId();  // !! We must only return informations visible by this player !!

    // Get information about players
    // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
    $sql = "SELECT player_id id, player_score score FROM player";
    $result['players'] = self::getCollectionFromDb( $sql );

    // TODO: Gather all information about current game situation (visible by player $current_player_id).

    // Get information about the dice roll
    $sql = "SELECT dice1, dice1_available, dice2, dice2_available
            FROM dice_result";
    $result['dice_result'] = self::getObjectFromDB($sql);

    // Get information about steps and tokens
    $sql = "SELECT step_id, tokens, top_player_id FROM steps
            WHERE tokens != 0";
    $result['steps'] = self::getObjectListFromDB($sql);

    // List all available steps
    $sql = "SELECT step_id FROM steps
            WHERE tokens < 2";
    $steps_list = self::getObjectListFromDB($sql);
    $result['availableSteps'] = array();
    foreach ($steps_list as $item) {
      $result['availableSteps'][] = $item['step_id'];
    }
    if (!in_array('1', $result['availableSteps'])) {
        $result['availableSteps'][] = '1';
    }
    if (!in_array('24', $result['availableSteps'])) {
        $result['availableSteps'][] = '24';
    }
    sort($result['availableSteps'], SORT_NUMERIC);

    // List all available tokens
    $active_player_id = $this->getActivePlayerId();
    $sql = "SELECT step_id FROM steps
            WHERE top_player_id = $active_player_id";
    $steps_list = self::getObjectListFromDB($sql);
    $result['availableTokens'] = array();
    foreach ($steps_list as $item) {
      $result['availableTokens'][] = $item['step_id'];
    }

    return $result;
  }

  /*
  getGameProgression:

  Compute and return the current game progression.
  The number returned must be an integer beween 0 (=the game just started) and
  100 (= the game is finished or almost finished).

  This method is called each time we are in a game state with the "updateGameProgression" property set to true
  (see states.inc.php)
  */
  function getGameProgression()
  {
    // TODO: compute and return the game progression

    return 0;
  }


//////////////////////////////////////////////////////////////////////////////
//////////// Utility functions
////////////

  /*
  In this space, you can put any utility methods useful for your game logic
  */
  /**
   * Roll new dice and notify players that dice has been rolled
   */
  private function rollDice()
  {
    self::incStat(1, "turns_number");

    $active_player_id = self::getActivePlayerId();
    self::incStat(1, "turns_number", $active_player_id);

    // Roll dices
    $dice1_value = bga_rand(1, 6);
    $dice2_value = bga_rand(1, 6);

    // Notify all players about dice rolling
    self::notifyAllPlayers(
      "rollDiceDone",
      clienttranslate( '${player_name} roll dice and get ${dice1_value} and ${dice2_value}' ),
      [
        'i18n' => array( 'additional' ),
        'player_name' => self::getActivePlayerName(),
        'dice1_value' => $dice1_value,
        'dice2_value' => $dice2_value
      ]
    );

    // save dice roll in database
    $sql = "UPDATE dice_result
            SET dice1 = $dice1_value,
                dice2 = $dice2_value,
                dice1_available=1,
                dice2_available=1";
    self::DbQuery( $sql );
    self::reloadPlayersBasicInfos();

    self::incStat(1, "dice" . $dice1_value, $active_player_id);
    self::incStat(1, "dice" . $dice2_value, $active_player_id);

    return array($dice1_value, $dice2_value);
  }

  /**
   * Update used dice number to dice_available: 0
   * @param $dice_number
   */
  function updateDiceNotAvailable($dice_number)
  {
    $sql = "SELECT dice1, dice1_available, dice2, dice2_available
            FROM dice_result";
    $dice_result = self::getObjectFromDB($sql);

    if ($dice_result['dice1'] == $dice_number) {
      $sql = "UPDATE dice_result SET dice1_available=0";
    } else {
      $sql = "UPDATE dice_result SET dice2_available=0";
    }
    self::DbQuery($sql);
  }

  /**
   * Insert steps table with $step_id, $tokens, $top_player_id
   * @param $step_id, 1-24.
   * @param $tokens, 0-5 and 20. 20 means 2 tokens but lower is another color.
   * @param $top_player_id
   */
  function createStepsRecord($step_id, $tokens, $top_player_id)
  {
    $sql = "INSERT INTO steps (step_id, tokens, top_player_id) VALUES ($step_id, $tokens, $top_player_id);";
    self::DbQuery($sql);
  }

  /**
   * Update steps table with $step_id, $tokens, $top_player_id
   * @param $step_id, 1-24.
   * @param $tokens, 0-5 and 20. 20 means 2 tokens but lower is another color.
   * @param $top_player_id
   */
  function updateStepsRecord($step_id, $tokens, $top_player_id)
  {
    $sql = "UPDATE steps SET tokens=$tokens, top_player_id=$top_player_id WHERE step_id=$step_id;";
    self::DbQuery($sql);
  }

//////////////////////////////////////////////////////////////////////////////
//////////// Player actions
////////////

  /*
  Each time a player is doing some game action, one of the methods below is called.
  (note: each method below must match an input method in battlegammon.action.php)
  */

  /*

  Example:

  function playCard( $card_id )
  {
    // Check that this is the player's turn and that it is a "possible action" at this game state (see states.inc.php)
    self::checkAction( 'playCard' );

    $player_id = self::getActivePlayerId();

    // Add your game logic to play a card there
    ...

    // Notify all players about the card played
    self::notifyAllPlayers( "cardPlayed", clienttranslate( '${player_name} plays ${card_name}' ), array(
      'player_id' => $player_id,
      'player_name' => self::getActivePlayerName(),
      'card_name' => $card_name,
      'card_id' => $card_id
    ) );

  }

  */

  /**
   * save move from client
   * check if this move is valid and change board and go to next state
   * @param $argJS [$token_id, $from_step, $to_step, $dice_value]
   */
  public function saveMoveFromClient($argJS)
  {

    // Record in token_history
    $turn_number = self::getStat("turns_number");
    $active_player_id = $this->getActivePlayerId();
    $token_id   = $argJS[0];
    $from_step  = $argJS[1];
    $to_step    = $argJS[2];
    $dice_value = $argJS[3];
    //
    // $sql = "INSERT INTO token_history (dice_value, token_id, player_id, from_step_id, to_step_id) VALUES ($dice_value, $token_id, $active_player_id, $from_step, $to_step);";
    // self::DbQuery($sql);

    // Record in "from steps"
    $sql = "SELECT tokens FROM steps
            WHERE step_id=$from_step AND top_player_id=$active_player_id";
    $from_tokens = self::getUniqueValueFromDB($sql);
    if ($from_tokens > 0)
    {
      if ($from_tokens != 20) {
        $from_tokens -= 1;
        $from_top_player_id = $active_player_id;
      } else {
        $from_tokens = 1;
        $sql = "SELECT player_id FROM player
                WHERE player_id!=$active_player_id";
        $from_top_player_id = self::getUniqueValueFromDB($sql);
      }
    }

    $sql = "UPDATE steps SET tokens=$from_tokens, top_player_id=$from_top_player_id
            WHERE step_id=$from_step";
    self::DbQuery($sql);

    // Record in "to steps"
    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $color_code = self::getUniqueValueFromDB($sql);

    $sql = "SELECT tokens, top_player_id FROM steps
            WHERE step_id=$to_step";
    $to_step_result = self::getObjectFromDB($sql);
    $to_tokens = $to_step_result['tokens'];
    $to_top_player_id = $to_step_result['top_player_id'];

    if ($to_step == 1 && $color_code == 'ffffff') {
      # code...
    }

    if ($to_step == 24 && $color_code == '333333') {
      # code...
    }

    if ($to_step >= 2 && $to_step <= 23)
    {
      switch ($to_tokens) {
        case 0:
          $to_tokens = 1;
          break;
        case 1:
          if ($to_top_player_id == $active_player_id) {
            $to_tokens = 2;
          } else {
            $to_tokens = 20;
          }
          break;
        case 2:
          if ($to_top_player_id == $active_player_id) {
            $to_tokens = 3;
          }
          break;
        case 3:
          if ($to_top_player_id == $active_player_id) {
            $to_tokens = 4;
          }
          break;
        case 4:
          if ($to_top_player_id == $active_player_id) {
            $to_tokens = 5;
          }
          break;
      }
    }

    $sql = "UPDATE steps SET tokens=$to_tokens, top_player_id=$to_top_player_id
            WHERE step_id=$to_step";
    self::DbQuery($sql);

    self::updateDiceNotAvailable($dice_value);

    $this->gamestate->nextState( 'selectTokenB' );
  }

//////////////////////////////////////////////////////////////////////////////
//////////// Game state arguments
////////////

  /*
  Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
  These methods function is to return some additional information that is specific to the current
  game state.
  */

  /*

  Example for game state "MyGameState":

  function argMyGameState()
  {
    // Get some values from the current game situation in database...

    // return values:
    return array(
      'variable1' => $value1,
      'variable2' => $value2,
      ...
    );
  }
  */

  function argSelectToken()
  {
    // List all available dice
    $sql = "SELECT dice1, dice1_available, dice2, dice2_available
            FROM dice_result";
    $dice_result = self::getObjectFromDB($sql);
    $availableDice = array();
    if ($dice_result['dice1_available'] == 1) {
      $availableDice[] = $dice_result['dice1'];
    }
    if ($dice_result['dice2_available'] == 1) {
      $availableDice[] = $dice_result['dice2'];
    }

    // List all available steps
    $sql = "SELECT step_id FROM steps
            WHERE tokens < 2";
    $steps_list = self::getObjectListFromDB($sql);
    $availableSteps = array();
    foreach ($steps_list as $item) {
      $availableSteps[] = $item['step_id'];
    }
    if (!in_array('1', $availableSteps)) {
        $availableSteps[] = '1';
    }
    if (!in_array('24', $availableSteps)) {
        $availableSteps[] = '24';
    }
    sort($availableSteps, SORT_NUMERIC);

    // List all available tokens
    $active_player_id = $this->getActivePlayerId();
    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $color_code = self::getUniqueValueFromDB($sql);
    $active_player_color = ($color_code == 'ffffff') ? 'white' : 'black';

    $sql = "SELECT step_id FROM steps
            WHERE top_player_id = $active_player_id";
    $steps_list = self::getObjectListFromDB($sql);
    $availableTokens = array();
    foreach ($steps_list as $item) {
      $availableTokens[] = $item['step_id'];
    }

    return [
      'color'           => $active_player_color,
      'availableSteps'  => $availableSteps,
      'availableTokens' => $availableTokens,
      'availableDice'   => $availableDice
    ];
  }

//////////////////////////////////////////////////////////////////////////////
//////////// Game state actions
////////////

  /*
  Here, you can create methods defined as "game state actions" (see "action" property in states.inc.php).
  The action method of state X is called everytime the current game state is set to X.
  */

  /*

  Example for game state "MyGameState":

  function stMyGameState()
  {
    // Do some stuff ...

    // (very often) go to another gamestate
    $this->gamestate->nextState( 'some_gamestate_transition' );
  }
  */

//////////////////////////////////////////////////////////////////////////////
//////////// Zombie
////////////

  /*
  zombieTurn:

  This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
  You can do whatever you want in order to make sure the turn of this player ends appropriately
  (ex: pass).

  Important: your zombie code will be called when the player leaves the game. This action is triggered
  from the main site and propagated to the gameserver from a server, not from a browser.
  As a consequence, there is no current player associated to this action. In your zombieTurn function,
  you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message.
  */

  function zombieTurn( $state, $active_player )
  {
    $statename = $state['name'];

    if ($state['type'] === "activeplayer") {
      switch ($statename) {
      default:
        $this->gamestate->nextState( "zombiePass" );
        break;
      }

      return;
    }

    if ($state['type'] === "multipleactiveplayer") {
      // Make sure player is in a non blocking status for role turn
      $this->gamestate->setPlayerNonMultiactive( $active_player, '' );

      return;
    }

    throw new feException( "Zombie mode not supported at this game state: ".$statename );
  }

///////////////////////////////////////////////////////////////////////////////////:
////////// DB upgrade
//////////

  /*
  upgradeTableDb:

  You don't have to care about this until your game has been published on BGA.
  Once your game is on BGA, this method is called everytime the system detects a game running with your old
  Database scheme.
  In this case, if you change your Database scheme, you just have to apply the needed changes in order to
  update the game database and allow the game to continue to run with your new version.

  */

  function upgradeTableDb( $from_version )
  {
    // $from_version is the current version of this game database, in numerical form.
    // For example, if the game was running with a release of your game named "140430-1345",
    // $from_version is equal to 1404301345

    // Example:
    //  if( $from_version <= 1404301345 )
    //  {
    //    // ! important ! Use DBPREFIX_<table_name> for all tables
    //
    //    $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
    //    self::applyDbUpgradeToAllDB( $sql );
    //  }
    //  if( $from_version <= 1405061421 )
    //  {
    //    // ! important ! Use DBPREFIX_<table_name> for all tables
    //
    //    $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
    //    self::applyDbUpgradeToAllDB( $sql );
    //  }
    //  // Please add your future database scheme changes here
    //
    //
  }
}
