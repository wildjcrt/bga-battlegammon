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
    <div id="steps1"  class="steps" style="left:0px;   bottom:0px;"></div>
    <div id="steps2"  class="steps" style="left:223px; bottom:14px;"></div>
    <div id="steps3"  class="steps" style="left:321px; bottom:16px;"></div>
    <div id="steps4"  class="steps" style="left:419px; bottom:15px;"></div>
    <div id="steps5"  class="steps" style="left:516px; bottom:14px;"></div>
    <div id="steps6"  class="steps" style="left:613px; bottom:18px;"></div>
    <div id="steps7"  class="steps" style="left:709px; bottom:14px;"></div>
    <div id="steps8"  class="steps" style="left:792px; bottom:62px;"></div>
    <div id="steps9"  class="steps" style="left:719px; bottom:119px;"></div>
    <div id="steps10" class="steps" style="left:630px; bottom:144px;"></div>
    <div id="steps11" class="steps" style="left:535px; bottom:151px;"></div>
    <div id="steps12" class="steps" style="left:442px; bottom:171px;"></div>
    <div id="steps13" class="steps" style="left:687px; bottom:363px;"></div>
    <div id="steps14" class="steps" style="left:591px; bottom:403px;"></div>
    <div id="steps15" class="steps" style="left:488px; bottom:391px;"></div>
    <div id="steps16" class="steps" style="left:393px; bottom:398px;"></div>
    <div id="steps17" class="steps" style="left:297px; bottom:391px;"></div>
    <div id="steps18" class="steps" style="left:203px; bottom:399px;"></div>
    <div id="steps19" class="steps" style="left:110px; bottom:389px;"></div>
    <div id="steps20" class="steps" style="left:21px;  bottom:338px;"></div>
    <div id="steps21" class="steps" style="left:38px;  bottom:237px;"></div>
    <div id="steps22" class="steps" style="left:142px; bottom:222px;"></div>
    <div id="steps23" class="steps" style="left:241px; bottom:198px;"></div>
    <div id="steps24" class="steps" style="left:341px; bottom:191px;"></div>
  </div>
  <!-- END steps -->

  <!--BEGIN tokens -->
  <div id="tokens">
    <div class="token token token-five black-five" style="left:110px; bottom:13px;"></div>
    <div class="token token black-two-to-right" style="left:516px; bottom:13px;"></div>
    <div class="token token black-two-to-right" style="left:613px; bottom:16px;"></div>
    <div class="token token black-one-to-left" style="left:714px; bottom:118px;"></div>
    <div class="token token token-five white-five" style="left:704px; bottom:390px;"></div>
    <div class="token token white-one-to-left" style="left:292px; bottom:390px;"></div>
    <div class="token token white-two-to-left" style="left:20px; bottom:336px;"></div>
    <div class="token token white-two-to-right" style="left:36px; bottom:235px;"></div>
  </div>
  <!--END tokens -->
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var jstpl_token='<div class="token token_${token_number} ${token_color_and_number}_to_${direction}" id="token_${token_step_id}"></div>';
  var js_dice_class="dice dice_${dice_id}_${dice_value} dice_usable_${dice_usable}";
  var jstpl_step='<div id="steps_white_${step_id}" class="steps hint-${hint_type}"></div>';
</script>

{OVERALL_GAME_FOOTER}
