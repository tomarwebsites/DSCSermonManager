<?php
if ( ! function_exists( 'great_slider' ) ) :
/**
 * display featured post slider
 */
function great_slider() { ?>
<div class="site-slider">
	<div class="slider-wrap">
		<div class="slider-cycle">
			<?php
			for( $i = 1; $i <= 10; $i++ ) {
				$slide_this_page = get_theme_mod( 'slide_this'.$i , '' );
				
				if( has_post_thumbnail( $slide_this_page ) &&
					$slide_this_page != '' &&
					$slide_this_page != 'great_hide_this'	) {

					// Get page content by id
					$post = get_post($slide_this_page); 
					$great_slider_text = apply_filters('the_content', $post->post_content);
					
					$great_slider_title = esc_attr( $post->post_title );
					
					// Slide Icon
					
					$icon = "";
					if ( get_theme_mod( 'slide_icon'.$i, false ) )
						$icon = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod( 'slide_icon'.$i )) );
					
					// Slide url
					$great_slide_link = get_theme_mod( 'slide_link'.$i , false );
					if ( $great_slide_link == '' or $great_slide_link == false )
						$great_slide_link = get_permalink( $post->ID );
						
					// Get post fetured image
					$great_slider_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					
					// Hide texts
					$class_text = '';
					if ( get_theme_mod( 'disable_slider_text', 0 ) )
						$class_text = 'displaynone';
					
					// Class
					if ( $i == 1 ) {
						$classes = "slides displayblock"; }
					else {
						$classes = "slides displaynone"; }?>
					<section id="featured-slider" class="<?php echo $classes; ?>">
						<figure class="slider-image-wrap">
                        	<a href="<?php echo esc_url( $great_slide_link ); ?>">
							<img alt="<?php echo esc_attr( $great_slider_title ); ?>" src="<?php echo esc_url( $great_slider_image ); ?>" />
                            </a>
					    </figure>
					    <?php if( !empty( $great_slider_title ) || !empty( $great_slider_text ) ) { ?>
						    <article id="slider-text-box">
					    		<div class="inner-wrap">
						    		<div class="slider-text-wrap <?php echo $class_text;?>">
						    			<?php if( !empty( $great_slider_title )  ) { ?>
							     			<span id="slider-title" class="clearfix"><a title="<?php echo esc_attr( $great_slider_title ); ?>" href="<?php echo esc_url( $great_slide_link ); ?>"><?php echo $icon . esc_html( $great_slider_title ); ?></a></span>
							     		<?php } ?>
							     		<?php if( !empty( $great_slider_text )  ) { ?>
							     			<span id="slider-content"><?php echo wp_kses_post( $great_slider_text ); ?></span>
							     		<?php } ?>
							     	</div>
							    </div>
							</article>
						<?php } ?>
					</section><!-- .featured-slider -->
				<?php
				}
			}
			?>
		</div>
		<nav id="controllers" class="clearfix">
		</nav><!-- #controllers -->
	</div><!-- .slider-cycle -->
</div><!-- .site-slider -->
<?php
}
endif;

?>