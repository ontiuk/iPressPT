iPress PT - WordPress Theme Framework 
=======================================

=== iPress Parent Theme ===
Contributors: tifosi
Requires at least: 6.0
Tested up to: 6.3
Requires PHP: 7.4
Stable tag: 2.7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

iPressPT is a Parent Theme framework based on the iPress Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton themes such as underscores, bones, and html5blank, as well as the latest default WordPress themes, this uses best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Structured hierarchy template structure with hooks: actions & filters.
- Highly configurable class-based functionality hooking into core WordPress functionality.
- Simple default theme that can be easily replaced with your own via child theme.
- Plugin integration: WooCommerce & Advanced Custom Fields
- Lots of helpful stuff: helper functions, shortcodes, menus, extensions etc.

Note: this was intended primarily a development version for personal & client e-commerce projects. 

It contains a basic but functional CSS structure which is based on the normalise.css global reset and a selection of element and component styles and using SCSS. This can be readily replaced, all or in part, by structured framework such as Bootstrap or Tailwind.

This is done through the iPress Child Theme. All styling & templating is delegated to the Child Theme.

== Installation ==

1. Upload the iPress Parent Theme folder via FTP to your wp-content/themes/ directory.
2. Upload the iPress Child Theme folder via FTP to your wp-content/themes/ directory.
3. Go to your WordPress dashboard and select Appearance.
4. Select and activate the child theme.

The theme is translation ready. Default language files can be found in the /languages directory. Currently it's not possible to change the textdomain identifier to a global variable or PHP define.

== User Manual ==

I'll be updating this asap with details of available filters.

== Widget Areas ==

* Primary Sidebar 	- This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar 	- This is the widgeted area for the top right of the header.

== Support ==

Please visit the github page: https://github.com/ontiuk.

== Other Stuff ==

iPress consists of 3 primary themes:
iPressPT - iPress Parent Theme. Designed to work with an iPressCT child theme.
iPressCT - iPress Child Theme. Requires iPressPT. Child themes can be configured and styled as required.
iPressST - iPress Standalone Theme. Integrates iPressPT & iPressCT. Used for standalone theme development.

ToDo
iPressRX - iPress React Theme Framework. Custom theme for use with the React Framework with particular reference to the WP REST API.
iPress Extensions - Additional modular framework functionality 

== Copyright ==

iPress WordPress Parent Theme is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Structure: Folders & Files ==

/
|-CHANGELOG.md
|-footer.php
|-functions.php
|-header.php
|-index.php
|-README.md
|-screenshot.jpg
|-style.css
|-/inc
|	|-bootstrap.php
| 	|-config.php
| 	|-customizer.php
| 	|-functions.php
| 	|-/classes
| 		|-class-ipr-compat.php
| 		|-class-ipr-custom.php
| 		|-class-ipr-customizer.php
| 		|-class-ipr-images.php
| 		|-class-ipr-init.php
| 		|-class-ipr-load-fonts.php
| 		|-class-ipr-load-scripts.php
| 		|-class-ipr-load-styles.php
| 		|-class-ipr-login.php
| 		|-class-ipr-multisite.php
| 		|-class-ipr-navigation.php
| 		|-class-ipr-page.php
| 		|-class-ipr-post-type.php
| 		|-class-ipr-rewrites.php
| 		|-class-ipr-sidebars.php
| 		|-class-ipr-taxonomy.php
| 		|-class-ipr-theme.php
| 		|-class-ipr-widgets.php
| 	|-/customizer
|		functions.php
| 		|-/controls
| 			|-/css
| 				|-customizer.css
| 			|-/js
| 			|-class-ipr-arbitrary-control.php
| 			|-class-ipr-checkbox-multiple-control.php
| 			|-class-ipr-seperator-control.php
| 			|-class-ipr-title-control.php
| 	|-/functions
|		|-content.php
|		|-image.php
|		|-navigation.php
|		|-pagination.php
|		|-template.php
|		|-user.php
|-/languages
|-/docs

