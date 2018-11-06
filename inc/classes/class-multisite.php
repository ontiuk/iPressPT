<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme initialisation for core WordPress MultiSite features
 * 
 * @package		iPress\Includes
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Multisite' ) ) :

	/**
	 * Set up query rewrite features
	 */ 
	final class IPR_Multisite {

		/**
		 * Current Blog ID
		 *
		 * @var integer
		 */
		private $current_blog_id;

		/**
		 * Current User
		 *
		 * @var array
		 */
		private $current_user = [];

		/**
		 * Collection of blog objects
		 *
		 * @var array
		 */
		private $blogs = [];

		/**
		 * Collection of sites objects
		 *
		 * @var array
		 */
		private $sites = [];

		/**
		 * Class Constructor
		 */
		public function __construct() {

			// Not a multisite?
			if ( ! is_multisite() ) { return; }

			// Set up current blog id
			$this->current_blog_id = get_current_blog_id();

			// Set up current user - should be network admin
			$this->current_user = $this->get_users( 'ID', apply_filters( 'ipress_multisite_network_id', 1 ) );

			// Get list of blogs
			$this->blogs = (array) apply_filters( 'ipress_multisite_blogs', $this->get_blogs_by_user() );

			// Get list of sites
			$this->sites = (array) apply_filters( 'ipress_multisite_sites', $this->get_sites() );
		}

		//------------------------------------------
		// Core Functions
		//------------------------------------------

		/**
		 * Get blogs by user ID
		 *
		 * @param integer $id
		 */
		public function get_blogs_by_user( $id = 0 ) {

			// Preset
			$user_id = ( $id <= 0 ) ? current( $this->current_user ) : $id; 

			// Get blogs
			$blogs = get_blogs_of_user( $user_id );

			// Update blog list with sanitized ID and language
			if ( is_array( $blogs ) ) {	
				foreach ( $blogs as $k => $blog ) {

					// Set ID & description
					$blogs[$k]->blog_id 	= $blog->userblog_id;
					$blogs[$k]->description = apply_filters( 'ipress_multisite_description', $blog->userblog_id, '' );

					// Set language
					$blog_language			= (string) get_blog_option( $blog->userblog_id, 'WPLANG' );
					$blogs[$k]->language	= ( empty( $blog_language ) ) ? 'us' : $blog_language;  
					$blogs[$k ]->alpha		= substr( $blogs[$k]->language, 0, 2 );
				}
			}

			return $blogs;
		}

		/**
		 * Gets the registered users of the current blog
		 *
		 * @param string $fields
		 * @param int|string $number
		 *
		 * @return array
		 */
		public function get_users( $fields = 'all', $number = '' ) {
			$args = [
				'blog_id' => $this->current_blog_id,
				'orderby' => 'registered',
				'fields'  => $fields,
				'number'  => $number,
			];

			return get_users( $args );
		}

		/**
		 * Gets blog by language
		 *
		 * @param	string		$language
		 * @param	boolean		$alpha
		 * @return	array|null
		 */
		public function get_blog_by_language( $language, $alpha = false ) {

			// Iterate blog list
			foreach ( $this->blogs as $blog ) {
				$blog_language = ( $alpha ) ? $blog->alpha : $blog->language;
				if ( $language == $blog_language ) { return $blog->userblog_id; }
			}

			return null;
		}

		/**
		 * Checks if current blog is in the blogs list
		 *
		 * @return bool
		 */
		public function has_current_blog() {
			return isset( $this->blogs[ $this->current_blog_id ] );
		}

		/**
		 * Gets current blog as object
		 * @return object
		 */
		public function get_current_blog() {
			return ( $this->has_current_blog() ) ? $this->blogs[ $this->current_blog_id ] :	null;
		}

		/**
		 * Gets an array list of blog objects
		 *
		 * @param	boolean		$all	true for all blogs, false removes current blog if set
		 * @return 	array
		 */
		public function get_blogs( $all = true ) {

			// Remove currrent blog?
			if ( ! $all && $this->has_current_blog() ) {
				unset( $this->blogs[ $this->current_blog_id ] );
			}

			// Return blog list
			return $this->blogs;
		}

		/**
		 * Get the id of the current blog
		 * 
		 * @return integer
		 */
		public function get_current_blog_id() {
			return $this->current_blog_id;
		}

		/**
		 * Get blog option by ID
		 *
		 * @param 	string	$option
		 * @param	integer	$id
		 * @return	object
		 */
		public function get_blog_option( $option, $id = 0 ) {
			return ( $id <= 0 ) ? get_blog_option( $option, $this->get_current_blog_id() ) : get_blog_option( $option, $id );
		}

		/**
		 * Get blog details by ID
		 *
		 * @param 	integer	$id
		 * @return 	object	WP_Site_Object
		 */
		public function get_blog_details_by_id( $id = 0 ) {
			return ( $id <= 0 ) ? get_blog_details( $this->get_current_blog_id() ) : get_blog_details( $id );
		}

		//------------------------------------------
		// Additional Site Functions
		//------------------------------------------

		/**
		 * Get multisite sites
		 *
		 * @return	array	WP_Site_Object List
		 */
		public function get_sites() {
			return $this->sites;
		}

		/**
		 * Get the id of the current site
		 * 
		 * @param	boolean	$current
		 * @return 	array|null
		 */
		public function get_site_by_id( $id = 1 ) {
			return ( $id <= 0 ) ? null : $this->sites[$id];
		}

		/**
		 * Get the current site or id
		 * 
		 * @param	boolean	$id
		 * @return 	array|integer
		 */
		public function get_current_site( $id = false) {
			return ( $id === true ) ? get_current_site()->blog_id : get_current_site();
		}
	}

endif;

// Instantiate Multisite Class
return new IPR_Multisite;

//end
