<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template hooks functions
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Core Hooks Functions
//----------------------------------------------

//----------------------------------------------
//	General Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_skip_links' ) ) :
	
	/**
	 * Add skip links html
	*/
	function ipress_skip_links() {
		get_template_part( 'templates/global/skip-links' );
	}	 
endif;

if ( ! function_exists( 'ipress_get_sidebar' ) ) :
	
	/**
	 * Display sidebar
	 *
	 * @uses 	get_sidebar()
	 * @param	string	$sidebar default empty
	 */
	function ipress_get_sidebar( $sidebar='' ) {
		if ( empty( $sidebar ) ) {
			get_sidebar();
		} else {
			get_sidebar( $sidebar );
		}
	}
endif;

if ( ! function_exists( 'ipress_scroll_top' ) ) :
	
	/**
	 * Scroll to top link
	 */
	function ipress_scroll_top() {
		echo '<div id="scrollTop" class="scroll-top"></div>';
	}
endif;

if ( ! function_exists( 'ipress_breadcrumbs' ) ) :
	
	/**
	 * Load header breadcrumbs
	 */
	function ipress_breadcrumbs() {

		// Not if error page
		if ( is_404() ) { return; }

		// Test if breadcumbs are turned on - default off
		$do_breadcrumbs = apply_filters( 'ipress_breadcrumbs', false );
		if ( ! $do_breadcrumbs ) { return; }
		
		// Get custom template?
		$custom_template = apply_filters( 'ipress_custom_breadcrumbs' , '' );
		if ( ! empty( $custom_template ) ) {
			return get_template_part( 'templates/global/breadcrumbs/' . $custom_template );
		}

		// Load generic hierarchy crumbs
		if ( is_home() && ! is_front_page() ) {
			$template = 'home';
		} elseif ( is_single() ) {
			$template = 'single';
		} elseif ( is_author() ) {
			$template = 'author';
		} elseif ( is_page() ) {
			$template = 'page';
		} elseif ( is_author() ) {
			$template = 'author';
		} elseif ( is_category() ) {
			$template = 'category';
		} elseif ( is_tag() ) {
			$template = 'tag';
		} elseif ( is_date() ) {
			$template = 'date';
		} elseif ( is_search() ) {
			$template = 'search';
		} elseif ( is_tax() ) {
			$template = 'taxonomy';
		} elseif ( is_post_type_archive() ) {
			$template = 'archive-cpt';
		} elseif ( is_archive() ) {
			$template = 'archive';
		}

		// Load breadcrumbs template if set...
		if ( !empty( $template ) ) {
			get_template_part( 'templates/global/breadcrumbs/' . $template );
		}
	}
endif;

//----------------------------------------------
//	Header Hooks Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_site_branding' ) ) :
	
	/**
	 * Site branding wrapper and display
	 */
	function ipress_site_branding() {
		get_template_part( 'templates/header/site-branding' );
	}
endif;

if ( ! function_exists( 'ipress_primary_navigation' ) ) :
	
	/**
	 * Site navigation
	 */
	function ipress_primary_navigation() {
		get_template_part( 'templates/header/site-navigation' );
	}
endif;

//----------------------------------------------
//	Footer Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_footer_widgets' ) ) :
	
	/**
	 * Display the footer widget regions
	 */
	function ipress_footer_widgets() {
		get_template_part( 'templates/footer/footer-widgets' );
	}
endif;

if ( ! function_exists( 'ipress_credit_info' ) ) :
	
	/**
	 * Display the theme credit
	 */
	function ipress_credit_info() {
		get_template_part( 'templates/footer/site-credit' );
	}
endif;

//----------------------------------------------
//	Posts Hook Functions
//----------------------------------------------

if ( ! function_exists( 'ipress_loop_header' ) ) :
	
	/**
	 * Display the post header 
	 */
	function ipress_loop_header() {
		get_template_part( 'templates/loop/header' );
	}
endif;

if ( ! function_exists( 'ipress_loop_meta' ) ) :
	
	/**
	 * Display the post meta data
	 */
	function ipress_loop_meta() {
		get_template_part( 'templates/loop/meta' );
	}
