<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Load_Scripts' ) ) :

	/**
	 * Set up theme scripts
	 */ 
	final class IPR_Load_Scripts {

		/**
		 * Admin scripts 
		 *
		 * @var array $admin
		 */
		private $admin = [];

		/**
		 * Scripts for deregistration
		 *
		 * @var array $undo
		 */
		private $undo = [];

		/**
		 * Core scripts
		 *
		 * @var array $core
		 */
		private $core = [];

		/**
		 * External scripts
		 *
		 * @var array $external
		 */
		private $external = [];

		/**
		 * Header scripts
		 *
		 * @var array $header
		 */
		private $header = [];

		/**
		 * Footer scripts
		 *
		 * @var array $footer
		 */
		private $footer = [];

		/**
		 * Plugin scripts
		 *
		 * @var array $plugins
		 */
		private $plugins = [];

		/**
		 * Page scripts
		 *
		 * @var array $page
		 */
		private $page = [];

		/**
		 * Conditional scripts
		 *
		 * @var array $conditional
		 */
		private $conditional = [];

		/**
		 * Front page scripts
		 *
		 * @var array $front
		 */
		private $front = [];

		/**
		 * Custom scripts
		 *
		 * @var array $custom
		 */
		private $custom = [];

		/**
		 * Login scripts
		 *
		 * @var array $login
		 */
		private $login = [];

		/**
		 * Localize scripts
		 *
		 * @var array $local
		 */
		private $local = [];

		/**
		 * Class constructor
		 * - set up hooks
		 */
		public function __construct() {

			// Load adminscripts
			add_action( 'admin_enqueue_scripts', 	[ $this, 'load_admin_scripts' ] ); 

			// Login page scripts
			add_action( 'login_enqueue_scripts', 	[ $this, 'load_login_scripts' ], 1 );			

			// Front end only
			if ( is_admin() ) { return; }

			// Load parent scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'load_parent_scripts' ], 10 ); 

			// Load scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'load_child_scripts' ], 25 ); 

			// Dequeueue scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'undo_scripts' ], 99 ); 

			// Conditional header scripts
			add_action( 'wp_enqueue_scripts', 		[ $this, 'conditional_scripts' ] ); 

			// Inline header scripts 
			add_action( 'wp_head', 					[ $this, 'header_scripts' ], 99 );

			// Footer Scripts
			add_action( 'wp_footer', 				[ $this, 'footer_scripts' ], 99 );

			// Analytics
			add_action( 'wp_head', 					[ $this, 'analytics_script' ], 100 );
		}

		/**
		 * Initialise main scripts
		 *
		 * @param array $scripts
		 */
		public function init( $scripts ) {

			// Admin scripts: [ 'label' => [ 'hook', 'src', (array)deps, 'ver' ] ... ]
			$this->admin = $this->set_key( $scripts, 'admin' );

			// Core scripts for deregistration: [ 'script-name', [ 'script-name2', 'template' ] ... ]
			$this->undo = $this->set_key( $scripts, 'undo' );

			// Core scripts: [ 'script-name', 'script-name2' ... ]
			$this->core = $this->set_key( $scripts, 'core' );

			// External scripts: [ 'script-name', 'script-name2' ... ]
			$this->external = $this->set_key( $scripts, 'external' );

			// Header scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->header = $this->set_key( $scripts, 'header' );

			// Footer scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->footer = $this->set_key( $scripts, 'footer' );

			// Plugin scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->plugins = $this->set_key( $scripts, 'plugins' );

			// Page scripts: [ 'label' => [ 'template', 'src', (array)deps, 'ver' ] ... ];
			$this->page = $this->set_key( $scripts, 'page' );

			// Conditional scripts: [ 'label' => [ [ 'callback', [ args ] ], 'src', (array)deps, 'ver' ] ... ];
			$this->conditional = $this->set_key( $scripts, 'conditional' );

			// Front Page scripts: [ 'label' => [ 'template', 'src', (array)deps, 'ver' ] ... ];
			$this->front = $this->set_key( $scripts, 'front' );

			// Custom scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ];
			$this->custom = $this->set_key( $scripts, 'custom' );

			// Login scripts: [ 'label' => [ 'src', (array)deps, 'ver' ] ... ]
			$this->login = $this->set_key( $scripts, 'login' );

			// Localize scripts: [ 'label' => [ 'name' => name, trans => function/src ] ]
			$this->local = $this->set_key( $scripts, 'local' );
		}

		/**
		 * Validate and set key
		 *
		 * @param 	array 	$scripts
		 * @param 	string 	$key
		 * @return 	array
		 */
		private function set_key( $scripts, $key ) {
			return ( isset ( $scripts[$key] ) && is_array( $scripts[$key] ) && ! empty( $scripts[$key] ) ) ? $scripts[$key] : [];
		}

		//----------------------------------------------
		//	Admin Scripts
		//----------------------------------------------

		/**
		 * Load admin scripts
		 *
		 * @param	string	$hook	Current admin page
		 */
		public function load_admin_scripts( $hook ) {

			// Initial validation
			if ( empty( $this->admin ) ) { return; }

			// Register & enqueue admin scripts
			foreach ( $this->admin as $k=>$v ) { 
				
				// Test hook dependency
				if ( !empty( $v[0] ) && $hook != $v[0] ) { continue; }

				// Register and enqueue scripts in footer
				wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
				wp_enqueue_script( $k );
			}
		}

		//----------------------------------------------
		//	Scripts, Styles & Fonts
		//----------------------------------------------

		/**
		 * Load core, header & footer parent scripts 
		 */
		public function load_parent_scripts() { 

			// Register & enqueue jquery core script as default
			wp_enqueue_script( 'jquery' );

			// Add base footer scripts
			wp_register_script( 'ipress', IPRESS_JS_URL . '/theme.js', [ 'jquery' ], null, true ); 

			// Set up core localization
			$trans = [ 
				'home_url' => home_url(), 
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'rest_url' => rest_url( '/' ) 
			];
			wp_localize_script( 'ipress', 'theme', $trans ); 

			// Enqueue main script
			wp_enqueue_script( 'ipress' );
		}

		/**
		 * Load core, header & footer scripts 
		 */
		public function load_child_scripts() { 
	 
			// Register & enqueue core scripts
			foreach ( $this->core as $k=>$v ) { wp_enqueue_script( $v ); }

			// Register & enqueue header scripts
			foreach ( $this->external as $k=>$v ) { 
				$locale = ( isset( $v[3] ) && $v[3] === true ) ? true : false;
				wp_register_script( $k, $v[0], $v[1], $v[2], $locale ); 
				wp_enqueue_script( $k );
			}

			// Register & enqueue header scripts
			foreach ( $this->header as $k=>$v ) { 
				wp_register_script( $k, $v[0], $v[1], $v[2], false ); 
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}
				wp_enqueue_script( $k );
			}

			// Register & enqueue footer scripts
			foreach ( $this->footer as $k=>$v ) { 
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}
				wp_enqueue_script( $k );
			}

			// Register & enqueue plugin scripts
			foreach ( $this->plugins as $k=>$v ) { 
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}
				wp_enqueue_script( $k );
			}

			// Page templates in footer head
			foreach ( $this->page as $k=>$v ) {
				if ( is_page_template( $v[0] ) ) {
					wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
					if ( array_key_exists( $k, $this->local ) ) {	
						$this->localize( $k );
					} 
					wp_enqueue_script( $k );
				}
			}

			// Conditional templating in footer
			foreach ( $this->conditional as $k=>$v ) {
				$callback = $v[0];
				if ( is_array( $callback ) ) {
					$r = ( isset( $callback[1] ) ) ? call_user_func_array ( $callback[0] , (array)$callback[1] ) : call_user_func ( $callback[0] );
				} else {
					$r = call_user_func ( $callback );
				}
				if ( $r ) {
					wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
					wp_enqueue_script( $k );
				}
			}

			// Front page scripts
			foreach ( $this->front as $k=>$v ) {
				switch( $v[0] ) {
					case 'front' :
						if ( is_front_page() ) { 
							wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
							if ( array_key_exists( $k, $this->local ) ) {
								$this->localize( $k );
							}
							wp_enqueue_script( $k );
						}
						break;
					case 'home' :
						if ( is_home() ) { 
							wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
							if ( array_key_exists( $k, $this->local ) ) {
								$this->localize( $k );
							}
							wp_enqueue_script( $k );
						}
						break;
					case 'front-home' :
					case 'home-front' :
						if ( is_home() && is_front_page() ) { 
							wp_register_script( $k, $v[1], $v[2], $v[3], true ); 
							if ( array_key_exists( $k, $this->local ) ) {
								$this->localize( $k );
							}
							wp_enqueue_script( $k );
						}
						break;
					default: //NOWORK
				}
			}

			// Add base footer scripts
			foreach ( $this->custom as $k=>$v ) { 
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
				if ( array_key_exists( $k, $this->local ) ) {
					$this->localize( $k );
				}
				wp_enqueue_script( $k );
			}

			// Comments
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Localize script
		 *
		 * @param string $key
		 * @return void
		 */
		private function localize( $key ) {

			// Get local key
			$h = $this->local[$key]; 

			// Validate & Localize
			if ( isset( $h['name'] ) && isset( $h['trans'] ) )  { 
				wp_localize_script( $key, $h['name'], $h['trans'] ); 
			}
		}

		/**
		 * Dequeue scripts 
		 */
		public function undo_scripts() { 
	 
			// Dequeue core scripts 
			foreach ( $this->undo as $s ) { 

				// Page template or global
				if ( is_array( $s ) ) {
					if ( is_page_template( $s[1] ) ) {
						wp_dequeue_script( $s[0] );
						wp_deregister_script( $s[0] ); 
					}
				} else {
					wp_dequeue_script( $s );
					wp_deregister_script( $s ); 
				}
			}
		}

		//----------------------------------------------
		// IE Conditional Scripts 
		//----------------------------------------------

		/**
		 * Load IE conditional header scripts
		 *
		 * @global	$wp_version
		 * @global	$wp_scripts
		 */
		public function conditional_scripts() {

			global $wp_scripts;
			
			// Add IE support
			$support_old_ie = apply_filters( 'ipress_support_old_ie', false );
			if ( ! $support_old_ie ) { return; }

			// Enqueue scripts
			wp_enqueue_script( 'html5-shiv', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', [], NULL );
			wp_enqueue_script( 'respond-min', 'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js', [], NULL );

			// Add to global scripts list
			$wp_scripts->add_data( 'html5-shiv', 'conditional', 'lt IE 9' );
			$wp_scripts->add_data( 'respond-min', 'conditional', 'lt IE 9' );
		}

		//----------------------------------------------
		//	Header & Footer Scripts
		//----------------------------------------------

		/**
		 * Load inline header scripts
		 * - Must have <script></script> wrapper
		 */
		public function header_scripts() {

			// Set?
			$scripts = apply_filters( 'ipress_header_scripts', get_theme_mod( 'ipress_header_scripts', '' ) );
			if ( empty( $scripts ) ) { return; }
			
			// Capture output
			echo $scripts;
		}

		/**
		 * Freeform footer scripts
		 * - Must have <script></script> wrapper
		 */
		public function footer_scripts() {

			// Set?
			$scripts = apply_filters( 'ipress_footer_scripts', get_theme_mod( 'ipress_footer_scripts', '' ) );
			if ( empty( $scripts ) ) { return; }

			// Capture output
			echo $scripts;
		}

		//----------------------------------------------
		//	Analytics Scripts
		//----------------------------------------------

		/**
		 * Load analytics scripts
		 * - Must be valid analytics identifier: UA-XXXX
		 * - See https://google.com/analytics
		 */
		public function analytics_script() {
		
			// Default Analytics code block
			$ga = get_template_part( 'templates/global/analytics' );

			// Theme mod set? Filterable identifier
			$analytics = apply_filters( 'ipress_analytics', get_theme_mod( 'ipress_analytics', $ga ) );

			// Test valid identifier
			if ( empty( $analytics ) || !preg_match( '/^UA-/', $analytics ) ) { return; }

			// OK, output analytics code
			echo sprintf( $ga, $analytics );
		}

		//----------------------------------------------
		//	Login Page Scripts
		//----------------------------------------------

		/**
		 * Load login scripts
		 */
		public function load_login_scripts() {

			// Initial validation
			if ( empty( $this->login ) ) { return; }

			// Register & enqueue admin scripts
			foreach ( $this->login as $k=>$v ) { 
				
				// Register and enqueue script
				wp_register_script( $k, $v[0], $v[1], $v[2], true ); 
				wp_enqueue_script( $k );
			}
		}
	}

endif;

// Instantiate Script Loader class
return new IPR_Load_Scripts;

//end
