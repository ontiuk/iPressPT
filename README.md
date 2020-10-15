iPress PT - WordPress Theme Framework 
=======================================

http://on.tinternet.co.uk

## About

iPressPT is a Parent Theme framework based on the iPress Rapid Development Theme Framework for WordPress.

Taking inspiration from other skeleton themes such as underscores, bones, and html5blank, as well as the latest default WordPress themes, 
this uses best practices in WordPress theme development to create a configurable and modular theme with a minimalist footprint.

- Theme set up with placeholders for important functionality.
- Modular file structure with separation of concerns.
- Clean folder and file structure.
- Structured hierarchy template structure with hooks: actions & filters
- Highly configurable class-based functionality hooking into core WordPress functionality
- Simple default theme that can be easily replaced with your own via child theme.
- Plugin integration: Woocommerce, Advanced Custom Fields, JetPack
- Lots of helpful stuff: helper functions, shortcodes, menus etc.

Note: this was intended primarily a development version for personal & client e-commerce projects. 
It contains a very basic css structure. This can be readily replace all or in part by structured framework such as Bootstrap. 
This is done through the Child theme. All styling & templating is transferred to the Child Theme.

## Install

1. Upload the theme folder via FTP to your wp-content/themes/ directory.
2. Upload the child theme folder via FTP to your wp-content/themes/ directory
3. Go to your WordPress dashboard and select Appearance.
4. Select and activate the child theme

## User Manual

Will be updating this asap with details of available filters on the dedicated ipress.uk site.

## Widget Areas

* Primary Sidebar - This is the primary sidebar.
* Secondary Sidebar - This is the secondary sidebar.
* Header Sidebar - This is the widgeted area for the top right of the header.

## Support

Please visit the github page: https://github.com/ontiuk.

## Other Stuff

iPress consists of 3 primary themes:
iPressPT	- Parent Theme. Not to be used on it's own. Designed to work with an iPressCT child theme.
iPressCT	- Child Theme. Requires iPressPT. Child themes can be configured and styled as required via a base template.
iPressST	- Standalone Theme. Integrates iPressPT and iPressCT. Used for standalone theme development.

Older deprecated but still functional themes:
iPress RD 
iPress RD2

Upcoming:
iPress-NG(x)- Theme Framework integrating iPress with Angular and the WordPress WP-API
iPress-RX	- Theme Framework integrating iPress with React and the WordPress WP-API

## Structure: Folders & Files

/
|-favicon.ico
|-functions.php
|-index.php
|-screenshot.jpg
|-style.css
|-/inc
|	|-blocks.php
|	|-bootstrap.php
| 	|-config.php
| 	|-functions.php
| 	|-shortcodes.php
| 	|-template-tags.php
| 	|-/classes
| 		|-class-blocks.php
| 		|-class-compat.php
| 		|-class-content.php
| 		|-class-custom.php
| 		|-class-customizer.php
| 		|-class-images.php
| 		|-class-init.php
| 		|-class-layout.php
| 		|-class-load-scripts.php
| 		|-class-load-styles.php
| 		|-class-login.php
| 		|-class-multisite.php
| 		|-class-navigation.php
| 		|-class-page.php
| 		|-class-query.php
| 		|-class-rewrite.php
| 		|-class-schema.php
| 		|-class-sidebars.php
| 		|-class-structured-data.php
| 		|-class-theme.php
| 		|-class-widgets.php
| 	|-/functions
|		|-content.php
|		|-image.php
|		|-navigation.php
|		|-pagination.php
|		|-schema.php
|		|-user.php
| 	|-/languages
| 	|-/lib
|		|-/acf
|		|-acf-config.php
| 	|-/shortcodes
|		|-analytics.php
|		|-category.php
|		|-date.php
|		|-links.php
|		|-media.php
|		|-post.php
|		|-search.php
|		|-user.php

##Structure: Files & Templates

/
|- functions.php
|- index.php

## Hooks - Filters

index.php
----------

'ipress_before_main_content'
'ipress_archive_before'
'ipress_archive_after'
'ipress_sidebar'
'ipress_after_main_content'	
'main' class: index-page

class-compat.php
-----------------
Initialise and set up theme compatibility functionality.

'ipress_theme_php'
- minimum theme PHP version
- default, IPRESS_THEME_PHP set in bootstrap.php.

'ipress_theme_wp'
- minimum theme WP version
- default IPRESS_THEME_WP set in bootstrap.php.

class-content.php
-----------------
Set up theme starter content via starter-content theme support.

'ipress_starter_content'
- filter: Construct theme starter content - (array) default [].
- adds 'starter-content' theme support if active.

