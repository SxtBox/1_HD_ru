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
    $stream_play = $stream . "&s=".$token;
    session_destroy();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>1TV Clappr Player</title>
<link rel="shortcut icon" href="https://kodi.al/panel.ico"/>
<link rel="icon" href="https://kodi.al/panel.ico"/>
<script type="text/javascript" src="clappr.min.js"></script>
<script type="text/javascript" src="rtmp.js"></script>
</head>
<body style="background:#000;">
<div id="player"></div>
      <script>
        var player = new Clappr.Player({
            source: '<?php echo $stream_play; ?>',
	    width: '100%',
            height: '100%',
            poster: 'https://png.kodi.al/tv/albdroid/black.png',
            watermark: 'https://png.kodi.al/tv/albdroid/logo.png',
            position: 'top-right',
           //watermarkLink: '',
            parentId: "#player",
            autoPlay: true,
            rtmpConfig: {
                swfPath: 'RTMP.swf',
                scaling:'stretch',
                playbackType: 'vod',
                bufferTime: 1,
                startLevel: 0
            },
            plugins: {
                playback: [RTMP],
            },
        });
      </script>
</body>
</html>
