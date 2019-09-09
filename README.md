iPress PT - WordPress Theme Framework 
=======================================

http://on.tinternet.co.uk

## About

iPressPT is a Parent Theme based on iPressRD - Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton such as underscores, bones, and html5blank, as well as the latest default WordPress themes, this uses in the best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Bloat of standard theme initialization configurable.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Simple default theme that can be easily replaced with your own.
- Lots of helpful stuff: helper functions, shortcodes, menus etc.

Note: this was intended primarily a development version for personal & client projects and for understanding how a WordPress theme is structured. 
While it contains a very basic template, it's likely this will be replace all or in part by a more detailed template such as with Bootstrap. 
It's there primarily to show the theme structure and to keep up with WordPress developments.

## Install

1. Upload the theme folder via FTP to your wp-content/themes/ directory.
2. Go to your WordPress dashboard and select Appearance.

## User Manual

I'll be updating this asap with details of available filters.

## Widget Areas

* Primary Sidebar - This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar - This is the widgeted area for the top right of the header.

## Support

Please visit the github page: https://github.com/ontiuk.

## Folder Structure

Out of the box it works as a standard theme with a very basic template. 
Uses a template restructure to move primary files to the route directory.
See https://core.trac.wordpress.org/ticket/13239 for potential/hopeful changes on template structure.

## Other Stuff

This is he precursor to 3 additional themes:
iPress-PT	- Parent Theme. As iPress-RD but with filterable / customisable theme options and a more refined file structure. To be used as a parent theme with customization / setup / styling via a child theme
iPress-PT2	- Parent Theme. As iPress-PT but primary options moved to the theme customizer for greater admin micro management.
iPress-NGx	- Theme Framework integrating iPress with Angular and the WosrPress WP-API

## Hooks - Filters

class-compat.php
-----------------
'ipress_theme_php'
- default minimum theme PHP version - default IPRESS_THEME_PHP 

'ipress_theme_wp
- default minimum theme WP version - default IPRESS_THEME_WP

class-content.php
-----------------
'ipress_starter_content'
- filter: Construct theme starter content - (array) default []
- adds starter-content theme support

class-custom.php
------------------
'ipress_custom_post_types',
- filter: Construct theme custom post types - (array) default []
- config driven post-type generation, see separate docs / config.php for parameters

'ipress_taxonomies'
- filter: Construct theme custom taxonomies - (array) default []
- config driven taxonomy generation, see separate docs / config.php for parameters

'ipress_custom_post_type_reserved'
- filter: Takes the codex list of reserved post-types

'ipress_custom_post_type_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values

'ipress_{post-type}_prefix
- filter: Generate a prefix for a custom post-type a-z, hyphen, underscore

'ipress_custom_taxonomy_reserved'
- filter: Takes the codex list of reserved post-types

'ipress_custom_taxonomy_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values

class-customizer.php
-----------------
'ipress_custom_logo';
- filter: turn on/off custom_logo theme support - (bool) default true

'ipress_custom_logo_args'
- filter: default args for add_theme_support( 'custom_logo' )

'ipress_custom_header';
- filter: turn on/off custom_logo theme support - (bool) default false

'ipress_custom_header_args'
- filter: default args for add_theme_support( 'custom-header' )

'ipress_default_headers';
- filter: register default headers - (bool) default false

'ipress_default_header_args'
- filter: default args for register_default_headers - default []

'ipress_default_background_color'
- filter: default custom background color - default 'ffffff'

'ipress_default_background_image'
- filter: default custom background image - default ''

'ipress_custom_background_args'
- filter: default args for add_theme_support( 'custom-background' )

'ipress_custom_css'
- filter: customizer css - default ''

ipress_customizer_css
- filter: customizer css - 2 params, custom styles && theme_mods

'ipress_theme_mods'
- filter: theme mods - (array) default []

'ipress_setting_default_values'
- filter: theme mods default values - (array) default []

class-dashboard.php
-----------------
'ipress_dashboard_post_types' 
- filter: add post-types to "At a glance" Dashboard widget - default []
- post-types must exist / be registered

class-images.php
-----------------
'ipress_media_images'
- filter: Image size media editor add custom image sizes - default [ 'image-in-post' => __( 'Image in Post', 'ipress' ), 'full'	=> __( 'Original size', 'ipress' ) ]
- should match custom images from add_images_size

'ipress_media_images_sizes'
- filter: Remove default image sizes - default sizes []

'ipress_upload_mimes'
- filter: Mime type support for file uploads - default [ 'svg' => 'mime/type' ] add svg support
- default to add SVG support

'ipress_gravatar'
- filter: (Gr)Avatar support - default []
- add as array ( 'name' => '', 'path' => '' )

class-init.php
-------------------
'ipress_header_clean'
- filter: Activate the WP header clean up - default false

'ipress_header_links'
- filter: Remove feed, rsd, manifest & shortlink links - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_index'
- filter: Remove noindex & rel link actions - default false
- Requires 'ipress_header_clean' to be true
	
'ipress_header_generator'
- filter: Disable XHTML generator - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_version'
- filter: Remove Versioning from scripts - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_css'
- filter: Clean CSS tags - from enqueued stylesheet - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_comments'
- filter: Remove inline Recent Comment Styles from wp_head() - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_canonical'
- filter: Disable canonical refereneces - default false
- Requires 'ipress_header_clean' to be true

