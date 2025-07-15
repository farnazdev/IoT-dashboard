<?php
function sendMessageToBale($id, $text){
    $postfields = array(
    'chat_id' => "$id",
    'text' => "$text",
    );
    if (!$curld = curl_init()) {
    exit;
    }
    $bot_token = '1081188276:CXbPXQVyAdbw7tgTvZO7UtIb7qPrlBwckdWwRtxT';
    $url = "https://tapi.bale.ai/bot$bot_token/sendMessage";
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($curld, CURLOPT_URL,$url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    
    $output = curl_exec($curld);
    curl_close ($curld);
}
function miladiBeShamsi($gy, $gm, $gd, $mod){
    $g_d_m = array(0,31,59,90,120,151,181,212,243,273,304,334);
    if( 1600 < $gy ){
        $jy = 979;
        $gy = (int)$gy - 1600; 
    }else{
        $jy = 0;
        $gy = (int)$gy - 621;
    }
    $gy2 = ($gm > 2)? ($gy + 1): $gy;
    $days = (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) - 80 + $gd + $g_d_m[$gm - 1];
    $jy += 33 * ((int)($days / 12053));
    $days %= 12053;
    $jy += 4 * ((int)($days / 1461));
    $days %= 1461;
    $jy += (int)(($days - 1) / 365);
    if($days > 365)
        $days = ($days - 1) % 365;
    if($days < 186){
        $jm = 1 + (int)($days / 31);
        $jd = 1 + ($days % 31);
    }else{
        $jm = 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days - 186) % 30);
    }
    return $jy . $mod . $jm . $mod . $jd;
}