<?php

/**
 * Show About Us Widget
 * Great Theme
 */
class great_about_widget extends WP_Widget
{
	 function great_about_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('About','great') );
            $widget_ops = array('classname' => 'great-about','description' => esc_html__( "This widget displays an about page." ,'great') );
            parent::__construct('great-about', esc_html($widget_title), $widget_ops);
            
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
        
            <?php if ( get_theme_mod("about_header") or get_theme_mod("about_description") ): ?>
            	<?php
                if ( get_theme_mod("about_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("about_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("about_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("about_description"));?></div>
                </div>
            <?php endif;?>
            
            <div class="about-page" style="text-align:<?php echo esc_attr(get_theme_mod("about_text_alignment"),'center');?>;">
				<?php
				$page = get_theme_mod( 'about_source' , false );
				if ( $page && $page != "great_hide_this" ) {
					// Get page content by id
					$post = get_post($page); 
					$title = esc_attr( $post->post_title );
					$content = apply_filters('the_content', $post->post_content);
					echo $content;
				}
                ?>                	
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