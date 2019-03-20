<?php
//error_reporting(E_ALL);

//ini_set('display_errors', '1');

define("DOUBANCOVER","ABCFC");

define('SYSTEM_DOUBAN_COVER_ROOT', dirname(__FILE__));

define('SYSTEM_DOUBAN_COVER', plugins_url('',__FILE__));

define("DOUBAN_API","https://api-cn.berryapi.net/?service=App.Douban.Subject&AppKey=Test201901&id=");

require SYSTEM_DOUBAN_COVER_ROOT.'/inc/core.php';

