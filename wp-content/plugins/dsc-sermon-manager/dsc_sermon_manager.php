<?php
/**
 Plugin Name: dsc-sermon-manager
 Plugin URI: http://www.blog-online.org.uk/dsc-sermon-manager
 Description: Sermon Manager based on DSC Theme functions
 Author: Tom Nicholas.
 Version: 0.0.1
 Author URI: http://www.blog-online.org.uk
 Text Domain: dscsermonmanager
 */

@require_once dirname( __FILE__ ) . '/dsc_sermon_options.php';

function is_editing_category() {
	$screen = get_current_screen();
	if($screen->id === ‘edit-category’) {
		 echo $screen->id;
		 wp_enqueue_media();
	}
}

add_action( ‘current_screen’, array ( $this, ‘is_editing_category’ ), 10, 2 );

function my_sermon_date($sermonID) {
	$sermon_date = get_post_meta($sermonID, '_date', true).": ";
	$sermon_service = get_post_meta($sermonID, '_service', true);		
	$sdate = date('d M, Y', $sermon_date);
	return $sdate. " ".$sermon_service;
}

function my_sermon_text($sermonID) {

	$messages_text_book = get_post_meta($sermonID, '_textbook', true);
	$messages_text_start_chapter = get_post_meta($sermonID, '_textstartchapt', true);
	$messages_text_start_verse = get_post_meta($sermonID, '_textstartverse', true);
	$messages_text_end_chapter = get_post_meta($sermonID, '_textendchapt', true);
	$messages_text_end_verse = get_post_meta($sermonID, '_textendverse', true);
    
	return my_sermon_ref($messages_text_book,
						$messages_text_start_chapter,
						$messages_text_start_verse,
						$messages_text_end_chapter,
						$messages_text_end_verse);
}

function my_sermon_ref($mtbook, $mtsc, $mtsv, $mtec, $mtev) {

// Book
	if ($mtbook == "" OR $mtbook == "Unknown") {
		$bgref .="";
	} else {
		$bgref ="$mtbook";
	}

// Start Chapt
	if ($mtsc == "") {
		$bgref .="";
	} else {
		$bgref .=" $mtsc";
	}

// Start Verse
	if ($mtsv == "") {
		$bgref .="";
	} else {
		$bgref .=":$mtsv";
	}

// End Chapt
	if ($mtec == "" OR $mmtec == $mtsc) {
		$bgref .="-";
	} else {
		$bgref .=" - $mtec:";
	}

// End Verse
	if ($mtev == "") {
		$bgref .="";
	} else {
		if ($mtec == "") {
	 		$bgref .=""; //-$mtev";
		} else {
			$bgref .="$mtev";
		}
	}
	return $bgref;
}

function dsc_kriesi_pagination($pages = '', $range = 2)
{  
	 $showitems = ($range * 2)+1;  

	 global $paged;
	 if(empty($paged)) $paged = 1;

	 if($pages == '')
	 {
	 global $wp_query;
	 $pages = $wp_query->max_num_pages;
	 if(!$pages)
	 {
		 $pages = 1;
	 }
	 }   

	 if(1 != $pages)
	 {
	 echo "<div class='pagination'>";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
	 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

	 for ($i=1; $i <= $pages; $i++)
	 {
		 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		 {
		 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
		 }
	 }

	 if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
	 echo "</div>\n";
	 }
}