== Structure: Files & Templates ==

/
|- footer.php
|- functions.php
|- header.php
|- index.php
|- style.css

== Hooks & Classes ==

index.php
action:
	'ipress_before_main_content'
	'ipress_after_main_content'	
'main' class: index-page

== Custom Hooks - Actions & Filters ==

bootstrap.php
------------------

'ipress_bootstrap'
Action: Initialise pre-bootstrap functionality

'ipress_init'
Action: Initialise functionality before loading files & after defining constants

'ipress_config'
Action: Initialise functionality before loading config file

image.php
---------------
Image processing functions

'ipress_post_image_args'
- Filter: Image retrieval function default args
- Default: []
- Return: []
- Function: ipress_post_image()

'ipress_pre_post_image'
- Filter: Short-circuit image generation function
- Default: false
- Return: boolean
- Function: ipress_post_image()

pagination.php
----------------

'ipress_next_nav_link'
- Filter: Previous Next Context for ipress_get_prev_next_posts_nav() function
- Default: '&larr; Older'
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_prev_nav_link'
- Filter: Previous Next Context for ipress_get_prev_next_posts_nav() function
- Default: 'Newer &rarr;'
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_prev_next_posts_nav() output <section>
- Default: ''
- Return: string
- Function: 'ipress_get_prev_next_posts_nav'

'ipress_post_navigation_args'
- Filter: Set post navigation arguments for ipress_get_prev_next_post_nav() function
- Default: []
- Return: []
- Function: 'ipress_get_prev_next_post_nav'

'ipress_post_navigation_term'
- Filter: Set 'in_same_term' value for post navigation arguments
- Default: '';
- Return: string

'ipress_post_navigation_class'
- Filter: Wrapper class for ipress_get_prev_next_post_nav() output
- Default: ''
- Return: string
- Function: 'ipress_get_prev_next_post_nav'

'ipress_post_navigation_args'
- Filter: Set post navigation arguments for ipress_get_post_navigation() function
- Default: []
- Return: []
- Function: 'ipress_get_post_navigation'

'ipress_post_navigation_term'
- Filter: Set 'in_same_term' value for post navigation arguments
- Default: '';
- Return: string
- Function: 'ipress_get_post_navigation'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_post_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_post_navigation'

'ipress_loop_navigation_args'
- Filter: Set post navigation arguments for ipress_get_loop_navigation() function
- Default: []
- Return: []
- Function: 'ipress_get_loop_navigation'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_loop_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_loop_navigation'

'ipress_paginate_links_args'
- Filter: Set post navigation arguments for ipress_get_pagination() function
- Default: []
- Return: []

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_pagination() output
- Default: ''
- Return: string
- Function: 'ipress_get_pagination'

'ipress_posts_navigation_class'
- Filter: Wrapper class for ipress_get_posts_navigation() output
- Default: ''
- Return: string
- Function: 'ipress_get_pagination'

class-ipr-compat.php
------------------
Initialise and set up theme compatibility functionality.

'ipress_theme_php'
- Filter: Set minimum PHP requirements.
- Default: IPRESS_THEME_PHP defined in bootstrap.php.
- Return: String

'ipress_theme_wp'
- Filter: Set minimum WP requirements.
- Default: IPRESS_THEME_WP defined in bootstrap.php.

class-ipr-customizer.php
---------------------
Initialize theme WordPress theme customizer features & enable theme support via customizer.

'ipress_setup_customizer'
- Action: Additional customizer theme settings. 
- Hook: 'after_theme_setup'

'ipress_customize_register'
- Action: Additional customizer settings. Uses the current WP Customizer instance. 
- Hook: 'customize_register'

'ipress_custom_logo_args'
- Filter: Default args for add_theme_support( 'custom_logo' ).
- Default [ 'width', 'height', 'flex-width', 'flex-height' ]
- Return []

