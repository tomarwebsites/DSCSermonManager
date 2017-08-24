<?php
get_header();
	if ( get_theme_mod( 'display_front_page_posts', true ) ):
		/****** Front page displays  ********/
		if ( get_option( 'show_on_front' ) == "posts" ) {
			get_template_part('index', 'homepage') ;
		} elseif ( get_option( 'show_on_front' ) == "page" ) {
			get_template_part('page') ;
		}
	endif;	
get_footer();
?>