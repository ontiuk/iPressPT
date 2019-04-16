<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the main 404 page content.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php do_action( 'ipress_404_before' ); ?>

<section class="error-404 not-found">

   	<header class="page-header">
    	<h1 class="page-title error-title"><?= __( 'Oops! That page can&rsquo;t be found.', 'ipress' ); ?></h1>
        <p><a href="<?= home_url(); ?>"><?= __( 'Return home?', 'ipress' ); ?></a></p>
    </header><!-- .page-header -->

	<div id="post-404" class="page-content">
		<p><?= __( 'Nothing found at this location.', 'ipress' ); ?></p>
		<?php get_search_form(); ?>
    </div><!-- .page-content -->

</section><!-- .error-404 -->

<?php do_action( 'ipress_404_after' );
