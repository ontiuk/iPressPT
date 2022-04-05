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

// Theme Name & Versioning
define( 'IPRESS_THEME_NAME', 'iPress' );
define( 'IPRESS_THEME_WP',   5.6 );  // WordPress minimum version required
define( 'IPRESS_THEME_PHP',  7.4 );  // Server PHP minimum version required

// Directory Structure
define( 'IPRESS_DIR',           get_parent_theme_file_path() );
define( 'IPRESS_INCLUDES_DIR',  IPRESS_DIR . '/inc' );
define( 'IPRESS_LANG_DIR',      IPRESS_DIR . '/languages' );

// Includes Directory Structure
define( 'IPRESS_CLASSES_DIR',   IPRESS_INCLUDES_DIR . '/classes' );
define( 'IPRESS_CONTROLS_DIR',  IPRESS_INCLUDES_DIR . '/controls' );
define( 'IPRESS_FUNCTIONS_DIR', IPRESS_INCLUDES_DIR . '/functions' );

// Directory Paths
define( 'IPRESS_URL',           get_parent_theme_file_uri() );
define( 'IPRESS_INCLUDES_URL',  IPRESS_URL . '/inc' );
define( 'IPRESS_LANG_URL',      IPRESS_URL . '/languages' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Load compatability check
$ipress_compat = require_once IPRESS_INCLUDES_DIR . '/classes/class-ipr-compat.php';
if ( true === $ipress_compat->get_error() ) { return; }

//----------------------------------------------
//	Includes - Functions, Customizer
//----------------------------------------------

// Functions
require_once IPRESS_INCLUDES_DIR . '/functions.php';

// Customizer: custom controls
require_once IPRESS_INCLUDES_DIR . '/customizer.php';

//----------------------------------------------
//	Init
//----------------------------------------------

// Initialization
do_action( 'ipress_init' );

// Retrieve class object
global $ipress;

// Set theme & version
$ipress->theme   = wp_get_theme( IPRESS_THEME_NAME );
$ipress->version = $ipress->theme['Version'];

// Theme setup & customizer functionality
$ipress->main       = require_once IPRESS_CLASSES_DIR . '/class-ipr-theme.php';
$ipress->customizer = require_once IPRESS_CLASSES_DIR . '/class-ipr-customizer.php';

// Tag on Child Theme data, should be defined by now
if ( is_child_theme() ) {
	$ipress->child_theme   = wp_get_theme( IPRESS_CHILD_THEME_NAME );
	$ipress->child_version = $ipress->child_theme['Version'];
}

// Multisite?
if ( is_multisite() ) {
	$ipress->multisite = require_once IPRESS_CLASSES_DIR . '/class-ipr-multisite.php';
}

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Load scripts & styles
require_once IPRESS_CLASSES_DIR . '/class-ipr-load-scripts.php';
require_once IPRESS_CLASSES_DIR . '/class-ipr-load-styles.php';

// Theme header setup
require_once IPRESS_CLASSES_DIR . '/class-ipr-init.php';

// Layout template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-layout.php';

// Mavigation functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-navigation.php';

// Images & Media template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-images.php';

// Login Redirect template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-login.php';

// Rewrites template functions
require_once IPRESS_CLASSES_DIR . '/class-ipr-rewrites.php';

// Sidebars functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-sidebars.php';

// Widgets functionality
require_once IPRESS_CLASSES_DIR . '/class-ipr-widgets.php';

// Page Support: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-ipr-page.php';

//----------------------------------------------------------
//	Initialize Custom Post Types & Taxonomies
//----------------------------------------------------------

// Custom Post-Types & Taxonomies
require_once IPRESS_CLASSES_DIR . '/class-ipr-post-type.php';
require_once IPRESS_CLASSES_DIR . '/class-ipr-taxonomy.php';

//----------------------------------------------
//	Parent Theme Configuration
//----------------------------------------------

// Configuration
do_action( 'ipress_config' );

// Theme Setup Configuration: actions, filters etc
include_once IPRESS_INCLUDES_DIR . '/config.php';
