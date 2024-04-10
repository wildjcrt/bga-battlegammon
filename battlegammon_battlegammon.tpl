{OVERALL_GAME_HEADER}

<div id="bg_board">
  <!-- BEGIN steps -->
  <!-- White start: 1, White end: 12; Black end: 13, Black start: 24 -->
  <div id="steps_{step_id}" class="steps" style="left:{LEFT}px; top:{TOP}px;"></div>
  <!-- END steps -->

  <!-- BEGIN dice -->
  <div id="dicearea_{dicearea_id}" class="dice_area" style="left:{LEFT}px; top :{TOP}px;"></div>
  <!-- END dice -->

  <div id="tokens"></div>
  <div id="dices"></div>
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var jstpl_token='<div class="token tokencolor_${color} tokennb_${token_nb}_${vertpos}" id="token_${token_step_id}"></div>';
  var jstpl_dice='<div class="dice dice_${dice_id} dice_${dice_id}_${dice_value} dice_usable_${dice_usable}" id="dice_${dice_id}"></div>';
</script>

{OVERALL_GAME_FOOTER}
