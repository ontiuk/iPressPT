<?php

/**
 * iPress - WordPress Theme Framework						
 * ==========================================================
 *
 * Theme specific custom post-type and taxonomy initialization.
 * 
 * @package		iPress\Includes
 * @link		http://ipress.co.uk
 * @license		GPL-2.0+
 */

if ( ! class_exists( 'IPR_Custom' ) ) :

	/**
	 * Set up custom post-types & taxonomies
	 */ 
	class IPR_Custom {

		/**
		 * Post Types
		 *
		 * @var array $post_types
		 */
		protected $post_types = [];

		/**
		 * Taxonomies
		 *
		 * @var array $taxonomies
		 */
		protected $taxonomies = [];

		/**
		 * Post Types Errors
		 *
		 * @var array $post_types
		 */
		protected $post_type_errors = [];

		/**
		 * Taxonomy Errors
		 *
		 * @var array $taxonomy_errors
		 */
		protected $taxonomy_errors = [];

		/**
		 * Class constructor
		 */
		public function __construct() {

			// Set up theme post-types and taxonomies
			add_action( 'init', [ $this, 'init' ], 0 );

			// Generate & register custom post-types
			add_action( 'init', [ $this, 'register_post_types' ], 3 ); 

			// Generate & register taxonomies
			add_action( 'init', [ $this, 'register_taxonomies' ], 3 ); 

			// Flush rewrite rules after theme activation
			add_action( 'after_switch_theme', 		[ $this, 'flush_rewrite_rules' ] );

			// Post-type & taxonomy error messages
			add_action( 'admin_notices', 			[ $this, 'admin_notices' ] );

			// Setup Messages Callback
			add_filter( 'post_updated_messages', 	[ $this, 'messages' ] );

			// Contextual screen help
			add_action( 'load-edit.php', 			[ $this, 'contextual_help_tabs' ] );
			add_action( 'load-post.php', 			[ $this, 'contextual_help_tabs' ] );
		}

		//----------------------------------------------
		//	Initialise Variables
		//----------------------------------------------
		
		/**
		 * Initialise Post Types & Taxonomies
		 *
		 * @param 	array 	$post_types
		 * @param 	array 	$taxonomies
		 * @param	string	$prefix
		 */
		public function init() {

			// Register post-types
			$this->post_types = (array) apply_filters( 'ipress_custom_post_types', [] );

			// Register taxonomies
			$this->taxonomies = (array) apply_filters( 'ipress_taxonomies', [] );

			// Post-type - taxonomy columns & filters
			$this->taxonomy_columns();
		}
		
		//----------------------------------------------
		//	Register Custom Post Types
		//----------------------------------------------

		/**
		 * Register Custom Post Type
		 * @see https://codex.wordpress.org/Function_Reference/register_post_type
		 *
		 * $post_types = [ 'cpt' => [ 
		 *		 'name'			 => __( 'CPT', 'ipress' ), 
		 *		 'plural'		 => __( 'CPTs', 'ipress' ),
		 *		 'description'	 => __( 'This is the CPT post-type', 'ipress ), 
		 *		 'supports'		 => [ 'title', 'editor', 'thumbnail' ],
		 *		 'taxonomies	 => [ 'cpt_tax' ],
		 *		 'args'			 => [], 
		 * ] ];
		 */
		public function register_post_types() {

			// Post-Type reserved names
			$post_type_reserved = [ 
				'post', 'page', 'attachment', 'revision', 
				'nav_menu_item', 'custom_css', 'customize_changeset',
				'oembed_cache', 'user_request', 'p_block',
				'action', 'author', 'order', 'theme'
			];

			// Valid optional args - description as unique arg
			$valid = [
				'label', 'labels', 'public', 'exclude_from_search', 'publicly_queryable', 
				'show_ui', 'show_in_nav_menus', 'show_in_menu',	'show_in_admin_bar', 'menu_position', 'menu_icon', 
				'capability_type', 'capabilities', 'map_meta_cap', 'hierarchical', 'supports', 'register_meta_box_cb',
				'taxonomies', 'has_archive', 'rewrite', 'query_var', 'can_export', 'delete_with_user',
				'show_in_rest', 'rest_base', 'rest_controller_class'					
			];

			// Built-in, do not use here
			$invalid = [ '_builtin', '_edit_link' ];

			// Iterate custom post-types...
			foreach ( $this->post_types as $k=>$v ) {
				
				// Basic key overrides: no spaces, translate to underscores
				$post_type = sanitize_key( str_replace( ' ', '_', $k ) );

				// Tag on post type prefix if required
				$post_type_prefix = sanitize_text_field( apply_filters( 'ipress_' . $post_type . '_prefix', '' ) );

				// Sanitize post-type... [a-z_-] only, with or without prefix
				$post_type = $post_type_prefix . $post_type;

				// Sanity checks - reserved words and max post-type length (20)
				if ( in_array( $post_type, $post_type_reserved ) || strlen( $post_type ) > 20 ) { 
					$this->post_type_errors[] = $post_type;
					continue; 
				}		 

				// Set up singluar & plural
				$singular	= ( isset( $v['name'] ) && ! empty( $v['name'] ) ) 		? $v['name'] : ucwords( str_replace( [ '-', '_' ], ' ', $post_type ) );
				$plural		= ( isset( $v['plural'] ) && ! empty( $v['plural'] ) ) 	? $v['plural'] : $singular . 's'; 

				// Set up post-type labels - Rename to suit, common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
				$labels = [
					'name'						=> sprintf( _x( '%s', 'Post type general name', 'ipress' ), $plural ),
					'singular_name'				=> sprintf( _x( '%s', 'Post type singular name', 'ipress' ), $singular ),
					'menu_name'					=> sprintf( _x( '%s', 'Admin menu text', 'ipress' ), $plural ),
					'name_admin_bar'			=> sprintf( _x( '%s', 'Add new on admin bar', 'ipress' ), $singular ),
					'add_new'					=> sprintf( _x( 'Add New', '%s', 'ipress' ), $singular ),
					'add_new_item'				=> sprintf( __( 'Add New %s', 'ipress' ), $singular ),
					'edit_item'					=> sprintf( __( 'Edit %s', 'ipress' ), $singular ),
					'new_item'					=> sprintf( __( 'New %s', 'ipress' ), $singular ),
					'view_item'					=> sprintf( __( 'View %s', 'ipress' ), $singular ),
					'view_items'				=> sprintf( __( 'View %s', 'ipress' ), $plural ),
					'search_items'				=> sprintf( __( 'Search %s', 'ipress' ), $plural ),
					'not_found'					=> sprintf( __( 'No %s found', 'ipress' ), $plural ),
					'not_found_in_trash'		=> sprintf( __( 'No %s found in Trash', 'ipress' ), $plural ),
					'parent_item_colon'			=> sprintf( __( 'Parent %s:', 'ipress' ), $singular ),
					'all_items'					=> sprintf( __( 'All %s', 'ipress' ), $plural ), 
					'archives'					=> sprintf( __( '%s Archives', 'ipress' ), $singular ),
					'attributes'				=> sprintf( __( '%s Attributes', 'ipress' ), $singular ),
					'insert_into_item'			=> sprintf( __( 'Insert into %s', 'ipress' ), $singular ),
					'uploaded_to_this_item' 	=> sprintf( __( 'Uploaded to this %s', 'ipress' ), $singular ),
					'featured_image'			=> sprintf( __( '%s Featured Image', 'ipress' ), $singular ),
					'set_featured_image'		=> sprintf( __( 'Set %s Featured Image', 'ipress' ), $singular ),
					'remove_featured_image' 	=> sprintf( __( 'Remove %s Featured Image', 'ipress' ), $singular ),
					'use_featured_image'		=> sprintf( __( 'Use %s Featured Image', 'ipress' ), $singular ),
					'filter_items_list'			=> sprintf( __( 'Filter %s list', 'ipress' ), $plural ),
					'items_list_navigation' 	=> sprintf( __( '%s list navigation', 'ipress' ), $plural ), 
					'items_list'				=> sprintf( __( '%s list', 'ipress' ), $plural ),
					'item_published'	 		=> sprintf( __( '%s published', 'ipress' ), $singular ),
					'item_published_privately' 	=> sprintf( __( '%s published privately', 'ipress' ), $singular ),
					'item_reverted_to_draft' 	=> sprintf( __( '%s reverted to draft', 'ipress' ), $singular ),
					'item_scheduled' 			=> sprintf( __( '%s scheduled', 'ipress' ), $singular ),
					'item_updated' 				=> sprintf( __( '%s updated', 'ipress' ), $singular )
				];

				// Set up post-type support - default: 'title', 'editor', 'thumbnail'
				$supports = ( isset( $v['supports'] ) && is_array( $v['supports'] ) && ! empty( $v['supports'] ) ) ? $this->sanitize_support( $v['supports'] ) : apply_filters( 'ipress_' . $post_type . '_supports', [
					'title',
					'editor',
					'thumbnail'
				] );
		
				// Set up post-type args - common options here @see https://codex.wordpress.org/Function_Reference/register_post_type
				$args = ( isset( $v['args'] ) && is_array( $v['args'] ) && ! empty( $v['args'] ) ) ? $v['args'] : [];

				// Validate args
				foreach ( $args as $k2=>$v2 ) {
					
					// No built in
					if ( in_array( $k2, $invalid ) ) { unset( $args[$k2] ); continue; }

					// Available args
					if ( ! in_array( $k2, $valid ) ) { unset( $args[$k2] ); continue; }
				}

				// Some sanitization: exclude_from_search : boolean
				if ( isset( $args['exclude_from_search'] ) ) {
					$args['exclude_from_search'] = $this->sanitize_bool( $args['exclude_from_search'] );
				}

				// Some sanitization: publicly_queryable : boolean
				if ( isset( $args['publicly_queryable'] ) ) {
					$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'] );
				}

				// Some sanitization: show_ui : boolean
				if ( isset( $args['show_ui'] ) ) {
					$args['show_ui'] = $this->sanitize_bool( $args['show_ui'] );
				}

				// Some sanitization: show_in_nav_menus : boolean
				if ( isset( $args['show_in_nav_menus'] ) ) {
					$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'] );
				}

				// Some sanitization: show_in_menu : boolean | string
				if ( isset( $args['show_in_menu'] ) ) {
					$args['show_in_menu'] = $this->sanitize_string_or_bool( $args['show_in_menu'] );
				}

				// Some sanitization: show_in_admin_bar : boolean
				if ( isset( $args['show_in_admin_bar'] ) ) {
					$args['show_in_admin_bar'] = $this->sanitize_bool( $args['show_in_admin_bar'] );
				}

				// Some sanitization: menu_position : integer
				if ( isset( $args['menu_position'] ) ) {
					$args['menu_position'] = $this->sanitize_integer( $args['menu_position'] );
				}

				// Some sanitization: capability_type : string | array
				if ( isset( $args['capability_type'] ) ) {
					$args['capability_type'] = $this->sanitize_string_or_array( $args['capability_type'], 'post' );
				}

				// Some sanitization: map_meta_cap : boolean
				if ( isset( $args['map_meta_cap'] ) ) {
					$args['map_meta_cap'] = $this->sanitize_bool( $args['map_meta_cap'] );
				}

				// Some sanitization: capabilities : array
				if ( isset( $args['capabilities'] ) ) {
					if ( is_array( $args['capabilities'] ) ) {
						$meta_cap = ( isset( $args['map_meta_cap'] ) ) ? $args['map_meta_cap'] : false;
						$this->sanitize_capabilities( $args['capabilities'], $meta_cap );
					} else {
						unset( $args['capabilities'] );
					}
				}

				// Some sanitization: hierarchical : boolean
				if ( isset( $args['hierarchical'] ) ) {
					$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
				}

				// Some sanitization: archives : string or boolean
				if ( isset( $args['has_archive'] ) ) {
					$args['has_archive'] = $this->sanitize_string_or_bool( $args['has_archive'] );
				}

				// Some sanitization: rewrite : boolean or array
				if ( isset( $args['rewrite'] ) ) {
					$args['rewrite'] = $this->sanitize_bool_or_array( $args['rewrite'] );
				}

				// Some sanitization: archives : string or boolean
				if ( isset( $args['query_var'] ) ) {
					$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
				}

				// Some sanitization: can_export : boolean
				if ( isset( $args['can_export'] ) ) {
					$args['can_export'] = $this->sanitize_bool( $args['can_export'] );
				}

				// Some sanitization: delete_with_user : boolean
				if ( isset( $args['delete_with_user'] ) ) {
					$args['delete_with_user'] = $this->sanitize_bool( $args['delete_with_user'] );
				}

				// Some sanitization: show_in_rest : boolean
				if ( isset( $args['show_in_rest'] ) ) {
					$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
				}

				// Some sanitization: rest_base : string
				if ( isset( $args['rest_base'] ) ) {
					$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
				}

				// Some sanitization: rest_controller_class : string
				if ( isset( $args['rest_controller_class'] ) ) {
					$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
				}

				// Associated taxonomies... still need to explicitly register with 'register_taxonomy'
				if ( isset( $v['taxonomies'] ) && is_array( $v['taxonomies'] ) && ! empty( $v['taxonomies'] ) ) {
					$args['taxonomies'] = array_map( [ $this, 'sanitize_key' ], $v['taxonomies'] );
				} elseif ( isset( $args['taxonomies'] ) && is_array( $args['taxonomies'] ) && ! empty( $args['taxonomies'] ) ) {
					$args['taxonomies'] = array_map( [ $this, 'sanitize_key' ], $args['taxonomies'] );
				}

				// Merge with 
				$args = array_merge( [
					'labels'		=> $labels,
					'description'	=> ( isset( $v['description'] ) && ! empty( $v['description'] ) ) ? __( $v['description'], 'ipress' ) : sprintf( __( 'This is the %s post-type', 'ipress' ), $singular ),
					'public'		=> ( isset( $v['public'] ) ) ? (bool) $v['public'] : true,
					'supports'		=> $supports
				], $args );
		
				// Register new post-type
				register_post_type( $post_type, $args );
			}
		}

		//----------------------------------------------
		//	Register Taxonomies
		//----------------------------------------------

		/**
		 * Register taxonomies & assign to post-types
		 * @see https://codex.wordpress.org/Function_Reference/register_taxonomy
		 * 
		 *	$taxonomies = [ 'cpt_tax' => [ 
		 *		'name'			=> __( 'Tax Name', 'ipress' ), 
		 *		'plural'		=> __( 'Taxes', 'ipress' ),
		 *		'description'	=> __( 'This is the Taxonomy name', 'ipress' ), 
		 *		'post_types'	=> [ 'cpt' ], 
		 *		'args'			=> [],
		 *		'column'		=> true, //optional
		 *		'sortable'		=> true, //optional
		 *		'filter'		=> true  //optional
		 *	] ];
		 */
		public function register_taxonomies() {

			// Taxonomy Reserved Terms
			$taxonomy_reserved = [
				'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat',
				'category', 'category__and', 'category__in', 'category__not_in', 'category_name',
				'comments_per_page', 'comments_popup', 'customize_messenger_channel', 'customized',
				'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'fields', 'hour', 'link_category',	
				'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nonce', 'nopaging', 'offset',
				'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post',
				'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag',
				'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots',
				's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id',
				'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in',
				'taxonomy', 'tb', 'term', 'theme', 'type', 'w', 'withcomments', 'withoutcomments', 'year'
			];

			// Valid optional args - description as a unique arg
			$valid = [ 
				'label', 'labels', 'public', 'publicly_queryable', 
				'show_ui', 'show_in_menu', 'show_in_nav_menus',
				'show_in_rest', 'rest_base', 'rest_controller_class',
				'show_tag_cloud', 'show_in_quick_edit', 'meta_box_cb',
				'show_admin_column', 'hierarchical', 'update_count_callback',
				'query_var', 'rewrite', 'capabilities', 'sort'
			];

			// Built-in, do not use here
			$invalid = [ '_builtin' ];

			// Iterate taxonomies...
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Sanity checks - reserved words and maximum taxonomy length
				if ( in_array( $taxonomy, $taxonomy_reserved ) || strlen( $taxonomy ) > 32 ) { 
					$this->taxonomy_errors[] = $taxonomy;
					continue; 
				}

				// Set up singular & plural
				$singular	 = ( isset( $v['name'] ) && ! empty( $v['name'] ) ) 	? $v['name'] : ucwords( str_replace( [ '_', '-' ], ' ', $taxonomy ) );
				$plural		 = ( isset( $v['plural'] ) && !empty( $v['plural'] ) ) 	? $v['plural'] : $singular . 's'; 

				// Set up taxonomy labels
				$labels = [
					'name'							=> sprintf( _x( '%s', 'ipress' ), $plural ), 
					'singular_name'					=> sprintf( _x( '%s', 'ipress' ), $singular ), 
					'menu_name'						=> sprintf( __( '%s', 'ipress' ), $singular ), 
					'all_items'						=> sprintf( __( 'All %s', 'ipress' ), $plural ), 
					'edit_item'						=> sprintf( __( 'Edit %s', 'ipress' ), $singular ), 
					'view_item'						=> sprintf( __( 'View %s', 'ipress' ), $singular ), 
					'update_item'					=> sprintf( __( 'Update %s', 'ipress' ), $singular ), 
					'add_new_item'					=> sprintf( __( 'Add New %s', 'ipress' ), $singular ), 
					'new_item_name'					=> sprintf( __( 'New %s Name', 'ipress' ), $singular ), 
					'parent_item'					=> sprintf( __( 'Parent %s', 'ipress' ), $singular ), 
					'parent_item_colon'				=> sprintf( __( 'Parent %s:', 'ipress' ), $singular ), 
					'search_items'					=> sprintf( __( 'Search %s', 'ipress' ), $plural ), 
					'popular_items'					=> sprintf( __( 'Popular %s', 'ipress' ), $plural ), 
					'not_found'						=> sprintf( __( 'No %s found', 'ipress' ), $plural ), 
					'back_to_items'					=> sprintf( __( '&#8617; Back to %s', 'ipress' ), $plural ), 
					'separate_items_with_commas' 	=> sprintf( __( 'Separate %s with commas', 'ipress' ), $plural ), 
					'add_or_remove_items'		 	=> sprintf( __( 'Add or remove %s', 'ipress' ), $plural ), 
					'choose_from_the_most_used'  	=> sprintf( __( 'Chose from the most used %s', 'ipress' ), $plural ) 
				];
										
				// Set up taxonomy args
				$args = ( isset( $v['args'] ) && is_array( $v['args'] ) && ! empty( $v['args'] ) ) ? $v['args'] : [];

				// Validate args
				foreach ( $args as $k2=>$v2 ) {
					
					// No built in
					if ( in_array( $k2, $invalid ) ) { unset( $args[$k2] ); continue; }

					// Available args
					if ( ! in_array( $k2, $valid ) ) { unset( $args[$k2] ); continue; }
				}

				// Some sanitization: publicly_queryable : boolean
				if ( isset( $args['publicly_queryable'] ) ) {
					$args['publicly_queryable'] = $this->sanitize_bool( $args['publicly_queryable'] );
				}

				// Some sanitization: show_ui : boolean
				if ( isset( $args['show_ui'] ) ) {
					$args['show_ui'] = $this->sanitize_bool( $args['show_ui'] );
				}

				// Some sanitization: show_in_menu : boolean
				if ( isset( $args['show_in_menu'] ) ) {
					$args['show_in_menu'] = $this->sanitize_bool( $args['show_in_menu'] );
				}

				// Some sanitization: show_in_nav_menus : boolean
				if ( isset( $args['show_in_nav_menus'] ) ) {
					$args['show_in_nav_menus'] = $this->sanitize_bool( $args['show_in_nav_menus'] );
				}

				// Some sanitization: show_in_rest : boolean
				if ( isset( $args['show_in_rest'] ) ) {
					$args['show_in_rest'] = $this->sanitize_bool( $args['show_in_rest'] );
				}

				// Some sanitization: rest_base : string
				if ( isset( $args['rest_base'] ) ) {
					$args['rest_base'] = sanitize_text_field( $args['rest_base'] );
				}

				// Some sanitization: rest_controller_class : string
				if ( isset( $args['rest_controller_class'] ) ) {
					$args['rest_controller_class'] = sanitize_text_field( $args['rest_controller_class'] );
				}

				// Some sanitization: show_tag_cloud : boolean
				if ( isset( $args['show_tag_cloud'] ) ) {
					$args['show_tag_cloud'] = $this->sanitize_bool( $args['show_tag_cloud'] );
				}

				// Some sanitization: show_in_quick_edit : boolean
				if ( isset( $args['show_in_quick_edit'] ) ) {
					$args['show_in_quick_edit'] = $this->sanitize_bool( $args['show_in_quick_edit'] );
				}

				// Some sanitization: show_admin_column : boolean
				if ( isset( $v['column'] ) ) {
					$args['show_admin_column'] = $this->sanitize_bool( $v['column'] );
				} elseif ( isset( $args['show_admin_column'] ) ) {
					$args['show_admin_column'] = $this->sanitize_bool( $args['show_admin_column'] );
				}

				// Some sanitization: hierarchical : boolean
				if ( isset( $args['hierarchical'] ) ) {
					$args['hierarchical'] = $this->sanitize_bool( $args['hierarchical'] );
				}

				// Some sanitization: archives : string or boolean
				if ( isset( $args['query_var'] ) ) {
					$args['query_var'] = $this->sanitize_string_or_bool( $args['query_var'] );
				}

				// Some sanitization: rewrite : boolean or array
				if ( isset( $args['rewrite'] ) ) {
					$args['rewrite'] = $this->sanitize_bool_or_array( $args['rewrite'] );
				}
				
				// Some sanitization: capabilities : array
				if ( isset( $args['capabilities'] ) ) {
					if ( is_array( $args['capabilities'] ) ) {
						$this->sanitize_capabilities( $args['capabilities'], $meta, true );
					} else {
						unset( $args['capabilities'] );
					}
				}
				
				// Some sanitization: sort : boolean
				if ( isset( $args['sort'] ) ) {
					$args['sort'] = $this->sanitize_bool( $args['sort'] );
				}

				// Construct args
				$args = array_merge( [
					'labels'		=> $labels,
					'public'		=> ( isset( $v['public'] ) ) ? (bool) $v['public'] : true,
					'description'	=> ( isset( $v['description'] ) && ! empty( $v['description'] ) ) ? __( $v['description'], 'ipress' ) : sprintf( __( 'This is the %s taxonomy', 'ipress' ), $singular ),
				], $args );

				// Assign to post-types?
				if ( isset( $v['post_types'] ) ) {
					$post_types = ( is_array( $v['post_types'] ) ) ? array_map( [ $this, 'sanitize_key' ], $v['post_types'] ) : sanitize_key( str_replace( ' ', '_', $v['post_types'] ) );
				} else { $post_types = []; }

				// Register taxonomy
				register_taxonomy( $taxonomy, $post_types, $args );
			}	
		}

		//----------------------------------------------
		//	Post Type Taxonomy Columns & Filters
		//----------------------------------------------
		
		/**
		 * Taxonomy columns and filters
		 */
		protected function taxonomy_columns() {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k=>$v ) {

				// Assign to post-types required
				if ( isset( $v['post_types'] ) ) {

					// Sanitize post types
					$post_types = ( is_array( $v['post_types'] ) ) ? $v['post_types'] : (array) $v['post_types'];

					// Sanitize taxonomy... a-z_- only
					$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

					// Post-type taxonomy column
					if ( isset( $v['column'] ) && true === $v['column'] ) {

						// Sortable?
						if ( isset( $v['sortable'] ) && true === $v['sortable'] ) {

							// Get post-types
							foreach ( $post_types as $post_type ) {
				
								// Sanitize post-type... a-z_- only
								$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

								add_filter( 'manage_edit-' . $post_type . '_sortable_columns', [ $this, 'sortable_columns' ] ); 
								add_filter( 'posts_clauses', [ $this, 'sort_column' ], 10, 2 );
							}
						}
					}
				}

				// Post-type taxonomy filter
				if ( isset( $v['filter'] ) && true === $v['filter'] ) {
					add_action( 'restrict_manage_posts', [ $this, 'post_type_filter' ] ); 
					add_filter( 'parse_query', [ $this, 'post_type_filter_query' ] );
				}
			}
		}

		/**
		 * Make filter column sortable
		 * 
		 * @param	array $columns
		 * @return	array
		 */
		public function sortable_columns( $columns ) {

			// Taxonomy columns & filters
			foreach ( $this->taxonomies as $k=>$v ) {

				// Post-type taxonomy column
				if ( isset( $v['column'] ) && true === $v['column'] ) {

					// Sortable?
					if ( isset( $v['sortable'] ) && true === $v['sortable'] ) {

						// Sanitize taxonomy... a-z_- only
						$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

						// Set column key
						$column_key = 'taxonomy-' . $taxonomy;

						// Add filter column to sortable list
						$columns[ $column_key ] = $taxonomy;		
					}
				}
			}
			
			return $columns;	
		}

		/** 
		 * Sort custom taxonomy columns as required 
		 * 
		 * @param array $pieces 
		 * @param array $wp_query 
		 * 
		 * @return array 
		 */ 
		public function sort_column( $pieces, $query ) { 

			global $wpdb; 

			// Ordering set?
			$orderby = $query->get( 'orderby' ); 
			if ( empty( $orderby ) ) { return $pieces; }
				
			// Only if admin main query
			if ( is_admin() && $query->is_main_query() ) {

				// Taxonomy columns & filters
				foreach ( $this->taxonomies as $k=>$v ) {

					// Filter?
					if ( isset( $v['filter'] ) && true === $v['filter'] ) {

						// Sanitize taxonomy... a-z_- only
						$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

						// Matching taxonomy
						if ( $orderby === $taxonomy ) { 
							
							$order = ( strtoupper( $query->get( 'order' ) ) != 'DESC' ) ? 'ASC': 'DESC';

							// Construct sql
							$pieces['join'] .= ' LEFT OUTER JOIN ' . $wpdb->term_relationships . ' as tr ON ' . $wpdb->posts . '.ID = tr.object_id
												 LEFT OUTER JOIN ' . $wpdb->term_taxonomy . ' as tt USING (term_taxonomy_id)
												 LEFT OUTER JOIN ' . $wpdb->terms . ' as t USING (term_id)';
							$pieces['where']	.= ' AND ( tt.taxonomy = "' . $taxonomy . '" OR tt.taxonomy IS NULL)';
							$pieces['groupby']	= 'tr.object_id';
							$pieces['orderby']	= 'GROUP_CONCAT( t.name ORDER BY name ASC) ';
							$pieces['orderby'] .= $order;	

							// Matched...
							break;
						}  
					}
				}
			}

			// Get pieces
			return $pieces; 
		} 

		//----------------------------------------------
		//	Taxonomy Filters
		//----------------------------------------------

		/**
		 * Add taxonomy type post list filtering
		 * - Called via restrict_manage_posts action
		 *
		 * @return void
		 */
		public function post_type_filter() {

			global $typenow, $wp_query; 

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Assign to post-types required
				if ( isset( $v['post_types'] ) ) {
					
					// Sanitize post types
					$post_types = ( is_array( $v['post_types'] ) ) ? $v['post_types'] : (array) $v['post_types'];
				  
					// Get post-types
					foreach ( $post_types as $post_type ) {
				
						// Sanitize post-type... a-z_- only
						$post_type = sanitize_key( str_replace( ' ', '_', $post_type ) );

						// Only if current post-type			
						if ( $typenow !== $post_type ) { continue; }

						// Get current taxonomy			
						$current_taxonomy = get_taxonomy( $taxonomy ); 

						// Only if query_var
						if ( empty( $current_taxonomy->query_var ) ) { continue; }

						// Terms & term count
						$tax_terms = get_terms( $taxonomy );
						$tax_term_count = (int)sizeof( $tax_terms );
			
						// Need terms...
						if ( $tax_term_count === 0 ) { continue; }

						// Dropdown select
						wp_dropdown_categories(
							[ 
								'show_option_all' =>  sprintf( __( 'Show All %s', 'ipress' ), $current_taxonomy->label ), 
								'taxonomy'		  =>  $taxonomy,	 
								'name'			  =>  $current_taxonomy->name, 
								'orderby'		  =>  'name', 
								'selected'		  =>  ( isset( $wp_query->query[$taxonomy] ) ) ? $wp_query->query[$taxonomy] : '', 
								'hierarchical'	  =>  true, 
								'depth'			  =>  3, 
								'show_count'	  =>  true, 
								'hide_empty'	  =>  true 
							]
						); 
					}
				}
			}
		}

		/**
		 * Filter query for post_type taxonomy
		 * Called via parse_query filter
		 *
		 * @param object $query
		 * @return void
		 */
		public function post_type_filter_query( $query ) {

			global $pagenow; 

			// Test page
			if ( $pagenow !== 'edit.php' ) { return; }

			// Set filter 
			$vars = &$query->query_vars;

			// Iterate taxonomies
			foreach ( $this->taxonomies as $k=>$v ) {

				// Sanitize taxonomy... a-z_- only
				$taxonomy = sanitize_key( str_replace( ' ', '_', $k ) );

				// Edit page & matching taxonomy
				if ( $pagenow == 'edit.php' && isset( $vars[ $taxonomy ] ) && is_numeric( $vars[$taxonomy] ) ) {
					 $term = get_term_by( 'id', $vars[ $taxonomy ], $taxonomy );
					 if ( $term ) { $vars[ $taxonomy ] = $term->slug; }
				}
			}
		}

		//----------------------------------------------
		//	Rewrite Rules
		//----------------------------------------------

		/**
		 * Flush rewrite rules for custom post-types & taxonomies after switching theme
		 */
		public function flush_rewrite_rules() { 
			$this->register_post_types();
			$this->register_taxonomies();
			flush_rewrite_rules(); 
		}

		//----------------------------------------------
		//	Admin Error Notices
		//----------------------------------------------

		/**
		 * Post-Type and Taxonomy Error Notices
		 */
		public function admin_notices() {
			
			// Post-Type Errors
			if ( !empty( $this->post_type_errors ) ) {
				$message = sprintf( __( 'Error: Bad Post Types [%s].', 'ipress' ), join( ', ', $this->post_type_errors ) ); 
				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) ); 
			}

			// Taxonomy Errors
			if ( !empty( $this->taxonomy_errors ) ) {
				$message = sprintf( __( 'Error: Bad Taxonomies [%s].', 'ipress' ), join( ', ', $this->taxonomy_errors ) );
				echo sprintf( '<div class="notice notice-error"><p>%s</p></div>', esc_html( $message ) ); 
			}
		}

		//----------------------------------------------
		//	Messages
		//----------------------------------------------

		/**
		 * Messages Callback
		 *
		 * @param	array $messages
		 * @return	array
		 */
		public function messages( $messages ) { 
			return (array) apply_filters( 'ipress_post_type_messages', $messages ); 
		}

		//----------------------------------------------
		//	Contextual Help
		//----------------------------------------------

		/**
		 * Contextual Help Callback
		 * 	[
		 *  	[
		 *  		'id'      => 'sp_overview',
		 *  		'title'   => 'Overview',
		 *  		'content' => '<p>Overview of your plugin or theme here</p>'
		 *  	]
		 *  ];
 		 *
		 * @param	string $contextual_help
		 * @param	object $screen_id
		 * @param	string $screen
		 * @return	array
		 */
		public function contextual_help_tabs() {

			// Get current screen
			$screen = get_current_screen();

			// Test valid post types
			if ( ! in_array( $screen->id, $this->post_types ) ) { return; }

			// Get help types
			$help_types = (array) apply_filters( 'ipress_post_type_help', [] );
			if ( empty( $help_types ) ) { return; }

			// Get right help
			if ( ! array_key_exists( $screen->id, $help_types[$screen->id] ) ) { return; }
			$help_tabs = $help_types[$screen->id];

			// Construct tabs from array
			foreach ( $help_tabs as $help_tab ) {
				$screen->add_help_tab( $help_tab );
			}
		}

		//----------------------------------------------
		//	Sanitization functions
		//----------------------------------------------

		/**
		 * Sanitize post_types & taxonomy keys
		 *
		 * @param 	string	$key
		 * @return	string
		 */
		protected function sanitize_key( $key ) {
			return sanitize_key( str_replace( ' ', '_', $key ) );
		}

		/**
		 * Sanitize support
		 *
		 * @param 	mixed	$support
		 * @return	bool
		 */
		private function sanitize_support( &$support ) {

			// Valid suppport
			$supports = [ 
				'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks',
				'custom-fields','comments','revisions','page-attributes','post-formats'
			];

			// Sanitize
			foreach ( $support as $k=>$v ) {
				if ( ! in_array( $v, $supports ) ) { unset( $support[$k] ); }
			}

			// Return sanitized values
			return $support;
		}

		/**
		 * Sanitize capabilities
		 *
		 * @param 	mixed	$caps
		 * @param	boolean	$meta
		 * @param	boolean	$term
		 * @return 	void
		 */
		private function sanitize_capabilities( &$caps, $meta = false, $term = false ) {

			// Valid capabilities
			$post_capabilities = [ 
				'edit_post', 'read_post','delete_post',
				'edit_posts', 'edit_others_posts', 'publish_posts', 'read_private_posts'
			];	

			// terms capabilities
			$term_capabilities = [ 'manage_terms','edit_terms', 'delete_terms','assign_terms' ];

			// Valid meta capabilities
			$meta_caps = [ 
				'read', 'delete_posts', 'delete_private_posts', 'delete_published_posts', 
				'delete_others_posts', 'edit_private_posts', 'edit_published_posts','create_posts', 
			];	
	
			// Set capabilities
			$capabilities = ( true === $term ) ? $term_capabilities : ( true === $meta ) ? array_merge( $meta_caps, $post_capabilities ) : $post_capabilities;

			// Sanitize
			foreach ( $caps as $k=>$v ) {
				if ( ! in_array( $k, $capabilities ) ) { unset( $caps[$k] ); }
			}
		}

		/**
		 * Sanitize argument as bool
		 *
		 * @param 	mixed	$arg
		 * @return	bool
		 */
		private function sanitize_bool( $arg ) {
			return (bool) $arg;
		}

		/**
		 * Sanitize argument as bool or string
		 *
		 * @param 	mixed	$arg
		 * @return	bool|string
		 */
		private function sanitize_string_or_bool( $arg ) {
			return ( is_bool( $arg ) ) ? $arg : sanitize_text_field( $arg );
		}

		/**
		 * Sanitize argument as bool or array
		 *
		 * @param 	mixed $arg
		 * @return	bool|string
		 */
		private function sanitize_bool_or_array( $arg ) {
			return ( is_bool( $arg ) ) ? $arg : (array) $arg;
		}

		/**
		 * Sanitize argument as integer
		 *
		 * @param 	mixed	$arg
		 * @return	bool
		 */
		private function sanitize_integer( $arg ) {
			return ( is_integer( $arg ) ) ? absint( $arg ) : null;
		}

		/**
		 * Sanitize argument as string or array
		 *
		 * @param 	mixed	$arg
		 * @return	string|array
		 */
		private function sanitize_string_or_array( $arg, $str = '' ) {
			return ( is_string( $arg ) || is_array( $arg ) ) ? $arg : $str;
		}

		/**
		 * Sanitize argument as array
		 *
		 * @param 	mixed	$arg
		 * @return	string|array
		 */
		private function sanitize_array( $arg ) {
			return ( is_array( $arg ) && ! empty( $arg ) ) ? $arg : null;
		}
	}

endif;

// Instantiate Custom Class
return new IPR_Custom;

//end
