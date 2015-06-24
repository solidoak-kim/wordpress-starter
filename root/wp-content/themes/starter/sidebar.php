<?php
/**
 * The sidebar containing the widget area.
 */

if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<div class="sidebar">
		<div class="container">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div><!-- .container -->
	</div><!-- .sidebar -->
<?php endif; ?>