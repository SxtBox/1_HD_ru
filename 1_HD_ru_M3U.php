<?php
/*
JUST FOR FUNNY DUDE
BAB DUDA ME KALLASHNIKOV ESHTE KETU
*/

/*
1 HD
https://www.1tv.ru/live
https://stream.1tv.ru/api/playlist/1tvch_as_array.json
https://stream.1tv.ru/api/playlist/1tvch.json

ORBIT
http://static.1tv.ru/eump/pages/1tv_live_orbit-plus-4.html
http://static.1tv.ru/eump/initializers/1tv_live_orbit-plus-4.js
http://stream.1tv.ru/api/playlist/1tv-orbit-plus-4_as_array.json
http://stream.1tv.ru/api/playlist/1tv-orbit-plus-4.json

https://static.1tv.ru/eump/embeds/1tv_live.html?interactive=yes&__paranja=yes
*/
error_reporting(0);

function get_json_data($url) {
   $resp = file_get_contents($url);       
   return json_decode($resp);
};

$stream_format = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : "0"; // 0 to 3

$channel_meta = get_json_data("https://stream.1tv.ru/api/playlist/1tvch_as_array.json");
$stream_url = $channel_meta->hls[$stream_format];

$stream_token = file_get_contents("https://stream.1tv.ru/get_hls_session");

preg_match('/"s".:."(.*?)"/',$stream_token, $token_matches);
$token = trim($token_matches[1]);

$stream = $stream_url;

if (is_null($stream_url))
{
echo 'Stream is NULL or Invalid Type Number';
}
else
{
    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    echo "#EXTM3U Albdroid PHP Streaming Tools => USE ?type=0 to 3\n";
    echo "#EXTINF:-1,1 HD\n";
    echo $stream . "&s=".$token;
    session_destroy();
}
?>
