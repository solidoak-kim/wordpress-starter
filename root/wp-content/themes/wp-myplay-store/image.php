<?php
/**
 * The template for displaying image attachments.
 */

get_header(); ?>

<div class="content image">
   	<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
   		<header class="entry-header">
   			<h1 class="entry-title"><?php the_title(); ?></h1>

   			<div class="entry-meta">
   				<?php
   					$published_text = __( '<span class="attachment-meta">Published on <time class="entry-date" datetime="%1$s">%2$s</time> in <a href="%3$s" title="Return to %4$s" rel="gallery">%5$s</a></span>', 'twentythirteen' );
   					$post_title = get_the_title( $post->post_parent );
   					if ( empty( $post_title ) || 0 == $post->post_parent )
   						$published_text = '<span class="attachment-meta"><time class="entry-date" datetime="%1$s">%2$s</time></span>';

   					printf( $published_text,
   						esc_attr( get_the_date( 'c' ) ),
   						esc_html( get_the_date() ),
   						esc_url( get_permalink( $post->post_parent ) ),
   						esc_attr( strip_tags( $post_title ) ),
   						$post_title
   					);

   					$metadata = wp_get_attachment_metadata();
   					printf( '<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
   						esc_url( wp_get_attachment_url() ),
   						esc_attr__( 'Link to full-size image', 'twentythirteen' ),
   						__( 'Full resolution', 'twentythirteen' ),
   						$metadata['width'],
   						$metadata['height']
   					);
   				?>
   			</div><!-- .entry-meta -->
   		</header><!-- .entry-header -->

</div><!-- .content -->

<?php get_footer(); ?>