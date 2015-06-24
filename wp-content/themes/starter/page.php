<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>

<div class="content thispage">
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
			<div class="entry-content">
			   <?php the_content(); ?>
			</div><!-- .entry-content -->
		<?php endwhile; ?>
	
		<?php rg_paging_nav(); ?>

	<?php endif; ?>
	
</div><!-- .content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>