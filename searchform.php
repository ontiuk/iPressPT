<?php

/**
 * Template for displaying the standard search form
 *
 * @package		iPress
 * @link		http://ipress.uk
 * @license		GPL-2.0+
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?= esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?= $unique_id; ?>"><?= _x( 'Search for:', 'label', 'ipress' ); ?></label>
	<input type="search" id="<?= $unique_id; ?>" class="search-field" placeholder="<?= esc_attr_x( 'Search &hellip;', 'placeholder', 'ipress' ); ?>" value="<?= get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit"><?= _x( 'Search', 'ipress' ); ?><span class="screen-reader-text"><?= _x( 'Search', 'submit button', 'ipress' ); ?></span></button>
</form>
