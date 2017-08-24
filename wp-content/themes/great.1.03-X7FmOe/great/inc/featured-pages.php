<?php
if ( ! function_exists( 'great_featured_pages' ) ) :
/**
 * display featured pages
 */
function great_featured_pages () {?>
<div class="featured-wrap items">
<?php
for( $i = 1; $i <= 3; $i++ ) {
	$page = get_theme_mod( 'featured_page'.$i , '' );
	if( has_post_thumbnail( $page ) &&
		$page != '' &&
		$page != 'great_hide_this'	):

		// Get page content by id
		$post = get_post($page); 
		$title = esc_attr( $post->post_title );
		$text = get_theme_mod( 'featured_alternative_text'.$i , false );
		if ( $text == '' or $text == false ) {
			$text = apply_filters('the_content', $post->post_content);
		} else {
			$text = "<p>$text</p>";
		}
		
		// Slider url
		$link = get_theme_mod( 'featured_link'.$i , false );
		if ( $link == '' or $link == false )
			$link = get_permalink( $post->ID );
						
		// Get post fetured image
		$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		
		// Buttton
		$button_bg = $button_color = '';
		$button_text = get_theme_mod( 'featured_button_text'.$i , __('Learn More', 'great') );
		if ( get_theme_mod( 'featured_button_bg'.$i ) )
			$button_bg = get_theme_mod( 'featured_button_bg'.$i );
		if ( get_theme_mod( 'featured_button_color'.$i ) )
			$button_color = get_theme_mod( 'featured_button_color'.$i );
		
		?>
        
        <div class="item-wrap">
        	<div class="image" style="background-image:url(<?php echo esc_url( $image ); ?>);">
            	<a href="<?php echo esc_url( $link ); ?>">
                <img alt="<?php echo esc_attr( $title ); ?>" src="<?php echo esc_url( $image ); ?>" />
                </a>
            </div>
            
            <div class="title">
            	<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_attr( $title );?></a>
            </div>
            
        	<div class="text">
            	<?php echo wp_kses_post($text);?>
            </div>
            
            <div class="button">
            	<a style="background:<?php echo esc_attr($button_bg);?>; color:<?php echo esc_attr($button_color);?>;"
                href="<?php echo esc_url( $link ); ?>">
				<?php echo esc_attr( $button_text );?></a>
            </div>
        </div><!-- .item-wrap-->
	<?php
	endif;		
} // end for
?>
</div><!-- .featured-wrap -->
<?php
} // end function
endif;

?>