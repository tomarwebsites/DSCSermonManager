<?php

/**
 * Show Slider Widget
 * Great Theme
 */
class great_slider_widget extends WP_Widget
{
	 function great_slider_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Slider','great') );
            $widget_ops = array('classname' => 'great-slider','description' => esc_html__( "Its shows the Great theme slider and works only front page" ,'great') );
            parent::__construct('great-slider', esc_html($widget_title), $widget_ops);
            
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
		great_slider();
		
        echo $after_widget;
    }

    function form($instance) {
		?>
        <p><?php echo __('Visit customizer for settings.','great') ?></p>
		<?php
    }

}
?>