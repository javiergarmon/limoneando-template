<?php
/**
*	Custom function to get current URL
**/
function curPageURL() {
 	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
 	 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
 	 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}
    
function pp_debug($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function gen_permalink($current_url = '', $additional = '')
{
	$current_arr = parse_url($current_url);
	
	$start = '';
	if(isset($current_arr['query']) && !empty($current_arr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
    
    return $current_url.$start.$additional;
}

function gen_pagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=10) 
{ 
    if(!$total OR !$currentPage OR !$baseLink) 
    { 
        return false; 
    } 

    //Total Number of pages 
    $totalPages = ceil($total/$limit); 
     
    //Text to use after number of pages 
    //$txtPagesAfter = ($totalPages==1)? " page": " pages"; 
     
    //Start off the list. 
    //$txtPageList = '<br />'.$totalPages.$txtPagesAfter.' : <br />'; 
     
    //Show only 3 pages before current page(so that we don't have too many pages) 
    $min = ($page - 3 < $totalPages && $currentPage-3 > 0) ? $currentPage-3 : 1; 
     
    //Show only 3 pages after current page(so that we don't have too many pages) 
    $max = ($page + 3 > $totalPages) ? $totalPages : $currentPage+3; 
     
    //Variable for the actual page links 
    $pageLinks = ""; 
    
    $baseLinkArr = parse_url($baseLink);
    $start = '';
    
    if(isset($baseLinkArr['query']) && !empty($baseLinkArr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
     
    //Loop to generate the page links 
    for($i=$min;$i<=$max;$i++) 
    { 
        if($currentPage==$i) 
        { 
            //Current Page 
            $pageLinks .= '<a href="#" class="active">'.$i.'</a>';  
        } 
        elseif($max <= $totalPages OR $i <= $totalPages) 
        { 
            $pageLinks .= '<a href="'.$baseLink.$start.'page='.$i.'" class="slide">'.$i.'</a>'; 
        } 
    } 
     
    if($nextPrev) 
    { 
        //Next and previous links 
        $next = ($currentPage + 1 > $totalPages) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage + 1).'" class="slide">Siguiente</a>'; 
         
        $prev = ($currentPage - 1 <= 0 ) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage - 1).'" class="slide">Anterior</a>'; 
    } 
     
    if($totalPages > 1)
    {
    	return '<br class="clear"/><div class="pagination">'.$txtPageList.$prev.$pageLinks.$next.'</div>'; 
    }
    else
    {
    	return '';
    }
     
} 

function count_shortcode($content = '')
{
	$return = array();
	
	if(!empty($content))
	{
		$pattern = get_shortcode_regex();
    	$count = preg_match_all('/'.$pattern.'/s', $content, $matches);
    	
    	$return['total'] = $count;
    	
    	if(isset($matches[0]))
    	{
    		foreach($matches[0] as $match)
    		{
    			$return['content'][] = substr_replace($match ,"",-1);
    		}
    	}
	}
	
	return $return;
}

function pp_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Inicio'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore;
      single_cat_title();
      echo $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Resultados de B&uacute;squeda para &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Art&iacute;culos etiquetados como &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Art&iacute;culos escritos por ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('P&aacute;gina') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}
    
/**
*	Setup blog comment style
**/
function pp_comment($comment, $args, $depth) 
{
	$GLOBALS['comment'] = $comment; 
?>
   
	<div class="comment" id="comment-<?php comment_ID() ?>">
		<div class="left">
         	<?php echo get_avatar($comment,$size='50',$default='<path_to_url>' ); ?>
      	</div>
      
		<div class="comment_arrow"></div>
      	<div class="right">
			<?php if ($comment->comment_approved == '0') : ?>
         		<em><?php echo _e('(Tu comentario est&aacute; esperando ser aprobado.)', THEMEDOMAIN) ?></em>
         		<br />
      		<?php endif; ?>
			
			<?php
				if(!empty($comment->comment_author_url))
				{
			?>
					<a href="<?php echo $comment->comment_author_url; ?>"><strong style="float:left;margin-top:1px"><?php echo $comment->comment_author; ?></strong></a>
			<?php
				}
				else
				{
			?>
					<strong style="float:left;margin-top:1px"><?php echo $comment->comment_author; ?></strong>
			<?php
				}
			?>
			
			<div class="comment_date"><?php echo pp_ago(strtotime($comment->comment_date)); ?></div>
			
			<?php 
      			if($depth < 3)
      			{
      		?>
      			<p class="comment-reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth,
'reply_text' => '(Responder)', 'login_text' => 'Accede al sistema para comentar', 'max_depth' => $args['max_depth']))) ?></p>
			<?php
				}
			?>
			
			<br class="clear"/><br/>
      		<?php ' '.comment_text() ?>

      	</div>
    </div>
<?php
}

function pp_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("segundo", "minuto", "hora", "d&iacute;a", "semana", "mes", "a&ntilde;o", "d&eacute;cada");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}


// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function pp_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function pp_posts($sort = 'recent', $items = 3, $echo = TRUE, $bg_color = 'black') 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish');
		$title = __('Art&iacute;culos Recientes', THEMEDOMAIN);
	}
	else
	{
		global $wpdb;
		
		$query = "SELECT ID, post_title, post_content FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0,".$items;
		$posts = $wpdb->get_results($query);
		$title = __('Art&iacute;culos Populares', THEMEDOMAIN); 
	}
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';
		$return_html.= '<ul class="posts blog '.$bg_color.'_wrapper">';
		
		$count_post = count($posts);

			foreach($posts as $post)
			{
				$image_thumb = get_post_meta($post->ID, 'blog_thumb_image_url', true);
				$return_html.= '<li>';
				
				if(has_post_thumbnail($post->ID, 'large'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<a href="'.get_permalink($post->ID).'"><img class="alignleft frame" src="'.$image_url[0].'" alt="" /></a>';
				}
				
				$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></strong><br/><span class="post_attribute">'.get_the_time('j - F - Y', $post->ID).'</span>';
				$return_html.= '</li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function _substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}

function get_the_content_with_formatting ($more_link_text = '', $length = 600, $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = strip_shortcodes($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = _substr(strip_tags($content), $length);
	
	if(!empty($more_link_text))
	{
		$content.= '<br/><br/><a class="long_button" href="'.get_permalink().'"><span>'.$more_link_text.'</span></a>';
	}
	
	return $content;
}

function image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}


function select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}


function get_flickr($settings) {
	if (!function_exists('MagpieRSS')) {
	    // Check if another plugin is using RSS, may not work
	    include_once (ABSPATH . WPINC . '/class-simplepie.php');
	    error_reporting(E_ERROR);
	}
	
	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}
	
	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&tags=' . $settings['tags'] . '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags=' . $settings['tags'] . '&format=rss_200'; }
	else {
	    print '<strong>No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.</strong>';
	    die();
	}
	# get rss file

	$feed = new SimplePie($rss_url);
	$photos_arr = array();
	
	foreach ($feed->get_items() as $key => $item)
	{
		$enclosure = $item->get_enclosure();
		$img = image_from_description($item->get_description()); 
		$thumb_url = select_image($img, 0);
		$large_url = select_image($img, 4);
		
		$photos_arr[] = array(
			'title' => $enclosure->get_title(),
			'thumb_url' => $thumb_url,
			'url' => $large_url,
		);
		
		$current = intval($key+1);
		
		if($current == $settings['items'])
		{
			break;
		}
	}  

	return $photos_arr;
}

