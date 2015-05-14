<?php
/**
 * Template Name: Page Sidebar
 * The main template file for display page.
 *
 * @package WordPress
*/


/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

get_header(); 
?>
		<br class="clear"/>

		<!-- Begin content -->
		<div id="content_wrapper">
			
			<div class="inner">
			
				<!-- Begin main content -->
				<div class="inner_wrapper">
				
				<div class="sidebar_content">
				
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		
						
							<h2 class="widgettitle header"><?php the_title(); ?></h2>
							
							<div class="page_fullwidth">			
								<?php do_shortcode(the_content()); ?>
							</div>

					<?php endwhile; ?>
					
				</div>
				
				<div class="sidebar_wrapper">
    				<?php 
						error_reporting(0);
					    $twitter_id = get_option(SHORTNAME.'_twitter_username');
					    $fb_id = get_option('pp_feedburner_id');
					    
					    if(!empty($twitter_id) OR !empty($fb_id)):
					?>
					<div class="social_profile">
					    <div class="profile">
					    	<a href="<?php echo $fb_id; ?>">
					    		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social_feeds.png" alt="" class="alignleft social"/>
					    	</a>
					    	<h4><?php pp_feeds_count(); ?></h4>
					    	<span class="count">Suscriptores</span>
					    </div>
					
					    <div class="profile">
					    	<a href="http://twitter.com/<?php echo $twitter_id; ?>">
					    		<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/social_twitter.png" alt="" class="alignleft social"/>
					    	</a>
					    	<h4><?php pp_twitter_followers(); ?></h4>
					    	<span class="count">Seguidores</span>
					    </div>
					    
					     <br class="clear"/>
					</div>
					<?php
					    endif; 
					?>
    				
    				<div class="ads125_wrapper">
					    <?php
					        $pp_side_banner = get_option('pp_side_banner');
					    
					        if(!empty($pp_side_banner))
					        {
					        	echo stripslashes($pp_side_banner);
					        }
					    ?>
					</div>
    			
    				<div class="sidebar">
    				
    					<div class="content">
    				
    						<ul class="sidebar_widget">
    						<?php // ESTE ERA EL ORIGINAL dynamic_sidebar($page_sidebar); ?>
                            <?php dynamic_sidebar('Home Sidebar'); ?>
    						</ul>
    					
    					</div>
    			
    				</div>
    				<br class="clear"/>

    			</div>
    			
    			<br class="clear"/>
				
				</div>
				<!-- End main content -->
				
				<br class="clear"/>
			</div>
			
		</div>
		<!-- End content -->

<br class="clear"/>
<?php get_footer(); ?>