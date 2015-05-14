<?php
if (have_posts()) : while (have_posts()) : the_post();
    $count++;
    /*$image_thumb = '';
    							
    if(has_post_thumbnail(get_the_ID(), 'blog_ft'))
    {
        $image_id = get_post_thumbnail_id(get_the_ID());
        $image_thumb = wp_get_attachment_image_src($image_id, 'blog_ft', true);
    }*/
    
    $post_categories = wp_get_post_categories( get_the_ID() );
    $cats = array();

	foreach($post_categories as $c){
		$cat = get_category( $c );
		$cats[] = array( 'name' => $cat->name);
	}
?>
    
    
    <!-- Begin each blog post -->
    <div class="post_wrapper" <?php if(empty($featured_posts_arr) && $count==1 && is_home()) { ?>style="margin-top:15px;"<?php } ?>>
    
    	<?php
    		if(has_post_thumbnail())
    		{
    	?>
    	
    	<div class="post_img">
    		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    			<?php the_post_thumbnail( array(600,250) );?>
    		</a>
    		   		
    		<div class="caption_cat"><?php
			$count = count($cats);
			$i = 1;
            foreach($cats as $c){ echo $c['name'].(($count>$i)?' | ':''); $i++;
			}?></div>
    		
    	</div>
    	
    	<?php
    		}
    	?>
    	
    	<div class="post_inner_wrapper" <?php if(empty($image_thumb)) { ?>style="margin-top:10px"<?php } ?>>
    	
    	<div class="post_header_wrapper">
    		<div class="post_header">
    			<h3>
    				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
    			</h3>
                <?php if (function_exists('the_subheading')) { the_subheading('<h4>', '</h4>'); } ?>
    		</div>
    		
    		<br class="clear"/>
    		
    		<div class="post_detail">
    		
    		Por <?php echo get_the_author(); ?> | <?php echo get_the_time('d-M-Y H:m'); ?> |
    		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php comments_number('Sin comentarios', '1 comentario', '% comentarios'); ?></a>
    		</div>
    	</div>
    	
    	<?php
    	$pp_blog_display_social = get_option('pp_blog_display_social');
    	
    	if(!empty($pp_blog_display_social)):
    	?>
    	<div class="post_social">
    		<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=268239076529520" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe>
    		
    		<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-text="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
    	</div>
    	<?php
    	endif; ?>
    	
    	<br class="clear"/><br/><hr/>
    	
    	<?php
    		$pp_blog_display_full = get_option('pp_blog_display_full');
    		
    		if(!empty($pp_blog_display_full))
    		{
    			the_content();
    		}
    		else
    		{
    			the_excerpt();
    	?>
    	
    			<a href="<?php the_permalink(); ?>"><?php echo _e( 'Leer m&aacute;s', THEMEDOMAIN ); ?> →</a>
    	
    	<?php
    		}
    	?>
    	
    	
    	</div>
    	
    </div>
    
<?php
if(!isset($cuentaanuncio)){$cuentaanuncio=1;}
switch($cuentaanuncio/2){
case 0.5:
?>
<div class="post_wrapper">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4833777420352075";
/* Portada Banner 1 */
google_ad_slot = "0104530670";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php
break;
case 1.5:?>
<div class="post_wrapper">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4833777420352075";
/* Portada Banner 2 */
google_ad_slot = "8214804325";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php
break;
case 2.5:?>
<div class="post_wrapper">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4833777420352075";
/* Portada Banner 3 */
google_ad_slot = "3097324622";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php
break;
case 3.5:?>
<div class="post_wrapper">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4833777420352075";
/* Portada Banner 4 */
google_ad_slot = "7543380945";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<?php
break;
}
$cuentaanuncio++;
?>
    <!-- End each blog post -->

<?php endwhile; endif; ?>

<div class="pagination">
     <?php 
     	if (function_exists("wpapi_pagination")) {
     		wpapi_pagination($wp_query->max_num_pages); 
     	}
     ?>
 </div>