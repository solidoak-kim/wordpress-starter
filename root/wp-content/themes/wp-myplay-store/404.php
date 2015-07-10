<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header();
?>
	<div class="page-container error-404">
		<h2><?php _e( 'OOPS', 'rg' ); ?></h2>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'rg' ); ?></p>
		<?php _rgnrtrSearchForm( get_search_form() ); ?>
	</div>

<?php get_footer(); ?>