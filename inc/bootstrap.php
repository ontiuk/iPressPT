<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Set up and load theme requirements and bootstrap initialization.
 *
 * @package iPress\Bootstrap
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

// phpcs:disable

// Initialise hooks
do_action( 'ipress_bootstrap' );

//----------------------------------------------
//	Theme Defines
//----------------------------------------------

// Theme Name
define( 'IPRESS_THEME_NAME', 'iPress' );

// Theme Versioning
define( 'IPRESS_THEME_WP', 6.2 ); // WordPress minimum version required
define( 'IPRESS_THEME_PHP', 8.1 ); // Server PHP minimum version required

// Directory Structure
define( 'IPRESS_DIR', get_parent_theme_file_path() );
define( 'IPRESS_INCLUDES_DIR', IPRESS_DIR . '/inc' );
define( 'IPRESS_LANG_DIR', IPRESS_DIR . '/languages' );

// Directory Paths
define( 'IPRESS_URL', get_parent_theme_file_uri() );
define( 'IPRESS_INCLUDES_URL', IPRESS_URL . '/inc' );
define( 'IPRESS_LANG_URL', IPRESS_URL . '/languages' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Load compatability check
$ipress_compat = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-compat.php';
if ( true === $ipress_compat->get_error() ) { return; }

//----------------------------------------------
//	Includes - Functions, Customizer
//----------------------------------------------

require_once IPRESS_INCLUDES_DIR . '/functions.php';
require_once IPRESS_INCLUDES_DIR . '/customizer.php';

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Load scripts, styles & fonts
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-scripts.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-styles.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-load-fonts.php';

// Core functionality
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-init.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-navigation.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-images.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-login.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-rewrites.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-sidebars.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-widgets.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-page.php';

//----------------------------------------------
//	Init
//----------------------------------------------

// Initialization
do_action( 'ipress_init' );

// Retrieve class object
global $ipress;

// Set theme & version
$ipress->theme = wp_get_theme( IPRESS_THEME_NAME );
$ipress->version = $ipress->theme['Version'];

// Theme setup & customizer functionality
$ipress->main = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-theme.php';
$ipress->customizer = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-customizer.php';

// Tag on Child Theme data, should be defined by now
if ( is_child_theme() ) {
	$ipress->child_theme = wp_get_theme( IPRESS_CHILD_THEME_NAME );
	$ipress->child_version = $ipress->child_theme['Version'];
}

// Multisite?
if ( is_multisite() ) {
	$ipress->multisite = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-multisite.php';
}

//----------------------------------------------------------
//	Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------

require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-custom.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-post-type.php';
require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-taxonomy.php';

//----------------------------------------------
//	Parent Theme Configuration
//----------------------------------------------

// Configuration
do_action( 'ipress_config' );

// Theme Setup Configuration: actions, filters etc
include_once IPRESS_INCLUDES_DIR . '/config.php';
