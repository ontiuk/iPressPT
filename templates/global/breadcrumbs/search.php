<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for search page breadcrumb.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<!-- Breadcrumb -->
<section class="header-breadcrumb search-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?= __( 'Search', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?= ucfirst( get_search_query() ); ?></li>
		</ul>
	</div>
</section>
