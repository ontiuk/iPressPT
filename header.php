<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * @see     https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package iPress\Templates
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<?php do_action( 'ipress_before_site' ); ?>

	<div id="page" class="site-container">

	<?php do_action( 'ipress_before_header' ); ?>

	<header id="masthead" class="site-header">

		<?php do_action( 'ipress_header' ); ?>

	</header><!-- #masthead / .site-header -->

	<?php do_action( 'ipress_before_content' ); // phpcs:ignore Squiz.PHP.EmbeddedPhp.ContentAfterOpen
