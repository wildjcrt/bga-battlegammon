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
 * states.inc.php
 *
 * Battlegammon game states description
 *
 */

$machinestates = array(

  // The initial state. Please do not modify.
  1 => array(
    "name" => "gameSetup",
    "description" => "Game setup",
    "type" => "manager",
    "transitions" => [
      "" => 10
    ]
  ),

  10 => array(
    "name" => "rollDice",
    "description" => clienttranslate('Roll dice.'),
    "type" => "game",
    "action" => "stRollDice",
    "updateGameProgression" => true,
    "transitions" => [
      "" => 21
    ]
  ),

  21 => array(
    "name" => "selectTokenByDice1",
    "description" => clienttranslate('${actplayer} turn.'),
    "descriptionmyturn" => clienttranslate('Your turn. Click a ${color} token to do first move.'),
    "type" => "activeplayer",
    "args" => "argSelectToken",
    "possibleactions" => [
      "actMove",
      "actPass"
    ],
    "transitions" => [
      "selectDice2" => 22,
      "pass" => 10,
      "end"  => 24
    ]
  ),

  22 => array(
    "name" => "selectTokenByDice2",
    "description" => clienttranslate('${actplayer} choose second token.'),
    "descriptionmyturn" => clienttranslate('Your turn. Click a ${color} token to do second move.'),
    "type" => "activeplayer",
    "args" => "argSelectToken",
    "possibleactions" => [
      "actMove",
      "actPass",
      "actUndo"
    ],
    "transitions" => [
      "confirm" => 23,
      "undo" => 21,
      "pass" => 10,
      "end"  => 24
    ]
  ),

  23 => array(
    "name" => "confrimMoves",
    "description" => clienttranslate('${actplayer} confirm.'),
    "descriptionmyturn" => clienttranslate('Your turn. Click a ${color} token to do second move.'),
    "type" => "activeplayer",
    "args" => "argSelectToken",
    "possibleactions" => [
      "actConfirm",
      "actUndo"
    ],
    "transitions" => [
      "roll" => 10,
      "undo" => 22
    ]
  ),

  24 => array(
    "name" => "beforeGameEnd",
    "description" => clienttranslate('Ending game.'),
    "type" => "game",
    "action" => "stBeforeGameEnd",
    "updateGameProgression" => true,
    "transitions" => [
      "" => 99
    ]
  ),

  // Final state.
  // Please do not modify (and do not overload action/args methods).
  99 => array(
    "name" => "gameEnd",
    "description" => clienttranslate("End of game"),
    "type" => "manager",
    "action" => "stGameEnd",
    "args" => "argGameEnd"
  )

);
