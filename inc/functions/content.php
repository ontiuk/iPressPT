<?php 

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Content and URL functions & functionality
 * 
 * @package		iPress\Functions
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

//---------------------------------------------
//	Content & URL
//	
//	- ipress_canonical_url
//	- ipress_paged_post_url
//	- ipress_get_permalink_by_page
//	- ipress_excerpt
//	- ipress_content
//	- ipress_truncate
//	- ipress_init_structured_data
//---------------------------------------------

if ( ! function_exists( 'ipress_canonical_url' ) ) :

	/**
	 * Calculate and return the canonical URL
	 * 
	 * @global	$wp_query	WP_Query
	 * @return	string		The canonical URL, if one exists
	 */
	function ipress_canonical_url() {

		global $wp_query;
		$canonical = '';

		// Pagination values
		$paged = absint( get_query_var( 'paged' ) );	
		$page  = absint( get_query_var( 'page' ) );

		// Front page / home page
		if ( is_front_page() ) {
			$canonical = ( $paged ) ? get_pagenum_link( $paged ) : trailingslashit( home_url() );
		}

		// Single post
		if ( is_singular() ) {
			$numpages = substr_count( $wp_query->post->post_content, '<!--nextpage-->' ) + 1;
			if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
			$canonical = ( $numpages > 1 && $page > 1 ) ? ipress_paged_post_url( $page, $id ) : get_permalink( $id );
		}

		// Archive
		if ( is_category() || is_tag() || is_tax() ) {
			if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
			$taxonomy = $wp_query->queried_object->taxonomy;
			$canonical = ( $paged ) ? get_pagenum_link( $paged ) : get_term_link( (int)$id, $taxonomy );
		}

		// Author
		if ( is_author() ) {
			if ( ! $id = $wp_query->get_queried_object_id() ) { return; }
			$canonical = ( $paged ) ? get_pagenum_link( $paged ) : get_author_posts_url( $id );
		}

		// Search
		if ( is_search() ) {
			$canonical = get_search_link();
		}

		// Return generated code
		return $canonical;
	}
endif;

if ( ! function_exists( 'ipress_paged_post_url' ) ) :

	/**
	 * Return the special URL of a paged post 
	 * - adapted from _wp_link_page() in WP core
	 *
	 * @param   int     $i The page number to generate the URL from
	 * @param   int     $post_id The post ID
	 * @return  string  Unescaped URL
	 */
	function ipress_paged_post_url( $i, $post_id = 0 ) {

		global $wp_rewrite;

		// Get post by ID
		$post = get_post( $post_id );

		// Paged?
		if ( 1 == $i ) {
			$url = get_permalink( $post_id );
		} else {
			if ( '' == get_option( 'permalink_structure' ) || in_array( $post->post_status, [ 'draft', 'pending' ] ) ) {
				$url = add_query_arg( 'page', $i, get_permalink( $post_id ) );
			} elseif ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) == $post->ID ) {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $wp_rewrite->pagination_base . '/' . $i, 'single_paged' );
			} else {
				$url = trailingslashit( get_permalink( $post_id ) ) . user_trailingslashit( $i, 'single_paged' );
			}
		}

		// Return link
		return $url;
	}
endif;

if ( ! function_exists( 'ipress_get_permalink_by_page' ) ) :

	/**
	 * Get url by page template 
	 *
	 * @param   string $template
	 * @return  string
	 */
	function ipress_get_permalink_by_page( $template ) {

		// Get pages
		$page = get_pages( [
			'meta_key'      => '_wp_page_template',
			'meta_value'    => $template . '.php'
		] );

		// Get the url
		return ( empty( $page ) ) ? '' : get_permalink( $page[0]->ID );
	}
endif;

