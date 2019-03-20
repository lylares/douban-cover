<?php
/*
Plugin Name: 豆瓣电影封面
Description: 快速获取豆瓣电影封面及影片信息展示在页面中。
Version: 1.0.2
Author: lylares
Author URI: https://www.lylares.com
Plugin URI: https://www.lylares.com/a-wordpress-plugin-of-douban-movie.html
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0-standalone.html

Douban cover is free software: you can redistribute it
and/or modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of the License,
or any later version.
 
Douban cover  is distributed in the hope that it will be
useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more details.
 
You should have received a copy of the GNU General Public License along
with Douban cover . If not, see
https://www.gnu.org/licenses/gpl-3.0-standalone.html.
*/
//global $wpdb;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define("DOUBANCOVER","ABCFC");

define('SYSTEM_DOUBAN_COVER_ROOT', dirname(__FILE__));

define('SYSTEM_DOUBAN_COVER', plugins_url('',__FILE__));

define("DOUBAN_API","https://api-cn.berryapi.net/?service=App.Douban.Subject&AppKey=Test201901&id=");

require SYSTEM_DOUBAN_COVER_ROOT.'/inc/core.php';
