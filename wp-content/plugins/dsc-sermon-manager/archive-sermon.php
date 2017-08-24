<?php get_header(); ?>
<div class="x-container max width main">
	<div class="offset cf">
		<div class="x-main full" role="main">

			<div class="sermoncontent">

				<h3>Next Sunday</h3>

				<div class="sermonheader">
					<div class="sermondateH">Date</div>
					<div class="sermontitleH">Title (Click 'title' to listen online)</div>
					<div class="sermontextH">Book/Chapter/Verse</div>
					<div class="sermonseriesH">Series</div>
					<div class="sermonspeakerH">Speaker</div>
				</div><!-- sermonheader -->
<?php
				global $post;
				$args = array('post_type' => 'sermon',
							'post_status'  => 'publish',
							'numberposts'  => 2,
							'meta_query' => array(
								array(
									'key' => '_date',
									'value' => time()-1,
									'compare' => '>'
								),  
							),
							'orderby' => 'meta_value',
							'order' => 'asc'
						);

				$futureposts = get_posts( $args );

				foreach ( $futureposts as $post ) {
					setup_postdata( $post );
?>
					<div class="sermonlist">

						<div class="sermondate">
<?php
							$date = date('m/d/Y h:i:s a', time());
							echo my_sermon_date($post->ID);
?>
						</div><!—End “sermondate" -->

						<div class="sermontitle">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</div><!-- End “sermontitle” -->

						<div class="sermontext">
<?php						 echo my_sermon_text($post->ID);?>
						</div><!-- End “sermontext” -->

						<div class="sermonseries">
<?php						echo get_the_term_list($post->ID, 'series', ''); ?>
						</div><!-- End “sermonseries” -->

						<div class="sermonspeaker">
<?php
							echo get_the_term_list($post->ID, 'speaker', ''); ?>
						</div><!-- End “sermonspeaker” -->

					</div><!-- End "sermonlist" -->
<?php
				}

				wp_reset_postdata();

?>
				</br>
				<h3>Most Recent Sermons</h3>

				<div class="sermonheader">
					<div class="sermondateH">Date</div>
					<div class="sermontitleH">Title (Click 'title' to listen online)</div>
					<div class="sermontextH">Book/Chapter/Verse</div>
					<div class="sermonseriesH">Series</div>
					<div class="sermonspeakerH">Speaker</div>
				</div><!-- sermonheader -->
<?php
				$args2 = array(
						'post_type' => 'sermon',
						'post_status' => 'publish',
						'orderby' => 'meta_value',
						'order' => 'dsc',
						'paged' => $paged,
						'posts_per_page' => 8,
						'meta_query' => array(
							array(
							'key' => '_date',
							'value' => time(),
							'compare' => '<'
								)
							)
						);
				$pastposts = get_posts($args2);
				foreach ( $pastposts as $post ) : setup_postdata( $post );?>

					<div class="sermonlist">
						<div class="sermondate">
<?php
							$date = date('m/d/Y h:i:s a', time());
							echo my_sermon_date($post->ID);
?>
						</div><!—End “sermondate" -->

						<div class="sermontitle">
							<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</div><!-- End “sermontitle” -->

						<div class="sermontext">
<?php						echo my_sermon_text($post->ID);?>
						</div><!-- End “sermontext” -->

						<div class="sermonseries">
<?php						echo get_the_term_list($post->ID, 'series', ''); ?>
						</div><!-- End “sermonseries” -->

						<div class="sermonspeaker">
<?php
							echo get_the_term_list($post->ID, 'speaker', ''); ?>
						</div><!-- End “sermonspeaker” -->

					</div><!-- End "sermonlist" -->
<?php
					endforeach; 
					wp_reset_postdata();
?>
					<div class="sermonlist">

						<h3>Click <a href="<?php bloginfo('url');?>/speaker/john-samuel/" rel="tag">HERE</a> for more sermons by our Senior Minister: John Samuel</h3>	
					</div><!-- End "sermonlist" -->

					<div class="sermonlist">
						<h3>Subscribe to our podcasts...</h3>
						<p>
							<img src='http://sermons.dukestreetchurch.com/images/xmlrssfeed.gif' border='0' align='absmiddle' alt='Podcast'>
							<a title="Morning Podcast" href="http://phobos.apple.com/WebObjects/MZStore.woa/wa/viewPodcast?id=199320119 " target="_blank">Morning Sermons</a>
						</p>
						<p>
							<img src='http://sermons.dukestreetchurch.com/images/xmlrssfeed.gif' border='0' align='absmiddle' alt='Podcast'>
							<a title="Evening Podcast" href="http://phobos.apple.com/WebObjects/MZStore.woa/wa/viewPodcast?id=269412447 " target="_blank">Evening Sermons</a>
						</p>
					</div><!-- sermonlist -->

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
	} ?>

					<div class="sermonlist">

						<div class="sermontextdd">
							<h3>...by BOOK</h3>
							<form action="<?php bloginfo('url'); ?>" method="get">
<?php
								$taxonomies = array('book');
								$args = array('orderby' => 'name', 'hide_empty' => true);
								$select = get_terms_dropdown($taxonomies, $args, 'book');
								$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select BOOK</option>", $select);
								echo $select;?>
								<noscript>
									<div>
										<input type="submit" value="Näytä" />
									</div>
								</noscript>
							</form>
						</div><!-- sermontextdd -->

						<div class="sermontextdd">
							<h3>...by SERIES</h3>
							<form action="<?php bloginfo('url'); ?>" method="get">
<?php
								$taxonomies = array('series');
								$args = array('orderby' => 'name', 'hide_empty' => true);
								$select = get_terms_dropdown($taxonomies, $args, 'series');
								$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select SERIES</option>", $select);
								echo $select;
?>
								<noscript>
									<div>
										<input type="submit" value="Näytä" />
									</div>
								</noscript>
							</form>
						</div><!-- sermontextdd -->

						<div class="sermontextdd">
							<h3>...by SPEAKER</h3>
							<form action="<?php bloginfo('url'); ?>" method="get">
<?php
								$taxonomies = array('speaker');
								$args = array('orderby' => 'name', 'hide_empty' => true);
								$select = get_terms_dropdown($taxonomies, $args, 'speaker');
								$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select SPEAKER</option>", $select);
								echo $select;
?>
								<noscript>
									<div>
										<input type="submit" value="Näytä" />
									</div>
								</noscript>
							</form>
						</div><!-- "sermontextdd" -->
					</div><!-- "sermonlist"-->
			</div><!-- "sermoncontent" -->

		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>