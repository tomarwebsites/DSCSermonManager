<?php
	get_header(); // Loads the header.php template
?>

<div class="x-container max width main">
	<div class="offset cf">
		<div class="x-main full" role="main">

<?php
			if (have_posts ()) : while (have_posts ()) : the_post(); ?>       
                <h5><?php the_title();?></h5>
                <div class="sspeaker">
<?php
                        $terms = get_the_terms($post->ID, 'speaker');
                   		$count = count($terms);
                        if ($count > 0) {
                            foreach ($terms as $term) {
                                $imagename = $term->name;
                            }
                        }
                        $speakername = str_replace(" ", "", $imagename);
                        $speakerimage = "/audio/images/" . strtolower($speakername) . ".jpg";

                        if (file_exists( ABSPATH . $speakerimage)) {
							echo "<img src = $speakerimage>";
						}
						else
						{
							echo 'Speaker';
						}
?>
			
                    </div> <!--sermonspeaker-->
<?php
				echo get_the_term_list($post->ID, 'series', 'Series: ').'</br></br>';

				echo get_the_term_list($post->ID, 'speaker', 'By: ').'</br></br>';
?>
                <div class="sermondte">
<?php
						$sermon_date = get_post_meta($post->ID, '_date', true);
						$sermon_year = date('Y', $sermon_date);
						$sermon_month = date('m', $sermon_date);
						$sermon_day = date('d', $sermon_date);

						$smonth=date('F Y', $sdate);
            			$sermon_service = get_post_meta($post->ID, '_service', true);

						if ($sermon_service == 'am') {
							$d_service = get_option('dsc_am');
						} else {
							$d_service = get_option('dsc_pm');
						}

						echo "Date: " . date('l, d F Y', $sermon_date) . " : " . $d_service . "</br></br>";

						$audiofile = "/audio/".$sermon_year.$sermon_month.$sermon_day.$sermon_service.".mp3";

                        if (file_exists( ABSPATH . $audiofile)) {
							echo '<p><audio controls>
<source src="' . $audiofile . '" type="audio/mpeg">
Your browser does not support the audio element
</audio></p>';
						}
							else
						{
							echo '<div id="noaudio">';
							echo 'AUDIO(.mp3) NOT currently available on-line';
							echo '</div>';
						}

						// the_content();
?>
                    </div><!--sermondte-->
                </div><!--sermonheader-->


	
                	<div class="sermonpassage">
<?php
                        $messages_text_book = get_post_meta($post->ID, '_textbook', true);
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
						if ($messages_text_start_chapter == "") {
                            $bgref .="";
                        } else {
                            $bgref .=" $messages_text_start_chapter";
                        }

                        if ($messages_text_start_verse == "" OR $messages_text_start_verse == "0") {
                            $bgref .="";
                        } else {
                            $bgref .=":$messages_text_start_verse";
                        }
// End Chapt

                        if ($messages_text_end_chapter == "" OR $messages_text_end_chapter == $messages_text_start_chapter) {
                            $bgref .="";
                        } else {
                            $bgref .="-$messages_text_end_chapter:";
                        }
// End Verse

                        if ($messages_text_end_verse == "") {
                            $bgref .="";
                        } else {
                            if ($messages_text_end_chapter == "") {
                                $bgref .="";
                            } else {
                                if ($messages_text_end_chapter != $messages_text_start_chapter) {
                            		$bgref .="$messages_text_end_verse";
                        		} else {
                            		$bgref .="-$messages_text_end_verse";
                        		}
							}
						}

						$linkref = $bgref;

                        if ($linkref <> "") {
                            echo "<div class='bibleChapter'>" . $linkref. "</div>";
                            $key = "IP";
                            $passage = urlencode($linkref);
                            $options = "include-passage-references=false";
                            $url = "http://www.esvapi.org/v2/rest/passageQuery?key=$key&passage=$passage&$options";
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            $response = curl_exec($ch);
                            curl_close($ch);
                            print $response;
                        } else {
                            echo "No Bible reference available";
                        }
					endwhile;
				else :
?>
                    <div class="post">                        
                        <h2><?php _e('Not Found'); ?></h2>
                    </div><!--post-->                                              
<?php
				endif;
?>
		</div>
	</div>
</div>

<?php get_footer(); // Loads the footer.php template ?>