function pp_photos_in_news($items = 10, $title = 'Photos In News', $echo = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date');
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle"><span>'.$title.'</span></h2>';
		$return_html.= '<ul class="thumb">';

			foreach($posts as $post)
			{
				if(has_post_thumbnail($post->ID, 'thumbnail'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);

					$return_html.= '<li><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'"><img class="resize frame" src="'.$image_url[0].'" alt="" /></a></li>';
				}

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}


function pp_cat_posts($cat_id = '', $items = 5, $echo = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{

		$return_html.= '<h2 class="widgettitle">'.$title.'</h2>';
		$return_html.= '<ul class="posts">';

			foreach($posts as $key => $post)
			{
				$return_html.= '<li>';
			
				if(has_post_thumbnail($post->ID, 'large'))
				{
					$image_id = get_post_thumbnail_id($post->ID);
					$image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
					
					$return_html.= '<a href="'.get_permalink($post->ID).'"><img class="alignleft frame post_thumb" src="'.$image_url[0].'" alt="" /></a>';
				}
				
				$return_html.= '<strong class="title"><a href="'.get_permalink($post->ID).'">'.pp_substr($post->post_title, 50).'</a></strong><br/><span class="post_attribute">'.get_the_time('j - F - Y', $post->ID).'</span><br/>';
				$return_html.= '</li>';
			}	

		$return_html.= '</ul><br class="clear"/>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function hex_lighter($hex,$factor = 30) 
    { 
    $new_hex = ''; 
     
    $base['R'] = hexdec($hex{0}.$hex{1}); 
    $base['G'] = hexdec($hex{2}.$hex{3}); 
    $base['B'] = hexdec($hex{4}.$hex{5}); 
     
    foreach ($base as $k => $v) 
        { 
        $amount = 255 - $v; 
        $amount = $amount / 100; 
        $amount = round($amount * $factor); 
        $new_decimal = $v + $amount; 
     
        $new_hex_component = dechex($new_decimal); 
        if(strlen($new_hex_component) < 2) 
            { $new_hex_component = "0".$new_hex_component; } 
        $new_hex .= $new_hex_component; 
        } 
         
    return $new_hex;     
} 

function hex_darker($hex,$factor = 30)
{
	$new_hex = '';
	
	$base['R'] = hexdec($hex{0}.$hex{1});
	$base['G'] = hexdec($hex{2}.$hex{3});
	$base['B'] = hexdec($hex{4}.$hex{5});
	
	foreach ($base as $k => $v)
	        {
	        $amount = $v / 100;
	        $amount = round($amount * $factor);
	        $new_decimal = $v - $amount;
	
	        $new_hex_component = dechex($new_decimal);
	        if(strlen($new_hex_component) < 2)
	                { $new_hex_component = "0".$new_hex_component; }
	        $new_hex .= $new_hex_component;
	        }
	        
	return $new_hex;        
}

function XML2Array ( $xml , $recursive = false )
{
    if ( ! $recursive )
    {
        $array = simplexml_load_string ( $xml ) ;
    }
    else
    {
        $array = $xml ;
    }
    
    $newArray = array () ;
    $array = ( array ) $array ;
    foreach ( $array as $key => $value )
    {
        $value = ( array ) $value ;
        if ( isset ( $value [ 0 ] ) )
        {
            $newArray [ $key ] = trim ( $value [ 0 ] ) ;
        }
        else
        {
            $newArray [ $key ] = XML2Array ( $value , true ) ;
        }
    }
    return $newArray ;
}

/**
 * Converts a simpleXML element into an array. Preserves attributes and everything.
 * You can choose to get your elements either flattened, or stored in a custom index that
 * you define.
 * For example, for a given element
 * <field name="someName" type="someType"/>
 * if you choose to flatten attributes, you would get:
 * $array['field']['name'] = 'someName';
 * $array['field']['type'] = 'someType';
 * If you choose not to flatten, you get:
 * $array['field']['@attributes']['name'] = 'someName';
 * _____________________________________
 * Repeating fields are stored in indexed arrays. so for a markup such as:
 * <parent>
 * <child>a</child>
 * <child>b</child>
 * <child>c</child>
 * </parent>
 * you array would be:
 * $array['parent']['child'][0] = 'a';
 * $array['parent']['child'][1] = 'b';
 * ...And so on.
 * _____________________________________
 * @param simpleXMLElement $xml the XML to convert
 * @param boolean $flattenValues    Choose wether to flatten values
 *                                    or to set them under a particular index.
 *                                    defaults to true;
 * @param boolean $flattenAttributes Choose wether to flatten attributes
 *                                    or to set them under a particular index.
 *                                    Defaults to true;
 * @param boolean $flattenChildren    Choose wether to flatten children
 *                                    or to set them under a particular index.
 *                                    Defaults to true;
 * @param string $valueKey            index for values, in case $flattenValues was set to
        *                            false. Defaults to "@value"
 * @param string $attributesKey        index for attributes, in case $flattenAttributes was set to
        *                            false. Defaults to "@attributes"
 * @param string $childrenKey        index for children, in case $flattenChildren was set to
        *                            false. Defaults to "@children"
 * @return array the resulting array.
 */
function simpleXMLToArray($xml, 
                $flattenValues=true,
                $flattenAttributes = true,
                $flattenChildren=true,
                $valueKey='@value',
                $attributesKey='@attributes',
                $childrenKey='@children'){

    $return = array();
    if(!($xml instanceof SimpleXMLElement)){return $return;}
    $name = $xml->getName();
    $_value = trim((string)$xml);
    if(strlen($_value)==0){$_value = null;};

    if($_value!==null){
        if(!$flattenValues){$return[$valueKey] = $_value;}
        else{$return = $_value;}
    }

    $children = array();
    $first = true;
    foreach($xml->children() as $elementName => $child){
        $value = simpleXMLToArray($child, $flattenValues, $flattenAttributes, $flattenChildren, $valueKey, $attributesKey, $childrenKey);
        if(isset($children[$elementName])){
            if($first){
                $temp = $children[$elementName];
                unset($children[$elementName]);
                $children[$elementName][] = $temp;
                $first=false;
            }
            $children[$elementName][] = $value;
        }
        else{
            $children[$elementName] = $value;
        }
    }
    if(count($children)>0){
        if(!$flattenChildren){$return[$childrenKey] = $children;}
        else{$return = array_merge($return,$children);}
    }

    $attributes = array();
    foreach($xml->attributes() as $name=>$value){
        $attributes[$name] = trim($value);
    }
    if(count($attributes)>0){
        if(!$flattenAttributes){$return[$attributesKey] = $attributes;}
        else{$return = array_merge($return, $attributes);}
    }
    
    return $return;
}

function curl($url) {
    $ch = curl_init($url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    // EDIT your domain to the next line:
    curl_setopt($ch,CURLOPT_TIMEOUT,10);
    $data = curl_exec($ch);
    
    if (curl_errno($ch) !== 0 || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
        $data === false;
    }
    curl_close($ch);
    return $data;
}

function theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'theme_queue_js');

?>