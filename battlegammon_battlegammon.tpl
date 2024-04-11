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
  <div id="steps_black_0"  class="steps hint-square" style="left:0px;   bottom:0px;"></div>
  <div id="steps_black_1"  class="steps hint-circle" style="left:223px; bottom:14px;"></div>
  <div id="steps_black_2"  class="steps hint-circle" style="left:321px; bottom:16px;"></div>
  <div id="steps_black_3"  class="steps hint-circle" style="left:419px; bottom:15px;"></div>
  <div id="steps_black_4"  class="steps hint-circle" style="left:516px; bottom:14px;"></div>
  <div id="steps_black_5"  class="steps hint-circle" style="left:613px; bottom:18px;"></div>
  <div id="steps_black_6"  class="steps hint-circle" style="left:709px; bottom:14px;"></div>
  <div id="steps_black_7"  class="steps hint-circle" style="left:792px; bottom:62px;"></div>
  <div id="steps_black_8"  class="steps hint-circle" style="left:719px; bottom:119px;"></div>
  <div id="steps_black_9"  class="steps hint-circle" style="left:630px; bottom:144px;"></div>
  <div id="steps_black_10" class="steps hint-circle" style="left:535px; bottom:151px;"></div>
  <div id="steps_black_11" class="steps hint-circle" style="left:442px; bottom:171px;"></div>
  <div id="steps_white_0"  class="steps hint-square" style="left:687px; bottom:363px;"></div>
  <div id="steps_white_1"  class="steps hint-circle" style="left:591px; bottom:403px;"></div>
  <div id="steps_white_2"  class="steps hint-circle" style="left:488px; bottom:391px;"></div>
  <div id="steps_white_3"  class="steps hint-circle" style="left:393px; bottom:398px;"></div>
  <div id="steps_white_4"  class="steps hint-circle" style="left:297px; bottom:391px;"></div>
  <div id="steps_white_5"  class="steps hint-circle" style="left:203px; bottom:399px;"></div>
  <div id="steps_white_6"  class="steps hint-circle" style="left:110px; bottom:389px;"></div>
  <div id="steps_white_7"  class="steps hint-circle" style="left:21px;  bottom:338px;"></div>
  <div id="steps_white_8"  class="steps hint-circle" style="left:38px;  bottom:237px;"></div>
  <div id="steps_white_9"  class="steps hint-circle" style="left:142px; bottom:222px;"></div>
  <div id="steps_white_10" class="steps hint-circle" style="left:241px; bottom:198px;"></div>
  <div id="steps_white_11" class="steps hint-circle" style="left:341px; bottom:191px;"></div>
  <!-- END steps -->

  <div id="tokens"></div>
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var jstpl_token='<div class="token tokencolor_${color} tokennb_${token_nb}_${vertpos}" id="token_${token_step_id}"></div>';
  var js_dice_class="dice dice_${dice_id}_${dice_value} dice_usable_${dice_usable}";
</script>

{OVERALL_GAME_FOOTER}
