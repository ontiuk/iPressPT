<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for tag archive page breadcrumb,
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
     
<!-- Breadcrumb -->
<section class="header-breadcrumb tag-breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= __( 'Home', 'ipress' ); ?></a></li>
			<li class="breadcrumb-item"><?= __( 'Tag', 'ipress' ); ?></li>
			<li class="breadcrumb-item active"><?= single_tag_title( '', false ); ?></li>
		</ul>
	</div>
</section>
