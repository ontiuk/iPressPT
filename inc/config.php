<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme config file: actions, filters etc
 * 
 * @package		iPress\Config
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Child Theme Config
//----------------------------------------------

// Get current transient and sanitize, or error
if ( false === ( $ipress_config = get_transient( 'ipress_config' ) ) ) {
	add_action( 'admin_notices', function() {
		echo sprintf( '<div class="notice notice-error is-dismissible"><p>%s</p></div>', __( 'Error: Could not retrieve theme config', 'ipress' ) );
	} );
	$ipress_scripts = $ipress_styles = $ipress_fonts = $ipress_post_types =	$ipress_taxonomies = [];
} else {
	$ipress_scripts 	= ( isset( $ipress_config->scripts ) && ! empty( $ipress_config->scripts ) ) ? $ipress_config->scripts : [];
	$ipress_styles 		= ( isset( $ipress_config->styles ) && ! empty( $ipress_config->styles ) ) ? $ipress_config->styles : [];
	$ipress_fonts 		= ( isset( $ipress_config->fonts ) && ! empty( $ipress_config->fonts ) ) ? $ipress_config->fonts : [];
	$ipress_post_types 	= ( isset( $ipress_config->post_types ) && ! empty( $ipress_config->post_types ) ) ? $ipress_config->post_types : [];
	$ipress_taxonomies 	= ( isset( $ipress_config->taxonomies ) && ! empty( $ipress_config->taxonomies ) ) ? $ipress_config->taxonomies : [];
}

//------------------------------------------------------
//	Child Theme: Initialize Scripts, Styles & Fonts
//------------------------------------------------------
$ipress->scripts->init( $ipress_scripts );
$ipress->styles->init( $ipress_styles, $ipress_fonts );

//----------------------------------------------------------
//	Child Theme: Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------
$ipress->custom->init( $ipress_post_types, $ipress_taxonomies );

//end