'ipress_custom_logo_args'
- Filter: Default args for add_theme_support( 'custom-logo' ).
- Default: [ 'width', 'height', 'flex-width', 'flex-height' ]
- Return: []

'ipress_custom_header'
- Filter: Enable custom header theme support. Hooked into after_theme_setup action.
- Default: boolean, false
- Return: boolean

'ipress_custom_header_default_image'
- Filter: Set the default header image, default header.png. Requires custom header theme support.
- Default: string, header.png
- Return: string, url

'ipress_custom_header_args'
- Filter: Default args for add_theme_support( 'custom-header' ). Requires custom header theme support.
- Default: [ 'default-image', 'header-text', 'width', 'height', 'flex-width', 'flex-height' ]
- Return: []

'ipress_custom_header_uploads'
- Filter: Enable custom header uploads. Requires custom headers to be enabled. Hooked into after_theme_setup.
- Default: boolean, false
- Return: boolean

'ipress_default_headers';
- Filter: Register default headers. Requires custom header theme support.
- Default: boolean, false
- Return: boolean 

'ipress_default_header_args'
- Filter: Default args for register_default_headers.
- Default []
- Return: []

'ipress_custom_background'
- Filter: Enable theme support for custom backgrounds. Hooked into after_theme_setup action.
- Default: false
- Return: bool

'ipress_custom_background_default_image'
- Filter: Set the default custom background image. Requires custom background to be enabled.
- Default: ''
- Return: string, url

'ipress_custom_background_default_color'
- Filter: Set the default custom background. Requires custom background to be enabled.
- Default: #ffffff
- Return: string, hex

'ipress_custom_background_args'
- Filter: Default args for add_theme_support( 'custom-background' ). Requires custom background theme support.
- Default: []
- Return: []

'ipress_custom_selective_refresh'
- Filter: Enable theme support for 'selective_refresh' for widgets.
- Default: boolean, true
- Return boolean

'ipress_customize_header_partials'
- Filter: Enable dynamic refresh for header partials.
- Default: boolean, true
- Return boolean.

'ipress_customize_register_control_type'
- Filter: Register external customizer control types
- Default: []
- Return: []

'ipress_customize_register_section_type'
- Filter: Register external customizer control types
- Default: []
- Return: []

class-ipr-images.php
-----------------
Initialize theme custom images & core images functionality.

'ipress_media_images'
- Filter: Image size media editor add custom image sizes. Should match custom images from add_images_size.
- Default: [ 'image-in-post', 'full' ]
- Return: []
- Hook: 'image_size_names_choose'

'ipress_media_images_sizes'
- Filter: Remove default image sizes.
- Default: sizes [], 'thumbnail', 'medium', 'medium_large', 'large'
- Return: []
- Hook: 'intermediate_image_sizes_advanced'

'ipress_upload_mimes'
- Filter: Add / Remove Mime type support for file uploads.
- Default: [ 'svg', 'svgz' ], add SVG support
- Return: []
- Hook: 'upload_mimes'

'ipress_custom_mimes_restricted'
- Filter: Set mime types that are restricted to admin only upload
- Default: []
- Return: []
- Hook: 'upload_mimes'

'ipress_custom_gravatar'
- Filter: (Gr)Avatar support. Add as [ 'name' => '', 'path' => '' ].
- Default: []
- Return: []
- Hook: 'avatar_defaults'

class-ipr-init.php
-------------------
Initialisation theme header fuctionality with core WordPress features.

'ipress_header_clean'
- Filter: Activate the WP header clean up functionality.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_header_links'
- Filter: Remove feed, rsd, manifest & shortlink links. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_index'
- Filter: Remove noindex & rel link actions. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean
	
'ipress_header_generator'
- Filter: Disable XHTML generator. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_version'
- Filter: Remove Versioning from scripts. Requires 'ipress_header_clean' to be true. 
- Default: boolean, false
- Return: boolean

