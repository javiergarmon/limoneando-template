<?php
// Get Twitter Follower count as plain text
add_option('pp_twitter_followers','0','','yes');
add_option('pp_twitter_api_timer',mktime(),'','yes');
error_reporting(0);
function pp_twitter_followers() {
	$twittercount = 0;
    
    if ( $twittercount == 0 OR get_option(SHORTNAME.'_twitter_api_timer') < (mktime() - 3600) ) {
        // EDIT your Twitter user name here:
        $twitter_id = get_option(SHORTNAME.'_twitter_username');
        $followers = curl("http://twitter.com/users/show.xml?screen_name=" . $twitter_id);
        try {
            $xml = new SimpleXmlElement($followers, LIBXML_NOCDATA);
            if ($xml) {
                $twittercount = (string) $xml->followers_count;
                //var_dump('twitter');
                
                if($twittercount > 0)
				{
                	update_option('pp_twitter_followers', $twittercount);
                	update_option('pp_twitter_api_timer', mktime());
                }
                else
                {
                	$twittercount = get_option('pp_twitter_followers');
                }
            }
        } catch (Exception $e) { }
    }
    else
    {
    	$twittercount = get_option('pp_twitter_followers');
    }
    if ( $twittercount != '0' ) { echo number_format($twittercount); }
    else { echo 0; }
}

// Get Feedburner RSS Subscriber count as plain text
add_option('pp_feeds_count','0','','yes');
add_option('pp_feeds_api_timer',mktime(),'','yes');

function pp_feeds_count() {
    $rsscount = 0;

    if ( $rsscount == 0 OR get_option('pp_feeds_api_timer') < (mktime() - 3600) ) {
    //if ( true ) {
        // EDIT your Feedburner feed name here:
        $fb_id = get_option('pp_feedburner_id');
        $suscriptores = curl("http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=" . $fb_id);
        
        //echo "http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=" . $fb_id;
        
        try {
            $xml = new SimpleXmlElement($suscriptores, LIBXML_NOCDATA);
            //var_dump($xml);

            if ($xml) {
                $rsscount = (string) $xml->feed->entry['circulation'];

                if($rsscount > 0)
				{
                	update_option('pp_feeds_count', $rsscount);
                	update_option('pp_feeds_api_timer', mktime());
                }
                else
                {
                	$rsscount = get_option('pp_feeds_count');
                }
            }
        } catch (Exception $e) { }
    }
    else
    {
    	$rsscount = get_option('pp_feeds_count');
    }
    
    //Echo the count if we got it
    if($rsscount == 'N/A' || $rsscount == '0') { echo 0; }
    else { echo number_format($rsscount); }
}

function wpapi_pagination($pages = '', $range = 3)
{
 $showitems = ($range * 2)+1;
 
 global $paged;
 if(empty($paged)) $paged = 1;
 
 if($pages == '')
 {
 global $wp_query;
 $pages = $wp_query->max_num_pages;
 if(!$pages)
 {
 $pages = 1;
 }
 }
 
 if(1 != $pages)
 {
 echo "<div class=\"pagination\">";
 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; Primero</a>";
 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Anterior</a>";
 
 for ($i=1; $i <= $pages; $i++)
 {
 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
 {
 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
 }
 }
 
 if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Siguiente &rsaquo;</a>";
 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&Uacute;ltimo &raquo;</a>";
 echo "</div>\n";
 }
}

function pp_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'pp_formatter', 99);
add_filter('widget_text', 'pp_formatter', 99);


/* Disable the Admin Bar. */
function yoast_disable_admin_bar() {
add_filter( 'show_admin_bar', '__return_false' );
add_action( 'admin_print_scripts-profile.php',
'yoast_hide_admin_bar_settings' );
}
add_action( 'init', 'yoast_disable_admin_bar' , 9 );


//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');

if (isset($_GET['activated']) && $_GET['activated']){
	global $wpdb;
	
	// Run default settings
	include_once(TEMPLATEPATH . "/default_settings.php");
    wp_redirect(admin_url("themes.php?page=admin-action.lib.php&activate=true"));
}
?>