<?php
if(!defined('DOUBANCOVER')) die('非法访问 - Insufficient Permissions');

class DBCover{
//抓取函数
public static function curl($url){ 
    $ch = curl_init(); 
    $timeout = 30; 
    $ua = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);   
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $content = trim(curl_exec($ch)); 
    curl_close($ch); 
    return $content; 
}
//评分与星星
public static function echoUi_star($score){
	$star_num = $score*0.5;
	
	if (is_float($star_num)){
		$star_num = round($star_num);
		}

	for($i = 1;$i <= $star_num;$i++){
		echo '<span class="douban-star douban-star-full"></span>';
	}
	
	$star_gray_num = 5 - $star_num;
	if(!empty($star_gray_num)){
		$num = 1;
	    while($num <= $star_gray_num){	
        echo '<span class="douban-star douban-star-gray"></span>';
        $num ++;
        }		
		
	}
}
}