'ipress_header_css'
- Filter: Clean CSS tags - from enqueued stylesheet. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_comments'
- Filter: Remove inline Recent Comment Styles from wp_head(). Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_header_canonical'
- Filter: Disable canonical references. Requires 'ipress_header_clean' to be true.
- Default boolean, false
- Return: boolean

'ipress_header_login'
- Filter: Show less info to users on failed login for security. Requires 'ipress_header_clean' to be true.
- Default: boolean, false
- Return: boolean

'ipress_login_info'
- Filter: Generate custom text for login error. 
- Default '<strong>ERROR</strong>: Stop guessing!'
- Return: string

'ipress_disable_emojicons' 
- Filter: Disable theme emojicon support.
- Default: boolean, true
- Return: boolean
- Hook: 'init'

class-ipr-load-fonts.php
------------------------

'ipress_fonts'
- Filter: Retrieve theme fonts, if used
- Default: []
- Return: []

'ip_font_display'
- Filter: Filterable per font option to display if not set
- Default: browser define (auto)
- Return: boolean

'ipress_font_resource_hint_type'
- Filter: Make sure we're using the right type, default preconnect
- Default: 'preconnect'
- Return: string

'ipress_font_resource_hints'
- Filter: Filterable list of urls
- Default: []
- Return: []

class-ipr-load-scripts.php
-----------------------
Initialize theme and plugin scripts.

'ipress_scripts'
- Filter: Initialise scripts via config file. Set up scripts list in config.php file, example provided.
- Default: []
- Return: []
- Hook: 'init'

'ipress_scripts_core'
- Filter: Set core scripts for enqueueing.
- Default: []
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_comment_reply'
- Filter: Turn comments on/off.
- Default: boolean, false
- Return: boolean
- Hook: 'wp_enqueue_scripts'

'ipress_scripts_local'
- Filter: Set local scripts for enqueing via inline script.
- Default: []
- Return: []
- Hook: 'wp_enqueue_scripts'

'ipress_header_js'
- Filter: Get option & format in <script></script> tag if set
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_footer_js'
- Filter: Get option & format in <script></script> tag if set
- Default: ''
- Return: string
- Hook: 'wp_footer'

'ipress_header_admin_js'
- Filter: Get option & format in <script></script> tag if set
- Default: '' 
- Return: string 
- Hook: 'admin_head'

'ipress_footer_admin_js'
- Filter: Get option & format in <script></script> tag if set
- Default ''
- Return: string
- Hook: 'admin_footer'

class-ipr-load-styles.php
-----------------------
Initialize theme and plugin styles and fonts.

'ipress_styles'
- Filter: Initialise main styles via config file. Set up scripts list in config.php file, example provided.
- Default: []
- Return: []
- Hook: init

'ipress_styles_core'
- Filter: Initialise core styles
- Default: []
- Return: []

'ipress_header_styles'
- Filter: Get option & format in <styles></styles> tag if set
- Default: ''
- Return: string
- Hook: 'wp_head'

'ipress_header_admin_styles'
- Filter: Get option & format in <styles></styles> tag if set
- Default: ''
- Return: string
- Hook: 'admin_head'

class-ipr-login.php
-------------------
Initialisation login page custom features and redirects

'ipress_login_page'
- Filter: Redirect the default login page.
- Default: boolean, false, uses WP login page
- Return: string

ipress_login_failed_page'
- Filter: Custom login failed redirect.
- Default: boolean, false, uses WP login page.
- Return: string

ipress_login_verify_page'
- Filter: Custom login verify redirect.
- Default: boolean, false, uses WP login page.
- Return: string

ipress_login_logout_page'
- Filter: Custom login logout redirect.
- Default: boolean, false, uses WP login page.
- Return: string

