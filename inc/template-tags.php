<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme template tag functions
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//----------------------------------------------  
// Template Tag Functions: General
//
//	- ipress_is_home_page()
//	- ipress_is_index()
//----------------------------------------------  

if ( ! function_exists( 'ipress_is_home_page' ) ) :
	
	/**
	 * Check if the root page of the site is being viewed
	 *
	 * is_front_page() returns false for the root page of a website when
	 * - the WordPress 'Front page displays' setting is set to 'Static page'
	 * - 'Front page' is left undefined
	 * - 'Posts page' is assigned to an existing page
	 *
	 * @return boolean
	 */
	function ipress_is_home_page() {
		return ( is_front_page() || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) ) ? true : false;
	}
endif;

if ( ! function_exists( 'ipress_is_index' ) ) :
	
	/**
	 * Check if the page being viewed is the index page
	 *
	 * @param	string	$page
	 * @return	boolean
	 */
	function ipress_is_index( $page ) {
		return ( basename( $page ) === 'index.php' );
	}
endif;

//----------------------------------------------  
// Template Tag Functions: Header
//
// ipress_header_style()
// ipress_site_title_or_logo()
//----------------------------------------------  

if ( ! function_exists( 'ipress_header_style' ) ) :
	
	/**
	 * Apply background image to header
	 *
	 * @uses  get_header_image()
	 */
	function ipress_header_style() {

		// Header image?
		$is_header_image = get_header_image();
		if ( ! $is_header_image ) { return; }

		// Filterable output
		$styles = apply_filters( 'ipress_header_style', [
			'background-image' => 'url(' . esc_url( $is_header_image ) . ')'
		] );
		if ( !is_array( $styles ) || empty( $styles ) ) { return; }

		// Set header style
		ob_start();
		foreach ( $styles as $style => $value ) {
			echo esc_attr( $style . ': ' . $value . '; ' );
		}
		$attr = ob_get_clean();
		echo 'style="' . $attr . '"';
	}
endif;

if ( ! function_exists( 'ipress_site_title_or_logo' ) ) :
	
	/**
	 * Get site title or logo
	 */
	function ipress_site_title_or_logo( $echo = true ) {
		if ( has_custom_logo() ) {
			$html = get_custom_logo();
		} else if ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			$logo	 = site_logo()->logo;
			$logo_id = get_theme_mod( 'custom_logo' ); 
			$logo_id = $logo_id ? $logo_id : $logo['id']; 
			$size	 = site_logo()->theme_size();
			$html	 = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					false,
					[
						'class'		=> 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'	=> 'logo'
					 ]
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {
			$tag = ( ipress_is_home_page() ) ? 'h1' : 'p';
			$html = sprintf( '<%s class="site-title" itemprop="headline"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url('/') ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) {
				$html .= sprintf( '<p class="site-description" itemprop="description">%s</p>', esc_html( $description ) );
			} 
		}

		if ( ! $echo ) { return $html; }
		echo $html;
	}
endif;

//----------------------------------------------  
// Template Tag Functions: Content
// 
// ipress_posted_on()
// ipress_posted_by()
// ipress_posted_time()
// ipress_entry_footer()
// ipress_get_attachment_meta()
//----------------------------------------------  

if ( ! function_exists( 'ipress_posted_on' ) ) :
	
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @param	boolean $byline	default true
	 */
	function ipress_posted_on( $byline=false ) {
		
		// Get the author name; wrap it in a link.
		$byline_text = sprintf(
			/* translators: %s: post author */
			__( 'by <span class="author vcard"><a class="url fn n" href="%s">%s</a></span>', 'ipress' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);

		echo ( $byline ) ? sprintf( '<span class="posted-on">%s</span><span class="byline">%s</span>', ipress_posted_time(), $byline_text ) :
						   sprintf( '<span class="posted-on">%s</span>', ipress_posted_time() );
	}
endif;

if ( ! function_exists( 'ipress_posted_by' ) ) :
	
	/** 
	 * Prints HTML with meta information for the current author. 
	 */ 
	function ipress_posted_by() { 
		$byline = sprintf( 
			/* translators: %s: post author. */ 
			esc_html_x( 'by <span class="author vcard"><a class="url fn n" href="%s">%s</a></span>', 'post author', 'ipress' ), 
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() ) 
		); 
	 
		echo sprintf( '<span class="byline">%s</span>', $byline ); // WPCS: XSS OK
	}
endif;

if ( ! function_exists( 'ipress_posted_time' ) ) :
	
	/**
	 * Returns a formatted posted time stamp
	 *
	 * @param	boolean $byline	default false
	 */
	function ipress_posted_time() {
		
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on <a href="%s" rel="bookmark">%s</a>', 'post date', 'ipress' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'ipress_entry_footer' ) ) :
	
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ipress_entry_footer() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'ipress' ) );
			if ( $categories_list ) {
				echo sprintf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ipress' ) . '</span>', $categories_list ); 
			}

			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'ipress' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ipress' ) . '</span>', $tags_list ); 
			}
		}

		// Comment count.
		if ( ! is_singular() ) {
			ipress_post_comments_link();
		}

		// Construct edit link
		ipress_edit_post_link();
	}
endif;