'ipress_header_login'
- filter: Show less info to users on failed login for security - default false
- Requires 'ipress_header_clean' to be true

'ipress_disable_emojicons' 
- filter: disable theme emojicon support - default true 

'ipress_admin_bar'
- filter: hide the admin bar - default false
- options: 'all' - all users, 'users' - Non-admin users only

class-jetpack.php
-------------------
'ipress_jetpack_site_logo_args'
- filter: default args for add_theme_support( 'site-logo' )

'ipress_jetpack_infinite_scroll'
- filter: default args for add_theme_support( 'infinite-scroll' )

class-layout.php
-------------------
'ipress_theme_direction'
- filter: theme layout direction - default ''

'ipress_body_class'
- filter: add body class attributes - default []

'ipress_read_more_link'
- filter: read more link - default false

'ipress_view_more'
filter - custom view more link - default false

'ipress_view_more_link'
filter - custom view more link - default false

'ipress_embed_video'
filter - embed video html - default false

class-load-scripts.php
-----------------------

'ipress_scripts'
- filter: Initialise scripts via config file - default []
- Set up scripts list in config.php file, example provided

'ipress_support_old_ie'
- filter: Load IE conditional header scripts - default false
- html5-shiv & respond.js via cdn

'ipress_header_scripts'
- filter: Apply header scripts - default ''
- Must have <script></script> wrapper

'ipress_footer_scripts'
- filter: Apply footer scripts - default ''
- Must have <script></script> wrapper

'ipress_analytics_scripts'
- filter: Apply analytics scripts - default ''
- Must be valid analytics identifier: UA-XXXX
- Loads /template/global/analytics.php if set in child theme
- Loads analytics customizer theme mod if set

class-load-styles.php
-----------------------
'ipress_styles'
- filter: Initialise main styles via config file - default []
- Set up scripts list in config.php file, example provided

'ipress_fonts'
- filter: Load google API fonts from external source e.g. googleapi - default []

'ipress_fonts_url'
- filter: Set fonts url when loading external fonts - default: 'https://fonts.googleapis.com/css'

'ipress_show_conditional' ( deprecated )
- filter: Apply contitional styles - default false

'ipress_header_styles'
- filter: Apply inline header styles - default ''
- Loads 'ipress_header_styles' customizer theme mod if set

class-login.php
-------------------
'ipress_login_page'
- filter: Redirect the default login page - default [] uses WP login page

ipress_login_failed_page'
- filter: Custom login failed redirect- default [] uses WP login page

ipress_login_verify_page'
- filter: Custom login verify redirect - default [] uses WP login page

ipress_login_logout_page'
- filter: Custom login logout redirect - default [] uses WP login page

class-multisite.php
-------------------
'ipress_multisite_network_id'
- filter: Set up network user - should be network admin - default 1

'ipress_multisite_blogs'
- filter: Set up list of blogs - default generic blogs list

'ipress_multisite_sites'
- filter: Set up list of sites - default generics sites list

'ipress_multisite_description'
- filter: Set up blog description - default ''
- uses individual blog ID


class-navigation.php
-------------------

'ipress_nav_clean'
- filter: Clean navigation markup - Remove surrounding div - default false

'ipress_nav_css_attr'
- filter: Remove Injected classes, ID's and Page ID's from Navigation li items - default false

class-page.php
-------------------
'ipress_page_excerpt'
- filter: Page excerpt support: default false

'ipress_page_tags'
- filter: Page tags support: default false

'ipress_page_tags_query', false
- filter: Add page tags to query: default false

'ipress_search_types'
- filter: Add post-types to WordPress front search - default []

class-rewrites.php
-------------------
'ipress_query_vars'
- filter: Add new query vars - default []

class-sidebars.php
-------------------

'ipress_sidebar_defaults'
- filter: Override default sidebar wrappers: before & after widget, before & after title

'ipress_sidebar_xxx_defaults'
- filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID

'ipress_default_sidebars'
- filter: Default sidebars: default [ primary...]

'ipress_footer_widget_areas'
- filter: Default widget area number - default 3

'ipress_custom_sidebars'
- filter: Custom sidebars: default []

class-theme.php
-------------------
'ipress_content_width'
- filter: Content width: default 840

'ipress_post_thumbnails_post_types'
- filter: Add post-type to thumbnail support

'ipress_post_thumbnail_size'
- filter: Set thumbnail default size: width, height, crop - default []

'ipress_image_size_default'
- filter: Core image sizes overrides - default []

'ipress_add_image_size'
- filter: Add custom image sizes - default []

'ipress_nav_menu_default'
- filter: Set default nav menu - default [ primary ]

'ipress_nav_menus'
- filter: Register navigation menu locations - default [ 'primary' ]

'ipress_html5'
- filter: Enable support for HTML5 markup - default [x6]

'ipress_post_formats'
- filter: Register post-formats support - default false []

'ipress_theme_support'
- filter: Register additional theme support - default false []

'ipress_title_tag'
- filter: Add title-tag support - default true

'ipress_document_title_separator'
- filter: document title separator - default '-'
- requires: title-tag support

'ipress_home_doctitle_append'
- filter: append site description to title on homepage - default true
- requires: title-tag support

'ipress_doctitle_separator'
- filter: title separator - default ''
- requires: title-tag support

'ipress_append_site_name'
- filter: append site name to inner pages - default true
- requires: title-tag support

class-widgets.php
-------------------
'ipress_widgets'
- filter: custom widgets - default []