class-ipr-multisite.php
-------------------
Initialize MultiSite features if theme is multisite enabled.

'ipress_multisite_blogs'
- Filter: Set up list of blogs by user.
- Default: [], generic blogs list for user ID
- Return: []

'ipress_multisite_description'
- Filter: Set up blog description by blog ID.
- Default: ''
- Return: string

'ipress_current_blog_users_args'
- Filter: Set up the args for get_users()
- Default: []+
- Return: array

'ipress_multisite_sites'
- Filter: Set up list of sites from blobs list.
- Default: [], generics sites list
- Return: []

class-ipr-navigation.php
-------------------
Initialisation theme navigation features.

'ipress_nav_clean'
- Filter: Clean navigation markup & remove surrounding 'div'.
- Default: boolean, false
- Return: boolean
- Hook: 'wp_nav_menu_args'

'ipress_nav_css_attr'
- Filter: Remove Injected classes, ID's and Page ID's from Navigation li items.
- Default: boolean, false
- Return: bool

'ipress_navigation_markup_template'
- Filter: Custom navigation markup template.
- Default: string
- Return: string
- Hook: 'navigation_markup_template'

class-ipr-page.php
-------------------
Initialize theme page tag & excerpt support.

'ipress_page_excerpt'
- Filter: Page excerpt support.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_page_tags'
- Filter: Page tags support.
- Default: boolean, false
- Return: boolean
- Hook: 'init'

'ipress_page_tags_query'
- Filter: Add page tags to query.
- Default: boolean, false
- Return: bool
- Hook: 'pre_get_posts'

'ipress_search_post_types'
- Filter: Add post-types to WordPress front search.
- Default: []
- Return: []
- Hook: 'pre_get_posts'

class-ipr-post-type.php 
-----------------------
Initialize theme specific custom post-types and taxonomies. In general custom post-types and taxonomies should be created using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the theme and integral to it's functionality so they can be more tightly linked to the theme itself.

'ipress_post_types'
- Filter: Set the custom post types.
- Default: []
- Return: [] of post type names
- Config driven post-type generation, see separate docs / config.php for parameters.

'ipress_post_type_reserved'
- Filter: Reserved custom post type names.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_post_type_valid_args'
- Filter: Reserved list of arguments that can be passed to 'register_post_type'.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_{$post-type}_prefix'
- Filter: Generate a prefix for a custom post-type a-z, hyphen, underscore.
- Default: ''
- Return: string

'ipress_{$post-type}_labels'
- Filter: Post type labels per post type name.
- Default: [], built-in list defined in WP codex, with singular & plural post type name
- Return: []

'ipress_{$post-type}_supports'
- Filter: Post type supports per post type name.
- Default: [ 'title','editor','thumbnail' ]
- Return: []

'ipress_post_type_messages'
- Filter: Set post type helper messages callback.
- Default: []
- Return []

'ipress_{$screen->id}_help
- Filter: Set contextual help tabs.
- Default: []
- Return: []

class-ipr-rewrites.php
-------------------
Initialize theme rewrites and query_vars.

'ipress_query_vars'
- Filter: Add new query vars.
- Default: []
- Return: []
- Hook: 'query_vars'

class-ipr-sidebars.php
-------------------
Initialize theme sidebars and widget areas.

'ipress_sidebar_defaults'
- Filter: Override default sidebar wrappers: before & after widget, before & after title.
- Default: [ 'before_widget', 'after_widget', 'before_title', 'after_title', 'class' ]		
- Return: []

'ipress_before_widget_title'
- Filter: Set before title for current sidebar
- Default: '<h4 class="widget-title">'
- Return: string

'ipress_after_widget_title'
- Filter: Set after title for current sidebar
- Default: '</h4>'
- Return: string

'ipress_sidebar_{sidebar-id}_defaults'
- Filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID.
- Default: [ 'primary', 'header' ]
- Return: []

