<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template hooks - actions and filters
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------
//	Core Actions & Filters
//----------------------------------------------

//------------------------------------------
//  General
//------------------------------------------

/**
 * @see  ipress_skip_links()
 * @see  ipress_get_sidebar()
 * @see  ipress_scroll_top()
 */
add_action( 'ipress_before_header', 'ipress_skip_links',	3 );
add_action( 'ipress_sidebar',		'ipress_get_sidebar',	10 );
add_action( 'ipress_before_footer',	'ipress_scroll_top', 	10 );
	    
/**
 * @see ipress_breadcrumbs()
 */
add_action( 'ipress_before_main_content', 'ipress_breadcrumbs', 10 );

//------------------------------------------
//  Header
//------------------------------------------

/**
 * @see  ipress_site_branding()
 * @see  ipress_primary_navigation()
 */
add_action( 'ipress_header',	'ipress_site_branding',			10 );
add_action( 'ipress_header',	'ipress_primary_navigation',	20 );

//------------------------------------------
//  Footer
//------------------------------------------

/**
 * @see  ipress_footer_widgets()
 * @see  ipress_credit()
 */
add_action( 'ipress_footer',	'ipress_footer_widgets',	10 );
add_action( 'ipress_footer',	'ipress_credit_info',		20 );

//------------------------------------------
//  Posts
//------------------------------------------

/**
 * @see  ipress_loop_header()
 * @see  ipress_loop_meta()
 * @see  ipress_loop_content()
 * @see  ipress_loop_footer()
 * @see	 ipress_init_structured_data()
 * @see  ipress_loop_nav()
 * @see  ipress_loop_thumbnail()
 */
add_action( 'ipress_loop',					'ipress_loop_header',			10 );
add_action( 'ipress_loop',					'ipress_loop_meta',				20 );
add_action( 'ipress_loop',					'ipress_loop_content',			30 );
add_action( 'ipress_loop',					'ipress_loop_footer',			40 );
add_action( 'ipress_loop_footer',			'ipress_init_structured_data',	10 );
add_action( 'ipress_loop_content_before',	'ipress_loop_thumbnail',		10 );
add_action( 'ipress_loop_after',			'ipress_loop_nav',				10 );

/**
 * @see  ipress_loop_header()
 * @see  ipress_loop_meta()
 * @see  ipress_loop_excerpt()
 * @see  ipress_loop_footer()
 */        
add_action( 'ipress_loop_excerpt', 			'ipress_loop_header',          	10 );
add_action( 'ipress_loop_excerpt',			'ipress_loop_meta',				20 );
add_action( 'ipress_loop_excerpt', 			'ipress_loop_excerpt', 			23 );
add_action( 'ipress_loop_excerpt',			'ipress_loop_footer',			40 );

//------------------------------------------
//  Single
//------------------------------------------

/**
 * @see  ipress_post_header()
 * @see  ipress_post_meta()
 * @see  ipress_post_content()
 * @see  ipress_post_footer()
 * @see  ipress_init_structured_data()
 * @see  ipress_post_nav()
 * @see  ipress_display_comments()
 * @see  ipress_post_thumbnail
 */
add_action( 'ipress_single',				'ipress_post_header',			10 );
add_action( 'ipress_single',		  		'ipress_post_meta',				20 );
add_action( 'ipress_single',		  		'ipress_post_content',			30 );
add_action( 'ipress_single',		  		'ipress_post_footer',			40 );
add_action( 'ipress_post_footer',			'ipress_init_structured_data',	10 );

add_action( 'ipress_article_after',  		'ipress_post_nav',			10 );
add_action( 'ipress_post_content_before',	'ipress_post_thumbnail',	10 );

//------------------------------------------
//  Page
//------------------------------------------

/**
 * @see  ipress_page_header()
 * @see  ipress_page_content()
 * @see  ipress_page_footer()
 * @see  ipress_init_structured_data()
 * @see  ipress_display_comments()
 * @see  ipress_post_thumbnail
 */
add_action( 'ipress_page',					'ipress_page_header',			10 );
add_action( 'ipress_page',					'ipress_page_content',			20 );
add_action( 'ipress_page',					'ipress_page_footer',			30 );
add_action( 'ipress_page_footer',			'ipress_init_structured_data',	10 );

add_action( 'ipress_article_after',			'ipress_display_comments',		10 );
add_action( 'ipress_page_content_before',	'ipress_post_thumbnail',		10 );

//------------------------------------------
//  Search
//------------------------------------------

/**
 * @see  ipress_loop_header()
 * @see  ipress_loop_meta()
 * @see  ipress_loop_excerpt()
 * @see  ipress_loop_footer()
 * @see  ipress_init_structured_data()
 */        
add_action( 'ipress_search',		'ipress_loop_header',			10 );
add_action( 'ipress_search',		'ipress_loop_meta',				20 );
add_action( 'ipress_search',		'ipress_loop_excerpt',			30 );
add_action( 'ipress_search',		'ipress_loop_footer',			40 );
add_action( 'ipress_footer',		'ipress_init_structured_data',	10 );

//------------------------------------------
//  Homepage
//------------------------------------------

//End
