<?php

/**
 * Show Clients Widget
 * Great Theme
 */
class great_clients_widget extends WP_Widget
{
	 function great_clients_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Clients','great') );
            $widget_ops = array('classname' => 'great-clients','description' => esc_html__( "This widget displays your clients." ,'great') );
            parent::__construct('great-clients', esc_html($widget_title), $widget_ops);
            
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
            <?php if ( get_theme_mod("clients_header") or get_theme_mod("clients_description") ): ?>
            	<?php
                if ( get_theme_mod("clients_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("clients_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("clients_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("clients_description"));?></div>
                </div>
            <?php endif;?>
            
            <div class="items clients">
                <div class="owl-clients owl-carousel owl-theme">
                <?php
                for( $i = 1; $i <= 15; $i++ ) {
                    $item = '';
                   
                    if (get_theme_mod('client_logo'.$i, false ))
                    $item.= sprintf('<div class="image"><img src="%s" alt="%s" /></div>',
                                    esc_url(get_theme_mod('client_logo'.$i)), esc_attr(get_theme_mod('client_title'.$i)) );
                    
                    if (get_theme_mod('client_title'.$i, false ))
                    $item.= sprintf( '<div class="title">%s</div>', esc_attr(get_theme_mod('client_title'.$i)) );
                    
                    if (!empty($item)) printf( '<div class="carousel-item">%s</div>', $item );
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