'ipress_default_sidebars'
- Filter: Creates default sidebars.
- Default: [ primary, header ]
- Return: []

'ipress_custom_sidebars'
- Filter: Register custom sidebars.
- Default: []
- Return: []

'ipress_footer_sidebar_rows'
- filter: Default footer sidebar row number.
- Default: 1
- Return: integer

'ipress_footer_sidebar_areas'
- Filter: Default footer sidebar area number.
- Default: 3
- Return: integer

class-ipr-taxonomy.php 
------------------
Initialize theme specific custom post-types and taxonomies. In general custompost-types and taxonomies should be created using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the theme and integral to it's functionality so they can be more tightly linked to the theme itself.

'ipress_taxonomies'
- Filter: Set the taxonomies.
- Default: []
- Return: [] of taxonomy names
- Config driven taxonomy generation, see separate docs / config.php for parameters.

'ipress_taxonomy_reserved'
- Filter: Reserved taxonomy names.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_taxonomy_valid_args'
- Filter: Reserved list of arguments that can be passed to 'register_taxonomy'.
- Default: [], built-in list defined in WP codex
- Return: []

'ipress_{$taxonomy}_labels
- Filter: Taxonomy labels per texonomy name.
- Default: [], built-in list defined in WP codex and with singular & plural taxonomy name
- Return: []

class-ipr-theme.php
-------------------
Initialize core theme settings.

'ipress_setup'
- Action: Trigger additional setup functionality
- Hook: 'after_theme_setup'

'ipress_content_width'
- Filter: Set default content width for image manipulation, px.
- Default: 980
- Return: integer
- Hook: 'after_setup_theme'

'ipress_post_thumbnails_post_types'
- Filter: Add post-type to thumbnail support. Requires 'post thumbnails' support to be active.
- Default: []
- Return: []

'ipress_post_thumbnail_size'
- Filter: Set thumbnail default size: width, height, crop. Requires 'post thumbnail' support to be active.
- Default: []
- Return: []

'ipress_image_size_default'
- Filter: Core image sizes overrides. Requires post thumbnail support to be active.
- Default: []
- Return: []

'ipress_add_image_size'
- Filter: Add custom image sizes. Requires post thumbnail support to be active.
- Default: []
- Return: []

'ipress_big_image_size
- Filter: Enable / disable 'big image' theme support. Requires post thumbnail support to be active.
- Default: boolean, true
- Return: boolean

'ipress_nav_menus'
- Filter: Register custom navigation menu locations. Requires nav menus support to be active.
- Default: []
- Return: []

'ipress_html5'
- Filter: Enable support for HTML5 markup.
- Default: [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style', 'widgets' ]
- Return: []

'ipress_post_formats'
- Filter: Register post-formats support. Options: 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'.
- Default: []
- Return: []

'ipress_theme_support'
- Filter: Register additional theme support.
- Default: [ 'align-wide', 'responsive-embeds', 'wp-block-styles' ]
- Return: []

'ipress_remove_theme_support'
- Filter: Unregister additional theme support.
- Default: []
- Return: []

'ipress_custom_title_tag'
- Filter: Enable custom title-tag functionality.
- Default: boolean, false
- Return: boolean

'ipress_document_title_separator'
- Filter: document title separator. Requires: title-tag support.
- Default: '-'
- Return: string

'ipress_home_doctitle_append'
- Filter: append site description to title on homepage. Requires: title-tag support.
- Default: boolean, true
- Return: string

'ipress_doctitle_separator'
- Filter: title separator. Requires: title-tag support.
- Default: ''
- Return: string

'ipress_append_site_name'
- Filter: append site name to inner pages. Requires: title-tag support.
- Default: boolean, true
- Return: boolean

class-ipr-widgets.php
-----------------------
Initialisation and register theme widgets.

'ipress_widgets'
- Filter: custom widgets
- Default: []
- Return: []
- Hook: 'widgets_init'
