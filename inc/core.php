<?php
if(!defined('DOUBANCOVER')) die('非法访问 - Insufficient Permissions');

/**
 * 豆瓣封面核心代码
 * 作者：lylares
 * Blog:https://www.lylares.com
 */
require("functions.php");
		
function add_douban_cover_style(){
		 $douban_main_css = SYSTEM_DOUBAN_COVER.'/static/css/main.css';
		 wp_enqueue_style('style',$douban_main_css,array(),filemtime($douban_main_css)); 
}
add_action('wp_enqueue_scripts','add_douban_cover_style');
		
function add_douban_cover_button($mce_settings) {
?>
<script type="text/javascript">
 QTags.addButton( 'douban_cover', '豆瓣封面', '\n[douban_cover id=""]','');
</script>
<?php
}

add_action('after_wp_tiny_mce', 'add_douban_cover_button');

function douban_shortcode($atts, $content = null) {
extract(shortcode_atts(array(
"id" => ''
), $atts));
//$content .= '<br />';
ob_start();  
$content = create_douban_cover($id);
return $content ;
	ob_end_clean(); 
}

 add_shortcode("douban_cover", "douban_shortcode");

function create_douban_cover($id){
	  //$doubanAPI = 'https://api.douban.com/v2/movie/subject/'.$id;
	$doubanAPI = DOUBAN_API.$id;

	$douban_Data = DBCover::curl($doubanAPI);
	$douban_Data = json_decode($douban_Data,true);
	
	$img = 'https://ww2.sinaimg.cn/large/'.$douban_Data['data']['pid'].'.jpg';
	$douban_Data = $douban_Data['data']['data'];
	$douban_Data = json_decode($douban_Data,true);
	//wp_reset_query();
	
	?>
	<?php if (is_single()){?>
    <div class="main-douban-cover">
	<h4 class="douban-cover-title">
	    <span><?php echo $douban_Data['original_title'];?></span>
	</h4>
	<div class="cover-img-bg">
		<a href="<?php echo $douban_Data['alt'];?>photos?type=R" title="点击看更多海报" rel="nofollow" target="_blank">
		    <img src="<?php echo $img;?>" alt="<?php echo $douban_Data['original_title'];?>">
		</a>
	</div>
	<div class="douban-info">
		<span class="douban-cover-p" >豆瓣评分:</span> 
		<div class="douban-score"><?php echo $score = $douban_Data['rating']['average'];?></div>
		<div class="douban-rank-span douban-stars">
	    <?php DBCover::echoUi_star($score);?>
	    </div>
		<div class="douban-cover-p doudan-comment-number"><?php echo $douban_Data['ratings_count'];?>人评价</div>
		<span class="douban-cover-p" >看过:</span> <?php echo $douban_Data['collect_count'];?>人<br>
		<span class="douban-cover-p" >想看:</span> <?php echo $douban_Data['wish_count'];?>人<br>
		<span class="douban-cover-p" >年份:</span> <?php echo $douban_Data['year'];?><br>
		<span class="douban-cover-p">导演</span>: <span class="douban-director"><?php $num = count($douban_Data['directors']);for($i=0;$i<$num;$i++){$durl=$douban_Data['directors'][$i]['alt'];$dname=$douban_Data['directors'][$i]['name'];echo'<a href="'.$durl.'" rel="nofollow" target="_blank">'.$dname.'</a> / ';}?></span><br>
		<span class="douban-cover-p">主演</span>: <span  class="douban-main-actor"><?php $num = count($douban_Data['casts']);for($i=0;$i<$num;$i++){$durl=$douban_Data['casts'][$i]['alt'];$dname=$douban_Data['casts'][$i]['name'];echo'<a href="'.$durl.'" rel="nofollow" target="_blank">'.$dname.'</a> / ';}?></span><br>
		<span class="douban-cover-p" >类型:</span> <?php foreach($douban_Data['genres'] as $value){echo $value.'/';};?><br>
		<span class="douban-cover-p" >制片国家/地区:</span> <?php foreach($douban_Data['countries'] as $value){echo $value.'/';}?><br>
		<?php $subtype = $douban_Data['subtype'];
		if($subtype == 'tv'){echo'
		<span class="douban-cover-p">集数:</span>'.$douban_Data['episodes_count'].'<br>';
		}?>
		<span class="douban-cover-p" >又名:</span> <?php $asname = $douban_Data['aka'];foreach( $asname as $value){echo $value.' <span>/</span> ';};?>
	</div>
	<div class="douban-cover-desc" >简介:<?php echo $douban_Data['summary'];?></div> 
		<div class="douban-cover-copyright"><a href="https://www.lylares.com/a-wordpress-plugin-of-douban-movie.html" target="_blank" rel ="nofollow" title="豆瓣封面插件官网">© LYLARES</a></div>
</div>
	<?}
	}