if ( ! function_exists( 'ipress_get_attachment_meta' ) ) :
	
	/**
	 * Get the image meta data
	 *
	 * @param	integer		$attachment_id
	 * @param	string		$size
	 * @return	array
	 */
	function ipress_get_attachment_meta( $attachment_id, $size = '' ) {

		// Set up data
		$data = [
			'alt'			=> '',
			'caption'		=> '',
			'description'	=> '',
			'href'			=> '',
			'src'			=> '',
			'title'			=> ''
		];

		// Get attachment data
		$attachment = get_post( $attachment_id );

		// Not valid
		if ( empty( $attachment ) ) { return $data; }
		
		// Get image data
		$att_data_thumb = ( empty( $size ) ) ? wp_get_attachment_image_src( $attachment_id ) :
											   wp_get_attachment_image_src( $attachment_id, $size );
		if ( ! $att_data_thumb ) { return $data; }
		
		// Construct data
		$data['alt']			= get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
		$data['caption']		= $attachment->post_excerpt;
		$data['description']	= $attachment->post_content;
		$data['href']			= $attachment->guid;
		$data['src']			= $att_data_thumb[0];
		$data['title']			= $attachment->post_title;

		// Return image data	
		return $data;
	}
endif;

//----------------------------------------------  
// Template Tag Functions: Miscellaneous
//
// ipress_edit_post_link 
// ipress_post_thumbnail
// ipress_loop_image
// ipress_post_author
// ipress_post_categories
// ipress_post_tags
// ipress_post_comments_link
//----------------------------------------------  

if ( ! function_exists( 'ipress_edit_post_link' ) ) :
	
	/**
	 * Outputs an accessibility-friendly link to edit a post or page
	 */
	function ipress_edit_post_link() {
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit <span class="screen-reader-text">"%s"</span>', 'ipress' ),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'ipress_post_thumbnail' ) ) :

	/** 
	 * Displays an optional post thumbnail
	 * 
	 * Wraps the post thumbnail in an anchor element on index views, or a div 
	 * element when on single views. 
	 */ 
	function ipress_post_thumbnail( $size = 'full' ) { 

		// Restrictions    
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) { return; } 

		// By Type
		if ( is_singular() ) {
		   echo sprintf( '<div class="post-thumbnail">%s</div><!-- .post-thumbnail -->', get_the_post_thumbnail( $size ) ); 
		} else { 
			echo sprintf( '<a class="post-thumbnail" href="%s" aria-hidden="true">%s</a>',
				get_the_permalink(),
				get_the_post_thumbnail( 'post-thumbnail', [ 
					'alt' => the_title_attribute( [ 'echo' => false ] ), 
				] ) ); 
		} 
	} 
endif;

if ( ! function_exists( 'ipress_loop_image' ) ) :
	
	/**
	 * Post image display
	 *
	 * @param 	string $size default 'full'
	 */
	function ipress_loop_image( $size = 'full' ) {
		if ( ! has_post_thumbnail() ) { return; }

		$image_id = get_post_thumbnail_id( get_the_ID() );
		$image = wp_get_attachment_image_src( $image_id, $size ); 
		if ( $image ) {
			echo sprintf( '<div class="entry-image"><a href="%s" title="%s"><img src="%s" /></a></div>',
					esc_url( get_permalink() ),
					the_title_attribute( [ 'echo' => false ] ),
					$image[0] );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_author' ) ) :
	
	/**
	 * Post Author display
	 */
	function ipress_post_author() {
		echo sprintf( '<div class="author">%s<div class="label">%s</div>%s</div>',
			get_avatar( get_the_author_meta( 'ID' ), 128 ),
			esc_attr( __( 'Written by', 'ipress' ) ),
			get_the_author_posts_link() );
	}
endif;

if ( ! function_exists( 'ipress_post_categories' ) ) :
	
	/**
	 * Post Categories list
	 */
	function ipress_post_categories() {
		$categories_list = get_the_category_list( __( ', ', 'ipress' ) );
		if ( $categories_list ) {
			echo sprintf('<div class="cat-links"><div class="label">%s</div>%s</div>',
				esc_attr( __( 'Posted in', 'ipress' ) ),
				wp_kses_post( $categories_list ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_tags' ) ) :
	
	/**
	 * Post Tags list
	 */
	function ipress_post_tags() {

		$tags_list = get_the_tag_list( '', __( ', ', 'ipress' ) );
		if ( $tags_list ) {
			echo sprintf( '<div class="tags-links"><div class="label">%s</div>%s</div>',
				esc_attr( __( 'Tagged', 'ipress' ) ),
				wp_kses_post( $tags_list ) );
		}
	}
endif;

if ( ! function_exists( 'ipress_post_comments_link' ) ) :
	
	/**
	 * Prints comments template if available
	 */
	function ipress_post_comments_link() {
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
			echo sprintf( '<div class="comments-link"><div class="label">%s</div><span class="comments-link">%s</span></div>',
				esc_attr( __( 'Comments', 'ipress' ) ),
				comments_popup_link( __( 'Leave a comment', 'ipress' ), __( '1 Comment', 'ipress' ), __( '% Comments', 'ipress' ) )
			);
		}
	}
endif;

// End
