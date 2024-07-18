/**
 *------
 * BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
 * Battlegammon implementation : © <wildjcrt> <wildjcrt@gmail.com>
 *
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 *
 * battlegammon.js
 *
 * Battlegammon user interface script
 *
 * In this file, you are describing the logic of your user interface, in Javascript language.
 *
 */

define([
  "dojo","dojo/_base/declare",
  "ebg/core/gamegui",
  "ebg/counter"
],
function (dojo, declare) {
  return declare("bgagame.battlegammon", ebg.core.gamegui, {
    constructor: function(){
      // console.log( 'battlegammon.js >> battlegammon constructor' );

      // Here, you can init the global variables of your user interface
      // Example:
      // this.myGlobalValue = 0;
      this.colorMapping = {'ffffff': 'white', '333333': 'black'};
      this.numberMapping = {
        1:  'one',
        2:  'two',
        3:  'three',
        4:  'four',
        5:  'five'
      };
      this.directionMapping = {
        'white': {
          1:  'left',
          2:  'left',
          3:  'left',
          4:  'left',
          5:  'left',
          6:  'left',
          7:  'left',
          8:  'left',
          9:  'right',
          10: 'right',
          11: 'right',
          12: 'right',
          13: 'right',
          14: 'right',
          15: 'right',
          16: 'right',
          17: 'left',
          18: 'left',
          19: 'left',
          20: 'left',
          21: 'left',
          22: 'left',
          23: 'left',
          24: 'left'
        },
        'black': {
          1:  'right',
          2:  'right',
          3:  'right',
          4:  'right',
          5:  'right',
          6:  'right',
          7:  'right',
          8:  'right',
          9:  'left',
          10: 'left',
          11: 'left',
          12: 'left',
          13: 'left',
          14: 'left',
          15: 'left',
          16: 'left',
          17: 'right',
          18: 'right',
          19: 'right',
          20: 'right',
          21: 'right',
          22: 'right',
          23: 'right',
          24: 'right'
        }
      };
    },

    /*
      setup:

      This method must set up the game user interface according to current game situation specified
      in parameters.

      The method is called each time the game interface is displayed to a player, ie:
      _ when the game starts
      _ when a player refreshes the game page (F5)

      "gamedatas" argument contains all datas retrieved by your "getAllDatas" PHP method.
    */

    setup: function( gamedatas )
    {
      // console.log( 'battlegammon.js >> Starting game setup' );

      // Setting up player boards
      for ( var playerId in gamedatas.players )
      {
        var player = gamedatas.players[playerId];
        var colorName = this.colorMapping[player.color];
        var directionMappingByColor = this.directionMapping[colorName];

        // place tokens
        playerSteps = gamedatas.steps.filter( function(el) {
                        return el.top_player_id === playerId;
                      } );
        for (var i = 0; i < playerSteps.length; i++)
        {
          var step = playerSteps[i],
              directionName = directionMappingByColor[step.step_id],
              tokenNumber, tokenColorAndNumber;

          if (step.tokens !== '20') {
            tokenNumber = this.numberMapping[step.tokens];
            tokenColorAndNumber = `${colorName}-${tokenNumber}`;
          } else {
            tokenNumber = 'two';
            tokenColorAndNumber = (colorName === 'white') ? 'white-and-black' : 'black-and-white';
          }

          dojo.attr(
            `token-${step.step_id}`,
            'class',
              this.format_block( 'js_token_class', {
                token_number: tokenNumber,
                token_color_and_number: tokenColorAndNumber,
                direction: directionName
              }
            )
          );
        }
      }

      // place dice 1 and dice 2
      var dice_result = gamedatas.dice_result;
      dojo.attr(
        'dice_1',
        'class',
          this.format_block( 'js_dice_class', {
            dice_id: 1,
            dice_value: dice_result.dice1,
            dice_usable: dice_result.dice1_usable
          }
        )
      );
      dojo.attr(
        'dice_2',
        'class',
          this.format_block( 'js_dice_class', {
            dice_id: 2,
            dice_value: dice_result.dice2,
            dice_usable: dice_result.dice2_usable
          }
        )
      );

      if( this.isCurrentPlayerActive() )
      {
        dojo.query('.dice.dice_usable_1').connect('onclick', this, 'onSelectDice');
        console.log(gamedatas.availableSteps);
        console.log(gamedatas.availableTokens);
      }

      // Setup game notifications to handle (see "setupNotifications" method below)
      this.setupNotifications();

      // console.log( 'battlegammon.js >> Ending game setup' );
    },


    ///////////////////////////////////////////////////
    //// Game & client states

    // onEnteringState: this method is called each time we are entering into a new game state.
    //      You can use this method to perform some user interface changes at this moment.
    //
    onEnteringState: function( stateName, args )
    {
      // console.log( 'battlegammon.js >> Entering state: '+stateName );
      // console.log(args)

      switch( stateName )
      {

        /* Example:

        case 'myGameState':

        // Show some HTML block at this game state
        dojo.style( 'my_html_block_id', 'display', 'block' );

        break;
         */

        case 'playerTurn':
        case 'dummmy':
        break;
      }
    },

    // onLeavingState: this method is called each time we are leaving a game state.
    //     You can use this method to perform some user interface changes at this moment.
    //
    onLeavingState: function( stateName )
    {
      // console.log( 'battlegammon.js >> Leaving state: '+stateName );

      switch( stateName )
      {

        /* Example:

        case 'myGameState':

        // Hide the HTML block we are displaying only during this game state
        dojo.style( 'my_html_block_id', 'display', 'none' );

        break;
         */


        case 'dummmy':
        break;
      }
    },

    // onUpdateActionButtons: in this method you can manage "action buttons" that are displayed in the
    //      action status bar (ie: the HTML links in the status bar).
    //
    onUpdateActionButtons: function( stateName, args )
    {
      // console.log( 'battlegammon.js >> onUpdateActionButtons: '+stateName );

      if( this.isCurrentPlayerActive() )
      {
        switch( stateName )
        {
          // Example:
          //
          // case 'myGameState':
          //
          // // Add 3 action buttons in the action status bar:
          //
          // this.addActionButton( 'button_1_id', _('Button 1 label'), 'onMyMethodToCall1' );
          // this.addActionButton( 'button_2_id', _('Button 2 label'), 'onMyMethodToCall2' );
          // this.addActionButton( 'button_3_id', _('Button 3 label'), 'onMyMethodToCall3' );
          // break;
          case 'playerTurn':
            // console.log( 'battlegammon.js >> onUpdateActionButtons >> '+stateName );
            // console.log(args)
            this.addActionButton( 'pass-btn', _('Pass'), 'onPass' );
            this.addActionButton( 'cancel-btn', _('Cancel'), 'onCancel', null, false, 'red' );
            break;
        }
      }
    },

    ///////////////////////////////////////////////////
    //// Utility methods

    /*

      Here, you can defines some utility methods that you can use everywhere in your javascript
      script.

    */


    ///////////////////////////////////////////////////
    //// Player's action

    /*

      Here, you are defining methods to handle player's action (ex: results of mouse click on
      game objects).

      Most of the time, these methods:
      _ check the action is possible at this game state.
      _ make a call to the game server

    */

    /* Example:

    onMyMethodToCall1: function( evt )
    {
      console.log( 'battlegammon.js >> onMyMethodToCall1' );

      // Preventing default browser reaction
      dojo.stopEvent( evt );

      // Check that this action is possible (see "possibleactions" in states.inc.php)
      if( ! this.checkAction( 'myAction' ) )
      {   return; }

      this.ajaxcall( "/battlegammon/battlegammon/myAction.html", {
                    lock: true,
                    myArgument1: arg1,
                    myArgument2: arg2,
                    ...
                   },
         this, function( result ) {

          // What to do after the server call if it succeeded
          // (most of the time: nothing)

         }, function( is_error) {

          // What to do after the server call in anyway (success or failure)
          // (most of the time: nothing)

         } );
    },

    */

    onSelectDice: function (e)
    {
      dojo.stopEvent(e);
      e.currentTarget.classList.toggle('lighton_dice');
    },

    onPass: function (e)
    {

    },

    onCancel: function (e)
    {

    },

    ///////////////////////////////////////////////////
    //// Reaction to cometD notifications

    /*
      setupNotifications:

      In this method, you associate each of your game notifications with your local method to handle it.

      Note: game notification names correspond to "notifyAllPlayers" and "notifyPlayer" calls in
        your battlegammon.game.php file.

    */
    setupNotifications: function()
    {
      // console.log( 'battlegammon.js >> notifications subscriptions setup' );

      // TODO: here, associate your game notifications with local methods

      // Example 1: standard notification handling
      // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );

      // Example 2: standard notification handling + tell the user interface to wait
      //    during 3 seconds after calling the method in order to let the players
      //    see what is happening in the game.
      // dojo.subscribe( 'cardPlayed', this, "notif_cardPlayed" );
      // this.notifqueue.setSynchronous( 'cardPlayed', 3000 );
      //
    },

    // TODO: from this point and below, you can write your game notifications handling methods

    /*
    Example:

    notif_cardPlayed: function( notif )
    {
      console.log( 'battlegammon.js >> notif_cardPlayed' );
      console.log( notif );

      // Note: notif.args contains the arguments specified during you "notifyAllPlayers" / "notifyPlayer" PHP call

      // TODO: play the card in the user interface.
    },

    */
  });
});