if ( ! function_exists( 'ipress_excerpt' ) ) :

	/**
	 * Create the Custom Excerpt 
	 *
	 * @param	string $length_callback
	 * @param	string $more_callback
	 * @param	boolean $wrap
	 */
	function ipress_excerpt( $length_callback = '', $more_callback = '', $wrap=true ) { 
		
		global $post; 

		// Excerpt length	 
		if ( !empty( $length_callback ) && function_exists( $length_callback ) ) { 
			add_filter( 'excerpt_length', $length_callback ); 
		} 

		// Excerpt more
		if ( !empty( $more_callback ) && function_exists( $more_callback ) ) { 
			add_filter( 'excerpt_more', $more_callback ); 
		} 

		// Get the excerpt
		$output = get_the_excerpt(); 
		$output = apply_filters( 'wptexturize', $output ); 
		$output = apply_filters( 'convert_chars', $output ); 

		// Output the excerpt
		echo ( $wrap ) ? sprintf( '<p>%s</p>', $output ) : $output; 
	} 
endif;

if ( ! function_exists( 'ipress_content' ) ) :

	/**
	 * Trim the content by word count
	 * 
	 * @param  integer
	 * @param  string
	 * @param  string
	 */
	function ipress_content( $length=54, $before='', $after='' ) {

		// Get the content
		$content = get_the_content();

		// Trim to word count and output
		echo sprintf( '%s', $before . wp_trim_words( $content, $length, '...' ) . $after );
	}
endif;

if ( ! function_exists( 'ipress_truncate' ) ) :

	/**
	 * Return a phrase shortened in length to a maximum number of characters
	 * - Truncated at the last white space in the original string
	 *
	 * @param	string $text 
	 * @param	integer $max_chara
	 * @return	string 
	 */
	function ipress_truncate( $text, $max_char ) {

		// Sanitize
		$text = trim( $text );

		// Test text length
		if ( strlen( $text ) > $max_char ) {

			// Truncate $text to $max_characters + 1
			$text = substr( $text, 0, $max_char + 1 );

			// Truncate to the last space in the truncated string
			$text = trim( substr( $text, 0, strrpos( $text, ' ' ) ) );
		}

		// Return truncated text
		return $text;
	}
endif;

if ( ! function_exists( 'ipress_init_structured_data' ) ) :

	/**
	 * Post structured data
	 */
	function ipress_init_structured_data() {

		global $ipress;

		// Init data
		$json = [];

		// Post & page structured data
		if ( is_home() || is_category() || is_date() || is_search() || is_single() ) {

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

			$json['@type']			  = 'BlogPosting';

			$json['mainEntityOfPage'] = [
				'@type'					=> 'webpage',
				'@id'					=> get_the_permalink(),
			];

			$json['publisher']		  = [
				'@type'					=> 'organization',
				'name'					=> get_bloginfo( 'name' ),
				'logo'					=> [
					'@type'				  => 'ImageObject',
					'url'				  => $logo[0],
					'width'				  => $logo[1],
					'height'			  => $logo[2],
				]
			];

			$json['author']			  = [
				'@type'					=> 'person',
				'name'					=> get_the_author()
			];

			if ( $image ) {
				$json['image']			  = [
					'@type'					=> 'ImageObject',
					'url'					=> $image[0],
					'width'					=> $image[1],
					'height'				=> $image[2],
				];
			}

			$json['datePublished']	  = get_post_time( 'c' );
			$json['dateModified']	  = get_the_modified_date( 'c' );
			$json['name']			  = get_the_title();
			$json['headline']		  = $json['name'];
			$json['description']	  = get_the_excerpt();

		} elseif ( is_page() ) {
			$json['@type']			  = 'WebPage';
			$json['url']			  = get_the_permalink();
			$json['name']			  = get_the_title();
			$json['description']	  = get_the_excerpt();
		}

		// Set if ok
		if ( ! empty( $json ) ) {
			$ipress->main->set_structured_data( apply_filters( 'ipress_structured_data', $json ) );
		}
	}
endif;

//end
