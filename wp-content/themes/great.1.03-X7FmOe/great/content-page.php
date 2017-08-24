<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Great

 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() and get_theme_mod('enable_fih_pages' , 1 ) ):?> 
	<div class="post-entry-media">
    	<a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php
		if ( basename(get_page_template()) == "no-sidebar.php" )
			the_post_thumbnail(array(950));
		else
			the_post_thumbnail('great-image-header');
		?></a>
    </div>
    <?php endif;?> 

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        
        
        <?php edit_post_link( __( 'Edit', 'great' ), '
		<div class="entry-meta">
		<span class="edit-link"><i class="fa fa-edit"></i> ', '</span>
		</div>' ); ?>
        
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'great' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
    
</article><!-- #post-## -->
