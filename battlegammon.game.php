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
    }
    $sql .= implode( ',', $values );
    self::DbQuery( $sql );
    self::reattributeColorsBasedOnPreferences( $players, $gameinfos['player_colors'] );
    self::reloadPlayersBasicInfos();

    /************ Start the game initialization *****/

    // Init global values with their initial values
    //self::setGameStateInitialValue( 'my_first_global_variable', 0 );

    // Insert dice record in dice_result table
    $sql = "INSERT INTO dice_result (dice1, dice2)
            VALUES (0, 0)";
    self::DbQuery( $sql );

    // Insert step record in steps table
    // @params: $step_id, $white_tokens, $black_tokens, $top_token_id, $bottom_token_id
    self::createStepRecord( 1, 5, 0, 1, 0);
    self::createStepRecord( 2);
    self::createStepRecord( 3);
    self::createStepRecord( 4);
    self::createStepRecord( 5, 1, 0, 6, 0);
    self::createStepRecord( 6);
    self::createStepRecord( 7);
    self::createStepRecord( 8, 2, 0, 7, 8);
    self::createStepRecord( 9, 2, 0, 9, 10);
    self::createStepRecord(10);
    self::createStepRecord(11);
    self::createStepRecord(12);
    self::createStepRecord(13);
    self::createStepRecord(14);
    self::createStepRecord(15);
    self::createStepRecord(16, 0, 1, 20, 0);
    self::createStepRecord(17);
    self::createStepRecord(18);
    self::createStepRecord(19, 0, 2, 18, 19);
    self::createStepRecord(20, 0, 2, 16, 17);
    self::createStepRecord(21);
    self::createStepRecord(22);
    self::createStepRecord(23);
    self::createStepRecord(24, 0, 5, 11, 0);

    // Insert token record in tokens table
    // @params: $token_id, $step_id
    self::createTokenRecord( 1,  1);
    self::createTokenRecord( 2,  1);
    self::createTokenRecord( 3,  1);
    self::createTokenRecord( 4,  1);
    self::createTokenRecord( 5,  1);
    self::createTokenRecord( 6,  5);
    self::createTokenRecord( 7,  8);
    self::createTokenRecord( 8,  8);
    self::createTokenRecord( 9,  9);
    self::createTokenRecord(10,  9);
    self::createTokenRecord(11, 24);
    self::createTokenRecord(12, 24);
    self::createTokenRecord(13, 24);
    self::createTokenRecord(14, 24);
    self::createTokenRecord(15, 24);
    self::createTokenRecord(16, 20);
    self::createTokenRecord(17, 20);
    self::createTokenRecord(18, 19);
    self::createTokenRecord(19, 19);
    self::createTokenRecord(20, 16);

    // Insert history record in histories table
    // @params: $turn, $dice_number, $token_id, $from_step_id, $to_step_id
    self::createHistoryRecord(0, 0,  1, 0,  1);
    self::createHistoryRecord(0, 0,  2, 0,  1);
    self::createHistoryRecord(0, 0,  3, 0,  1);
    self::createHistoryRecord(0, 0,  4, 0,  1);
    self::createHistoryRecord(0, 0,  5, 0,  1);
    self::createHistoryRecord(0, 0,  6, 0,  5);
    self::createHistoryRecord(0, 0,  7, 0,  8);
    self::createHistoryRecord(0, 0,  8, 0,  8);
    self::createHistoryRecord(0, 0,  9, 0,  9);
    self::createHistoryRecord(0, 0, 10, 0,  9);
    self::createHistoryRecord(0, 0, 11, 0, 24);
    self::createHistoryRecord(0, 0, 12, 0, 24);
    self::createHistoryRecord(0, 0, 13, 0, 24);
    self::createHistoryRecord(0, 0, 14, 0, 24);
    self::createHistoryRecord(0, 0, 15, 0, 24);
    self::createHistoryRecord(0, 0, 16, 0, 20);
    self::createHistoryRecord(0, 0, 17, 0, 20);
    self::createHistoryRecord(0, 0, 18, 0, 19);
    self::createHistoryRecord(0, 0, 19, 0, 19);
    self::createHistoryRecord(0, 0, 20, 0, 16);

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
    $active_player_id = $this->getActivePlayerId();
    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $active_color_code = self::getUniqueValueFromDB($sql);
    $active_color = ($active_color_code == 'ffffff') ? 'white' : 'black';

    // Get information about players
    // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
    $sql = "SELECT player_id id, player_score score FROM player";
    $result['players'] = self::getCollectionFromDb( $sql );

    // Get information about steps and tokens
    $sql = "SELECT * FROM steps";
    $result['steps'] = self::getObjectListFromDB($sql);

    // List all available steps
    $sql = "SELECT step_id FROM steps
            WHERE (white_tokens + black_tokens) < 2";
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
    if ($active_color == 'white') {
      $sql = "SELECT token_id, step_id FROM tokens
              WHERE available = 1 AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)";
    } else {
      $sql = "SELECT token_id, step_id FROM tokens
              WHERE available = 1 AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)";
    }
    $token_list = self::getObjectListFromDB($sql);
    foreach ($token_list as $token) {
      $result['availableTokens'][$token['step_id']] = $token['token_id'];
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
  function stRollDice()
  {
    $prev_turn_number = self::getStat("turns_number");
    if ($prev_turn_number != 0) {
      // notifyAllPlayers previous moves
      $prev_player_id = self::getActivePlayerId();
      $prev_player_name = self::getActivePlayerName();

      $sql = "SELECT player_color FROM player
              WHERE player_id=$prev_player_id";
      $prev_player_color = self::getUniqueValueFromDB($sql);

      $histories = self::getHistoryRecordsByTurn($prev_turn_number, $prev_player_color);
      foreach ($histories as $history) {
        self::notifyAllPlayers(
          "playerMoves",
          clienttranslate( '${player_name} uses dice ${dice_number} to move ${token_id} from ${from_step_id} to ${to_step_id}.' ),
          [
            'i18n' => array( 'additional' ),
            'player_name' => $prev_player_name,
            'dice_number' => $history['dice_number'],
            'token_id' => $history['token_id'],
            'from_step_id' => $history['from_step_id'],
            'to_step_id' => $history['to_step_id']
          ]
        );
      }
    }

    // set active player and update turns_number
    $this->activeNextPlayer();
    self::incStat(1, "turns_number");

    $active_player_id = self::getActivePlayerId();
    $active_player_name = self::getActivePlayerName();
    self::incStat(1, "turns_number", $active_player_id);

    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $active_color_code = self::getUniqueValueFromDB($sql);
    $active_color = ($active_color_code == 'ffffff') ? 'white' : 'black';

    // Roll dices
    $dice1_value = bga_rand(1, 6);
    $dice2_value = bga_rand(1, 6);

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

    // Notify all players about dice rolling
    self::notifyAllPlayers(
      "rollDiceDone",
      clienttranslate( '${player_name} roll dice and get ${dice1_value} and ${dice2_value}.' ),
      [
        'i18n' => array( 'additional' ),
        'player_name' => $active_player_name,
        'dice1_value' => $dice1_value,
        'dice2_value' => $dice2_value
      ]
    );

    // reset all tokens available
    $sql = "UPDATE tokens
            SET available = 0";
    self::DbQuery($sql);

    // set available tokens
    $sql = "SELECT top_token_id FROM steps
            WHERE " . $active_color . "_tokens > 0";
    $available_steps = self::getCollectionFromDB($sql);
    $token_ids = array_column($available_steps, 'top_token_id');
    $sql = "UPDATE tokens
            SET available = 1
            WHERE token_id IN (" . implode(',', $token_ids) . ")";
    self::DbQuery($sql);

    // TODO: check available steps and may go to pass
    $this->gamestate->nextState('selectDice1');
  }

  function stGameEnd()
  {
    $prev_turn_number = self::getStat("turns_number");
    if ($prev_turn_number != 0) {
      // notifyAllPlayers previous moves
      $prev_player_id = self::getActivePlayerId();
      $prev_player_name = self::getActivePlayerName();

      $sql = "SELECT player_color FROM player
              WHERE player_id=$prev_player_id";
      $prev_player_color = self::getUniqueValueFromDB($sql);

      $histories = self::getHistoryRecordsByTurn($prev_turn_number, $prev_player_color);
      foreach ($histories as $history) {
        self::notifyAllPlayers(
          "playerMoves",
          clienttranslate( '${player_name} uses dice ${dice_number} to move ${token_id} from ${from_step_id} to ${to_step_id}.' ),
          [
            'i18n' => array( 'additional' ),
            'player_name' => $prev_player_name,
            'dice_number' => $history['dice_number'],
            'token_id' => $history['token_id'],
            'from_step_id' => $history['from_step_id'],
            'to_step_id' => $history['to_step_id']
          ]
        );
      }
    }
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
   * Insert steps table
   * @param $step_id, 1-24.
   * @param $white_tokens, white tokens count.
   * @param $black_tokens, black tokens count.
   * @param $top_token_id
   * @param $bottom_token_id
   */
  function createStepRecord($step_id, $white_tokens = 0, $black_tokens = 0, $top_token_id = 0, $bottom_token_id = 0)
  {
    $sql = "INSERT INTO steps (step_id, white_tokens, black_tokens, top_token_id, bottom_token_id)
            VALUES ($step_id, $white_tokens, $black_tokens, $top_token_id, $bottom_token_id);";
    self::DbQuery($sql);
  }

  /**
   * Update steps table
   * @param $step_id, 1-24.
   * @param $white_tokens, white tokens count.
   * @param $black_tokens, black tokens count.
   * @param $top_token_id
   * @param $bottom_token_id
   */
  function updateStepRecord($step_id, $white_tokens, $black_tokens, $top_token_id, $bottom_token_id)
  {
    $sql = "UPDATE steps SET white_tokens=$white_tokens, black_tokens=$black_tokens, top_token_id=$top_token_id, bottom_token_id=$bottom_token_id
            WHERE step_id=$step_id;";
    self::DbQuery($sql);
  }

  /**
   * Get step record from steps table
   * @param $step_id, 1-24.
   */
  function getStepRecord($step_id)
  {
    $sql = "SELECT * FROM steps
            WHERE step_id = $step_id";
    return self::getObjectFromDB($sql);
  }

  /**
   * Insert tokens table
   * @param $token_id, 1-10 for white player and 11-20 for black player.
   * @param $step_id, token position.
   */
  function createTokenRecord($token_id, $step_id)
  {
    $sql = "INSERT INTO tokens (token_id, step_id)
            VALUES ($token_id, $step_id);";
    self::DbQuery($sql);
  }

  /**
   * Update tokens table
   * @param $token_id, 1-10 for white player and 11-20 for black player.
   * @param $step_id, token position.
   * @param $available
   */
  function updateTokenRecord($token_id, $step_id, $available = 0)
  {
    $sql = "UPDATE tokens SET step_id=$step_id, available=$available
            WHERE token_id=$token_id;";
    self::DbQuery($sql);
  }

  /**
   * Insert histories table
   * @param $turn
   * @param $dice_number
   * @param $token_id, 1-10 for white player and 11-20 for black player.
   * @param $from_step_id
   * @param $to_step_id
   */
  function createHistoryRecord($turn, $dice_number, $token_id, $from_step_id, $to_step_id)
  {
    $sql = "INSERT INTO histories (turn, dice_number, token_id, from_step_id, to_step_id)
            VALUES ($turn, $dice_number, $token_id, $from_step_id, $to_step_id);";
    self::DbQuery($sql);
  }

  /**
   * Get history records by turn number
   * @param $turn
   * @param $color, ffffff or 333333
   */
  function getHistoryRecordsByTurn($turn, $color)
  {
    if ($color == 'ffffff') {
      $sql = "SELECT * FROM histories
              WHERE turn = $turn
                AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
              ORDER BY history_id";
    } else {
      $sql = "SELECT * FROM histories
              WHERE turn = $turn
                AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
              ORDER BY history_id";
    }

    return self::getObjectListFromDB($sql);
  }

  /**
   * Destroy last history
   */
  function destroyLastHistorysRecord()
  {
    $sql = "DELETE FROM histories ORDER BY id DESC LIMIT 1";
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
   * @param $argJS [$token_id, $from_step, $to_step, $dice_number]
   */
  public function saveMoveFromClient($argJS)
  {
    $turn_number = self::getStat("turns_number");
    $token_id    = $argJS[0];
    $from_step   = $argJS[1];
    $to_step     = $argJS[2];
    $dice_number = $argJS[3];

    $active_player_id = $this->getActivePlayerId();
    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $active_color_code = self::getUniqueValueFromDB($sql);
    $active_color = ($active_color_code == 'ffffff') ? 'white' : 'black';

    $sql = "SELECT player_id FROM player
            WHERE player_id != $active_player_id";
    $opponent_id = self::getUniqueValueFromDB($sql);

    // Record in history
    self::createHistoryRecord($turn_number, $dice_number, $token_id, $from_step, $to_step);

    // update token record
    self::updateTokenRecord($token_id, $to_step, 0);

    // win?
    if ($active_color == 'white') {
      $sql = "SELECT COUNT(token_id) FROM tokens
              WHERE step_id IN (13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24)
                AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)";
      $white_tokens_in_black_steps_count = self::getUniqueValueFromDb($sql);
      if ($white_tokens_in_black_steps_count == 8) {
        $this->gamestate->nextState( 'end' );
      }
    } else {
      $sql = "SELECT COUNT(token_id) FROM tokens
              WHERE step_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)
                AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)";
      $black_tokens_in_white_steps_count = self::getUniqueValueFromDb($sql);
      if ($black_tokens_in_white_steps_count == 8) {
        $this->gamestate->nextState( 'end' );
      }
    }

    // update for "from steps"
    $from_step_record = self::getStepRecord($from_step);
    switch ($from_step_record['step_id']) {
      case '1': // white home
        if ($from_step_record['white_tokens'] > 0) {
          $white_tokens = $from_step_record['white_tokens'] - 1;
          $black_tokens = $from_step_record['black_tokens'];
          $bottom_token_id = 0;
          if ($white_tokens == 0) {
            $top_token_id = 0;
          } else {
            $top_token_id = $from_step_record['top_token_id'] + 1;
          }
        }
        break;
      case '24': // black home
        if ($from_step_record['black_tokens'] > 0) {
          $white_tokens = $from_step_record['white_tokens'];
          $black_tokens = $from_step_record['black_tokens'] - 1;
          $bottom_token_id = 0;
          if ($black_tokens == 0) {
            $top_token_id = 0;
          } else {
            $top_token_id = $from_step_record['top_token_id'] + 1;
          }
        }
        break;
      default:
        $tokens_count = $from_step_record['white_tokens'] + $from_step_record['black_tokens'];
        $sql = "SELECT COUNT(token_id) FROM tokens
                WHERE step_id=$from_step AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)";
        $white_tokens = self::getUniqueValueFromDb($sql);

        $sql = "SELECT COUNT(token_id) FROM tokens
                WHERE step_id=$from_step AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)";
        $black_tokens = self::getUniqueValueFromDb($sql);

        if (($active_color == 'white' && $to_step > $from_step) ||
            ($active_color == 'black' && $from_step > $to_step))
        {
          $bottom_token_id = 0;
          if ($tokens_count == 2) {
            $top_token_id = $from_step_record['bottom_token_id'];
          }

          if ($tokens_count == 1) {
            $top_token_id = 0;
          }
        }
        break;
    }
    self::updateStepRecord($from_step, $white_tokens, $black_tokens, $top_token_id, $bottom_token_id);

    // Record in "to steps"
    $to_step_record = self::getStepRecord($to_step);
    switch ($to_step_record['step_id']) {
      case '1': // white home
        if ($to_step_record['black_tokens'] < 3) {
          $white_tokens = $to_step_record['white_tokens'];
          $black_tokens = $to_step_record['black_tokens'] + 1;

          // win?
          if ($black_tokens == 3) {
            $this->gamestate->nextState( 'end' );
          }

          $top_token_id = $token_id;
          $bottom_token_id = 0;
        }
        break;
      case '24': // black home
        if ($to_step_record['white_tokens'] < 3) {
          $white_tokens = $to_step_record['white_tokens'] + 1;
          $black_tokens = $to_step_record['black_tokens'];

          // win?
          if ($white_tokens == 3) {
            $this->gamestate->nextState( 'end' );
          }

          $top_token_id = $token_id;
          $bottom_token_id = 0;
        }
        break;
      default:
        $tokens_count = $to_step_record['white_tokens'] + $to_step_record['black_tokens'];
        $sql = "SELECT COUNT(token_id) FROM tokens
                WHERE step_id=$to_step AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)";
        $white_tokens = self::getUniqueValueFromDb($sql);

        $sql = "SELECT COUNT(token_id) FROM tokens
                WHERE step_id=$to_step AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)";
        $black_tokens = self::getUniqueValueFromDb($sql);

        if (($active_color == 'white' && $to_step > $from_step) ||
            ($active_color == 'black' && $from_step > $to_step))
        {
          $top_token_id = $token_id;
          if ($tokens_count == 0) {
            $bottom_token_id = 0;
          }

          if ($tokens_count == 1) {
            $bottom_token_id = $to_step_record['top_token_id'];
          }
        }
        break;
    }
    self::updateStepRecord($to_step, $white_tokens, $black_tokens, $top_token_id, $bottom_token_id);

    self::updateDiceNotAvailable($dice_number);

    self::notifyPlayer(
      $active_player_id,
      "temporaryMove",
      clienttranslate( '[TEMPORARY] ${player_name} TEMPORARY uses dice ${dice_number} to move ${token_id} from ${from_step_id} to ${to_step_id}.' ),
      [
        'i18n' => array( 'additional' ),
        'player_name' => self::getActivePlayerName(),
        'dice_number' => $dice_number,
        'token_id' => $token_id,
        'from_step_id' => $from_step,
        'to_step_id' => $to_step
      ]
    );

    $state = $this->gamestate->state();
    switch ($state['name']) {
      case 'selectTokenByDice1':
        $this->gamestate->nextState( 'selectDice2' );
        break;
      case 'selectTokenByDice2':
        $this->gamestate->nextState( 'roll' );
        break;
    }
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
    $active_player_id = $this->getActivePlayerId();
    $sql = "SELECT player_color FROM player
            WHERE player_id=$active_player_id";
    $active_color_code = self::getUniqueValueFromDB($sql);
    $active_color = ($active_color_code == 'ffffff') ? 'white' : 'black';

    $result = array();

    // List dice
    $sql = "SELECT dice1, dice1_available, dice2, dice2_available
            FROM dice_result";
    $result['dice_result'] = self::getObjectFromDB($sql);

    // List all available steps
    $sql = "SELECT step_id FROM steps
            WHERE (white_tokens + black_tokens) < 2";
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
    if ($active_color == 'white') {
      $sql = "SELECT token_id, step_id FROM tokens
              WHERE available = 1 AND token_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)";
    } else {
      $sql = "SELECT token_id, step_id FROM tokens
              WHERE available = 1 AND token_id IN (11, 12, 13, 14, 15, 16, 17, 18, 19, 20)";
    }
    $token_list = self::getObjectListFromDB($sql);
    foreach ($token_list as $token) {
      $result['availableTokens'][$token['step_id']] = $token['token_id'];
    }

    return [
      'color'           => $active_color,
      'dice_result'     => $result['dice_result'],
      'availableSteps'  => $result['availableSteps'],
      'availableTokens' => $result['availableTokens']
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
