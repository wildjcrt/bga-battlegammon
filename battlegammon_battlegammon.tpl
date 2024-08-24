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
    <div id="step-1"  class="step hint-square" style="left:687px; bottom:353px;"></div>
    <div id="step-2"  class="step hint-circle" style="left:594px; bottom:404px;"></div>
    <div id="step-3"  class="step hint-circle" style="left:496px; bottom:391px;"></div>
    <div id="step-4"  class="step hint-circle" style="left:398px; bottom:398px;"></div>
    <div id="step-5"  class="step hint-circle" style="left:301px; bottom:393px;"></div>
    <div id="step-6"  class="step hint-circle" style="left:203px; bottom:399px;"></div>
    <div id="step-7"  class="step hint-circle" style="left:107px; bottom:384px;"></div>
    <div id="step-8"  class="step hint-circle" style="left:23px;  bottom:334px;"></div>
    <div id="step-9"  class="step hint-circle" style="left:41px;  bottom:234px;"></div>
    <div id="step-10" class="step hint-circle" style="left:144px; bottom:222px;"></div>
    <div id="step-11" class="step hint-circle" style="left:244px; bottom:223px;"></div>
    <div id="step-12" class="step hint-circle" style="left:344px; bottom:213px;"></div>
    <div id="step-13" class="step hint-circle" style="left:440px; bottom:192px;"></div>
    <div id="step-14" class="step hint-circle" style="left:534px; bottom:173px;"></div>
    <div id="step-15" class="step hint-circle" style="left:631px; bottom:159px;"></div>
    <div id="step-16" class="step hint-circle" style="left:727px; bottom:138px;"></div>
    <div id="step-17" class="step hint-circle" style="left:795px; bottom:67px;"></div>
    <div id="step-18" class="step hint-circle" style="left:711px; bottom:18px;"></div>
    <div id="step-19" class="step hint-circle" style="left:614px; bottom:18px;"></div>
    <div id="step-20" class="step hint-circle" style="left:517px; bottom:27px;"></div>
    <div id="step-21" class="step hint-circle" style="left:420px; bottom:17px;"></div>
    <div id="step-22" class="step hint-circle" style="left:323px; bottom:29px;"></div>
    <div id="step-23" class="step hint-circle" style="left:226px; bottom:20px;"></div>
    <div id="step-24" class="step hint-square" style="left:18px;  bottom:0px;"></div>
  </div>
  <!-- END steps -->

  <!--BEGIN tokens -->
  <div id="tokens">
    <div id="token-home-white" style="left:790px; bottom:395px;"></div>
    <div id="token-1"          style="left:696px; bottom:395px;"></div>
    <div id="token-2"          style="left:590px; bottom:415px;"></div>
    <div id="token-3"          style="left:491px; bottom:401px;"></div>
    <div id="token-4"          style="left:393px; bottom:409px;"></div>
    <div id="token-5"          style="left:296px; bottom:403px;"></div>
    <div id="token-6"          style="left:199px; bottom:410px;"></div>
    <div id="token-7"          style="left:102px; bottom:396px;"></div>
    <div id="token-8"          style="left:18px;  bottom:343px;"></div>
    <div id="token-9"          style="left:36px;  bottom:242px;"></div>
    <div id="token-10"         style="left:139px; bottom:231px;"></div>
    <div id="token-11"         style="left:239px; bottom:233px;"></div>
    <div id="token-12"         style="left:338px; bottom:224px;"></div>
    <div id="token-13"         style="left:434px; bottom:203px;"></div>
    <div id="token-14"         style="left:528px; bottom:183px;"></div>
    <div id="token-15"         style="left:625px; bottom:172px;"></div>
    <div id="token-16"         style="left:720px; bottom:148px;"></div>
    <div id="token-17"         style="left:791px; bottom:77px;"></div>
    <div id="token-18"         style="left:708px; bottom:28px;"></div>
    <div id="token-19"         style="left:611px; bottom:28px;"></div>
    <div id="token-20"         style="left:513px; bottom:38px;"></div>
    <div id="token-21"         style="left:416px; bottom:28px;"></div>
    <div id="token-22"         style="left:319px; bottom:39px;"></div>
    <div id="token-23"         style="left:222px; bottom:29px;"></div>
    <div id="token-24"         style="left:110px; bottom:13px;"></div>
    <div id="token-home-black" style="left:10px;  bottom:13px;"></div>
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
