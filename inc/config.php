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

// Retrieve theme settings
global $ipress;

//----------------------------------------------
//	Parent Theme Scripts
//----------------------------------------------

// Set up scripts - filterable array. See definitions for structure
$ipress_scripts = [

	// Core scripts: [ 'script-name', 'script-name2' ... ]
	'core' => [ 'jquery' ],

	// Custom scripts: [ 'label' => [ 'path_url', (array)dependencies, 'version' ] ... ];
	'custom' => [
		'ipress' => [ IPRESS_JS_URL . '/theme.js', [ 'jquery' ], NULL ] 
	],

	// Localize scripts: [ 'label' => [ 'name' => name, trans => function/path_url ] ]
	'local' => [
		'ipress'	=> [ 
			'name'	=> 'ipress', 
			'trans' => [ 
				'home_url' => home_url(), 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'rest_url' => rest_url( '/' ) 
			] 
		]
	]
];

// Initialise scripts
$ipress->scripts->init( $ipress_scripts );

//----------------------------------------------
//	Theme Styles & Fonts
//----------------------------------------------

// Set up scripts - filterable array. See definitions for structure
$ipress_styles = [

	// Theme styles
	'theme'  => [ 
		'ipress' => [ IPRESS_URL . '/style.css', [], NULL ]
	]
];

// Initialise styles & fonts
$ipress->styles->init( $ipress_styles, [] );

//end
