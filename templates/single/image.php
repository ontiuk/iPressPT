<?php

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template part for displaying post image in single.php.
 *
 * @package     iPress\Templates
 * @see         https://codex.wordpress.org/Template_Hierarchy
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
// No featured image?
if ( ! has_post_thumbnail() ) { return; }

// Get image details
$image_id = get_post_thumbnail_id( get_the_ID() );
if ( ! $image_id ) { return; }

// Get image
$image_size = apply_filters( 'page_image_size', 'large', get_the_ID() );
$image = wp_get_attachment_image_src( $image_id, $image_size ); 

// Display if OK
if ( $image ) :
	$meta 	= ipress_get_attachment_meta( $image_id );
    $alt    = ( empty( $meta['alt'] ) ) ? '' : $meta['alt'];
?>
<div class="entry-image">
	<img src="<?= $image[0]; ?>" alt="<?= $alt; ?>" />
</div>
<?php endif;
