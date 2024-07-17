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
  <div id="steps">
    <div id="step1"  class="step" style="left:687px; bottom:363px;"></div>
    <div id="step2"  class="step" style="left:591px; bottom:403px;"></div>
    <div id="step3"  class="step" style="left:488px; bottom:391px;"></div>
    <div id="step4"  class="step" style="left:393px; bottom:398px;"></div>
    <div id="step5"  class="step" style="left:297px; bottom:391px;"></div>
    <div id="step6"  class="step" style="left:203px; bottom:399px;"></div>
    <div id="step7"  class="step" style="left:110px; bottom:389px;"></div>
    <div id="step8"  class="step" style="left:21px;  bottom:338px;"></div>
    <div id="step9"  class="step" style="left:38px;  bottom:237px;"></div>
    <div id="step10" class="step" style="left:142px; bottom:222px;"></div>
    <div id="step11" class="step" style="left:241px; bottom:198px;"></div>
    <div id="step12" class="step" style="left:341px; bottom:191px;"></div>
    <div id="step13" class="step" style="left:442px; bottom:171px;"></div>
    <div id="step14" class="step" style="left:535px; bottom:151px;"></div>
    <div id="step15" class="step" style="left:630px; bottom:144px;"></div>
    <div id="step16" class="step" style="left:719px; bottom:119px;"></div>
    <div id="step17" class="step" style="left:792px; bottom:62px;"></div>
    <div id="step18" class="step" style="left:709px; bottom:14px;"></div>
    <div id="step19" class="step" style="left:613px; bottom:18px;"></div>
    <div id="step20" class="step" style="left:516px; bottom:14px;"></div>
    <div id="step21" class="step" style="left:419px; bottom:15px;"></div>
    <div id="step22" class="step" style="left:321px; bottom:16px;"></div>
    <div id="step23" class="step" style="left:223px; bottom:14px;"></div>
    <div id="step24" class="step" style="left:0px;   bottom:0px;"></div>
  </div>
  <!-- END steps -->

  <!--BEGIN tokens -->
  <div id="tokens">
  </div>
  <!--END tokens -->
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var jstpl_token='<div class="token token-${token_number} ${token_color_and_number}-to-${direction}" id="token-${token_step_id}" style="${token_position}"></div>';
  var js_dice_class="dice dice_${dice_id}_${dice_value} dice_usable_${dice_usable}";
  var jstpl_step='<div id="steps_white_${step_id}" class="steps hint-${hint_type}"></div>';
</script>

{OVERALL_GAME_FOOTER}
