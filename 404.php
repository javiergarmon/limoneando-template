<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/


get_header(); 

?>
		<br class="clear"/>
		
		<!-- Begin content -->
		<div id="content_wrapper">
		
			<div class="inner">
				
				<!-- Begin main content -->
				<div class="inner_wrapper">
				
					<div class="sidebar_content">
					
					<h2 class="widgettitle header"><?php _e( '404 Not Found', THEMEDOMAIN ); ?></h2>
					
					<div class="page_fullwidth">
						<?php _e( 'La p&aacute;gina solicitada no ha sido encontrada. Esto puede ser debido a que la p&aacute;gina ya no existe,  ha cambiado de direcci&oacute;n ha esta desactivada temporalmente.', THEMEDOMAIN ); ?>
					</div>
					
					</div>
					
				</div>
				<!-- End main content -->
				
				<br class="clear"/><br/><br/>
			
			</div>
			
		</div>
		<!-- End content -->
		
		<br class="clear"/>

<?php get_footer(); ?>