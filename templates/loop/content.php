<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop content and thumbnail.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<?php /** @hooked ipress_loop_thumbnail - 10 */
do_action( 'ipress_loop_content_before' ); ?>

<section class="entry-summary">
<?php
	the_content( sprintf(
		wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'underscores' ),
			[
				'span' => [
					'class' => [],
				]
			]
		),
		get_the_title()
	) );

	wp_link_pages( [
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'underscores' ),
		'after'  => '</div>',
	] );
?>
</section><!-- .entry-summary -->

<?php do_action( 'ipress_loop_content_after' );
