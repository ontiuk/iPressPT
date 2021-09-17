<?php

/**
 * iPress - WordPress Theme Framework
 * ==========================================================
 *
 * Theme initialisation for core WordPress theme customizer features.
 *
 * @package iPress\Includes
 * @link    http://ipress.uk
 * @license GPL-2.0+
 */

if ( ! class_exists( 'IPR_Customizer' ) ) :

	/**
	 * Initialise and set up Customizer features
	 */
	final class IPR_Customizer {

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Core WordPress functionality
			add_action( 'after_setup_theme', [ $this, 'setup_theme' ], 12 );

			// Main customizer api registration
			add_action( 'customize_register', [ $this, 'customize_register' ] );
		}

		/**
		 * Set up core theme settings & functionality
		 */
		public function setup_theme() {

			//----------------------------------------------------------------
			// Customizer Support & Layout
			//
			// Set up core customizer driven theme support & functionality
			// - add_theme_support( 'custom-logo' )
			// - add_theme_support( 'custom-header' )
			// - register_default_headers()
			// - add_theme_support( 'custom-background' )
			// - add_theme_support( 'customize-selective-refresh-widgets' )
			//----------------------------------------------------------------

			/**
			 * Enable support for custom logo within customizer and theme
			 *
			 * @see https://developer.wordpress.org/themes/functionality/custom-logo/
			 * 
			 * custom_logo_args = [
			 *   'width'       => 250, // Expected logo height in pixels.
			 *   'height'      => 80, // Expected logo width in pixels.
			 *   'flex-width'  => true, // Allow for a flexible height, skips cropping.
			 *   'flex-height' => true, // Whether to allow for a flexible width, skips cropping.
			 *   'header-text' => [ 'site-title', 'site-description ] // Classes of elements to hide.
			 * ];
			 *
			 * No width & height sets full flexibility support
			 */

			// Filterable custom logo settings, custom logo is enabled by default in customizer
			$ip_custom_logo = (bool) apply_filters( 'ipress_custom_logo', true );

			// Enable custom logo support
			if ( true === $ip_custom_logo ) {

				// Set up the custom args if required
				$ip_custom_logo_args = (array) apply_filters(
					'ipress_custom_logo_args',
					[
						'width'       => 200,
						'height'      => 133,
						'flex-width'  => true,
						'flex-height' => true,
					]
				);

				// Add theme support, with args if set
				if ( empty( $ip_custom_logo_args ) ) {
					add_theme_support( 'custom-logo' );
				} else {
					add_theme_support( 'custom-logo', $ip_custom_logo_args );
				}
			}

			/**
			 * Enable support for custom headers within customizer and theme
			 *
			 * @see https://developer.wordpress.org/themes/functionality/custom-headers/
			 * 
			 * $header_args = [
			 *   // Default header image to display
			 *   'default-image'          => apply_filters( 'ipress_custom_header_default_image', get_stylesheet_directory_uri() . '/assets/images/header.png' ),
			 *   'header-text'            => true,              // Display the header text along with the image.
			 *   'default-text-color'     => '000',             // Header text color default.
			 *   'width'                  => 0,                 // Header image width (in pixels).
			 *   'height'                 => 0,                 // Header image height (in pixels).
			 *   'flex-height'            => false,             // Flexible image width, skips the crop stage.
			 *   'flex-width'             => false,             // Flexible image height, skips the crop stage.
			 *   'random-default'         => false,             // Header image random rotation default.
			 *   'uploads'                => true,              // Enable upload of image file in admin.
			 *   'wp-head-callback'       => 'wphead_cb',       // Function to be called in theme head section.
			 *   'admin-head-callback'    => 'adminhead_cb',    // Function to be called in preview page head section.
			 *   'admin-preview-callback' => 'adminpreview_cb', // Function to produce preview markup in the admin screen.
			 *   'video'                  => false,             // Display video in background.
			 *   'video-active-callback'  => 'is_front_page'    // Function to be called in video playback.
			 * ];
			 */

			// Filterable custom header setttings, no width & height sets full flexibility, custom header is disabled by default
			$ip_custom_header = (bool) apply_filters( 'ipress_custom_header', false );

			// Enable custom header support
			if ( true === $ip_custom_header ) {

				// Set up default header image
				$ip_custom_header_image = (string) apply_filters( 'ipress_custom_header_default_image', get_stylesheet_directory_uri() . '/assets/images/header.png' );

				// Set up custom header args if required
				$ip_custom_header_args = (array) apply_filters(
					'ipress_custom_header_args',
					[
						'default-image' => ( empty( $ip_custom_header_image ) ) ? '' : esc_url_raw( $ip_custom_header_image ),
						'header-text'   => false,
						'width'         => 1600,
						'height'        => 325,
						'flex-width'    => true,
						'flex-height'   => true,
					]
				);

				// Add theme support, with args if set
				if ( empty( $ip_custom_header_args ) ) {
					add_theme_support( 'custom-header' );
				} else {
					add_theme_support( 'custom-header', $ip_custom_header_args );
				}

				// Force custom header uploads, requires custom headers to be active
				$ip_custom_header_uploads = (bool) apply_filters( 'ipress_custom_header_uploads', false );
				if ( true === $ip_custom_header_uploads ) {
					add_theme_support( 'custom-header-uploads' );
				}
			}

			/**
			 * Register default headers
			 *
			 * @see https://codex.wordpress.org/Function_Reference/register_default_headers
			 *
			 * register_default_headers(
			 *   apply_filters(
			 *     'ipress_default_header_args',
			 *     [
			 *       'default-image-1' => [
			 *         'url'           => '%s/assets/images/header.jpg',
			 *         'thumbnail_url' => '%s/assets/images/header.jpg',
			 *         'description'   => __( 'Default Header Image', 'ipress' ),
			 *       ],
			 *       'default-image-2' => [
			 *         'url'           => '%s/assets/images/header-alt.jpg',
			 *         'thumbnail_url' => '%s/assets/images/header-alt.jpg',
			 *         'description'   => __( 'Default Header Image Alt', 'ipress' ),
			 *       ],
			 *     ]
			 *   )
			 * );
			 */

			// Filterable default header settings
			$ip_default_headers = (bool) apply_filters( 'ipress_default_headers', false );

			// Register default header
			if ( true === $ip_default_headers ) {

				// Set up default header args
				$ip_default_header_args = (array) apply_filters( 'ipress_default_header_args', [] );

				// Register default headers if set
				if ( ! empty( $ip_default_header_args ) ) {
					register_default_headers( $ip_default_header_args );
				}
			}

			/**
			 * Enable support for custom backgrounds - default false
			 * 
			 * @see https://codex.wordpress.org/Custom_Backgrounds
			 * 
			 * $background_args = [
			 *   'default-image'          => apply_filters( 'ipress_custom_background_default_image', '' ),       // Default background image
			 *   'default-color'          => apply_filters( 'ipress_custom_background_default_color', 'ffffff' ), // Default background colour applied
			 *   'default-preset'         => 'default',  // Default image preset ( 'default', 'fill', 'fit', 'repeat', 'custom' ).
			 *   'default-position-x'     => 'left',     // Default image x-position ( 'left', 'center', 'right' ).
			 *   'default-position-y'     => 'top',      // Default image y-position ( 'top', 'center', 'bottom' ).
			 *   'default-size'           => 'auto',     // Default image sizing attribute ( 'auto', 'contain', 'cover' ).
			 *   'default-repeat'         => 'repeat',   // Default image repeat attribute ( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ).
			 *   'default-attachment'     => 'scroll',   // Default image attachment attribute ( 'scroll', 'fixed' ).
			 *   'admin-head-callback'    => '',         // Function to be called in preview page head section.
			 *   'admin-preview-callback' => '',         // Function to produce preview markup in the admin screen.
			 *   'wp-head-callback'       => '_custom_background_cb', // Function to be called in theme head section.
			 * ];
			 */

			// Filterable custom background settings
			$ip_custom_background = (bool) apply_filters( 'ipress_custom_background', false );

			// Enable custom background support
			if ( true === $ip_custom_background ) {

				// Set up a custm background image
				$ip_custom_background_image = (string) apply_filters( 'ipress_custom_background_default_image', '' );

				// Set up a default background colour
				$ip_custom_background_color = (string) apply_filters( 'ipress_custom_background_default_color', '#ffffff' );

				// Set up the default background image args from above
				$ip_custom_background_args = (array) apply_filters(
					'ipress_custom_background_args',
					[
						'default-image' => ( empty( $ip_custom_background_image ) ) ? '' : esc_url_raw( $ip_custom_background_image ),
						'default-color' => ( empty( $ip_custom_background_color ) ) ? '' : sanitize_hex_color( $ip_custom_background_color ),
					]
				);

				// Add theme support, with args if available
				if ( empty( $ip_custom_background_args ) ) {
					add_theme_support( 'custom-background' );
				} else {
					add_theme_support( 'custom-background', $ip_custom_backround_args );
				}
			}

			// Add theme support for selective refresh for widgets, default true
			$ip_custom_selective_refresh = (bool) apply_filters( 'ipress_custom_selective_refresh', true );
			if ( true === $ip_custom_selective_refresh ) {
				add_theme_support( 'customize-selective-refresh-widgets' );
			}

			// Theme initialization
			do_action( 'ipress_setup_customizer' );
		}

		//----------------------------------------------
		//	Customizer Settings, Controls & Scripts
		//----------------------------------------------

		/**
		 * Set up customizer and theme panel
		 * - Child theme extends settings and controls
		 *
		 * @param object $wp_customize WP_Customise_Manager
		 */
		public function customize_register( WP_Customize_Manager $wp_customize ) {

			// Modifiy default controls
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			// Dynamic refresh for header partials, default true
			$ip_customize_header_partials = (bool) apply_filters( 'ipress_customize_header_partials', true );

			// Set titles & branding as refreshable tags if allowed
			if ( true === $ip_customize_header_partials && isset( $wp_customize->selective_refresh ) ) {

				// Blog name
				$wp_customize->selective_refresh->add_partial(
					'blogname',
					[
						'selector'        => '.site-title a',
						'render_callback' => function() {
							return get_bloginfo( 'name', 'display' );
						},
					]
				);

				// Blog description
				$wp_customize->selective_refresh->add_partial(
					'blogdescription',
					[
						'selector'        => '.site-description',
						'render_callback' => function() {
							return get_bloginfo( 'description', 'display' );
						},
					]
				);

				// Custom logo image
				$wp_customize->selective_refresh->add_partial(
					'custom_logo',
					[
						'selector'        => '.site-branding',
						'render_callback' => function() {
							return ipress_site_title_or_logo( false );
						},
					]
				);
			}

			// Filterable registrations - pass customizer manager object to child theme settings filter
			do_action( 'ipress_customize_register', $wp_customize );
		}
	}

endif;

// Instantiate Customizer class
return new IPR_Customizer;