// Create our post type

	add_action( 'init', 'create_post_type' );

	function create_post_type() {
		$args = array(
		'labels' => post_type_labels( 'Sermon' ),
		'public' => true,
		'has_archive' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'),
		'register_meta_box_cb' => 'add_sermon_metaboxes' // This registers the metabox that we'll add later.
	);
	 
		register_post_type( 'sermon', $args );
	}
	 
	// A helper function for generating the labels
	function post_type_labels( $singular, $plural = '' )
	{
	if( $plural == '') $plural = $singular .'s';
	   
	return array(
		'name' => _x( $plural, 'post type general name' ),
		'singular_name' => _x( $singular, 'post type singular name' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New '. $singular ),
		'edit_item' => __( 'Edit '. $singular ),
		'new_item' => __( 'New '. $singular ),
		'view_item' => __( 'View '. $singular ),
		'search_items' => __( 'Search '. $plural ),
		'not_found' =>  __( 'No '. $plural .' found' ),
		'not_found_in_trash' => __( 'No '. $plural .' found in Trash' ),
		'parent_item_colon' => ''
	);
	}
	 
//add filter to ensure the text Sermon, or sermon, is displayed when user updates a sermon

	add_filter('post_updated_messages', 'post_type_updated_messages');

	function post_type_updated_messages( $messages ) {
		global $post, $post_ID;
	 
		$messages['sermon'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('Sermon updated. <a href="%s">View sermon</a>'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __('Sermon updated.'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('Semon restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Sermon published. <a href="%s">View sermon</a>'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Sermon saved.'),
			8 => sprintf( __('Sermon submitted. <a target="_blank" href="%s">Preview sermon</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Sermon scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview sermon</a>'),
			// translators: Publish box date format, see php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Sermon draft updated. <a target="_blank" href="%s">Preview sermonSermon</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID)))),
		);
		return $messages;
	}

//Custom Taxonomies
 
add_action( 'init', 'create_speakers' );

function create_speakers() {
 $labels = array(
	'name' => _x( 'Speakers', 'taxonomy general name' ),
	'singular_name' => _x( 'Speaker', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Speakers' ),
	'all_items' => __( 'All Speakers' ),
	'parent_item' => __( 'Parent Speaker' ),
	'parent_item_colon' => __( 'Parent Speaker:' ),
	'edit_item' => __( 'Edit Speaker' ),
	'update_item' => __( 'Update Speaker' ),
	'add_new_item' => __( 'Add New Speaker' ),
	'new_item_name' => __( 'New Speaker' ),
  );
 
  register_taxonomy('speaker','sermon',array(
	'hierarchical' => false,
	'labels' => $labels,
	"public" => "true"
  ));
}



add_action( 'init', 'create_series' );

function create_series() {
 $labels = array(
	'name' => _x( 'Series', 'taxonomy general name' ),
	'singular_name' => _x( 'Series', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Series' ),
	'all_items' => __( 'All Series' ),
	'parent_item' => __( 'Parent Series' ),
	'parent_item_colon' => __( 'Parent Series:' ),
	'edit_item' => __( 'Edit Series' ),
	'update_item' => __( 'Update Series' ),
	'add_new_item' => __( 'Add New Series' ),
	'new_item_name' => __( 'New Series' ),
  );
 
  register_taxonomy('series','sermon',array(
	'hierarchical' => false,
	'labels' => $labels,
	"public" => "true"
  ));
}

add_action( 'init', 'create_books' );

function create_books() {
 $labels = array(
	'name' => _x( 'Books', 'taxonomy general name' ),
	'singular_name' => _x( 'Book', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Books' ),
	'all_items' => __( 'All Books' ),
	'parent_item' => __( 'Parent Book' ),
	'parent_item_colon' => __( 'Parent Book:' ),
	'edit_item' => __( 'Edit Book' ),
	'update_item' => __( 'Update Book' ),
	'add_new_item' => __( 'Add New Book' ),
	'new_item_name' => __( 'New Book' ),
  );
 
  register_taxonomy('book','sermon',array(
	'hierarchical' => false,
	'labels' => $labels,
	"public" => "true"
  ));

}// Create Meta boxes
 
function add_sermon_metaboxes() {
	add_meta_box('sermon_info', 'Sermon Information', 'sermon_info', 'sermon', 'normal', 'high');
}
 
// Sermon Meta Box
 
function sermon_info() {
	global $post;
 
// Noncename needed to verify where the data originated
	echo '<input id="sermonmeta_noncename" name="sermonmeta_noncename" type="hidden" value="' .	 wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

// Get the data if its already been entered

	$date = get_post_meta($post->ID, '_date', true);
	If (!$date == "") {
	$sdate = date('F j, Y', $date);
	 }
	$service = get_post_meta($post->ID, '_service', true);
	$textbook = get_post_meta($post->ID, '_textbook', true);
	$textstartchapt = get_post_meta($post->ID, '_textstartchapt', true);
	$textstartverse = get_post_meta($post->ID, '_textstartverse', true);
	$textendchapt = get_post_meta($post->ID, '_textendchapt', true);
	$textendverse = get_post_meta($post->ID, '_textendverse', true);
 
// Sermon Date
	echo '<strong>Date</strong><em> - mmm dd, yyyy<br/></em>';
	echo '<input name="_date" size="15" type="text" value="' . $sdate  . '" />';

// Sermon Service am/pm?
	echo '<strong> Service</strong><em> - AM/PM? </em>';
	echo '<select name="_service">';
	echo '<option value="am" '.selected( $service, 'am' ).'>am</option>';
	echo '<option value="pm" '.selected( $service, 'pm' ).'>pm</option>';
	echo '</select><br/><br/>';
// Sermon Book
	echo '<strong>Book</strong><em> - Enter Book... </em><br/>';
	echo '<select name="_textbook">';
	echo '<option value="" '.selected( $textbook, '').'>None</option>';
	echo '<option value="Genesis" '.selected( $textbook, 'Genesis').'>Genesis</option>';
	echo '<option value="Exodus" '.selected( $textbook, 'Exodus').'>Exodus</option>';
	echo '<option value="Leviticus" '.selected( $textbook, 'Leviticus').'>Leviticus</option>';
	echo '<option value="Numbers" '.selected( $textbook, 'Numbers').'>Numbers</option>';
	echo '<option value="Deuteronomy" '.selected( $textbook, 'Deuteronomy').'>Deuteronomy</option>';
	echo '<option value="Joshua" '.selected( $textbook, 'Joshua').'>Joshua</option>';
	echo '<option value="Judges" '.selected( $textbook, 'Judges').'>Judges</option>';
	echo '<option value="Ruth" '.selected( $textbook, 'Ruth').'>Ruth</option>';
	echo '<option value="1 Samuel" '.selected( $textbook, '1 Samuel').'>1 Samuel</option>';
	echo '<option value="2 Samuel" '.selected( $textbook, '2 Samuel').'>2 Samuel</option>';
	echo '<option value="1 Kings" '.selected( $textbook, '1 Kings').'>1 Kings</option>';
	echo '<option value="2 Kings" '.selected( $textbook, '2 Kings').'>2 Kings</option>';
	echo '<option value="1 Chronicles" '.selected( $textbook, '1 Chronicles').'>1 Chronicles</option>';
	echo '<option value="2 Chronicles" '.selected( $textbook, '2 Chronicles').'>2 Chronicles</option>';
	echo '<option value="Ezra" '.selected( $textbook, 'Ezra').'>Ezra</option>';
	echo '<option value="Nehemia" '.selected( $textbook, 'Nehemia').'>Nehemia</option>';
	echo '<option value="Esther" '.selected( $textbook, 'Esther').'>Esther</option>';
	echo '<option value="Job" '.selected( $textbook, 'Job').'>Job</option>';
	echo '<option value="Psalms" '.selected( $textbook, 'Psalms').'>Psalms</option>';
	echo '<option value="Proverbs" '.selected( $textbook, 'Proverbs').'>Proverbs</option>';
	echo '<option value="Ecclesiastes" '.selected( $textbook, 'Ecclesiastes').'>Ecclesiastes</option>';
	echo '<option value="Song of Solomon" '.selected( $textbook, 'Song of Solomon').'>Song of Solomon</option>';
	echo '<option value="Isaiah" '.selected( $textbook, 'Isaiah').'>Isaiah</option>';
	echo '<option value="Jeremiah" '.selected( $textbook, 'Jeremiah').'>Jeremiah</option>';
	echo '<option value="Lamentations" '.selected( $textbook, 'Lamentations').'>Lamentations</option>';
	echo '<option value="Ezekiel" '.selected( $textbook, 'Ezekiel').'>Ezekiel</option>';
	echo '<option value="Daniel" '.selected( $textbook, 'Daniel').'>Daniel</option>';
	echo '<option value="Hosea" '.selected( $textbook, 'Hosea').'>Hosea</option>';
	echo '<option value="Joel" '.selected( $textbook, 'Joel').'>Joel</option>';
	echo '<option value="Amos" '.selected( $textbook, 'Amos').'>Amos</option>';
	echo '<option value="Obadiah" '.selected( $textbook, 'Obadiah').'>Obadiah</option>';
	echo '<option value="Jonah" '.selected( $textbook, 'Jonah').'>Jonah</option>';
	echo '<option value="Micah" '.selected( $textbook, 'Micah').'>Micah</option>';
	echo '<option value="Nahum" '.selected( $textbook, 'Nahum').'>Nahum</option>';
	echo '<option value="Habakkuk" '.selected( $textbook, 'Habakkuk').'>Habakkuk</option>';
	echo '<option value="Zephaniah" '.selected( $textbook, 'Zephaniah').'>Zephaniah</option>';
	echo '<option value="Haggai" '.selected( $textbook, 'Haggai').'>Haggai</option>';
	echo '<option value="Zechariah" '.selected( $textbook, 'Zechariah').'>Zechariah</option>';
	echo '<option value="Malachi" '.selected( $textbook, 'Malachi').'>Malachi</option>';
	echo '<option value="Matthew" '.selected( $textbook, 'Matthew').'>Matthew</option>';
	echo '<option value="Mark" '.selected( $textbook, 'Mark').'>Mark</option>';
	echo '<option value="Luke" '.selected( $textbook, 'Luke').'>Luke</option>';
	echo '<option value="John" '.selected( $textbook, 'John').'>John</option>';
	echo '<option value="Acts" '.selected( $textbook, 'Acts').'>Acts</option>';
	echo '<option value="Romans" '.selected( $textbook, 'Romans').'>Romans</option>';
	echo '<option value="1 Corinthians" '.selected( $textbook, '1 Corinthians').'>1 Corinthians</option>';
	echo '<option value="2 Corinthians" '.selected( $textbook, '2 Corinthians').'>2 Corinthians</option>';
	echo '<option value="Galatians" '.selected( $textbook, 'Galatians').'>Galatians</option>';
	echo '<option value="Ephesians" '.selected( $textbook, 'Ephesians').'>Ephesians</option>';
	echo '<option value="Philippians" '.selected( $textbook, 'Philippians').'>Philippians</option>';
	echo '<option value="Colossians" '.selected( $textbook, 'Colossians').'>Colossians</option>';
	echo '<option value="1 Thessalonians" '.selected( $textbook, '1 Thessalonians').'>1 Thessalonians</option>';
	echo '<option value="2 Thessalonians" '.selected( $textbook, '2 Thessalonians').'>2 Thessalonians</option>';
	echo '<option value="1 Timothy" '.selected( $textbook, '1 Timothy').'>1 Timothy</option>';
	echo '<option value="2 Timothy" '.selected( $textbook, '2 Timothy').'>2 Timothy</option>';
	echo '<option value="Titus" '.selected( $textbook, 'Titus').'>Titus</option>';
	echo '<option value="Philemon" '.selected( $textbook, 'Philemon').'>Philemon</option>';
	echo '<option value="Hebrews" '.selected( $textbook, 'Hebrews').'>Hebrews</option>';
	echo '<option value="James" '.selected( $textbook, 'James').'>James</option>';
	echo '<option value="1 Peter" '.selected( $textbook, '1 Peter').'>1 Peter</option>';
	echo '<option value="2 Peter" '.selected( $textbook, '2 Peter').'>2 Peter</option>';
	echo '<option value="1 John" '.selected( $textbook, '1 John').'>1 John</option>';
	echo '<option value="2 John" '.selected( $textbook, '2 John').'>2 John</option>';
	echo '<option value="3 John" '.selected( $textbook, '3 John').'>3 John</option>';
	echo '<option value="Jude" '.selected( $textbook, 'Jude').'>Jude</option>';
	echo '<option value="Revelation" '.selected( $textbook, 'Revelation').'>Revelation</option>';
	echo '</select> ';

	echo '<strong>From: </strong><em>Chapter: ';
	echo '<input name="_textstartchapt" size="3" type="text" value="' . $textstartchapt  . '" /> ';

	echo '<em> & Verse: </em>';
	echo '<input name="_textstartverse" size="3" type="text" value="' . $textstartverse  . '" /> ';
	
	echo '<strong>To: </strong><em>Chapter: </em> ';
	echo '<input name="_textendchapt" size="3" type="text" value="' . $textendchapt  . '" /> ';

	echo '<em> & Verse: </em> ';
	echo '<input name="_textendverse" size="3" type="text" value="' . $textendverse  . '" />';
}
 
// Save the Meta box Data
 
function save_sermon_meta($post_id, $post) {
 
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['sermonmeta_noncename'], plugin_basename(__FILE__) )) {
	return $post->ID;
	}
 
	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
	return $post->ID;
 
	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
 
	if ($_POST['_service'] == 'am') {
	$dsc_service = get_option('dsc_am');
	} else {
	$dsc_service = get_option('dsc_pm');
	}

	$storedate = strtotime ( $_POST['_date'] . $dsc_service);

	$sermon_meta['_date'] = $storedate;
	$sermon_meta['_service'] = $_POST['_service'];
	$sermon_meta['_textbook'] = $_POST['_textbook'];
	$sermon_meta['_textstartchapt'] = $_POST['_textstartchapt'];
	$sermon_meta['_textstartverse'] = $_POST['_textstartverse'];
	$sermon_meta['_textendchapt'] = $_POST['_textendchapt'];
	$sermon_meta['_textendverse'] = $_POST['_textendverse'];
 
	// Add values of $sermon_meta as custom fields
 
	foreach ($sermon_meta as $key => $value) { // Cycle through the $sermon_meta array!
	if( $post->post_type == 'revision' ) return; // Don't store custom data twice
	$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
	if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
		update_post_meta($post->ID, $key, $value);
	} else { // If the custom field doesn't have a value
		add_post_meta($post->ID, $key, $value);
	}
	if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
 
}

add_action('save_post', 'save_sermon_meta', 1, 2); // save the custom fields

add_action("manage_posts_custom_column",  "portfolio_custom_columns");

add_filter("manage_edit-sermon_columns", "sermon_edit_columns");
 
function sermon_edit_columns($columns){
  $columns = array(
	"cb" => "<input type=\"checkbox\" />",
	"title" => "Sermon Title",
	"pdate" => "Preached",
	"service" => "Service",
	"series" => "Series",
	"speaker" => "Speaker",
	"book" =>"Book",
	"date" => "Date",
  );
 
  return $columns;
}



add_action ('init','WPsermon_Init');


function portfolio_custom_columns($column){
  global $post;
 
  switch ($column) {
	case "pdate":
		$ser_date = get_post_meta($post->ID, '_date', true);
		$s_date = date('F j, Y', $ser_date);
	echo $s_date;
	break;
	case "service":
	echo get_post_meta($post->ID, '_service', true);
	break;
	case "series":
	echo get_the_term_list($post->ID, 'series', '', ', ','');
	break;
	case "speaker":
	echo get_the_term_list($post->ID, 'speaker', '', ', ','');
	break;
	case "book":
	echo get_the_term_list($post->ID, 'book', '', ', ','');
	break;
	case "book":
	echo get_the_term_list($post->ID, 'date', '', ', ','');
	break;
  }
}


// Insert Widget Here

function WPSermon_Recent_Widget()
{
global $post;
$args = ['post_type' => 'sermon',
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
'order' => 'asc'];
$fposts = get_posts( $args );
foreach ( $fposts as $post ) : setup_postdata( $post );
?>

				<div class="sermonlist">
					<div class="sermondate">
<?php						echo my_sermon_date($post->ID);?>
					</div><!-- sermondate -->
					<div class="sermontitle">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</div><!-- sermontitle -->
					<div class="sermonspeaker">
<?php
echo get_the_term_list($post->ID, 'speaker', ''); ?>
					</div><!-- sermonspeaker -->
				</div><!-- sermonlist -->
<?php
endforeach;
wp_reset_postdata();
}

function add_custom_query_var( $vars ){
  $vars[] = 'thisseries';
  return $vars;
}

add_action( 'query_vars', 'add_custom_query_var' );

function orderbyreplace($orderby) {
	return str_replace('menu_order',
			   'mt1.meta_value, mt2.meta_value',
			   $orderby);
}

// filter for tags (as a taxonomy) with comma
//  replace '--' with ', ' in the output - allow tags with comma this way

if(!is_admin()){ // make sure the filters are only called in the frontend
	
	$custom_taxonomy_type = 'series';	// here goes your taxonomy type
	
	function comma_taxonomy_filter($tag_arr){
		global $custom_taxonomy_type;
		$tag_arr_new = $tag_arr;
		if($tag_arr->taxonomy == $custom_taxonomy_type && strpos($tag_arr->name, '--')){
			$tag_arr_new->name = str_replace('--',', ',$tag_arr->name);
		}
		return $tag_arr_new;
	}
	add_filter('get_'.$custom_taxonomy_type, comma_taxonomy_filter);
	
	function comma_taxonomies_filter($tags_arr){
		$tags_arr_new = array();
		foreach($tags_arr as $tag_arr){
			$tags_arr_new[] = comma_taxonomy_filter($tag_arr);
		}
		return $tags_arr_new;
	}
	add_filter('get_the_taxonomies',	comma_taxonomies_filter);
	add_filter('get_terms', 			comma_taxonomies_filter);
	add_filter('get_the_terms',			comma_taxonomies_filter);
}

add_filter( 'manage_edit-movie_sortable_columns', 'my_sermons_sortable_columns' );

function my_sermons_sortable_columns( $columns ) {
	$columns['series'] = 'series';
	return $columns;
}

/* Only run our customization on the 'edit.php' page in the admin. */
add_action( 'load-edit.php', 'my_edit_movie_load' );

function my_edit_movie_load() {
	add_filter( 'request', 'my_sort_movies' );
}

/* Sorts the Sermons. */
function my_sort_movies( $vars ) {

	/* Check if we're viewing the 'sermon' post type. */
	if ( isset( $vars['post_type'] ) && 'Sermon' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'series' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'series',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}

// [sermons]

function dsc_sermons_shortcode( $atts ) {
	global $post;
	ob_start();

	$a = shortcode_atts( array('sort' => '_date', 'order' =>'dsc'), $atts );

	$dsc_sort_key = $a['sort'];
	$dsc_order = $a['order'];

	dsc_kriesi_pagination();?>

	

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
	}?>

<div class="sermonlist">
	<h3>SEARCH for other Sermons...</h3>
	  <!--   <div class="sermondate">
		<h4>...by DATE</h4>
		</div> -->

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

	 </div>

		<div class="sermontextdd">
		<h4>...by SERIES</h4>
		<form action="<?php bloginfo('url'); ?>" method="get">
			<?php
			$taxonomies = array('series');
			$args = array('orderby' => 'name', 'hide_empty' => true);
			$select = get_terms_dropdown($taxonomies, $args, 'series');
			$select = preg_replace("#<select([^>]*)>#", "<select$1 onchange='return this.form.submit()'><option value='0'>Select SERIES</option>", $select);
			echo $select;
			?>
			<noscript><div><input type="submit" value="Näytä" /></div></noscript>
		</form>

		</div>


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
		</div>
</div>

<h2><?php echo 'SORT by: '.$dsc_sort_key.' Order: '.$dsc_order;?></h2>
<div class="sermonlist">
	<div class=sermonheader>
		<div class="sermondateH">
			Date
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
			</div>
<?php

$args = array(
		'post_type' => 'sermon',
		'post_status' => 'publish',
		'orderby' => 'meta_value',
		'meta_key' => $dsc_sort_key,
		'order' => $dsc_order,
		'paged' => $paged,
		'posts_per_page' => 8
		);

	$sermons = new WP_Query( $args );
	if( $sermons->have_posts() )
		{
		while( $sermons->have_posts() )
			{
			$sermons->the_post();
	?>
			<h4><?php // the_title() ?></h4>

	<?php 
			$terms = get_the_terms($post->ID, 'series');
			$count = count($terms);
			if ( $count > 0 ) {
				foreach ($terms as $term) {
				$seriesname = $term->name;}}
			$sermon_date = get_post_meta($post->ID, '_date', true);
			$sermon_service = get_post_meta($post->ID, '_service', true);
			$sermon_year = substr($sermon_date, 0, 4);
			$sermon_month = substr($sermon_date, 4, 2);
			$sermon_day = substr($sermon_date, 6, 2);
			$item_name = "Series: ".$seriesname.": ".$sermon_day."/".$sermon_month."/".$sermon_year." ".$sermon_service." ".get_the_title();?>
			<div class="sermonlist">
				<div class="sermondate">
			<?php
				$sermon_date = get_post_meta($post->ID, '_date', true).": ";
				$sermon_year = substr($sermon_date, 0, 4);
				$sermon_month = substr($sermon_date, 4, 2);
				$sermon_day = substr($sermon_date, 6, 2);
				$sermon_service = get_post_meta($post->ID, '_service', true);											
				echo $sermon_day."/".$sermon_month."/".$sermon_year.$sermon_service;
			?>
				</div>
				<div class="sermontitle">
				<?php the_title();?>
				</div>
				<div class="sermontext">
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
				</div>
				<div class="sermonseries">
				<?php echo get_the_term_list($post->ID, 'series', '');?>
				</div>
				<div class="sermonspeaker">
			<?php	   echo get_the_term_list($post->ID, 'speaker', '');?>
				</div>
			</div><!--sermonlist-->
	<?php	   }

		} else {
		echo 'Oh ohm no Sermons!';
		}
?>
</div>
</div><!-- #content -->
	

<?php
//-------------------------------------------------------------------------------------------------------------

		$output = ob_get_contents();
		ob_end_clean();
	return $output;
}
add_shortcode( 'sermons', 'dsc_sermons_shortcode' );


function dsc_sermon_manager_styles()
{
	// Register the style
	wp_register_style( 'custom-style', plugins_url( '/CSS/custom-style.css', __FILE__ ), array(), '20120208', 'all' );
 
	// enqueue the style:
	wp_enqueue_style( 'custom-style' );
}
add_action( 'wp_enqueue_scripts', 'dsc_sermon_manager_styles' );

add_filter( 'template_include', 'dsc_sermon_include_template', 1 );

function dsc_sermon_include_template( $template_path ) {
	if ( get_post_type() == 'sermon' ) {
	if ( is_single() ) {
		// checks if the file exists in the theme first,
		// otherwise serve the file from the plugin
		if ( $theme_file = locate_template( array ( 'single-sermon.php' ) ) ) {
		$template_path = $theme_file;
		} else {
		$template_path = plugin_dir_path( __FILE__ ) . '/single-sermon.php';
		}
	}

	if ( is_archive() ) {
		if ( $theme_file = locate_template( array ( 'archive-sermon.php' ) ) ) {
		$template_path = $theme_file;
		} else { $template_path = plugin_dir_path( __FILE__ ) . '/archive-sermon.php';
 
		}
	}

	if ( is_tax('series') ) {
		if ( $theme_file = locate_template( array ( 'taxonomy-series.php' ) ) ) {
		$template_path = $theme_file;
		} else { $template_path = plugin_dir_path( __FILE__ ) . '/taxonomy-series.php';
 
		}
	}
	if ( is_tax('speaker') ) {
		if ( $theme_file = locate_template( array ( 'taxonomy-speaker.php' ) ) ) {
		$template_path = $theme_file;
		} else { $template_path = plugin_dir_path( __FILE__ ) . '/taxonomy-speaker.php';
 
		}
	}
	if ( is_tax('book') ) {
		if ( $theme_file = locate_template( array ( 'taxonomy-book.php' ) ) ) {
		$template_path = $theme_file;
		} else { $template_path = plugin_dir_path( __FILE__ ) . '/taxonomy-book.php';
 
		}
	}
	}
	return $template_path;
}


// EXTRA CODE --------------------------------------------------------------------------------------------->>>

function edit_form_tag( ) {
	echo ' enctype="multipart/form-data"';
}
add_action( 'speaker_term_edit_form_tag' , 'edit_form_tag' );
// add_action( '{TAXONOMY_HERE}_term_edit_form_tag' , 'edit_form_tag' );



/** Save Category Meta **/

function save_speaker_fields( $term_id ) {

	// Make sure that the nonce is set, taxonomy is set, and that our uploaded file is not empty
	if(
	  isset( $_POST['upload_meta_nonce'] ) && wp_verify_nonce( $_POST['upload_meta_nonce'], basename( __FILE__ ) ) &&
	  isset( $_POST['speaker'] ) && isset( $_FILES['_uploaded_file'] ) && !empty( $_FILES['_uploaded_file'] )
	) {
	$tax		= $_POST['speaker'];						   // Store our taxonomy, used for the option naming convention
	$supportedTypes = array( 'image/gif', 'image/jpeg', 'image/png' );			  // Only accept image mime types. - List of mimetypes: http://en.wikipedia.org/wiki/Internet_media_type
	$fileArray	  = wp_check_filetype( basename( $_FILES['_uploaded_file']['name'] ) );   // Get the mime type and extension.
	$fileType	   = $fileArray['type'];						   // Store our file type

	// Verify that the type given is what we're expecting
	if( in_array( $fileType, $supportedTypes ) ) {
		$uploadStatus = wp_handle_upload( $_FILES['_uploaded_file'], array( 'test_form' => false ) );   // Let WordPress handle the upload

		// Make sure that the file was uploaded correctly, without error
		if( isset( $uploadStatus['file'] ) ) {
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');

		// Let's add the image to our media library so we get access to metadata
		$imageID = wp_insert_attachment( array(
			'post_mime_type'	=> $uploadStatus['type'],
			'post_title'	=> preg_replace( '/\.[^.]+$/', '', basename( $uploadStatus['file'] ) ),
			'post_content'	  => '',
			'post_status'	   => 'publish'
			),
			$uploadStatus['file']
		);

		// Generate our attachment metadata then update the file.
		$attachmentData = wp_generate_attachment_metadata( $imageID, $uploadStatus['file'] );
		wp_update_attachment_metadata( $imageID,  $attachmentData );


		$existingImage = get_option( "{$tax}_image_{$term_id}" );		   // IF a file already exists in this option, grab it
		if( ! empty( $existingImage ) && is_numeric( $existingImage ) ) {	   // IF the option does exist, delete it.
			wp_delete_attachment( $existingImage );
		}

		update_option( "{$tax}_image_{$term_id}", $imageID );		   // Update our option with the new attachment ID
		delete_option( "{$tax}_image_{$term_id}_feedback" );			// Just in case there's a feedback option, delete it - theoretically it shouldn't exist at this point.
		}
		else {
		$uploadFeedback = 'There was a problem with your uploaded file. Contact Administrator.';	// Something major went wrong, enable debugging
		}
	}
	else {
		$uploadFeedback = 'Image Files only: JPEG/JPG, GIF, PNG';   // Wrong file type
	}

	// Update our Feedback Option
	if( isset( $uploadFeedback ) ) {
		update_option( "{$tax}_image_{$term_id}_feedback", $uploadFeedback );
	}
	}
}

add_action ( 'edited_speaker', 'save_speaker_fields');

/** Metabox Delete Image **/

function tax_del_image() {

	/** If we don't have a term_id or taxonomy, bail out **/
	if( ! isset( $_GET['term_id'] ) || ! isset( $_GET['speaker'] ) ) {
	echo 'Not Set or Empty';
	exit;
	}

	$term_id = $_GET['term_id'];
	$tax	 = $_GET['speaker'];
	$imageID = get_option( "{$tax}_image_{$term_id}" );	 // Get our attachment ID

	if( is_numeric( $imageID ) ) {			  // Verify that the attachment ID is indeed a number
	wp_delete_attachment( $imageID );		   // Delete our image
	delete_option( "{$tax}_image_{$term_id }" );		// Delete our option
	delete_option( "{$tax}_image_{$term_id }_feedback" ); // Delete our feedback in the off-chance it actually exists ( it shouldn't )
	exit;
	}

	echo 'Contact Administrator';   // If we've reached this point, something went wrong - enable debugging
	exit;
}
add_action('wp_ajax_tax_del_image', 'tax_del_image');

/** Delete Associated Media Upon Term Deletion **/

function delete_associated_term_media( $term_id, $tax ){
	global $wp_taxonomies; 

	if( isset( $term_id, $tax, $wp_taxonomies ) && isset( $wp_taxonomies[$tax] ) ) {
	$imageID	= get_option( "{$tax}_image_{$term_id}" );

	if( is_numeric( $imageID ) ) {
		wp_delete_attachment( $imageID );
		delete_option( "{$tax}_image_{$term_id}" );
		delete_option( "{$tax}_image_{$term_id}_feedback" );
	}
	}
}
add_action( 'pre_delete_term', 'delete_associated_term_media', 10, 2 );

// Check if the menu exists
$menu_name = 'Main2';
$menu_exists = wp_get_nav_menu_object( $menu_name );

// If it doesn't exist, let's create it.
if( !$menu_exists){
	$menu_id = wp_create_nav_menu($menu_name);

	// Set up default menu items
	wp_update_nav_menu_item($menu_id, 0, array(
	'menu-item-title' =>  __('Home'),
	'menu-item-classes' => 'home',
	'menu-item-url' => home_url( '/' ), 
	'menu-item-status' => 'publish'));

	wp_update_nav_menu_item($menu_id, 0, array(
	'menu-item-title' =>  __('Custom Page'),
	'menu-item-url' => home_url( '/custom/' ), 
	'menu-item-status' => 'publish'));

}

add_action( 'admin_menu', 'sermons_register_ref_page' );

function sermons_register_ref_page() {
	add_submenu_page(
	'edit.php?post_type=sermon',
	__( 'Preaching Programme', 'textdomain' ),
	__( 'Import Preaching Programme', 'textdomain' ),
	'manage_options',
	'sermons-import',
	'sermons_import_callback'
	);
}

add_action( 'admin_menu', 'sermons_register_ref_page2' );

function sermons_register_ref_page2() {
	add_submenu_page(
	'edit.php?post_type=sermon',
	__( 'UPDATE Sermon Date', 'textdomain' ),
	__( 'UPDATE Sermon Database', 'textdomain' ),
	'manage_options',
	'sermons-update',
	'sermons_update_callback'
	);
}
 
function split_scripture($scripture){

		$parts = preg_split('/\s*:\s*/', trim($scripture, " ;"));

// init book
		$book = array('name' => "", 'chapter' => "", 'verses' => Array());

// $part[0] = book + chapter, if isset $part[1] is verses
		if(isset($parts[0]))
		{
// 1.) get chapter
  			if(preg_match('/\d+\s*$/', $parts[0], $out)) {
				$book['chapter'] = rtrim($out[0]);
  			}
// 2.) book name
  			$book['name'] = trim(preg_replace('/\d+\s*$/', "", $parts[0]));
		}

// 3.) verses
		if(isset($parts[1])) {
  			$book['verses'] = preg_split('~\s*,\s*~', $parts[1]);
		}
	return $book;

}

function link_term_to_sermon($pppostid, $ppterm, $pptax) {
			
			$term = term_exists($ppterm, $pptax);

			// var_dump($term);

			// echo '</br>';

			if ($term !== 0 && $term !== null) {
				// echo '</br>' . $ppterm.' exists in the book taxonomy! and its ID is: '.$term['term_id'] . '</br>';
			} else {
				// echo $ppterm . ' does NOT exist in the ' . $pptax . 'taxonomy! - Create new term?</br>';

				wp_insert_term(
    				$ppterm,   // the term 
    				$pptax, // the taxonomy
    				array(
        				'description' => '',
        				'slug'        => strtolower($ppterm),
        				'parent'      => ''
    				)
				);
				$term = term_exists($ppterm, $pptax);
			}

			$cat_ids = array(intval($term['term_id']));

			$cat_ids = array_map( 'intval', $cat_ids );
			$cat_ids = array_unique( $cat_ids );

			$term_taxonomy_ids = wp_set_object_terms( $pppostid, $cat_ids, $pptax);

			if ( is_wp_error( $term_taxonomy_ids ) ) {
				// echo 'There was an error somewhere and the terms couldnt be set.</br>';
			} else {
				// echo 'Success! The posts categories were set.</br>';
			}

}

function write_preach_programme($ppdate, $ppservice, $pptitle, $ppbook, $ppspeaker, $ppseries) {

	global $post;

	echo '<strong>Input: </strong>';
	echo $ppdate . '-' . $ppservice . '-' . $pptitle . '-' . $ppbook . '-' . $ppspeaker . '-' . $ppseries . '</br>';

	if ($ppservice == 'am') {
		$dsc_service = get_option('dsc_am');
	} else {
		$dsc_service = get_option('dsc_pm');
	}

	$storedate = strtotime ($ppdate . $dsc_service);

	// $sdate = date('F j, Y h:i:s A', $storedate);

	$args = ['post_type' => 'sermon',
				'post_status'  => 'publish',
				'numberposts'  => 1,
				'meta_query' => array(
				array(
					'key' => '_date',
					'value' => $storedate,
					'compare' => '='
					),  
				),
				'orderby' => 'meta_value',
				'order' => 'asc'];

	$existingposts = get_posts( $args );

	echo count($existingposts);

	If (count($existingposts) > 0) {
		echo ' Post FOUND</br>';
		foreach ( $existingposts as $post ) {
				setup_postdata( $post );
				$sdate= get_post_meta($post->ID, '_date', true);
				$syear=date('Y',$sdate);

				If ($syear >= '2017') {
					$sservice = get_post_meta($post->ID, '_service', true);
					$tdate = date('j F Y', $sdate);
					$smonth=date('F Y', $sdate);

					if ($sservice == 'am') {
						$dsc_service = get_option('dsc_am');
					} else {
						$dsc_service = get_option('dsc_pm');
					}
 		
					echo '<strong>Sermon: </strong>';

					echo $tdate . ' - ';
					echo $sservice . ' - ';
					echo the_title() . ' - '; 
					echo my_sermon_text($post->ID) . ' - ';
					$sspeaker = wp_get_object_terms($post->ID, 'speaker');
					foreach($sspeaker as $speakers) {
    					echo $speakers->name . '<br>';
					}
 					$sseries = wp_get_object_terms($post->ID, 'speaker');
					foreach($sseries as $series) {
    					echo $series->name . '<br>';
					}
					echo '</br></br>';
	
				}
			}

		wp_reset_postdata();
	} else {
		echo  ' post(s) found - Create NEW Sermon!</br></br>';
// Initialize the page ID to -1. This indicates no action has been taken.
			$post_id = -1;

// Setup the author, slug, and title for the post
			$author_id = 1;

			$slug = str_replace(' ', '-', strtolower($preachtitle));

			$post_id = wp_insert_post(
				array(
					'comment_status'	=>	'closed',
					'ping_status'		=>	'closed',
					'post_author'		=>	$ppauthor,
					'post_name'			=>	$ppslug,
					'post_title'		=>	$pptitle,
					'post_status'		=>	'publish',
					'post_type'			=>	'sermon'
					)
			);
			
			$sermon_meta['_date'] = $storedate;
			$sermon_meta['_service'] = $ppservice;
			$sermon_meta['_textbook'] = $ppbook['name'];
			$sermon_meta['_textstartchapt'] = $ppbook['chapter'];

			// var_dump($ppbook['verses']);

			if (array_key_exists(0, $ppbook['verses'])) {
				$vlen = strlen($ppbook['verses'][0]);
				$hpos = strpos($ppbook['verses'][0],"-");
    			$sermon_meta['_textstartverse'] = substr($ppbook['verses'][0], 0, $hpos);
				if ($vlen !== "3") {
					$sermon_meta['_textendverse'] = substr($ppbook['verses'][0], $hpos+1, 2);
				} else {
				    $sermon_meta['_textendverse'] = substr($ppbook['verses'][0], $hpos+1, 1);
				}
			}
			$sermon_meta['_textendchapt'] = $ppbook['chapter'];
			
 
// Add values of $sermon_meta as custom fields

			// var_dump($post);
 
			foreach ($sermon_meta as $key => $value) { 				// Cycle through the $sermon_meta array!
				if( $post->post_type == 'revision' ) return; 		// Don't store custom data twice
				$value = implode(',', (array)$value); 				// If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post_id, $key, FALSE)) { 			// If the custom field already has a value
					update_post_meta($post_id, $key, $value);
				} else { 											// If the custom field doesn't have a value
					add_post_meta($post_id, $key, $value);
				}
			}

// Link to Book, Series & Speaker

//Book
			link_term_to_sermon($post_id, $ppbook['name'], 'book');
//Speaker
			link_term_to_sermon($post_id, $ppspeaker, 'speaker');
//Series
			link_term_to_sermon($post_id, $ppseries, 'series');
	}
}

function write_preach_programme2($ppdate, $ppservice, $pptitle, $ppbook, $ppspeaker, $ppseries) {

	if ($ppservice == 'am') {
		$dsc_service = get_option('dsc_am');
	} else {
		$dsc_service = get_option('dsc_pm');
	}

	$storedate = strtotime ($ppdate . $dsc_service);

	$sdate = date('F j, Y h:i:s A', $storedate);

	echo 'STORED Date: ' . $storedate . '</br>';

			$query = new WP_Query(array(
							'post_type' => 'sermon',
    						'meta_key'   => '_date', 
							'meta_value' =>  $storedate
						));
			$existingposts = get_posts( $query );

			// var_dump($existingposts);

			$cmonth = '';

			If (have_posts()) {
				foreach ( $existingposts as $post );
					setup_postdata( $post );
					$sdate= get_post_meta($post->ID, '_date', true);
					$query->the_post();
					$postid = get_the_ID();
					echo  'Existing Record!</br><ul>';
					echo '<li><strong>Post ID:</strong> ' . $postid . ' - ' . get_the_title().'</li></ul>';
					$sdate= get_post_meta($post->ID, '_date', true);
					echo 'Sermon Date: '.$sdate . '</br>';
					$syear=date('Y',$sdate);

					If ($syear >= '2017') {
						$sservice = get_post_meta($post->ID, '_service', true);
						$tdate = date('l, d F', $sdate);
						$smonth=date('F Y', $sdate);

						if ($sservice == 'am') {
							echo '<div class="ppdate">' . $tdate . '</div>';
							$dsc_service = get_option('dsc_am');
						} else {
							$dsc_service = get_option('dsc_pm');
						}
				
?>				
						<div class="sermonlist">
							<div class="sermondate">
<?php
								echo $dsc_service;
?>
						</div><!—End “sermondate" -->
						<div class="sermontitle">
								<?php the_title(); ?>
						</div><!-- End “sermontitle” -->
						<div class="sermontext">
<?php
							echo my_sermon_text($post->ID);?>
						</div><!-- End “sermontext” -->
						<div class="sermonseries">
<?php
							echo get_the_term_list($post->ID, 'series', ''); ?>
						</div><!-- End “sermonseries” -->
						<div class="sermonspeaker">
<?php
							echo get_the_term_list($post->ID, 'speaker', ''); ?>
						</div><!-- End “sermonspeaker” -->
					</div><!-- End "sermonlist" -->
<?php
					wp_reset_postdata();
				}
?>
		</div><!-- End "sermoncontent" -->
	</div>
<?php 
		} else {
			echo  ' NO post found!</br>';

// Initialize the page ID to -1. This indicates no action has been taken.
			$post_id = -1;

// Setup the author, slug, and title for the post
			$author_id = 1;

			$slug = str_replace(' ', '-', strtolower($preachtitle));

			$post_id = wp_insert_post(
				array(
					'comment_status'	=>	'closed',
					'ping_status'		=>	'closed',
					'post_author'		=>	$ppauthor,
					'post_name'			=>	$ppslug,
					'post_title'		=>	$pptitle,
					'post_status'		=>	'publish',
					'post_type'			=>	'sermon'
					)
			);
			
			$sermon_meta['_date'] = $storedate;
			$sermon_meta['_service'] = $ppservice;
			$sermon_meta['_textbook'] = $ppbook['name'];
			$sermon_meta['_textstartchapt'] = $ppbook['chapter'];

			// var_dump($ppbook['verses']);

			if (array_key_exists(0, $ppbook['verses'])) {
				$vlen = strlen($ppbook['verses'][0]);
				$hpos = strpos($ppbook['verses'][0],"-");
    			$sermon_meta['_textstartverse'] = substr($ppbook['verses'][0], 0, $hpos);
				if ($vlen !== "3") {
					$sermon_meta['_textendverse'] = substr($ppbook['verses'][0], $hpos+1, 2);
				} else {
				    $sermon_meta['_textendverse'] = substr($ppbook['verses'][0], $hpos+1, 1);
				}
			}
			$sermon_meta['_textendchapt'] = $ppbook['chapter'];
			
 
// Add values of $sermon_meta as custom fields

			// var_dump($post);
 
			foreach ($sermon_meta as $key => $value) { 				// Cycle through the $sermon_meta array!
				if( $post->post_type == 'revision' ) return; 		// Don't store custom data twice
				$value = implode(',', (array)$value); 				// If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post_id, $key, FALSE)) { 			// If the custom field already has a value
					update_post_meta($post_id, $key, $value);
				} else { 											// If the custom field doesn't have a value
					add_post_meta($post_id, $key, $value);
				}
			}

// Link to Book, Series & Speaker

//Book
			link_term_to_sermon($post_id, $ppbook['name'], 'book');
//Speaker
			link_term_to_sermon($post_id, $ppspeaker, 'speaker');
//Series
			link_term_to_sermon($post_id, $ppseries, 'series');


	}
}

/**
 * Display callback for the submenu page.
 */
function sermons_import_callback() { 
?>
	<div class="wrap">
		<h1><?php _e( 'Preaching Programme', 'textdomain' ); ?></h1>
			<p><?php _e( 'Import...', 'textdomain' ); ?></p>
	</div>
<?php	
	$dsc_googledocs_ID = get_option('googledocs_ID');
	$pp_url = 'https://' .
		'spreadsheets.google.com/' .
		'feeds/list/' .
		$dsc_googledocs_ID .
		'/2/public/values?alt=json';

	$file= file_get_contents($pp_url);
	$json = json_decode($file);
	$rows = $json->{'feed'}->{'entry'};
	foreach($rows as $row) {

		echo '<hr><p>';

  		$date = $row->{'gsx$date'}->{'$t'};

// Preacher AM
  		if ($row->{'gsx$preacheram'}->{'$t'}<>"") {
			$preacheram = $row->{'gsx$preacheram'}->{'$t'};
		} else {
			$preacheram = "To be confirmed";
		}

// Scripture
  		if ($row->{'gsx$scriptuream'}->{'$t'}<>"") {
  			$scriptuream = $row->{'gsx$scriptuream'}->{'$t'};
		} else {
			$scriptuream = "";
		}

// Title AM
  		if ($row->{'gsx$titleam'}->{'$t'}<>"") {
  			$titleam = $row->{'gsx$titleam'}->{'$t'}; 
		} else {
			$titleam = "To be confirmed";
		}

// Series Title AM
  		if ($row->{'gsx$seriestitleam'}->{'$t'}<>"") {
  			$seriestitleam = $row->{'gsx$seriestitleam'}->{'$t'}; 
		} else {
			$seriestitleam = "To be confirmed";
		}

		$bookam = split_scripture($scriptuream);
		
		write_preach_programme($date, 'am', $titleam, $bookam, $preacheram, $seriestitleam);
			
// Preacher PM
  		if ($row->{'gsx$preacherpm'}->{'$t'}<>"") {
			$preacherpm = $row->{'gsx$preacherpm'}->{'$t'};
		} else {
			$preacherpm = "To be confirmed";
		}

// Scripture PM
  		if ($row->{'gsx$scripturepm'}->{'$t'}<>"") {
  			$scripturepm = $row->{'gsx$scripturepm'}->{'$t'};
		} else {
			$scripturepm = "";
		}

// Title PM
  		if ($row->{'gsx$titlepm'}->{'$t'}<>"") {
  			$titlepm = $row->{'gsx$titlepm'}->{'$t'}; 
		} else {
			$titlepm = "To be confirmed";
		}

// Series Title
  		if ($row->{'gsx$seriestitlepm'}->{'$t'}<>"") {
  			$seriestitlepm = $row->{'gsx$seriestitlepm'}->{'$t'}; 
		} else {
			$seriestitlepm = "To be confirmed";
		}

		$bookpm = split_scripture($scripturepm);

		write_preach_programme($date, 'pm', $titlepm, $bookpm, $preacherpm, $seriestitlepm);
		
		echo '</p>';
		}
}	

function sermons_update_callback() { 
	global $post;
 ?>
	<div class="wrap">
		<h1><?php _e( 'Update Sermon DATABASE', 'textdomain' ); ?></h1>
		<p><?php _e( 'Update Sermon Date/Service', 'textdomain' ); ?></p>
	</div>
	<table>
	<tr>
		<th>Date</th>
		<th>Title</th>
		<th>Text</th>
		<th>Series</th>
		<th>Speaker</th>
	</tr>

<?php
			$args2 = array(
					'post_type' => 'sermon',
					'post_status' => 'publish',
					'paged' => $paged,
					'posts_per_page' => -1,
					);
				
				$allposts = get_posts($args2);
				
				//$wp_query2 = new WP_Query($args);?>
<?php
				//if (have_posts()) : ?>
<?php
					//while (have_posts()) : the_post();
					foreach ( $allposts as $post ) : setup_postdata( $post );?>

							<tr>
<!-- Sermon Date/Service -->
							<td width='30%'>
<?php							   //$date = date('m/d/Y h:i:s a', time());
								// $timezone = date_default_timezone_get();
								//echo "The current server timezone is: " . $timezone;
	

	//echo $x;
	
	if (substr(get_post_meta($post->ID, '_date', true),0,2) == '20') {
		//echo get_post_meta($post->ID, '_date', true).' - ';

		if (get_post_meta($post->ID, '_service', true) == 'am') {
		$dsc_service = get_option('dsc_am');
		} else {
		$dsc_service = get_option('dsc_pm');
		}

		$dtstr= substr(get_post_meta($post->ID, '_date', true),6,2).'-'.substr(get_post_meta($post->ID, '_date', true),4,2).'-'.substr(get_post_meta($post->ID, '_date', true),0,4).' '.$dsc_service;
	
		// echo $dtstr.': ';
	
		$timestamp = strtotime($dtstr);
		//echo $timestamp;
		//echo date('D d M, Y h:i A', $timestamp);
		echo $post->ID.' - '.get_post_meta($post->ID,'_date',true).' - '.$timestamp;
		update_post_meta( $post->ID, '_date', $timestamp, get_post_meta($post->ID,'_date',true));
	} else {
		echo 'Not Required';
	}

  
 ?>
								</td ><!—End “sermondate" -->
<!-- Sermon Title -->
							<td width='20%'>
								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							</><!-- End “sermontitle” -->
<!-- Sermon Text -->
							<td width='20%'>
<?php								 echo my_sermon_text($post->ID);?>
							</td><!-- End “sermontext” -->
<!-- Sermon Series -->
							<td width="15%">
<?php								echo get_the_term_list($post->ID, 'series', ''); ?>
							</td><!-- End “sermonseries” -->
<!-- Sermon Speaker -->
							<td width="15%">
<?php
								echo get_the_term_list($post->ID, 'speaker', ''); ?>
							</td><!-- End “sermonspeaker” -->
						</tr><!-- End "sermonlist" -->
					<?php endforeach; 

					wp_reset_postdata();
					//endwhile; ?>
<?php
				//endif; ?>
	</table>
	<?php }



function PPShortcode() {
	global $post;
	ob_start();
?>
	<div class="x-main full" role="main">
		<div class="sermon content">
			<h3>Preaching Programme</h3>
<?php
			$args = ['post_type' => 'sermon',
					'post_status'  => 'publish',
					'numberposts'  => 20,
					'meta_query' => array(
					array(
						'key' => '_date',
						'value' => time()-1,
						'compare' => '>='
						),  
					),
					'orderby' => 'meta_value',
					'order' => 'asc'];

			$futureposts = get_posts( $args );
			$cmonth = '';

			foreach ( $futureposts as $post ) : setup_postdata( $post );
				$sdate= get_post_meta($post->ID, '_date', true);
				$syear=date('Y',$sdate);

				If ($syear >= '2017') {
					$sservice = get_post_meta($post->ID, '_service', true);
					$tdate = date('l, d F', $sdate);
					$smonth=date('F Y', $sdate);
					If ($cmonth !== $smonth) {
						$cmonth = $smonth;
						echo '<h5>' . $cmonth . '</h5>';
					}

					if ($sservice == 'am') {
						echo '<div class="ppdate">' . $tdate . '</div>';
						$dsc_service = get_option('dsc_am');
					} else {
						$dsc_service = get_option('dsc_pm');
					}	
?>				
			<div class="sermonlist">
				<div class="sermondate">
<?php

					echo $dsc_service;
?>
				</div><!—End “sermondate" -->
				<div class="sermontitle">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</div><!-- End “sermontitle” -->
				<div class="sermontext">
<?php
					echo my_sermon_text($post->ID);?>
				</div><!-- End “sermontext” -->
				<div class="sermonseries">
<?php
					echo get_the_term_list($post->ID, 'series', ''); ?>
				</div><!-- End “sermonseries” -->
				<div class="sermonspeaker">
<?php
					echo get_the_term_list($post->ID, 'speaker', ''); ?>
				</div><!-- End “sermonspeaker” -->
			</div><!-- End "sermonlist" -->
<?php
					}
				endforeach;

				wp_reset_postdata();

?>
		</div><!-- End "sermoncontent" -->
	</div>

<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode('PreachProgram', 'PPShortcode');
 
/**
 * Display callback for the submenu page.
 */
function events_import_callback() { 
	?>
	<div class="wrap">
	<h1><?php _e( 'ChurchApp EVENTS', 'textdomain' ); ?></h1>
	<p><?php _e( 'Import ChurchApp EVENTS', 'textdomain' ); ?></p>
	</div>
	<?php		$Ep_url = 	'https://'.
							'dukestreetchurch.churchsuite.com'.
							'/embed/calendar/'.
							'json?'.
							'date_start=2017-06-01'.
							'&'.
							'date_end=2017-07-31';

				echo $Ep_url;
	
		   		//$Ep_json = file_get_contents($Ep_url);
		   		//$Ep_array = json_decode($Ep_json, true);
	?>
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
		<th scope="col" id='title' class='manage-column column-title column-primary sortable desc'>ID</th>
		<th scope="col" id='pdate' class='manage-column column-pdate'>Name</th>
		<th scope="col" id='service' class='manage-column column-service'>Date-Time Start</th>
		<th scope="col" id='series' class='manage-column column-series'>Description</th>
		<th scope="col" id='speaker' class='manage-column column-speaker'>Location/Address</th>
		<th scope="col" id='book' class='manage-column column-book'>URL</th>
		<th scope="col" id='book' class='manage-column column-book'></th>
		<th scope="col" id='book' class='manage-column column-book'></th>
		</tr>
	</thead>
	<tbody>
<?php
	if (!empty($ep_array)) {
	foreach ($ep_array['Programme'] as $key => $item) {
		$sermon_year = substr($item['Date'], 0, 4);
		$sermon_month = substr($item['Date'], 5, 2);
		$sermon_day = substr($item['Date'], 8, 2);
		echo	'<tr><td>'. $item['TitleAM'].'</td>'.
			'<td>' .$sermon_day . '/' 
			   .$sermon_month . '/'
			   .$sermon_year . '</td>
			<td>AM</td>
			<td>'.$item['SeriesAM'].'</td>'.
			'<td>'.$item['PreacherAM'].'</td>';

// split verses from book chapters
$item['ScriptureAM']=$item['ScriptureAM'].';';
$parts = preg_split('/\s*:\s*/', trim($item['ScriptureAM'], " ;"));

// init book
$book = array('name' => "", 'chapter' => "", 'verses' => Array());

}
}
	?>
		</tbody>
</table>
	<?php
}

function WPSermon_Recent_Widget_Control()
{
// get saved options

$options = get_option('wp_recent_sermon');

// handle user input

if ($_POST["sermon_submit"])
{
	$options['rs_title']=strip_tags(stripslashes($_POST["rs_title"]));
	update_option('wp_recent_sermon', $options);
}
$title = $options['rs_title'];

// print out widget control
echo '<p><label for="rstitle">Title: <input name="rs_title" type="text" value="';
echo $title;
echo '"/></label><input type="hidden" id="sermon_submit" value"1" />';


}

function WPSermon_Init()
{
register_sidebar_widget('Recent Sermons', 'WPSermon_Recent_Widget');
register_widget_control('Recent Sermons', 'WPSermon_Recent_Widget_Control');
}
?>