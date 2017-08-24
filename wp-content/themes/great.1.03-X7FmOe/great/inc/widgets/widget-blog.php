<?php

/**
 * Shows Your Latest Blogs Widget
 * Great Theme
 */
class great_blog_widget extends WP_Widget
{
	 function great_blog_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Blog','great') );
            $widget_ops = array('classname' => 'great-blog','description' => esc_html__( "This widget displays your latest blogs." ,'great') );
            parent::__construct('great-blog', esc_html($widget_title), $widget_ops);
            
    }

    function widget($args , $instance) {
    	extract($args);
		echo $before_widget;
		//echo $before_title;
		//echo $title;
		//echo $after_title;

        /**
         * Widget Content
         */
		?>
        <div class="great-widget-wrap">
            <?php if ( get_theme_mod("blog_header") or get_theme_mod("blog_description") ): ?>
				<?php
                if ( get_theme_mod("blog_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("blog_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("blog_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("blog_description"));?></div>
                </div>
            <?php endif;?>
            
            <div class="items blog">
                <div class="owl-blog owl-carousel owl-theme">
                <?php
                // Get posts from category
                $args = array( 'cat' => esc_attr(get_theme_mod('blog_source_category',1)), 'posts_per_page' => 15 );
                $posts = new WP_Query( $args );
                if ( $posts->have_posts() ) {
                    while ( $posts->have_posts() ) {
                        $posts->the_post();
                        $item = '';
                        
                        if ( has_post_thumbnail() )
                            $item.= sprintf('<div class="image">%s</div>', get_the_post_thumbnail() );
                            
                        $item.= sprintf('<div class="posted-on"><i class="fa fa-calendar"></i> %s</div>', get_the_date() );
                        
                        $item.= sprintf( '<div class="title">%s</div>', get_the_title() );
                        
                        $item.= sprintf( '<div class="excerpt">%s</div>', get_the_excerpt() );
                        
                        printf( '<div class="item"><a href="%s">%s</a></div>', get_the_permalink(), $item );
                    }

                    // Restore original Post Data
                    wp_reset_postdata();
                }
                ?>
                </div>            	
            </div>
            
        </div>
        <?php
		
        echo $after_widget;
    }

    function form($instance) {
		?>
        <p><?php echo __('Visit customizer for settings.','great') ?></p>
		<?php
    }

}
?>