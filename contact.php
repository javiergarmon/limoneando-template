<?php
/**
 * Template Name: Contact
 * The main template file for display contact page.
 *
 * @package WordPress
*/


/**
*	if not submit form
**/

if(!isset($_POST['your_name']))
{

if(!isset($hide_header) OR !$hide_header)
{
	get_header(); 
}
?>
		<br class="clear"/>

		<!-- Begin content -->
		<div id="content_wrapper">
			
			<div class="inner">

				<!-- Begin main content -->
				<div class="inner_wrapper">
				
				
					<div class="sidebar_content">
					
						<h2 class="widgettitle header"><?php the_title(); ?></h2>
						
						<div class="page_fullwidth">
						<?php 
							if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

									<?php the_content(); ?>

						<?php endwhile; 
						?>
						Por favor, rellena todos los campos del formulario, ya que son obligatorios.<br/><br/>
						<form id="contact_form" method="post" action="<?php echo curPageURL(); ?>">
						   <input id="your_name" name="your_name" title="<?php echo _e( 'Name', THEMEDOMAIN ); ?>*" type="text" style="width:47%"/> &nbsp;&nbsp; Nombre 
						    <br/><br/>
						   <input id="email" name="email" type="text" title="<?php echo _e( 'Email', THEMEDOMAIN ); ?>*" style="width:47%"/> &nbsp;&nbsp; E-mail (No ser&aacute; publicado)
						    <br/><br/>
						    Tu mensaje
                            <br/><br/> <textarea id="message" name="message" title="<?php echo _e( 'Message', THEMEDOMAIN ); ?>*" rows="7" cols="10" style="width:97%"></textarea> 
						    <br/><br/>
						    <input type="submit" value="<?php echo _e( 'Enviar mensaje', THEMEDOMAIN ); ?>"/><br/><br/>
						</form>
						<div id="reponse_msg"></div>
						
						</div>
					</div>
					
					<div class="sidebar_wrapper">
						<?php
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
								<?php dynamic_sidebar('Home Sidebar'); ?>
								<?php // ESTA ERA LA ORIGINAL dynamic_sidebar('Contact Sidebar'); ?></ul>
								
							</div>
						
						</div>
					</div>
				
				</div>
				<!-- End main content -->
							
				<br class="clear"/>
				
<?php
if(!isset($hide_header) OR !$hide_header)
{
?>	
			</div>
			
			<br class="clear"/>
		</div>
		<!-- End content -->
				

<?php get_footer(); ?>

<?php
}
?>
				
<?php
}

//if submit form
else
{

	/*
	|--------------------------------------------------------------------------
	| Mailer module
	|--------------------------------------------------------------------------
	|
	| These module are used when sending email from contact form
	|
	*/
	
	//Get your email address
	$contact_email = get_option('pp_contact_email');
	$pp_contact_thankyou = get_option('pp_contact_thankyou');
	
	//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
	define('DEST_EMAIL', $contact_email);
	
	//Change email subject to something more meaningful
	define('SUBJECT_EMAIL', 'Email de Limoneando');
	
	//Thankyou message when message sent
	define('THANKYOU_MESSAGE', $pp_contact_thankyou);
	
	//Error message when message can't send
	define('ERROR_MESSAGE', 'Oops! se ha producido un error. Vuelve a intentar mandar el mensaje.');
	
	
	/*
	|
	| Begin sending mail
	|
	*/
	
	$from_name = $_POST['your_name'];
	$from_email = $_POST['email'];
	
	$mime_boundary_1 = md5(time());
    $mime_boundary_2 = "1_".$mime_boundary_1;
    $mail_sent = false;
 
    # Common Headers
    $headers = "";
    $headers .= 'From: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
    $headers .= 'Reply-To: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
    $headers .= 'Return-Path: '.$from_name.'<'.$from_email.'>'.PHP_EOL;        // these two to set reply address
    $headers .= "Message-ID: <".$now."webmaster@".$_SERVER['SERVER_NAME'].">";
    $headers .= "X-Mailer: PHP v".phpversion().PHP_EOL;                  // These two to help avoid spam-filters

    # Boundry for marking the split & Multitype Headers
    $headers .= 'MIME-Version: 1.0'.PHP_EOL;
    $headers .= "Content-Type: multipart/mixed;".PHP_EOL;
    $headers .= "   boundary=\"".$mime_boundary_1."\"".PHP_EOL;
	
	$message = 'Name: '.$from_name.PHP_EOL;
	$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
	$message.= 'Message: '.PHP_EOL.$_POST['message'];
	    
	
	if(!empty($from_name) && !empty($from_email) && !empty($message))
	{
		mail(DEST_EMAIL, SUBJECT_EMAIL, $message, $headers);
	
		echo THANKYOU_MESSAGE;
		
		exit;
	}
	else
	{
		echo ERROR_MESSAGE;
		
		exit;
	}
	
	/*
	|
	| End sending mail
	|
	*/
}

?>