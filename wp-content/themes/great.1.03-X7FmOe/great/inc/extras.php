<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Great

 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function great_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'great_body_classes' );

// Great theme excerpt Lenght & More Filter
function great_excerpt_length( $length ) {
	$l = esc_attr(get_theme_mod( 'excerpt_size', 35));
	if ($l>=0) return $l;
	else return 35;
}
function great_excerpt_more( $more ) {
	return esc_attr(get_theme_mod( 'excerpt_more', '...'));	
}
add_filter( 'excerpt_more', 'great_excerpt_more' );
add_filter( 'excerpt_length', 'great_excerpt_length', 999 );

//
//if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function great_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}
		
		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'great' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'great_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function great_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'great_render_title' );
endif;

// Sm
function great_social_media( $position = "header" ) {
	// Position disbale?
	if ( !get_theme_mod( 'enable_sm_'.$position, 0 ) and $position != "widget" ) return;
	// Size
	$size = get_theme_mod( "sm_icon_size_$position", 'fa-1x' );
		
	// Icons
	$icons = array();
	for ($i=1;$i<=10;$i++) {
		$link = get_theme_mod( 'sm_link'.$i, esc_url(home_url( '/' )) );
		$icon = get_theme_mod( 'sm_icon'.$i );
		if ( $link != "" and !strpos($icon, '---') ) {
			$attr = sprintf('href="%s" ',  $link );
			if ( get_theme_mod( 'sm_title'.$i ) ) $attr .= sprintf('title="%s" ', get_theme_mod( 'sm_title'.$i ));
			if ( get_theme_mod( 'sm_target'.$i, 1 ) ) $attr .= 'target="_blank" ';
			if ( get_theme_mod( 'sm_color'.$i ) ) $attr .= sprintf('style="color:%s;" ', get_theme_mod( 'sm_color'.$i ));
			$icons [] = sprintf('<a %1$s><i class="fa %2$s %3$s"></i></a>', $attr, $icon, $size);
		}
	} // end for
	
	// After Text
	$after_text  = '';
	if ( get_theme_mod( 'sm_'.$position.'_title' ) ) $after_text = '<span class="'.$size.'-after-text sm-desc-'.$position.'">'. get_theme_mod( 'sm_'.$position.'_title' ) .'</span>';
	// Display Icons
	if ( count ($icons) )
		printf('<div class="sm sm-%1$s">%3$s %2$s</div>', $position, implode( " ", $icons ), $after_text) ;
}
//
// Quote
function great_footer_quote() {
	// Vars
	$b = esc_html(get_theme_mod( 'footer_quote_title'));
	$q = esc_html(get_theme_mod( 'footer_quote', '"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."'));
	$a = esc_html(get_theme_mod( 'footer_author', 'Dolor sit Amet'));
	$l = esc_url(get_theme_mod( 'footer_link', esc_url( home_url( '/' ) ) ));
	$t = esc_html(get_theme_mod( 'footer_linktext', __('Read more...', 'great') ));
	$i = esc_attr(get_theme_mod( 'footer_link_icon', 'fa-arrow-circle-right'));
	$i = sprintf('<i class="fa %s"></i>', $i);
	
	// Link
	$link = '';
	if ( trim($l) != '' or trim($t) != '' ) 
		$link = sprintf('<a class="more-link" href="%1$s">%2$s %3$s</a>', $l, $i, $t);

	// Check the Quote Rows
	$quote = '';
	if (!empty($b)) $quote .= sprintf('<div class="b">%s</div>', $b);
	if (!empty($q)) $quote .= sprintf('<div class="q">%s</div>', $q);
	if (!empty($a)) $quote .= sprintf('<div class="a">%s</div>', $a);
	if (!empty($l)) $quote .= sprintf('<div class="l">%s</div>', $link);
	
	// Display Quote
	if ( !empty($quote) ) printf('<div class="quote">%s</div>', $quote);
}
//
// Contact
function great_site_contact( $position = "" ) { ?>
	<div class="site-contact <?php echo $position;?>">
                	<?php
					// Get vars
                    $adress = 	esc_html(get_theme_mod( 'adress', 'Massachusetts Ave, Cambridge, MA, USA' ));
					$mail = 	esc_html(get_theme_mod( 'mail', 'info@example.com' ));
					$phone = 	esc_html(get_theme_mod( 'phone', '+1 617-253-1000' ));
					
					$adressUrl = 	esc_url(get_theme_mod( 'adress_url' ));
					$mailUrl = 		esc_url(get_theme_mod( 'mail_url' ));
					$phoneUrl = 	esc_url(get_theme_mod( 'phone_url' ));
					
					// Only text
					if ($adress)	$adressOut = '<span class="adress"><i class="fa fa-map-marker"></i>'.$adress.'</span> ';
					if ($mail)		$mailOut = '<span class="mail"><i class="fa fa-envelope-o"></i>'.$mail.'</span> ';
					if ($phone)		$phoneOut = '<span class="phone"><i class="fa fa-phone"></i>'.$phone.'</span> ';
					
					// It has url ?
					if ( $adress and $adressUrl )	$adressOut = '<a href="'.$adressUrl.'">'.$adressOut.'</a> ';
					if ( $mail and $mailUrl )		$mailOut = '<a href="'.$mailUrl.'">'.$mailOut.'</a> ';
					if ( $phone and $phoneUrl )		$phoneOut = '<a href="'.$phoneUrl.'">'.$phoneOut.'</a> ';
					
					// Echo
					echo $adressOut . $mailOut . $phoneOut;
					?>
	</div>
	 <?php
}
//
// Site Footer Function
function great_wp_footer () { ?>
	</div>
    <?php
	//  Footer Widgets
	$s = array('footer-left','footer-center','footer-right');
	// Is Active?
	$active = array();
    foreach ( $s as $i )
		if ( is_active_sidebar($i) ) $active [] = $i;
	?>
    
    
    <?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
		<ul id="sidebar"><?php dynamic_sidebar( 'left-sidebar' ); ?></ul>
    <?php endif; ?>
    
	<footer id="colophon" class="site-footer" role="contentinfo">
    	<!-- Footer Quotation -->
        <?php great_footer_quote ();?>
        <div class="clear"></div>
    	<!-- Footer Widgets -->
        <?php
		// Count Actives
		if ( count ($active) ) {
			$width = round ( 100 / count ($active) , 2 ) - 2; // -2 : for margins
			foreach ( $active as $activ ) {
				?>
				<div style="width:<?php echo $width;?>%;" class="footer-widget"><?php dynamic_sidebar( $activ ); ?></div>
            	<?php
			}
		}
		?>
        <div class="clear"></div>
        
        <!-- Site Contact -->
        <?php great_site_contact( "footer" );?>
        <div class="clear"></div>
        
        <!-- Footer SM -->
        <?php great_social_media( "footer" );?>
        <div class="clear"></div>
        
        <!-- Footer Menu -->
        <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
        <div id="footer-menu"><?php wp_nav_menu( array( 'theme_location'   => 'footer-menu',	'depth' => 1 ) ); ?></div>
        <?php endif; ?>
        
        <div class="site-info">
		<div class="info-text"><?php echo esc_attr(get_theme_mod( 'footer_infotext' ));?></div>
		<?php printf( __( 'Copyright &copy; %1$d %2$s.','great' ),date('Y'),'<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>');?> <?php _e( 'Powered by WordPress', 'great' ); ?><span class="sep"> &amp; </span><?php printf('%s , <strong><a target="_self" href="http://alvele.com/">alvele.com</a></strong>', 'Ben Alvele' ); ?><span class="sep"> &amp; </span><?php printf( __( '<span>%s is using the Great WordPress theme</span>', 'great' ), esc_attr( get_bloginfo( 'name', 'display' ) ) ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
    
    <div id="back_top"><i class="fa fa-angle-up"></i></div>
</div><!-- #page -->
<?php
} // end of great_wp_footer