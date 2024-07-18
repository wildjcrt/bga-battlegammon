
-- ------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- Battlegammon implementation : © <wildjcrt> <wildjcrt@gmail.com>
--
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-- -----

-- dbmodel.sql

-- This is the file where you are describing the database schema of your game
-- Basically, you just have to export from PhpMyAdmin your table structure and copy/paste
-- this export here.
-- Note that the database itself and the standard tables ("global", "stats", "gamelog" and "player") are
-- already created and must not be created here

-- Note: The database schema is created from this file when the game starts. If you modify this file,
--   you have to restart a game to see your changes in database.

-- Example 1: create a standard "card" table to be used with the "Deck" tools (see example game "hearts"):

-- CREATE TABLE IF NOT EXISTS `card` (
--   `card_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
--   `card_type` varchar(16) NOT NULL,
--   `card_type_arg` int(11) NOT NULL,
--   `card_location` varchar(16) NOT NULL,
--   `card_location_arg` int(11) NOT NULL,
--   PRIMARY KEY (`card_id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- Example 2: add a custom field to the standard "player" table
-- ALTER TABLE `player` ADD `player_my_custom_field` INT UNSIGNED NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS steps (
  `step_id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `tokens` int(2) unsigned NOT NULL DEFAULT 0,
  `top_player_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`step_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS token_history (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `turn` int(2) unsigned NOT NULL DEFAULT 0,
  `dice_value` int(2) unsigned NOT NULL DEFAULT 0,
  `token_id` int(2) unsigned NOT NULL DEFAULT 0,
  `player_id` int(10) unsigned NOT NULL DEFAULT 0,
  `from_step_id` int(2) unsigned NOT NULL DEFAULT 0,
  `to_step_id` int(2) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS dice_result (
  `dice1` int(2) unsigned NOT NULL DEFAULT 0,
  `dice1_usable` BIT(1) NOT NULL DEFAULT 0,
  `dice2` int(2) unsigned NOT NULL DEFAULT 0,
  `dice2_usable` BIT(1) NOT NULL DEFAULT 0,
 PRIMARY KEY (`dice1`, `dice2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
