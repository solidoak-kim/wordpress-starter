<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

	<div class="content error404">
		<div class="page-content">
		   <h2><?php _e( 'DOH!!', 'rg' ); ?></h2>
		   <div class="doh"><img src="<?php bloginfo( 'template_directory' ); ?>/images/homer-doh.png" /></div>
		   <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'rg' ); ?></p>
		   <?php get_search_form(); ?>
		</div><!-- .page-content -->

	</div><!-- .content -->

<?php get_footer(); ?>