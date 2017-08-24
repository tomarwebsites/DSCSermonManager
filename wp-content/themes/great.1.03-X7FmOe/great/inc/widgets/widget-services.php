<?php

/**
 * Show Services Widget
 * Great Theme
 */
class great_services_widget extends WP_Widget
{
	 function great_services_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Services','great') );
            $widget_ops = array('classname' => 'great-services','description' => esc_html__( "This widget displays your services." ,'great') );
            parent::__construct('great-services', esc_html($widget_title), $widget_ops);
            
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
        
            <?php if ( get_theme_mod("services_header") or get_theme_mod("services_description") ): ?>
            	<?php
                if ( get_theme_mod("services_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("services_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("services_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("services_description"));?></div>
                </div>
            <?php endif;?>
            
            <div class="items services">
            <?php
            for( $i = 1; $i <= 3; $i++ ) {
                $item = '';
                $icon_color = '';
                if (get_theme_mod('service_icon_color'.$i, false))
                $icon_color = sprintf( 'background-color:%s', esc_attr(get_theme_mod('service_icon_color'.$i)) );
                
                if (get_theme_mod('service_icon'.$i, true))
                $item.= sprintf( '<div class="icon" style="%1$s"><i class="fa %2$s"></i></div>', $icon_color, esc_attr(get_theme_mod('service_icon'.$i, 'fa-star')) );

                if (get_theme_mod('service_title'.$i, false ))
                $item.= sprintf( '<div class="title">%s</div>', esc_attr(get_theme_mod('service_title'.$i)) );
                
                if (get_theme_mod('service_description'.$i, false ))
                $item.= sprintf( '<div class="desc">%s</div>', esc_attr(get_theme_mod('service_description'.$i)) );
                
                if (!empty($item)) printf( '<div class="item">%s</div>', $item );
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