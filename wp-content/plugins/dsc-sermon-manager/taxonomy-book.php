<?php get_header(); ?>

<div class="x-container max width main">

	<div class="offset cf">

		<div class="x-main full" role="main">

<?php
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); ?>

			<h3>Sermons from <?php echo $term->name; ?></h3>

			<div class="sermoncontent">

<?php
	 			dsc_kriesi_pagination($additional_loop->max_num_pages);
?>

				<div class="sermonlist">

					<div class=sermonheader>

						<div class="sermondateH">
							Date Preached
						</div>

						<div class="sermontitleH">
                    		Title (Click 'title' to listen online)
						</div>

						<div class="sermontextH">
                    		Book/Chapter/Verse
						</div>

						<div class="sermonseriesH"> 
                    		Series
						</div>

						<div class="sermonspeakerH"> 
                    		Speaker
						</div>

            		</div><!-- sermonheader -->

				</div><!-- sermonlist -->

<?php
				$args=array(
  						'post_type' => 'sermon',
  						'post_status' => 'publish',
						'book' => $book,
    					'meta_query' => array(
        					array(
            					'key'     => '_textstartchapt'
        					),
        					array(
            					'key'     => '_textstartverse'
        					),
		                   array(
		                        'key' => '_date',
		                        'value' => time(),
		                        'compare' => '<'
			               )
    					),
						'orderby' => 'meta_value_num',
						'order' => 'asc',
  						'paged' => $paged,
  						'posts_per_page' => 10
						);
				$wp_query = new WP_Query($args);?>
<?php
		if (have_posts()) :
			while (have_posts()) : the_post();
?>
				<div class="sermonlist">

 					<div class="sermondate">
<?php
							$sermon_date = get_post_meta($post->ID, '_date', true).": ";
							$sermon_service = get_post_meta($post->ID, '_service', true);		
							$sdate = date('d M, Y', $sermon_date);
							echo $sdate." ".$sermon_service;
?>
                    </div><!-- sermon date -->

					<div class="sermontitle">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            		</div>

            		<div class="sermontext">
<?php					$messages_text_book = get_post_meta($post->ID, '_textbook', true);
						$messages_text_start_chapter = get_post_meta($post->ID, '_textstartchapt', true);
                		$messages_text_start_verse = get_post_meta($post->ID, '_textstartverse', true);
						$messages_text_end_chapter = get_post_meta($post->ID, '_textendchapt', true);
						$messages_text_end_verse = get_post_meta($post->ID, '_textendverse', true);
// Book
						if ($messages_text_book == "" OR $messages_text_book == "Unknown") {
                    		$bgref ="";
						} else {
                    		$bgref ="$messages_text_book";
						}
// Start Chapt
						if ($messages_text_start_chapter == "" OR $messages_text_start_chapter == 0) {
                    		$bgref .="";
						} else {
                    		$bgref .=" $messages_text_start_chapter";
						}
// Start Verse
						if ($messages_text_start_verse == "" OR $messages_text_start_verse == 0) {
                    		$bgref .="";
						} else {
                    		$bgref .=": $messages_text_start_verse";
						}
// End Chapt
						if ($messages_text_end_chapter == "" OR $messages_text_end_chapter == $messages_text_start_chapter) {
                    		$bgref .="";
						} else {
                    		$bgref .=" - $messages_text_end_chapter";
						}
// End Verse
						if ($messages_text_end_verse == "" OR $messages_text_end_verse == 0) {
                    		$bgref .="";
						} else {
                    		if ($messages_text_end_chapter == $messages_text_start_chapter) {
								$bgref .=" - $messages_text_end_verse";
                    		} else {
								$bgref .=": $messages_text_end_verse";
                    		}
						}
						echo $bgref;
?>
					</div> <!-- sermon text -->

            		<div class="sermonseries"> 
<?php
		          	 echo get_the_term_list($post->ID, 'series', ''); ?>
            		</div> <!-- sermon series -->

            		<div class="sermonspeaker">
<?php
		          		echo get_the_term_list($post->ID, 'speaker', ''); ?>
            		</div> <!-- sermon speaker -->

				</div><!--.sermonlist-->
<?php
			endwhile;
		endif;
	 			dsc_kriesi_pagination($additional_loop->max_num_pages);
?>
		

<!-- ----------------------------------------------------------------------------------------------- -->

<?php
	function get_terms_dropdown($taxonomies, $args, $taxname) {
		$myterms = get_terms($taxonomies, $args);
		$output = "<select name=$taxname>";
		foreach ($myterms as $term) {
			$root_url = get_bloginfo('url');
			$term_taxonomy = $term->taxonomy;
			$term_slug = $term->slug;
			$term_name = $term->name;
			$link = $term_slug;
			$output .="<option value='" . $link . "'>" . $term_name . " (" . $term->count . ") </option>";
		}
		$output .="</select>";
		return $output;
	}
?>

<!-- ----------------------------------------------------------------------------------------------- -->

			<div class="sermonlist">

				<h3>SEARCH for other Sermons...</h3>

				<div class="sermontextdd">
            		<h4>...by BOOK</h4>
            		<form action="<?php bloginfo('url'); ?>" method="get">
<?php
						$taxonomies = array('book');
						$args = array('orderby' => 'name', 'hide_empty' => true);
						$select = get_terms_dropdown($taxonomies, $args, 'book');
						$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select BOOK</option>", $select);
						echo $select;
?>
						<noscript><div><input type="submit" value="Näytä" /></div></noscript>
            		</form>
				</div><!-- sermontextdd -->

				<div class="sermontextdd">
            		<h4>...by SERIES</h4>
            			<form action="<?php bloginfo('url'); ?>" method="get">
<?php           			$taxonomies = array('series');
							$args = array('orderby' => 'name', 'hide_empty' => true);
							$select = get_terms_dropdown($taxonomies, $args, 'series');
							$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select SERIES</option>", $select);
							echo $select;
?>
							<noscript><div><input type="submit" value="Näytä" /></div></noscript>
            			</form>
				</div><!-- sermontextdd -->

				<div class="sermontextdd">
            		<h4>...by SPEAKER</h4>
            		<form action="<?php bloginfo('url'); ?>" method="get">
<?php
						$taxonomies = array('speaker');
						$args = array('orderby' => 'name', 'hide_empty' => true);
						$select = get_terms_dropdown($taxonomies, $args, 'speaker');
						$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select SPEAKER</option>", $select);
						echo $select;
?>
						<noscript><div><input type="submit" value="Näytä" /></div></noscript>
            		</form>
				</div><!-- End "sermontextdd" -->
			</div><!-- End "sermonlist"-->
	</div> <!-- sermon content  -->
		</div>
	</div>
</div>

<?php get_footer(); ?>