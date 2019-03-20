<?php
if(!defined('DOUBANCOVER')) die('Insufficient Permissions ');
require("functions.php");		
function add_douban_cover_style(){
		 $douban_main_css = SYSTEM_DOUBAN_COVER."/static/css/main.css";
	wp_enqueue_style('style',$douban_main_css,array(),filemtime($douban_main_css)); 
	//if (is_single()){
	wp_enqueue_script( 'main', SYSTEM_DOUBAN_COVER . '/static/js/main.js', array(), '1.0.0',true);
//}
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
	$douban_Data = DBCover::curl(DOUBAN_API.$id);
	$douban_Data = json_decode($douban_Data,true);	
	$douban_Data = $douban_Data['data'];
	$img = 'https://ww2.sinaimg.cn/large/'.$douban_Data['pid'].'.jpg';
	?>
	<?php if (is_single()){?>
    <div class="main-douban-cover">
		<h4 class="douban-cover-title-mb"><span><?php echo $douban_Data['title'];?></span></h4>
	    <div class="cover-img-bg">
		    <a href="https://movie.douban.com/subject/<?php echo $id;?>" title="<?php echo $douban_Data['title'];?>豆瓣详情" rel="nofollow" target="_blank">
		        <img src="<?php echo $img;?>" alt="<?php echo $douban_Data['original_title'];?>">
		    </a>
	    </div>
		<div class="douban-info">
		    <div class="douban-cover-p douban-cover-score-tips">豆瓣评分<span class="douban-cover-score-ver">TM</span></div>
			<a href="https://movie.douban.com/subject/<?php echo $id;?>" title="<?php echo $douban_Data['title'];?>豆瓣详情" rel="nofollow" target="_blank">
				<span class="douban-cover-play-icon"></span>
				<?php echo $douban_Data['title'];?>
			</a>
		    <div class="douban-score"><?php echo $score = $douban_Data['rating_average'];?></div>
		    <div class="douban-rank-span douban-stars">
	        <?php DBCover::echoUi_star($score);?>
	        </div>
		    <div class="douban-cover-p doudan-comment-number"><?php echo $douban_Data['ratings_count'];?>人评价</div>
		    <div class="douban-cover-p" >看过: <?php echo $douban_Data['collect_count'];?>人</div>
		    <div class="douban-cover-p" >想看: <?php echo $douban_Data['wish_count'];?>人</div>
		    <div class="douban-cover-p" >年份: <?php echo $douban_Data['year'];?></div>
		    <div class="douban-cover-p">导演: 
		        <span class="douban-director">
					<?php
					$directorarr = explode('#',$douban_Data['directors']); 
					foreach($directorarr as $k=>$v){
						$value = explode('$',$v);	   
							 echo'<a href="'.$value[2].'" rel="nofollow" target="_blank">'.$value[0].'</a>  ';  
						   }?>
				</span>
			</div>
		    <div class="douban-cover-p">主演:
				<span  class="douban-main-actor">
					<?php
					$castsarr = explode('#',$douban_Data['casts']); 
					foreach($castsarr as $k=>$v){
						$value = explode('$',$v);	   
							 echo'<a href="'.$value[2].'" rel="nofollow" target="_blank">'.$value[0].'</a>  ';  
						   }?>
				</span>
			</div>
		    <div class="douban-cover-p" >类型:  <?php echo $douban_Data['genres'];?></div>
			<div class="douban-cover-p" >制片国家/地区:  <?php echo $douban_Data['countries'];?></div>
		<?php $subtype = $douban_Data['subtype'];
		if($subtype == 'tv'){
			echo'
		    <div class="douban-cover-p">集数:'.$douban_Data['episodes_count'].'</div>';
		}?>
		    <div class="douban-cover-p" >又名:  <?php echo $douban_Data['aka'];?></div>
	    </div>
	    <div class="douban-cover-desc" id="douban-cover-desc">简介:<?php echo $douban_Data['summary'];?></div> 
	    <div class="douban-info-expland">展开</div>
		<!-- 以下版权信息希望保留 -->
	    <div class="douban-cover-copyright">
		    <a href="https://www.lylares.com/a-wordpress-plugin-of-douban-movie.html" target="_blank" rel ="nofollow" title="豆瓣封面插件官网">© LYLARES
			</a>
	    </div>
		<!-- 以上版权信息希望保留 -->		
    </div>
	<?}
	}
