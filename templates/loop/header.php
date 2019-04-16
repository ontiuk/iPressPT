<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop header.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_loop_header_before' ); ?>

<header class="entry-header">
<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
	<?= sprintf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'ipress' ) ); ?>
<?php endif; ?>

<?php
	if ( is_singular() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
	else :
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	endif;
?>        
</header><!-- .entry-header -->

<?php do_action( 'ipress_loop_header_after' );