endif;

if ( ! function_exists( 'ipress_loop_content' ) ) :
	
	/**
	 * Display the post content
	 */
	function ipress_loop_content() { 
		get_template_part( 'templates/loop/content' );
	}
endif;

if ( ! function_exists( 'ipress_loop_excerpt' ) ) :
	
	/**
	 * Display the post excerpt
	 */
	function ipress_loop_excerpt() {
		get_template_part( 'templates/loop/excerpt' );
	}
endif;

if ( ! function_exists( 'ipress_loop_footer' ) ) :
	
	/**
	 * Display the post footer
	 */
	function ipress_loop_footer() {
		get_template_part( 'templates/loop/footer' );
	}
endif;

if ( ! function_exists( 'ipress_loop_thumbnail' ) ) :
	
	/**
	 * Display the post thumbnail
	 */
	function ipress_loop_thumbnail() {
		get_template_part( 'templates/loop/thumbnail' );
	}
endif;

if ( ! function_exists( 'ipress_loop_nav' ) ) :
	
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function ipress_loop_nav() {

		$args = [
			'type'		=> 'list',
			'next_text' => _x( 'Next', 'Next post', 'ipress' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'ipress' ),
		];

		the_posts_pagination( $args );
	}
endif;

//----------------------------------------------
//	Single Post Hook Functions 
//----------------------------------------------

if ( ! function_exists( 'ipress_post_header' ) ) :
	
	/**
	 * Display the post header 
	 */
	function ipress_post_header() {
		get_template_part( 'templates/single/header' );
	}
endif;

if ( ! function_exists( 'ipress_post_meta' ) ) :
	
	/**
	 * Display the post meta data
	 */
	function ipress_post_meta() {
		get_template_part( 'templates/single/meta' );
	}
endif;

if ( ! function_exists( 'ipress_post_content' ) ) :
	
	/**
	 * Display the post content
	 */
	function ipress_post_content() {
		get_template_part( 'templates/single/content' );
	}
endif;

if ( ! function_exists( 'ipress_post_footer' ) ) :
	
	/**
	 * Display the post footer
	 */
	function ipress_post_footer() {
		get_template_part( 'templates/single/footer' );
	}
endif;

if ( ! function_exists( 'ipress_post_image' ) ) :
	
	/**
	 * Display the post image
	 */
	function ipress_post_image() {
		get_template_part( 'templates/single/image' );
	}
endif;

if ( ! function_exists( 'ipress_display_comments' ) ) :
	
	/**
	 * Display the comments form
	 */
	function ipress_display_comments() {

		// single type only
		if ( is_single() || is_page() ) { 
		
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || '0' != get_comments_number() ) :
				comments_template();
			endif;
		}
	}
endif;

if ( ! function_exists( 'ipress_post_nav' ) ) :
	
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function ipress_post_nav() {

		// Single post onle
		if ( ! is_single() ) { return; }

		$args = [
			'next_text' => '%title',
			'prev_text' => '%title',
		];
		the_post_navigation( $args );
	}
endif;

//----------------------------------------------
//	Template Hook Functions - Pages
//----------------------------------------------

if ( ! function_exists( 'ipress_page_header' ) ) :
	
	/**
	 * Display the page header 
	 */
	function ipress_page_header() {
		get_template_part( 'templates/page/header' );
	}
endif;

if ( ! function_exists( 'ipress_page_content' ) ) :
	
	/**
	 * Display the page content
	 */
	function ipress_page_content() {
		get_template_part( 'templates/page/content' );
	}
endif;

if ( ! function_exists( 'ipress_page_footer' ) ) :
	
	/**
	 * Display the page footer 
	 */
	function ipress_page_footer() {
		get_template_part( 'templates/page/footer' );
	}
endif;

if ( ! function_exists( 'ipress_page_image' ) ) :
	
	/**
	 * Display the page image 
	 */
	function ipress_page_image() {
		get_template_part( 'templates/page/image' );
	}
endif;

//----------------------------------------------
//	Homepage Hooks Functions
//----------------------------------------------

