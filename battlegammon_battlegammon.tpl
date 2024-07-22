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
  <div id="dice_1" class="dice dice_1_0 dice_available_0"></div>
  <div id="dice_2" class="dice dice_2_0 dice_available_0"></div>
</div>
<!-- END dice -->

<div id="bg_board">
  <!-- BEGIN steps -->
  <!-- White start: 1, White end: 12; Black end: 13, Black start: 24 -->
  <div id="steps">
    <div id="step-1"  class="step hint-square" style="left:687px; bottom:363px;"></div>
    <div id="step-2"  class="step hint-circle" style="left:591px; bottom:403px;"></div>
    <div id="step-3"  class="step hint-circle" style="left:488px; bottom:391px;"></div>
    <div id="step-4"  class="step hint-circle" style="left:393px; bottom:398px;"></div>
    <div id="step-5"  class="step hint-circle" style="left:297px; bottom:391px;"></div>
    <div id="step-6"  class="step hint-circle" style="left:203px; bottom:399px;"></div>
    <div id="step-7"  class="step hint-circle" style="left:110px; bottom:389px;"></div>
    <div id="step-8"  class="step hint-circle" style="left:21px;  bottom:338px;"></div>
    <div id="step-9"  class="step hint-circle" style="left:38px;  bottom:237px;"></div>
    <div id="step-10" class="step hint-circle" style="left:142px; bottom:222px;"></div>
    <div id="step-11" class="step hint-circle" style="left:241px; bottom:198px;"></div>
    <div id="step-12" class="step hint-circle" style="left:341px; bottom:191px;"></div>
    <div id="step-13" class="step hint-circle" style="left:442px; bottom:171px;"></div>
    <div id="step-14" class="step hint-circle" style="left:535px; bottom:151px;"></div>
    <div id="step-15" class="step hint-circle" style="left:630px; bottom:144px;"></div>
    <div id="step-16" class="step hint-circle" style="left:719px; bottom:119px;"></div>
    <div id="step-17" class="step hint-circle" style="left:792px; bottom:62px;"></div>
    <div id="step-18" class="step hint-circle" style="left:709px; bottom:14px;"></div>
    <div id="step-19" class="step hint-circle" style="left:613px; bottom:18px;"></div>
    <div id="step-20" class="step hint-circle" style="left:516px; bottom:14px;"></div>
    <div id="step-21" class="step hint-circle" style="left:419px; bottom:15px;"></div>
    <div id="step-22" class="step hint-circle" style="left:321px; bottom:16px;"></div>
    <div id="step-23" class="step hint-circle" style="left:223px; bottom:14px;"></div>
    <div id="step-24" class="step hint-square" style="left:0px;   bottom:0px;"></div>
  </div>
  <!-- END steps -->

  <!--BEGIN tokens -->
  <div id="tokens">
    <div id="token-home-white" style="left:804px; bottom:390px;"></div>
    <div id="token-1"  style="left:704px; bottom:390px;"></div>
    <div id="token-2"  style="left:591px; bottom:403px;"></div>
    <div id="token-3"  style="left:488px; bottom:391px;"></div>
    <div id="token-4"  style="left:393px; bottom:398px;"></div>
    <div id="token-5"  style="left:292px; bottom:390px;"></div>
    <div id="token-6"  style="left: 199px;bottom: 396px;"></div>
    <div id="token-7"  style="left: 105px;bottom: 386px;"></div>
    <div id="token-8"  style="left:20px; bottom:336px;"></div>
    <div id="token-9"  style="left:36px; bottom:235px;"></div>
    <div id="token-10" style="left: 137px;bottom: 220px;"></div>
    <div id="token-11" style="left: 235px;bottom: 197px;"></div>
    <div id="token-12" style="left: 337px;bottom: 190px;"></div>
    <div id="token-13" style="left:436px; bottom:170px;"></div>
    <div id="token-14" style="left:532px; bottom:150px;"></div>
    <div id="token-15" style="left:626px; bottom:144px;"></div>
    <div id="token-16" style="left:714px; bottom:118px;"></div>
    <div id="token-17" style="left:792px; bottom:62px;"></div>
    <div id="token-18" style="left:709px; bottom:14px;"></div>
    <div id="token-19" style="left:613px; bottom:16px;"></div>
    <div id="token-20" style="left:511px; bottom:13px;"></div>
    <div id="token-21" style="left:419px; bottom:15px;"></div>
    <div id="token-22" style="left:321px; bottom:16px;"></div>
    <div id="token-23" style="left:223px; bottom:14px;"></div>
    <div id="token-24" style="left:110px; bottom:13px;"></div>
    <div id="token-home-black" style="left:10px; bottom:13px;"></div>
  </div>
  <!--END tokens -->
</div>

<script type="text/javascript">
  // Javascript HTML templates
  var js_token_class="token token-${token_number} ${token_color_and_number}-to-${direction}";
  var js_dice_class="dice dice_${dice_id}_${dice_number} dice_available_${dice_available}";
  var js_step_class="step hint-${hint_type}";
</script>

{OVERALL_GAME_FOOTER}
