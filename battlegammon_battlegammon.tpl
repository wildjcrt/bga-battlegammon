<!--
--------
-- BGA framework: Gregory Isabelli & Emmanuel Colin & BoardGameArena
-- Battlegammon implementation : © <wildjcrt> <wildjcrt@gmail.com>
--
-- This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
-- See http://en.boardgamearena.com/#!doc/Studio for more information.
-------
-->

{OVERALL_GAME_HEADER}

<!-- BEGIN dice -->
<div id="dice_area">
  <div id="dice_1" class="dice dice_1_0 dice_usable_0"></div>
  <div id="dice_2" class="dice dice_2_0 dice_usable_0"></div>
</div>
<!-- END dice -->

<div id="bg_board">
  <!-- BEGIN steps -->
  <!-- White start: 1, White end: 12; Black end: 13, Black start: 24 -->
  <div id="steps_{step_id}" class="steps" style="left:{LEFT}px; top:{TOP}px;"></div>
  <!-- END steps -->

  <div id="tokens"></div>
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var jstpl_token='<div class="token tokencolor_${color} tokennb_${token_nb}_${vertpos}" id="token_${token_step_id}"></div>';
  var js_dice_class="dice dice_${dice_id}_${dice_value} dice_usable_${dice_usable}";
</script>

{OVERALL_GAME_FOOTER}
