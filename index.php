<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Main fallback template displaying generic posts list.
 *
 * @see https://codex.wordpress.org/Template_Hierarchy
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

<?php get_header(); ?>

	<main id="main" class="site-main index-page">

	<?php do_action( 'ipress_before_main_content' ); ?>

	<?php while ( have_posts() ) : ?>

		<?php the_post(); ?>

		<header class="page-header">
			<h2><?php the_title(); ?></h2>
		</header><!-- .page-header -->

		<?php the_excerpt(); ?>

	<?php endwhile; ?>

	<?php do_action( 'ipress_after_main_content' ); ?>

	</main><!-- #main / .site-content -->

<?php get_footer(); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
