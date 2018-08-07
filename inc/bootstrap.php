<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Set up and load theme requirements
 * 
 * @package		iPress\Bootstrap
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Theme Defines
//----------------------------------------------

// Theme Name & Versioning
define( 'IPRESS_THEME_NAME', 'iPress' );
define( 'IPRESS_THEME_WP', 4.9 );
define( 'IPRESS_THEME_PHP', 5.6 );

// Directory Structure
define( 'IPRESS_DIR', 			get_parent_theme_file_path() );
define( 'IPRESS_ASSETS_DIR',	IPRESS_DIR . '/assets' );
define( 'IPRESS_INCLUDES_DIR',	IPRESS_DIR . '/inc' );
define( 'IPRESS_TEMPLATES_DIR', IPRESS_DIR . '/templates' );

// Assets Directory Structure
define( 'IPRESS_CSS_DIR',		IPRESS_ASSETS_DIR . '/css' );
define( 'IPRESS_JS_DIR',		IPRESS_ASSETS_DIR . '/js' );
define( 'IPRESS_IMAGES_DIR',	IPRESS_ASSETS_DIR . '/images' );
define( 'IPRESS_FONTS_DIR',		IPRESS_ASSETS_DIR . '/fonts' );

// Includes Directory Structure
define( 'IPRESS_LANG_DIR',		IPRESS_INCLUDES_DIR . '/languages' );
define( 'IPRESS_LIB_DIR',		IPRESS_INCLUDES_DIR . '/lib' );
define( 'IPRESS_ADMIN_DIR',		IPRESS_INCLUDES_DIR . '/admin' );
define( 'IPRESS_CLASSES_DIR',	IPRESS_INCLUDES_DIR . '/classes' );
define( 'IPRESS_FUNCTIONS_DIR',	IPRESS_INCLUDES_DIR . '/functions' );
define( 'IPRESS_CONTROLS_DIR',	IPRESS_INCLUDES_DIR . '/controls' );
define( 'IPRESS_SHORTCODES_DIR',IPRESS_INCLUDES_DIR . '/shortcodes' );
define( 'IPRESS_WIDGETS_DIR',	IPRESS_INCLUDES_DIR . '/widgets' );

// Directory Paths
define( 'IPRESS_URL',			get_parent_theme_file_uri() );
define( 'IPRESS_ASSETS_URL',	IPRESS_URL . '/assets' );
define( 'IPRESS_INCLUDES_URL',	IPRESS_URL . '/inc' );

// Assets Directory Paths
define( 'IPRESS_CSS_URL',		IPRESS_ASSETS_URL . '/css' );
define( 'IPRESS_JS_URL',		IPRESS_ASSETS_URL . '/js' );
define( 'IPRESS_IMAGES_URL',	IPRESS_ASSETS_URL . '/images' );
define( 'IPRESS_FONTS_URL',		IPRESS_ASSETS_URL . '/fonts' );

// Includes Directory Paths
define( 'IPRESS_LANG_URL',		IPRESS_INCLUDES_URL . '/languages' );
define( 'IPRESS_LIB_URL',		IPRESS_INCLUDES_URL . '/lib' );

//----------------------------------------------
//	Theme Compatibility & Versioning
//----------------------------------------------

// Load compatability check
$ipress_version_error = require_once IPRESS_INCLUDES_DIR . '/classes/class-compat.php';
if ( true === $ipress_version_error->get_error() ) { return; }

//----------------------------------------------
//	Includes - Functions
//----------------------------------------------

// Functions
require_once IPRESS_INCLUDES_DIR . '/functions.php';

// Shortcodes functionality
require_once IPRESS_INCLUDES_DIR . '/shortcodes.php';

// Functions: theme template hooks & functions
require_once IPRESS_INCLUDES_DIR . '/template-hooks.php';
require_once IPRESS_INCLUDES_DIR . '/template-functions.php';
require_once IPRESS_INCLUDES_DIR . '/template-tags.php';

//----------------------------------------------
//	Includes - Classes
//----------------------------------------------

// Set Up theme
$theme			= wp_get_theme( IPRESS_THEME_NAME );
$ipress_version = $theme['Version'];

// Initiate Main Registry, Scripts & Styles
$ipress = (object)[

	// Set theme
	'theme'		=> $theme,
	'version'	=> $ipress_version,

	// Load scripts & styles
	'scripts'	=> require_once IPRESS_CLASSES_DIR . '/class-load-scripts.php',
	'styles'	=> require_once IPRESS_CLASSES_DIR . '/class-load-styles.php',
	
	// Custom Post-Types & Taxonomies 
	'custom'	=> require_once IPRESS_CLASSES_DIR . '/class-custom.php',

	// Theme setup
	'main'			=> require_once IPRESS_CLASSES_DIR . '/class-theme.php',
	'customizer'	=> require_once IPRESS_CLASSES_DIR . '/class-customizer.php'
];

// Theme header setup
require_once IPRESS_CLASSES_DIR . '/class-init.php';

// Admin functionlity
if ( is_admin() ) {
	$ipress->admin = require_once IPRESS_CLASSES_DIR . '/class-admin.php';
}

// Layout template functions
require_once IPRESS_CLASSES_DIR . '/class-layout.php';

// Mavigation functions
require_once IPRESS_CLASSES_DIR . '/class-navigation.php';

// Images & Media template functions
require_once IPRESS_CLASSES_DIR . '/class-images.php';

// Redirect template functions
require_once IPRESS_CLASSES_DIR . '/class-redirect.php';

// Rewrites template functions
require_once IPRESS_CLASSES_DIR . '/class-rewrites.php';

// Sidebars functionality
require_once IPRESS_CLASSES_DIR . '/class-sidebars.php';

// Widgets functionality
require_once IPRESS_CLASSES_DIR . '/class-widgets.php';

// Page Support: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-page.php';

// Content Functionality: actions & filters
require_once IPRESS_CLASSES_DIR . '/class-content.php';

//----------------------------------------------
//	Libraries & Plugins
//----------------------------------------------

// Jetpack functionality
if ( defined( 'JETPACK__VERSION' ) ) {
	$ipress->jetpack = require_once IPRESS_CLASSES_DIR . '/class-jetpack.php';
}

//----------------------------------------------
//	Theme Settings
//----------------------------------------------

// Register theme object
$GLOBALS['ipress'] = $ipress;

//end
