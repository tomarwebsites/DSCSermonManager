<?php

/**
 * Show Projects Widget
 * Great Theme
 */
class great_projects_widget extends WP_Widget
{
	 function great_projects_widget(){
            $widget_title = sprintf( "&diams; %s &rarr; %s", __('Great','great'), __('Projects','great') );
            $widget_ops = array('classname' => 'great-projects','description' => esc_html__( "This widget displays your projects." ,'great') );
            parent::__construct('great-projects', esc_html($widget_title), $widget_ops);
            
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
        
            <?php if ( get_theme_mod("projects_header") or get_theme_mod("projects_description") ): ?>
            	<?php
                if ( get_theme_mod("projects_header_icon") ) $i = sprintf('<i class="fa %s"></i> ', esc_attr(get_theme_mod("projects_header_icon")) );
                else $i = "";
                ?>
                <div class="intro">
                    <div class="title"><?php echo $i . esc_attr(get_theme_mod("projects_header"));?></div>
                    <div class="desc"><?php echo esc_attr(get_theme_mod("projects_description"));?></div>
                </div>
            <?php endif;?>
            
            <div class="items projects">
            <?php
            for( $i = 1; $i <= 3; $i++ ) {
                $item = '';
                $color = '';
                if (get_theme_mod('project_color'.$i, false))
                $color = sprintf( 'border-color:%s;', esc_attr(get_theme_mod('project_color'.$i)) );
                
                if (get_theme_mod('project_image'.$i, false ))
                $item.= sprintf('<div class="image"><img style="%s" src="%s" alt="%s" /></div>',
                                $color, esc_url(get_theme_mod('project_image'.$i)), esc_attr(get_theme_mod('project_title'.$i)) );
                
                if (get_theme_mod('project_title'.$i, false ))
                $item.= sprintf( '<div class="title">%s</div>', esc_attr(get_theme_mod('project_title'.$i)) );
                
                if (get_theme_mod('project_description'.$i, false ))
                $item.= sprintf( '<div class="desc">%s</div>', esc_attr(get_theme_mod('project_description'.$i)) );
                
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