class-custom.php
------------------
Initialize theme specific custom post-types and taxonomies. In general custompost-types and taxonomies should be created
using a plugin, so that their creation is theme agnostic. However it is sometimes the case that these are specific to the
theme and integral to it's functionality so they can be more tightly linked to the child theme itself.

'ipress_custom_post_types'
- filter: Construct theme custom post-types - (array) default [].
- config driven post-type generation, see separate docs / config.php for parameters.

'ipress_taxonomies'
- filter: Construct theme custom taxonomies - (array) default [].
- config driven taxonomy generation, see separate docs / config.php for parameters.

'ipress_custom_post_type_reserved'
- filter: Takes the codex list of reserved post-types.

'ipress_custom_post_type_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values.

'ipress_{post-type}_prefix
- filter: Generate a prefix for a custom post-type a-z, hyphen, underscore.

'ipress_{post-type}_labels'
- filter: Takes the generated post-type labels array.

'ipress_{post-type}_supports'
- filter: Takes the default post-type supports: default 'title', 'editor', 'thumbnails'.

'ipress_taxonomy_reserved'
- filter: Takes the codex list of reserved post-types.

'ipress_taxonomy_valid_args'
- filter: Takes the codes list of valid 'register_post_type' args parameter values.

'ipress_{taxonomy}_labels'
- filter: Takes the generated taxonomy labels array.

'ipress_post_type_messages'
- filter: Messages Callback - default [].

'ipress_{$screen->id}_help'
- filter: Contextual help tabs.

class-customizer.php
---------------------
Initialize theme WordPress theme customizer features.

'ipress_custom_logo';
- filter: Enable custom_logo theme support - (bool) default true.

'ipress_custom_logo_args'
- filter: Default args for add_theme_support( 'custom_logo' ).

'ipress_custom_header'
- filter: Enable custom_header theme support - (bool) default false.

'ipress_custom_header_default_image'
- filter: Set the default header image, default header.png.

'ipress_custom_header_args'
- filter: Default args for add_theme_support( 'custom-header' ).

'ipress_custom_header_uploads'
- filter: Enable custom header uploads, default false.
- Requires custom headers to be enabled.

'ipress_default_headers';
- filter: Register default headers - (bool) default false.

'ipress_default_header_args'
- filter: Default args for register_default_headers - default [].

'ipress_custom_background'
- filter: Enable support for custom backgrounds - default false.

'ipress_custom_background_default_image'
- filter: Custom background default image, default empty.
- Requires custom background to be enabled.

'ipress_custom_background_default_color'
- filter: Custom background default color, default #fff.
- Requires custom background to be enabled.

'ipress_custom_background_args'
- filter: Default args for add_theme_support( 'custom-background' ).
- Takes defaults from default image and default colour filters.

'ipress_custom_selective_refresh'
- filter: Enable theme support for 'selective_refresh'.

'ipress_customize_header_partials'
- filter: Enable selective refresh for header partials.

class-images.php
-----------------
Initialize theme custom images & core images functionality.

'ipress_media_images'
- filter: Image size media editor add custom image sizes.
- default [ 'image-in-post' => __( 'Image in Post', 'ipress' ), 'full'	=> __( 'Original size', 'ipress' ) ].
- should match custom images from add_images_size.

'ipress_media_images_sizes'
- filter: Remove default image sizes.
- default sizes [] - thumbnail / medium / large.

'ipress_upload_mimes'
- filter: Add / Remove Mime type support for file uploads.
- default [ 'svg' => 'mime/type' ] add svg support, default to add SVG support.

'ipress_custom_mimes_restricted'
- filter: Set mime types that are restricted to admin only upload, default [].

'ipress_custom_gravatar'
- filter: (Gr)Avatar support - default []. 
- add as array ( 'name' => '', 'path' => '' ).

class-init.php
-------------------
Initialisation theme header fuctionality with core WordPress features.

'ipress_header_clean'
- filter: Activate the WP header clean up - default false.

'ipress_header_links'
- filter: Remove feed, rsd, manifest & shortlink links - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_index'
- filter: Remove noindex & rel link actions - default false.
- Requires 'ipress_header_clean' to be true.
	
'ipress_header_generator'
- filter: Disable XHTML generator - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_version'
- filter: Remove Versioning from scripts - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_css'
- filter: Clean CSS tags - from enqueued stylesheet - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_comments'
- filter: Remove inline Recent Comment Styles from wp_head() - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_canonical'
- filter: Disable canonical refereneces - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_header_login'
- filter: Show less info to users on failed login for security - default false.
- Requires 'ipress_header_clean' to be true.

'ipress_login_info'
- filter: Generate custom text for login error - default '<strong>ERROR</strong>: Stop guessing!'.

