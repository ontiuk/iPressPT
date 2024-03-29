<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme footer - displays <footer> section content and containers.
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?>

	<?php do_action( 'ipress_before_footer' ); ?>

	<footer id="footer" class="site-footer">

		<?php do_action( 'ipress_before_footer_content' ); ?>

		<?php do_action( 'ipress_footer' ); ?>

		</div>

		<?php do_action( 'ipress_after_footer_content' ); ?>

	</footer><!-- #footer / .site-footer -->

	<?php do_action( 'ipress_after_footer' ); ?>

	</div><!-- #page / .site-container -->

	<?php do_action( 'ipress_after' ); ?>

<?php wp_footer(); ?>

</body>
</html>
