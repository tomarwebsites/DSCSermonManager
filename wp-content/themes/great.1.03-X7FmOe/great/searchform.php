<?php
/**
 * The template for displaying search forms
 *
 */
?>
<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php echo _e( 'Search for:', 'great' ); ?></span>
	</label>
	<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo _e( 'Search &hellip;', 'great' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-submit" title="<?php _e( 'Search', 'great' ); ?>">
    	<i class="fa fa-search" aria-hidden="true"></i><span class="screen-reader-text"><?php _e( 'Search', 'great' ); ?></span>
    </button>
</form>
<div class="clear"></div>