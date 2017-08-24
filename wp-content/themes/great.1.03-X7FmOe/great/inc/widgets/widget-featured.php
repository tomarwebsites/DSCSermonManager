<?php

/**
 * Show Featured Pages Widget
 * Great Theme
 */
class great_featured_widget extends WP_Widget
{
	 function great_featured_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Featured Pages','great') );
            $widget_ops = array('classname' => 'great-featured','description' => esc_html__( "This widget displays featured pages." ,'great') );
            parent::__construct('great-featured', esc_html($widget_title), $widget_ops);
            
    }

    function widget($args , $instance) {
    	extract($args);
		//$title = isset($instance['title']) ? $instance['title'] : esc_html__('Follow us' , 'great');

		echo $before_widget;
		//echo $before_title;
		//echo $title;
		//echo $after_title;

        /**
         * Widget Content
         */
		?>
        <div class="great-widget-wrap">
            <?php if ( get_theme_mod("featured_header") or get_theme_mod("featured_description") ): ?>
            	<?php
                if ( get_theme_mod("featured_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("featured_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("featured_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("featured_description"));?></div>
                </div>
            <?php endif;?>
            <?php great_featured_pages ();?>                	
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