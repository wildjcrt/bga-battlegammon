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
      this.tokenColorMapping = {
          1:  'white',
          2:  'white',
          3:  'white',
          4:  'white',
          5:  'white',
          6:  'white',
          7:  'white',
          8:  'white',
          9:  'white',
          10: 'white',
          11: 'black',
          12: 'black',
          13: 'black',
          14: 'black',
          15: 'black',
          16: 'black',
          17: 'black',
          18: 'black',
          19: 'black',
          20: 'black'
      };
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

      // Setting up steps
      var steps = gamedatas.steps;
      for (var i = 0; i < steps.length; i++)
      {
        var step = steps[i],
            tokens = parseInt(step.white_tokens) + parseInt(step.black_tokens),
            directionName, tokenNumber, tokenColorAndNumber;

        if (tokens > 0) {
          switch (step.step_id) {
          case '1': // white home
            directionName = this.directionMapping['white'][step.step_id];
            tokenNumber = this.numberMapping[step.white_tokens];
            tokenColorAndNumber = `white-${tokenNumber}`;
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
            break;
          case '24': // black home
            directionName = this.directionMapping['black'][step.step_id];
            tokenNumber = this.numberMapping[step.black_tokens];
            tokenColorAndNumber = `black-${tokenNumber}`;
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
            break;
          default:
            tokenNumber = this.numberMapping[tokens];
            var topTokenColor = this.tokenColorMapping[step.top_token_id],
                bottomTokenColor = this.tokenColorMapping[step.bottom_token_id];
            directionName = this.directionMapping[topTokenColor][step.step_id];

            switch (tokens) {
            case 1:
              tokenColorAndNumber = `${topTokenColor}-${tokenNumber}`;
              break;
            case 2:
              if (step.white_tokens == '2' || step.black_tokens == '2') {
                tokenColorAndNumber = `${topTokenColor}-${tokenNumber}`;
              } else {
                tokenColorAndNumber = `${topTokenColor}-${bottomTokenColor}`;
              }
              break;
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
      }

      // place dice 1 and dice 2
      var dice_result = gamedatas.dice_result;
      dojo.attr(
        'dice_1',
        'class',
          this.format_block( 'js_dice_class', {
            dice_id: 1,
            dice_number: dice_result.dice1,
            dice_available: dice_result.dice1_available
          }
        )
      );
      dojo.attr(
        'dice_2',
        'class',
          this.format_block( 'js_dice_class', {
            dice_id: 2,
            dice_number: dice_result.dice2,
            dice_available: dice_result.dice2_available
          }
        )
      );

      if( this.isCurrentPlayerActive() )
      {
        var activePlayerId = this.getActivePlayerId();
        this.activePlayer = this.gamedatas.players[activePlayerId];

        dojo.query('.dice.dice_available_1').connect('onclick', this, 'onSelectDice');

        for (let step_id in gamedatas.availableTokens)
        {
          dojo.addClass(`token-${step_id}`, 'available');
          dojo.query(`#token-${step_id}`).connect('onclick', this, 'onSelectToken');
        }
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
      console.log( 'battlegammon.js >> Entering state: '+stateName );
      // console.log(args)

      switch( stateName )
      {

        /* Example:

        case 'myGameState':

        // Show some HTML block at this game state
        dojo.style( 'my_html_block_id', 'display', 'block' );

        break;
         */

        case 'selectTokenByDice2':
          this.updatePageTitle();
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
          case 'selectTokenByDice1':
            // console.log( 'battlegammon.js >> onUpdateActionButtons >> '+stateName );
            // console.log(args)
            this.addActionButton( 'cancel-btn', _('Cancel'), 'onCancel', null, false, 'red' );
            dojo.addClass('cancel-btn', 'disabled');
            break;
          case 'selectTokenByDice2':
            // console.log( 'battlegammon.js >> onUpdateActionButtons >> '+stateName );
            // console.log(args)
            this.addActionButton( 'cancel-btn', _('Cancel'), 'onCancel', null, false, 'red' );
            dojo.addClass('cancel-btn', 'disabled');
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

    onSelectToken: function(e)
    {
      dojo.stopEvent(e);
      dojo.query('.step').removeClass('hint');
      dojo.removeClass('cancel-btn', 'disabled');

      // List availableDice
      var dice_result = this.gamedatas.dice_result,
          availableDice = [];
      if (dice_result.dice1_available === '1') {
        availableDice.push(parseInt(this.gamedatas.dice_result.dice1));
      }
      if (dice_result.dice2_available === '1') {
        availableDice.push(parseInt(this.gamedatas.dice_result.dice2));
      }

      this.tokenStep = parseInt(e.currentTarget.id.split('-')[1]);
      this.tokenId = this.gamedatas.availableTokens[this.tokenStep];
      if (this.activePlayer.color === 'ffffff') {
        for (var j = 0; j < availableDice.length; j++) {
          this.dice_number = availableDice[j];
          this.toStep = this.tokenStep + this.dice_number;

          if (this.gamedatas.availableSteps.includes(`${this.toStep}`)) {
            dojo.addClass(`step-${this.toStep}`, 'hint');
            dojo.query(`#step-${this.toStep}`).connect('onclick', this, 'onSelectStep');
          }
        }
      } else {
        for (var j = 0; j < availableDice.length; j++) {
          this.dice_number = availableDice[j];
          var toStep = this.tokenStep - this.dice_number;

          if (this.gamedatas.availableSteps.includes(`${toStep}`)) {
            dojo.addClass(`step-${toStep}`, 'hint');
            dojo.query(`#step-${toStep}`).connect('onclick', this, 'onSelectStep');
          }
        }
      }
    },

    onSelectStep: function (e)
    {
      dojo.stopEvent(e);
      this.gamedatas.gamestate.descriptionmyturn = 'Sending your move to server';
      this.updatePageTitle();

      dojo.query('.step').removeClass('hint');

      var toStepId = e.currentTarget.id.split('-')[1],
          fromStepId = `${this.tokenStep}`,
          fromStepRecord = this.gamedatas.steps.filter(function(el) {return el.step_id == fromStepId})[0],
          toStepRecord = this.gamedatas.steps.filter(function(el) {return el.step_id == toStepId})[0];

      // update from step
      var whiteTokens = parseInt(fromStepRecord.white_tokens),
          blackTokens = parseInt(fromStepRecord.black_tokens),
          tokenColor = this.tokenColorMapping[this.tokenId],
          tokensCount, tokenNumber, tokenColorAndNumber, directionName;
      switch (fromStepId) {
      case '1': // white home
        if (whiteTokens > 0) {
          whiteTokens -= 1;
        }
        tokenNumber = this.numberMapping[whiteTokens];
        tokenColorAndNumber = `white-${tokenNumber}`;
        directionName = this.directionMapping['white'][fromStepId];
        break;
      case '24': // black home
        if (blackTokens > 0) {
          blackTokens -= 1;
        }
        tokenNumber = this.numberMapping[blackTokens];
        tokenColorAndNumber = `black-${tokenNumber}`;
        directionName = this.directionMapping['black'][fromStepId];
        break;
      default:
        tokensCount = whiteTokens + blackTokens;

        if (tokensCount === 2) {
          tokenNumber = this.numberMapping[1];

          if (whiteTokens === 2) {
            tokenColorAndNumber = 'white-one';
            directionName = this.directionMapping['white'][fromStepId];
          }

          if (blackTokens === 2) {
            tokenColorAndNumber = 'black-one';
            directionName = this.directionMapping['black'][fromStepId];
          }

          if ((whiteTokens === 1) && (blackTokens === 1)) {
            if (tokenColor === 'white') {
              tokenColorAndNumber = 'black-one';
              directionName = this.directionMapping['black'][fromStepId];
            } else {
              tokenColorAndNumber = 'white-one';
              directionName = this.directionMapping['white'][fromStepId];
            }
          }

          dojo.attr(
            `token-${fromStepId}`,
            'class',
              this.format_block( 'js_token_class', {
                token_number: tokenNumber,
                token_color_and_number: tokenColorAndNumber,
                direction: directionName
              }
            )
          );
        }

        if (tokensCount === 1) {
          dojo.attr(
            `token-${fromStepId}`,
            'class',
            ''
          );
        }
      }

      // update to step
      var whiteTokens = parseInt(toStepRecord.white_tokens),
          blackTokens = parseInt(toStepRecord.black_tokens);
      switch (toStepId) {
      case '1': // white home
        if (blackTokens < 3) {
          blackTokens += 1;
        }
        tokenNumber = this.numberMapping[blackTokens];
        tokenColorAndNumber = `black-${tokenNumber}`;
        directionName = this.directionMapping['black'][toStepId];
        break;
      case '24': // black home
        if (whiteTokens < 3) {
          whiteTokens += 1;
        }
        tokenNumber = this.numberMapping[whiteTokens];
        tokenColorAndNumber = `white-${tokenNumber}`;
        directionName = this.directionMapping['white'][toStepId];
        break;
      default:
        tokensCount = whiteTokens + blackTokens;

        if (tokensCount === 0) {
          tokenNumber = this.numberMapping[1];
          tokenColorAndNumber = `${tokenColor}-${tokenNumber}`;
          directionName = this.directionMapping[tokenColor][toStepId];

          dojo.attr(
            `token-${toStepId}`,
            'class',
              this.format_block( 'js_token_class', {
                token_number: tokenNumber,
                token_color_and_number: tokenColorAndNumber,
                direction: directionName
              }
            )
          );
        }

        if (tokensCount === 1) {
          tokenNumber = this.numberMapping[2];

          if (whiteTokens === 1) {
            if (tokenColor == 'white') {
              tokenColorAndNumber = `${tokenColor}-${tokenNumber}`;
              directionName = this.directionMapping[tokenColor][toStepId];
            } else {
              tokenColorAndNumber = 'black-white';
              directionName = this.directionMapping['black'][toStepId];
            }
          }

          if (blackTokens === 1) {
            if (tokenColor == 'white') {
              tokenColorAndNumber = 'white-black';
              directionName = this.directionMapping[tokenColor][toStepId];
            } else {
              tokenColorAndNumber = `black-${tokenNumber}`;
              directionName = this.directionMapping['black'][toStepId];
            }
          }

          dojo.attr(
            `token-${toStepId}`,
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

      this.ajaxcall(
          "/battlegammon/battlegammon/sendMoveToServer.html",
          {
              token_id:    this.tokenId,
              from_step:   fromStepId,
              to_step:     toStepId,
              dice_number: this.dice_number
          },
          this,
          function( result ) {},
          function( is_error) {}
      );
    },

    onCancel: function (e)
    {
      dojo.query('.step').removeClass('hint');
      dojo.addClass('cancel-btn', 'disabled');
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