'ipress_disable_emojicons' 
- filter: disable theme emojicon support - default true.

class-layout.php
-------------------
Initialize theme layour features with core WordPress functionality.

'ipress_theme_direction'
- filter: theme layout direction - default ''.

'ipress_breadcrumbs'
- filter: add breadcrumbs body class if breadcrumbs active.

'ipress_body_class'
- filter: add body class attributes - default [].

'ipress_read_more_link'
- filter: read more link - default false.

'ipress_view_more'
filter - custom view more link - default false.

'ipress_view_more_link'
filter - custom view more link - default ''.

'ipress_embed_video'
filter - embed video html - default html.

class-load-scripts.php
-----------------------
Initialize theme and plugin scripts.

'ipress_scripts'
- filter: Initialise scripts via config file - default [].
- Set up scripts list in config.php file, example provided.

'ipress_scripts_core'
- filter: Set core scripts for enqueueing.

'ipress_comment_reply'
- filter: Turn comments on/off, default true.

'ipress_scripts_local'
- filter: Set local scripts for enqueing via inline script, default [].

'ipress_header_scripts'
- filter: Apply header scripts - default ''. 
- loads: Theme mod - 'ipress_header_js'.
- Must have <script></script> wrapper.

'ipress_footer_scripts'
- filter: Apply footer scripts - default ''.
- loads: Theme mod - 'ipress_footer_js'.
- Must have <script></script> wrapper.

'ipress_header_admin_scripts'
- filter: Apply header admin scripts - default ''. 
- loads: Theme mod - 'ipress_header_admin_js'.
- Must have <script></script> wrapper.

'ipress_footer_admin_scripts'
- filter: Apply footer admin scripts - default ''. 
- loads: Theme mod - 'ipress_footer_admin_js'.
- Must have <script></script> wrapper.

class-load-styles.php
-----------------------
Initialize theme and plugin styles and fonts.

'ipress_styles'
- filter: Initialise main styles via config file - default [].
- Set up scripts list in config.php file, example provided.

'ipress_fonts'
- filter: Load google API fonts from external source e.g. googleapi - default [].

'ipress_fonts_url'
- filter: Set fonts url when loading external fonts - default: 'https://fonts.googleapis.com/css'.

'ipress_header_styles'
- filter: Apply inline header styles - default ''.
- Loads: Theme Mod - 'ipress_header_styles'.

'ipress_header_admin_styles'
- filter: Apply inline header admin styles - default ''.
- Loads: Theme Mod - 'ipress_header_admin_styles'. 

"ipress_{$k}_style_data"
- filter: Add inline styling data.

class-login.php
-------------------
Initialisation login page custom features and redirects

'ipress_login_page'
- filter: Redirect the default login page.
- default [] uses WP login page.

ipress_login_failed_page'
- filter: Custom login failed redirect.
- default [] uses WP login page.

ipress_login_verify_page'
- filter: Custom login verify redirect.
- default [] uses WP login page.

ipress_login_logout_page'
- filter: Custom login logout redirect.
- default [] uses WP login page.

class-multisite.php
-------------------
Initialize MultiSite features if theme is multisite enabled.

'ipress_multisite_blogs'
- filter: Set up list of blogs.
- default generic blogs list.

'ipress_multisite_description'
- filter: Set up blog description.
- default individual blog ID.

'ipress_multisite_sites'
- filter: Set up list of sites.
- default generics sites list.

class-navigation.php
-------------------
Initialisation theme navigation features.

'ipress_nav_clean'
- filter: Clean navigation markup & remove surrounding 'div', default false.

'ipress_nav_css_attr'
- filter: Remove Injected classes, ID's and Page ID's from Navigation li items, default false.

class-page.php
-------------------
Initialize theme page tag & excerpt support.

'ipress_page_excerpt'
- filter: Page excerpt support, default false.

'ipress_page_tags'
- filter: Page tags support, default false.

'ipress_page_tags_query', false
- filter: Add page tags to query, default false.

'ipress_search_post_types'
- filter: Add post-types to WordPress front search, default [].

class-rewrites.php
-------------------
Initialize theme rewrites and query_vars.

'ipress_query_vars'
- filter: Add new query vars, default [].

class-schema.php
-----------------
Initialise Schema Microdata for selected html tags and elements.

'ipress_schema_head'
- filter: Set schema microdata for 'head' tag.

'ipress_schema_body'
- filter: Set schema microdata for 'body' tag.

'ipress_schema_site-header'
- filter: Set schema microdata for 'header' tag.

'ipress_schema_site-title'
- filter: Set schema microdata for 'site-title' element.

'ipress_schema_site-description'
- filter: Set schema microdata for 'site-descripton' element.

