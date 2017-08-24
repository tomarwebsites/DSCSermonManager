<?php
/**
 * Customizer Custom Control Class for Font Awesome Icons Fieald
 */
if( ! class_exists('CeeWP_Customize_FontAwesome_Control')) {
	class CeeWP_Customize_FontAwesome_Control extends WP_Customize_Control {
		public $type = 'fa';
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <div class="fa-icp">
                <input type="text" data-placement="bottom" data-input-search="true" class="icp icp-auto" <?php $this->link(); ?>
                value="<?php echo esc_attr( $value );?>" />
                <span class="input-group-addon"></span>
                </div>
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Disabled Text Fieald
 */
if( ! class_exists('CeeWP_Customize_Disabled_Text_Control')) {
	class CeeWP_Customize_Disabled_Text_Control extends WP_Customize_Control {
		public $type = 'disabled-text';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php printf('<span class="alvele-premium"><i class="fa fa-star"></i> <a target="_blank" href="%1$s">%2$s</a></span>',
				esc_url( 'http://ceewp.com/our-themes/great-pro' ),
				__( 'Upgrade', 'great' )
				);?>
                <input type="text" readonly="readonly" <?php $this->link(); ?>
                value="<?php echo esc_attr( $value );?>" />
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Disabled Dropdown
 */
if( ! class_exists('CeeWP_Customize_Disabled_Checkbox_Control')) {
	class CeeWP_Customize_Disabled_Checkbox_Control extends WP_Customize_Control {
		public $type = 'disabled-checkbox';

		public function render_content() {
			?>
			<label>
				<!--<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>-->
                <?php printf('<span class="alvele-premium"><i class="fa fa-star"></i> <a href="%1$s">%2$s</a></span>',
				esc_url( 'http://ceewp.com/our-themes/great-pro' ),
				__( 'Upgrade', 'great' )
				);?>
                <input type="checkbox" disabled="disabled" readonly="readonly" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />
                <?php echo esc_attr($this->label); ?>
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Disabled Dropdown
 */
if( ! class_exists('CeeWP_Customize_Rangeslider_Control')) {
	class CeeWP_Customize_Rangeslider_Control extends WP_Customize_Control {
		public $type = 'rangeslider';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php
                $min = isset($this->choices['min']) ? $this->choices['min'] : '0';
				$max = isset($this->choices['max']) ? $this->choices['max'] : '100';
				printf( '<div class="range-slider" data-min="%1$s" data-max="%2$s" data-value="%3$s">', esc_attr($min), esc_attr($max), esc_attr($this->value()) );
				?>
                <div class="ui-slider-handle"></div>
                </div><!-- .range-slider-->
                
                <input type="hidden" class="slide-val" <?php $this->link();?> value="<?php echo esc_attr($this->value());?>">
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Disabled Dropdown
 */
if( ! class_exists('CeeWP_Customize_Disabled_Select_Control')) {
	class CeeWP_Customize_Disabled_Select_Control extends WP_Customize_Control {
		public $type = 'disabled-select';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php printf('<span class="alvele-premium"><i class="fa fa-star"></i> <a href="%1$s">%2$s</a></span>',
				esc_url( 'http://ceewp.com/our-themes/great-pro' ),
				__( 'Upgrade', 'great' )
				);?>
				<select <?php $this->link(); ?>>
					<?php //printf( '<option value="0">%1$s</option>', __( 'Select Color Scheme', 'great' ) );
						foreach ( $this->choices as $value => $label )
							printf( '<option disabled="disabled" value="%1$s" %2$s>%3$s</option>', esc_attr( $value ), selected( $this->value(), $value, false ), $label );
					?>
				</select>
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Dropdown List Pages
 */
if( ! class_exists('CeeWP_Customize_Select_Control_List_Pages')) {
	class CeeWP_Customize_Select_Control_List_Pages extends WP_Customize_Control {
		public $type = 'list-pages';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<select <?php $this->link(); ?>>
					<?php
						foreach ( $this->choices as $value => $label )
							printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $value ), selected( $this->value(), $value, false ), $label );
					?>
				</select>
			</label>
		<?php
		}
	}
}

/**
 * Customizer Custom Control Class for Separator Title
 */
if( ! class_exists('CeeWP_Customize_sep_title')) {
	class CeeWP_Customize_sep_title extends WP_Customize_Control {
		public $type = 'title_sep';

		public function render_content() {?>
        	<div class="customize-sep-title"><?php echo esc_html($this->label); ?></div><?php
		}
	}
}

/**
 * Customizer Custom Control Class for Info
 */
if( ! class_exists('CeeWP_Customize_Info')) {
	class CeeWP_Customize_Info extends WP_Customize_Control {
		public $type = 'info';
		public $desc;
		public function render_content() {?>
			<div class="customize-sep-title info"><?php echo esc_html($this->label); ?></div>
            <?php echo $this->desc;
		}
	}
}

/**
 * Customizer Custom Control Class for Info
 */
if( ! class_exists('CeeWP_Customize_ExternalLinks')) {
	class CeeWP_Customize_ExternalLinks extends WP_Customize_Control {
		public $type = 'externallinks';

		public function render_content() {
			?>
			<div class="alvele-info"><?php
			 printf( __( 'Do you like this theme?', 'great' ) . '<a class="promote-site" href="%1$s">%2$s</a> &nbsp;&nbsp;',
			 esc_url('https://wordpress.org/support/view/theme-reviews/great#postform'),
			 __( 'Please write a review and to promote your website!', 'great' ) );
			 
			 printf( '<a class="button button-primary" href="%1$s">%2$s</a>',
			 esc_url('https://wordpress.org/support/theme/great'),
			 __( 'Support Forums', 'great' ) );			 
			?></div>
			<?php
		}
	}
}