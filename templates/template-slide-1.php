<?php
if($pp_home_display_slide)
{
	$featured_posts_arr = get_posts('numberposts=5&order=DESC&orderby=date&category='.$pp_featured_cat);
}

if(!empty($featured_posts_arr))
{
?>

<div class="sidebar_content">		
				
<div class="sidebar_left_home_wrapper">
    
    <?php
    	/*if(!empty($featured_posts_arr) && !empty($pp_featured_cat))
    	{
    ?>
    
    <div id="slider_wrapper">
    
    <div id="nivo_caption_wrapper">
    <?php
    		foreach($featured_posts_arr as $key => $featured_post)
    		{
    			$hyperlink_url = get_permalink($featured_post->ID);
    			
    			$post_categories = wp_get_post_categories( $featured_post->ID );
    			$cats = array();
    				
    			foreach($post_categories as $c){
    				$cat = get_category( $c );
    				
    				if($pp_featured_cat != $cat->term_id)
    				{
    					$cats[0] = array( 'name' => $cat->name );
    					break;
    				}
    			}
    		
    			if(has_post_thumbnail($featured_post->ID, 'home_ft'))
    			{
    ?>
    
    			<div id="caption<?php echo $key; ?>" class="nivo-html-caption" <?php if($key == 0) { echo 'style="display:block"'; } ?>>
    				<?php
    					if(isset($cats[0]))
    					{
    				?>
    				
    				<div class="caption_cat"><?php echo $cats[0]['name']; ?></div>
    				
    				<?php
    					} else {
    				?>
    				
    				<div class="caption_cat" style="visibility:hidden">None</div>
    				
    				<?php
    					}
    				?>
    				<h4><?php echo $featured_post->post_title; ?></h4>
    			</div>
    
    <?php
    			}
    		}
    ?>
    </div>
    
    <div id="nivo_slider" class="nivoSlider">
    
    <?php
    		foreach($featured_posts_arr as $key => $featured_post)
    		{
    			$hyperlink_url = get_permalink($featured_post->ID);
    			
    			if(has_post_thumbnail($featured_post->ID, 'home_ft'))
    			{
    				$image_id = get_post_thumbnail_id($featured_post->ID);
    				$image_url = wp_get_attachment_image_src($image_id, 'home_ft', true);
    				$thumb_url = wp_get_attachment_image_src($image_id, 'home_ft_thumb', true);
    ?>
    				<a href="<?php echo $hyperlink_url;?>">
    					<img src="<?php echo $image_url[0]; ?>" style="width:600px;height:350px" alt="#caption<?php echo $key; ?>" rel="<?php echo $thumb_url[0]; ?>"/>
    				</a>
    <?php
    			}
    			else
    			{
    ?>
    				<a href="<?php echo $hyperlink_url;?>">
    					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/trans_000_bg.png" style="width:600px;height:350px" alt="#caption<?php echo $key; ?>" rel="<?php echo get_stylesheet_directory_uri(); ?>/images/trans_000_bg.png"/>
    				</a>
    <?php
    			}
    		}
    ?>

    </div>
</div>
    
<?php
    } */
}
?>