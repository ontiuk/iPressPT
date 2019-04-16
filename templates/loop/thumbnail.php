<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the post loop thumbnail image.
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>

<?php
// No featured image?
if ( ! has_post_thumbnail() ) { return; }

// Get image details
$thumb_id   = get_post_thumbnail_id( get_the_ID() );
if ( ! $thumb_id ) { return; }

// Get image 
$thumb_size = apply_filters( 'post_thumbnail_size', 'post-thumbnail', get_the_ID() );
$image = wp_get_attachment_image_src( $thumb_id, $thumb_size ); 

// Display if ok
if ( $image ) :
    $meta 		= ipress_get_attachment_meta( $thumb_id );
    $alt    	= ( empty( $meta['alt'] ) ) ? '' : $meta['alt'];
    $caption    = ( empty( $meta['caption'] ) ) ? '' : $meta['caption'];
?>
<figure class="post-thumbnail">
	<a href="<?= esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1" >
		<img src="<?= $image[0]; ?>" class="img-fluid" alt="<?= $alt; ?>" />
	</a>
	<?php if ( $caption ) : ?>
	<figcaption><?= $caption; ?></figcaption>
	<?php endif; ?>
</figure>
<?php endif;