'ipress_schema_breadcrumb'
- filter: Set schema microdata for site breadcrumbs element.

'ipress_schema_breadcrumb-item'
- filter: Set schema microdata for site breadcrumbs list item element.

'ipress_schema_breadcrumb-link'
- filter: Set schema microdata for site breadcrumbs list item link element.

'ipress_schema_breadcrumb-text'
- filter: Set schema microdata for site breadcrumbs list item text element.

'ipress_schema_search-form'
- filter: Set schema microdata for site search 'form' tag.

'ipress_schema_search-form-meta'
- filter: Set schema microdata for site search form meta element.

'ipress_schema_search-form-input'
- filter: Set schema microdata for site search form 'input' tag.

'ipress_schema_nav-item'
- filter: Set schema microdata for site navigation 'nav' tag.

'ipress_schema_article'
- filter: Set schema microdata for 'article' tag.

'ipress_schema_article-title'
- filter: Set schema microdata for article title element.

'ipress_schema_article-image'
- filter: Set schema microdata for article img tag.

'ipress_schema_widget-image'
- filter: Set schema microdata for widget image element.

'ipress_schema_article-author'
- filter: Set schema microdata for article author element.

'ipress_schema_article-author-link'
- filter: Set schema microdata for article author link element.

'ipress_schema_article-author-name'
- filter: Set schema microdata for article author name attr element.

'ipress_schema_article-time'
- filter: Set schema microdata for article author 'time' tag.

'ipress_schema_article-modified-time'
- filter: Set schema microdata for article author 'time' tag with modified date.
 
'ipress_schema_article-content'
- filter: Set schema microdata for article content element.

'ipress_schema_comment'
- filter: Set schema microdata for article comment element.

'ipress_schema_sidebar'
- filter: Set schema microdata for sidebar 'aside' tag.

'ipress_schema_site-footer'
- filter: Set schema microdata for 'footer' tag.

'ipress_schema_disable'
- filter: Selected elements to remove from the schema microdata, default [].
- Requires that the Schema microdata is active.

'ipress_schema_{$element}'_
- filter: Update element schema data if required.

class-sidebars.php
-------------------
Initialize theme sidebars and widget areas.

'ipress_sidebar_defaults'
- filter: Override default sidebar wrappers: before & after widget, before & after title.

'ipress_sidebar_{sidebar-id}_defaults'
- filter: Dynamic sidebar defaults - takes sidebar defaults and sidebar ID.

'ipress_default_sidebars'
- filter: Default sidebars: default [ primary...].

'ipress_footer_widget_areas'
- filter: Default footer widget area number - default 3.

'ipress_custom_sidebars'
- filter: Register custom sidebars: default [].

class-theme.php
-------------------
Initialize core theme settings.

'ipress_content_width'
- filter: Content width: default 840.

'ipress_feed_links_support'
- filter: Add 'feed-link' theme support, default true.

'ipress_post_thumbnails_support'
- filter: Add 'post thumbnails' theme support, default true.

'ipress_post_thumbnails_post_types'
- filter: Add post-type to thumbnail support.
- Requires post thumbnail support to be active.

'ipress_post_thumbnail_size'
- filter: Set thumbnail default size: width, height, crop, default [].
- Requires post thumbnail support to be active.

'ipress_image_size_default'
- filter: Core image sizes overrides, default [].
- Requires post thumbnail support to be active.

'ipress_add_image_size'
- filter: Add custom image sizes, default [].
- Requires post thumbnail support to be active.

'ipress_big_image_size
- filter: Turn off 'big image' theme support, default true.
- Requires post thumbnail support to be active.

'ipress_menus_support'
- filter: Add nav manus theme support, default true.

'ipress_nav_menu_default'
- filter: Set default nav menu, default [ primary ].
- Requires nav menus support to be active.

'ipress_nav_menus'
- filter: Register custom navigation menu locations, default [].
- Requires nav menus support to be active.

'ipress_html5'
- filter: Enable support for HTML5 markup, default [x6].

'ipress_post_formats'
- filter: Register post-formats support, default false [].

'ipress_theme_support'
- filter: Register additional theme support, default false [].

'ipress_title_tag'
- filter: Add title-tag support, default true.

'ipress_document_title_separator'
- filter: document title separator, default '-'.
- requires: title-tag support.

'ipress_home_doctitle_append'
- filter: append site description to title on homepage, default true.
- requires: title-tag support.

'ipress_doctitle_separator'
- filter: title separator, default ''.
- requires: title-tag support.

'ipress_append_site_name'
- filter: append site name to inner pages, default true.
- requires: title-tag support.

class-widgets.php
-------------------
Initialisation and register theme widgets.

'ipress_widgets'
- filter: custom widgets, default [].

