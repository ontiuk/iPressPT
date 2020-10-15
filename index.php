<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Main fallback template displaying generic posts list.
 * 
 * @see https://codex.wordpress.org/Template_Hierarchy
 *
 * @package		iPress\Templates
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php get_header(); ?>

<?php do_action( 'ipress_before_main_content' ); ?>

	<main id="main" class="site-content index-page">

	<?php do_action( 'ipress_archive_before' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<header class="page-header">
			<h2><?php the_title(); ?></h2>
		</header><!-- .page-header -->

		<?php the_excerpt(); ?>

	<?php endwhile; ?>

	<?php do_action( 'ipress_archive_after' ); ?>

	</main><!-- #main / .site-content -->

	<?php do_action( 'ipress_sidebar' ); ?>

<?php do_action( 'ipress_after_main_content' ); ?>

<?php get_footer();
