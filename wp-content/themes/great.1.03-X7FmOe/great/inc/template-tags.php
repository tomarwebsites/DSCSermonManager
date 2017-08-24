<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Great

 */

if ( ! function_exists( 'great_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function great_posted_on() {
	// Show Hide?
	if ( get_theme_mod( 'display_post_date', 1 ) ):
	// Output
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	echo '<span class="posted-on"><i class="fa fa-calendar"></i> ' . $posted_on . '</span>';
	endif;
	
	// Comments
	if ( get_theme_mod( 'display_comments_link', 1 ) && ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
		comments_popup_link( __( 'Leave a comment', 'great' ), __( '1 Comment', 'great' ), __( '% Comments', 'great' ) );
		echo '</span>';
	}
	// Edit
	edit_post_link( __( 'Edit', 'great' ), '<span class="edit-link"><i class="fa fa-edit"></i> ', '</span>' );
}
endif;

if ( ! function_exists( 'great_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function great_entry_footer() {
	// Featured Star
	if ( is_sticky() && is_home() && ! is_paged() ) {printf( '<span class="sticky-post"><i class="fa fa-star"></i> %s</span>', __( 'Featured', 'great' ) );}
	
	// Post Author
	if ( get_theme_mod( 'display_post_author', 1 ) ):
	$byline = '	<span class="author vcard">
				<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">
				' . esc_html( get_the_author() ) . '</a></span>';
	echo '<span class="byline"><i class="fa fa-user"></i> ' . $byline . '</span>';
	endif;
	
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'great' ) );
		if ( $categories_list && great_categorized_blog() && get_theme_mod( 'display_post_cats', 1 ) ) {
			printf( '<span class="cat-links"><i class="fa fa-folder"></i> ' . '%1$s' . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'great' ) );
		if ( $tags_list and get_theme_mod( 'display_post_tags', 1 ) ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . '%1$s' . '</span>', $tags_list );
		}
	}



	
}
endif;

if ( ! function_exists( 'great_archive_title' ) ) :
function great_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'great' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'great' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'great' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'great' ), get_the_date( _x( 'Y', 'yearly archives date format', 'great' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'great' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'great' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'great' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'great' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'great' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'great' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'great' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'great' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'great' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'great_archive_description' ) ) :
function great_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function great_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'great_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'great_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so great_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so great_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in great_categorized_blog.
 */
function great_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'great_categories' );
}
add_action( 'edit_category', 'great_category_transient_flusher' );
add_action( 'save_post',     'great_category_transient_flusher' );


function great_theme_comment($comment,$args,$depth){
	$GLOBALS['comment'] = $comment;
	
	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) {
?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php echo __( 'Pingback:', 'great' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'great' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

<?php
	}else{
?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author"><?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
        
			<div class="comment-meta">
            	<span class="fn"><?php echo get_comment_author_link();?></span>
				<span><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'great' ), get_comment_date(), get_comment_time() ); ?></span>
                <?php edit_comment_link( __( 'Edit', 'great' ), '<span><i class="fa fa-edit"></i> ', '</span>' ); ?>

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php echo __( 'Your comment is awaiting moderation.', 'great' ); ?></p>
				<?php endif; ?>
			</div>

			<div class="mscon comment-content"><?php comment_text();?></div>

			<div class="reply"><?php comment_reply_link( array_merge( $args, array('reply_text' => '<i class="fa fa-retweet"></i>', 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
            
            <div class="clear"></div>
		</div>
<?php
	}
}

/**
 * Comment form : button.
 */
function great_comment_form_submit_button ( $submit_button, $args ){
    // Override the submit button HTML:
    $button = '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s <i class="fa fa-paper-plane"></i></button>';
    return sprintf(
        $button,
        esc_attr( $args['name_submit'] ),
        esc_attr( $args['id_submit'] ),
        esc_attr( $args['class_submit'] ),
        esc_attr( $args['label_submit'] )
     );
}
add_filter( 'comment_form_submit_button', 'great_comment_form_submit_button', 10, 2 );

/* Great: Header menu */
function great_header_menu () {?>
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container_class' => 'primary-menu-cont', 'fallback_cb' => 'great_header_menu_fb'  ) ); ?>
        <div class="clear"></div>
    </nav><!-- #site-navigation -->
<?php
}
function great_header_menu_fb () {
	wp_page_menu( array('menu_class'  => 'primary-menu-cont') );
}

// end of header menu


/* Classes to font awesome icons */
if( !is_admin() ) add_filter( 'wp_get_nav_menu_items', 'great_menu_fa_icons', 10, 3 );
function great_menu_fa_icons( $items, $menu, $args ) {
	foreach( $items as $k => $item )
		if ( !empty($item->classes) ) {
			foreach( $item->classes as $key => $class ) {
				// match .fa
				if ( $class == 'fa' ) unset( $items[$k]->classes[$key] );
				// match .fa-*
				$fa_class  = preg_match ("/fa-./", $class);
				if ( $fa_class ) {
					unset( $items[$k]->classes[$key] );
					$items[$k]->title = sprintf('<i class="fa %1$s menu-icon"></i> %2$s', esc_attr($class), $items[$k]->title);
				}
			}
		}
    return $items;
}

/* great_posts_navigation  */
function great_posts_navigation(){
	if(function_exists('wp_pagenavi')) {
		wp_pagenavi();
	} else {
		if(function_exists('the_posts_pagination')){
			the_posts_pagination( array(
				'prev_text'          => '<i class="fa fa-arrow-left"></i>',
				'next_text'          => '<i class="fa fa-arrow-right"></i>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'great' ) . ' </span>',
			) );
		}else{
	?>
        <div id="page-nav-below">
			<?php if ( get_next_posts_link() ) : ?>
            <div class="nav-previous"><i class="fa fa-arrow-left"></i> <?php next_posts_link( __( 'Older posts', 'great' ) ); ?></div>
            <?php endif; ?>
    
            <?php if ( get_previous_posts_link() ) : ?>
            <div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'great' ) ); ?> <i class="fa fa-arrow-right"></i></div>
            <?php endif; ?>
        </div>
	<?php
		}
	}
}
//
function great_post_navigation(){
	if ( ! get_theme_mod( 'display_post_nav', 1 ) ) return;
	global $post;
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) return;

	echo '<div role="navigation" id="nav-below" class="navigation-post">';
	previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fa fa-arrow-left"></i> %title');
	next_post_link( '<div class="nav-next">%link</div>', '%title <i class="fa fa-arrow-right"></i>'); 
	echo '<div class="clear"></div>';
	echo '</div>';
}
//
function great_post_box () { ?>
<div <?php post_class("post-box entry-content"); ?>>

	<?php if ( has_post_thumbnail() ):?>
    <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_post_thumbnail('thumbnail');?></a>
    <?php endif;?> 
    
    <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title( '<h3 class="entry-title">', '</h3>' ); ?></a>
    <span class="post-box-meta entry-meta">
    	<?php great_posted_on(); ?>
    </span>
    <br />
	<?php the_excerpt(); ?>

    <div class="post-box-more">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php echo get_theme_mod( 'readmore_text', __( 'Read More...', 'great' ) );?> <i class="fa fa-arrow-right"></i></a>
    </div>
    <div class="clear"></div>
</div><!-- #post-box -->

<?php
} // end of great_post_box
?>