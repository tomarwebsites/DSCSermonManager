<?php
function great_generate_array ( $req = "slider" ) {
// Disabled-numbers Array
$qty = array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30',  );

// Pages List Arry for Dropdown control
$page_list = array( 'great_hide_this' => sprintf( '&rArr; [ %1$s ]', __('Hide', 'great') ) );

$pages = get_pages();
	foreach ( $pages as $page )
		$page_list [$page->ID] = $page->post_title;
// Slider Array
$great_slider_array = array(
							'sep_slider' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Slider", 'great')),
                                'type' => 'info',
								'desc' => "<a href='http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme/' target='_blank'>How to add widgets?</a>",
                            ),
                            'disable_slider_text' => array(
                                'type' => 'checkbox',
                                'label' => __('Hide texts', 'great'),
                                'default' => 0,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'slider_style' => array(
                                'type' => 'disabled-select',
                                'label' => __('Style', 'great'),
                                'default' => 1,
								'choices' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ),
                                'sanitize_callback' => 'absint',
                            ),
							'slider_effect' => array(
                                'type' => 'disabled-select',
                                'label' => __('Effect', 'great'),
                                'default' => "fade",
								'choices' => array(
													"blindX" => __("blindX", "great"),
													"blindY" => __("blindY", "great"),
													"blindZ" => __("blindZ", "great"),
													"cover" => __("cover", "great"),
													"curtainX" => __("curtainX", "great"),
													"curtainY" => __("curtainY", "great"),
													"fade" => __("fade", "great"),
													"fadeZoom" => __("fadeZoom", "great"),
													"growX" => __("growX", "great"),
													"growY" => __("growY", "great"),
													"none" => __("none", "great"),
													"scrollUp" => __("scrollUp", "great"),
													"scrollDown" => __("scrollDown", "great"),
													"scrollLeft" => __("scrollLeft", "great"),
													"scrollRight" => __("scrollRight", "great"),
													"scrollHorz" => __("scrollHorz", "great"),
													"scrollVert" => __("scrollVert", "great"),
													"shuffle" => __("shuffle", "great"),
													"slideX" => __("slideX", "great"),
													"slideY" => __("slideY", "great"),
													"toss" => __("toss", "great"),
													"turnUp" => __("turnUp", "great"),
													"turnDown" => __("turnDown", "great"),
													"turnLeft" => __("turnLeft", "great"),
													"turnRight" => __("turnRight", "great"),
													"uncover" => __("uncover", "great"),
													"wipe" => __("wipe", "great"),
													"zoom" => __("zoom", "great")
								),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'slider_timeout' => array(
                                'type' => 'disabled-text',
                                'label' => __('Time-out', 'great'),
								'default' => 3000,
                                'sanitize_callback' => 'esc_attr',
                            ),
							'slider_speed' => array(
                                'type' => 'disabled-text',
                                'label' => __('Time-out', 'great'),
								'default' => 1000,
                                'sanitize_callback' => 'esc_attr',
                            )
							);
for ($i=1;$i<=10;$i++) {
	$great_slider_item = array();
	$great_slider_item = array(							
							'sep_slider'.$i => array(
								'label' => __("Slider", 'great') . "#$i",
                                'type' => 'sep-title',
                            ),
							'slide_this'.$i => array(
                                'type' => 'select',
                                'label' => sprintf( '%1$s {%2$s %3$s}', __('Select Page', 'great'), __('Featured Image', 'great'), __('(required)', 'great') ),
                                'default' => 'great_hide_this',
								'choices' => $page_list ,
                                'sanitize_callback' => 'absint',
                            ),
							'slide_icon'.$i => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'slide_link'.$i => array(
                                'type' => 'text',
                                'label' => __('Custom Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            )
							);
	$great_slider_array = array_merge($great_slider_array, $great_slider_item);
}
if ( $req == "slider" ) return $great_slider_array;


// Services Array
$great_services_array = array(
							'sep_info_services' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Services", 'great')),
                                'type' => 'info',
								'desc' => "<a href='http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme/' target='_blank'>How to add widgets?</a>",
                            ),
							'sep_services_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'services_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'services_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'services_description' => array(
                                'type' => 'textarea',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),							
							);
for ($i=1;$i<=3;$i++) {
	$great_services_item = array();
	$great_services_item = array(							
							'sep_service'.$i => array(
								'label' => __("Service", 'great') . " #$i",
                                'type' => 'sep-title',
                            ),
							'service_icon'.$i => array(
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
								'default' => 'fa-star',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'service_icon_color'.$i => array(
                                'type' => 'color',
                                'label' => __('Color', 'great'),
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'service_title'.$i => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'service_description'.$i => array(
                                'type' => 'text',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'service_link'.$i => array(
                                'type' => 'disabled-text',
                                'label' => __('Custom Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            )
							);
	$great_services_array = array_merge($great_services_array, $great_services_item);
}
if ( $req == "services" ) return $great_services_array;



// Projects Array
$great_projects_array = array(
							'sep_info_projects' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Projects", 'great')),
                                'type' => 'info',
								'desc' => '<a href="http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme" target="_blank">How to add widgets?</a>',
                            ),
							'sep_info_projects_is' => array(
								'label' => sprintf( "%1s (%2s)", __('Suggested image dimensions:', 'great'), '300 x 150' ),
                                'type' => 'info',
								'desc' => '',
                            ),
							'sep_projects_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'projects_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'projects_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'projects_description' => array(
                                'type' => 'textarea',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),							
							);
for ($i=1;$i<=3;$i++) {
	$great_projects_item = array();
	$great_projects_item = array(							
							'sep_project'.$i => array(
								'label' => __("Project", 'great') . " #$i",
                                'type' => 'sep-title',
                            ),
							'project_image'.$i => array(
								'default' => '',
                                'type' => 'image',
                                'label' => __('Image', 'great'),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'project_color'.$i => array(
                                'type' => 'color',
                                'label' => __('Color', 'great'),
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'project_title'.$i => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'project_description'.$i => array(
                                'type' => 'text',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'project_link'.$i => array(
                                'type' => 'disabled-text',
                                'label' => __('Custom Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            )
							);
	$great_projects_array = array_merge($great_projects_array, $great_projects_item);
}
if ( $req == "projects" ) return $great_projects_array;


// Clients Array
$great_clients_array = array(
							'sep_info_clients' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Clients", 'great')),
                                'type' => 'info',
								'desc' => '<a href="http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme" target="_blank">How to add widgets?</a>',
                            ),
							'sep_info_clients_is' => array(
								'label' => sprintf( "%1s (%2s)", __('Suggested image dimensions:', 'great'), '300 x 100' ),
                                'type' => 'info',
								'desc' => '',
                            ),
							
							'sep_clients_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'clients_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'clients_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'clients_description' => array(
                                'type' => 'textarea',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),							
							);
for ($i=1;$i<=15;$i++) {
	$great_clients_item = array();
	$great_clients_item = array(							
							'sep_clients'.$i => array(
								'label' => __("Client", 'great') . " #$i",
                                'type' => 'sep-title',
                            ),
							'client_logo'.$i => array(
								'default' => '',
                                'type' => 'image',
                                'label' => __('Logo', 'great'),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'client_title'.$i => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'client_link'.$i => array(
                                'type' => 'disabled-text',
                                'label' => __('Custom Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            )
							);
	$great_clients_array = array_merge($great_clients_array, $great_clients_item);
}
if ( $req == "clients" ) return $great_clients_array;


// Featured Pages Array
$great_featured_array = array(
							'sep_featured_info' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Featured Pages", 'great')),
                                'type' => 'info',
								'desc' => "<a href='http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme/' target='_blank'>How to add widgets?</a>",
                            ),
							'sep_featured_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'featured_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'featured_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'featured_description' => array(
                                'type' => 'textarea',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            )
							);
for ($i=1;$i<=3;$i++) {
	$great_featured_item = array();
	$great_featured_item = array(							
							'sep_featured'.$i => array(
								'label' => __("Page", 'great') . " #$i",
                                'type' => 'sep-title',
                            ),
							'featured_page'.$i => array(
                                'type' => 'select',
                                'label' => sprintf( '%1$s {%2$s %3$s}', __('Select Page', 'great'), __('Featured Image', 'great'), __('(required)', 'great') ),
                                'default' => 'great_hide_this',
								'choices' => $page_list ,
                                'sanitize_callback' => 'absint',
                            ),
							'featured_hide_title'.$i => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Page title', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'featured_alternative_text'.$i => array(
                                'type' => 'text',
                                'label' => __('Alternative Text', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'featured_button_text'.$i => array(
                                'type' => 'text',
                                'label' => __('Button Text', 'great'),
								'default' => __('Learn More', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'featured_button_bg'.$i => array(
								'default' => '',
                                'type' => 'color',
                                'label' => __('Button Background Color', 'great'),
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'featured_button_color'.$i => array(
								'default' => '',
                                'type' => 'color',
                                'label' => __('Button Text Color', 'great'),
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'featured_link'.$i => array(
                                'type' => 'text',
                                'label' => __('Custom Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            )
							);
	$great_featured_array = array_merge($great_featured_array, $great_featured_item);
}
if ( $req == "featured-page" ) return $great_featured_array;

// Socail Media Array
$great_social_array = array(
							'sep_info_social' => array(
								'label' => __("Hint", 'great'),
                                'type' => 'info',
								'desc' => __("If you want to hide the icon, set the icon field as empty.", 'great'),
                            ),
							'sep_sm_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'enable_sm_header' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable', 'great'),
                                'default' => 0,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'sm_header_title' => array(
								'default' => '',
								'type' => 'text',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sm_icon_size_header' => array(
                                'type' => 'select',
                                'label' => __('Size', 'great'),
                                'default' => 'fa-1x',
								'choices' => array( 'fa-1x' => '1', 'fa-lg' => '1.5', 'fa-2x' => 2, 'fa-3x' => 3, 'fa-4x' => 4, 'fa-5x' => 5) ,
                                'sanitize_callback' => 'esc_attr',
                            ),
							//_________
							'sep_sm_footer' => array(
								'label' => __("Footer", 'great'),
                                'type' => 'sep-title',
                            ),
							'enable_sm_footer' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable', 'great'),
                                'default' => 0,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'sm_footer_title' => array(
								'default' => '',
								'type' => 'text',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sm_icon_size_footer' => array(
                                'type' => 'select',
                                'label' => __('Size', 'great'),
                                'default' => 'fa-1x',
								'choices' => array( 'fa-1x' => '1', 'fa-lg' => '1.5', 'fa-2x' => 2, 'fa-3x' => 3, 'fa-4x' => 4, 'fa-5x' => 5) ,
                                'sanitize_callback' => 'esc_attr',
                            ),
							//_________
							'sep_sm_widget' => array(
								'label' => __("Social Widget", 'great'),
                                'type' => 'sep-title',
                            ),
							'sm_title_widget' => array(
								'default' => '',
								'type' => 'text',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sm_icon_size_widget' => array(
                                'type' => 'select',
                                'label' => __('Size', 'great'),
                                'default' => 'fa-1x',
								'choices' => array( 'fa-1x' => '1', 'fa-lg' => '1.5', 'fa-2x' => 2, 'fa-3x' => 3, 'fa-4x' => 4, 'fa-5x' => 5) ,
                                'sanitize_callback' => 'esc_attr',
                            )
							);

// Social Media Links
//$defaults = array('dropbox','facebook','flickr','linkedin','wordpress','instagram','foursquare','skype','twitter','vine','youtube','flickr');
$homeUrl = esc_url( home_url( '/' ) );
for ($i=1;$i<=10;$i++) {
	if ( $i > 5 ) $homeUrl = "";
	$great_social_item = array();
	$great_social_item = array(							
							'sep_sm'.$i => array(
								'label' => __("Custom Link", 'great') . " #$i",
                                'type' => 'sep-title',
                            ),
							'sm_icon'.$i => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sm_color'.$i => array(
								'default' => "#09F",
                                'type' => 'color',
                                'label' => __('Color', 'great'),
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
                            'sm_title'.$i => array(
								'default' => __("Title", 'great'),
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sm_link'.$i => array(
								'default' => $homeUrl,
                                'type' => 'text',
                                'label' => __('Enter the URL', 'great'),
                                'sanitize_callback' => 'esc_url',
                            ),
							'sm_target'.$i => array(
                                'type' => 'checkbox',
                                'label' => __('Open link in a new window/tab', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							);
	$great_social_array = array_merge($great_social_array, $great_social_item);
}
if ( $req == "social" ) return $great_social_array;

} // end of generate array function
 
/**
 * Options array
 */
    $options = array(
        'capability' => 10,
        'type' => 'theme_mod',
        'panels' => array(
            'great' => array(
                'priority'       => 9,
                'title'          => __('Great Theme Options', 'great'),
                'description'    => '',
                'sections' => array(
                    'header' => array(
                        'title' => __('Header', 'great'),
                        'fields' => array(
							'sep_hint_header' => array(
								'label' => __("Hint", 'great'),
                                'type' => 'info',
								'desc' => sprintf( "%1s (%2s)", __('Suggested image dimensions:', 'great'), '350 x 100' ),
                            ),
                            'logo' => array(
								'default' => get_template_directory_uri() . '/images/logo.png',
                                'type' => 'image',
                                'label' => __('Logo Upload', 'great'),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'header_icon' => array(
                                'type' => 'fa',
                                'label' => __('Site Icon', 'great'),
								'default' => 'fa-star',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'search_form' => array(
								'type' => 'checkbox',
								'label' => __('A search form for your site.', 'great'),
								'default' => 1,
								'sanitize_callback' => 'great_boolean',
							),
							'separotor_contact_info' => array(
								'label' => __("Contact Info", 'great'),
                                'type' => 'sep-title',
                            ),
							'adress' => array(
                                'type' => 'text',
                                'label' => __('Address', 'great'),
								'default' => '77 Massachusetts Ave, Cambridge, MA, USA',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'adress_color' => array(
                                'type' => 'color',
                                'label' => sprintf('%1$s [ %2$s ]', __('Text color', 'great'), __('Address', 'great')),
                                'default' => '#645F54',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'adress_url' => array(
                                'type' => 'text',
                                'label' => sprintf('%1$s [ %2$s ]', __('Custom Link', 'great'), __('Address', 'great')),
                                'default' => esc_url( home_url( '/' ) ),
                                'sanitize_callback' => 'esc_url',
                            ),
							'mail' => array(
                                'type' => 'text',
                                'label' => __('Email', 'great'),
								'default' => 'info@example.com',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'mail_color' => array(
                                'type' => 'color',
                                'label' => sprintf('%1$s [ %2$s ]', __('Text color', 'great'), __('Email', 'great')),
                                'default' => '#645F54',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'mail_url' => array(
                                'type' => 'text',
                                'label' => sprintf('%1$s [ %2$s ]', __('Custom Link', 'great'), __('Email', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'esc_url',
                            ),
							'phone' => array(
                                'type' => 'text',
                                'label' => __('Phone Number', 'great'),
								'default' => '+1 617-253-1000',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'phone_color' => array(
                                'type' => 'color',
                                'label' => sprintf('%1$s [ %2$s ]', __('Text color', 'great'), __('Phone Number', 'great')),
                                'default' => '#645F54',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'phone_url' => array(
                                'type' => 'text',
                                'label' => sprintf('%1$s [ %2$s ]', __('Custom Link', 'great'), __('Phone Number', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'esc_url',
                            ),
							'hours' => array(
                                'type' => 'disabled-text',
                                'label' => __('Hours', 'great'),
								'default' => sprintf( "%1s - %2s: 9:00 - 18:30", __('Monday', 'great'), __('Friday', 'great') ),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'hours_color' => array(
                                'type' => 'color',
                                'label' => sprintf('%1$s [ %2$s ]', __('Text color', 'great'), __('Hours', 'great')),
                                'default' => '#645F54',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'hours_url' => array(
                                'type' => 'text',
                                'label' => sprintf('%1$s [ %2$s ]', __('Custom Link', 'great'), __('Hours', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'esc_url',
                            ),
							'separotor_contact_info2' => array(
								'label' => __("Contact Info", 'great'),
                                'type' => 'sep-title',
                            ),
							'contact_info_alignment' => array(
								'type' => 'disabled-select',
								'label' => __('Alignment', 'great'),
								'default' => 'left',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'left'=>__('Align Left', 'great'),
													'right'=>__('Align Right', 'great')),
							),
							'contact_header' => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Header', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'contact_footer' => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Footer', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
                        ),
                    ),
					'style' => array(
                        'title' => sprintf('%1$s &amp; %2$s', __('Style', 'great'), __('Display Settings', 'great')),
                        'fields' => array(
                            'primary_color' => array(
                                'type' => 'color',
                                'label' => __('Primary Color', 'great'),
                                'default' => '#00B0C8',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'content_bg' => array(
								'default' => '',
                                'type' => 'image',
                                'label' => sprintf('%1$s [ %2$s ]', __('Background Image', 'great'), __('Content', 'great')),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'site_border_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Border color', 'great'), __('Content', 'great')),
                                'default' => '#FFF',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'content_bg_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Background color', 'great'), __('Content', 'great')),
                                'default' => '#FFF',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'widgets_bg' => array(
								'default' => '',
                                'type' => 'image',
                                'label' => sprintf('%1$s [ %2$s ]', __('Background Image', 'great'), __('Widgets', 'great')),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'widgets_bg_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Background color', 'great'), __('Widgets', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'separotor_front_page' => array(
								'label' => __("Front Page", 'great'),
                                'type' => 'sep-title',
                            ),
							'display_front_page_posts' => array(
                                'type' => 'checkbox',
                                'label' => __('Your latest posts', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'separotor_allposts' => array(
								'label' => __("All Posts", 'great'),
                                'type' => 'sep-title',
                            ),
							'posts_font_color' => array(
                                'type' => 'color',
								'label' => __('Text color', 'great'),
                                'default' => '#444545',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'posts_link_color' => array(
                                'type' => 'color',
								'label' => __('Link Text', 'great'),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'posts_font_size' => array(
                                'type' => 'select',
								'label' => __('Font Sizes', 'great'),
                                'default' => '14',
								'choices' => great_fontsize_array(),
                                'sanitize_callback' => 'absint',
                            ),
							'enable_fih_pages' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable featured image header for pages', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'enable_fih_posts' => array(
                                'type' => 'checkbox',
                                'label' => __('Enable featured image header for posts', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'display_post_nav' => array(
                                'type' => 'checkbox',
                                'label' => __('Posts navigation', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'separotor_excertp' => array(
								'label' => __("Excerpt View", 'great'),
                                'type' => 'sep-title',
                            ),
							'excerpt_size' => array(
								'type' => 'number',
								'label' => __('Auto excerpt length', 'great'),
								'default' => '35',
								'sanitize_callback' => 'esc_attr',
							),
							'excerpt_more' => array(
                                'type' => 'text',
								'default' => __('...', 'great'),
                                'label' => __('More string at the end of the excerpt', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'readmore_text' => array(
                                'type' => 'text',
								'default' => __('Read more...', 'great'),
                                'label' => __('Read more...', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'separotor_meta' => array(
								'label' => __("Metadata", 'great'),
                                'type' => 'sep-title',
                            ),
							'display_post_date' => array(
                                'type' => 'checkbox',
                                'label' => __('Display post date?', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'display_comments_link' => array(
                                'type' => 'checkbox',
                                'label' => __('Comments Count &amp; Link', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'display_post_author' => array(
                                'type' => 'checkbox',
                                'label' => __('Display item author if available?', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'display_post_cats' => array(
                                'type' => 'checkbox',
                                'label' => __('View Category', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'display_post_tags' => array(
                                'type' => 'checkbox',
                                'label' => __('View Tag', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'meta_color' => array(
                                'type' => 'color',
                                'label' => __('Text color', 'great'),
                                'default' => '#BABABA',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'separotor_footer_style' => array(
								'label' => __("Footer", 'great'),
                                'type' => 'sep-title',
                            ),
							'footer_bg_color' => array(
                                'type' => 'color',
								'label' => __('Background color', 'great'),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'footer_widgets_bg_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Background color', 'great'), __('Widgets', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'footer_widgets_title_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Title', 'great'), __('Widgets', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'footer_widgets_text_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Text color', 'great'), __('Widgets', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							
                        ),
                    ),
					'reading' => array(
						'title' => __('Reading Settings', 'great'),
						'fields' => array(
							'reading_front_page' => array(
								'type' => 'select',
								'label' => __('Front Page', 'great'),
								'default' => 'summary',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'summary'=>__('Summary', 'great'),
													'full'=>__('Full text', 'great'))
							),
							'reading_archive' => array(
								'type' => 'select',
								'label' => __('Archives', 'great'),
								'default' => 'summary',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'summary'=>__('Summary', 'great'),
													'full'=>__('Full text', 'great')),
							),
							'reading_search' => array(
								'type' => 'select',
								'label' => __('Search Results', 'great'),
								'default' => 'summary',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'summary'=>__('Summary', 'great'),
													'full'=>__('Full text', 'great'))
							),
						),
					),
					'layout' => array(
						'title' => __('Layout', 'great'),
						'fields' => array(
							'site_size' => array(
								'type' => 'select',
								'label' => __('Site size', 'great'),
								'default' => 'default',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'default'=>__('Default', 'great'),
													'full'=>__('Full Size', 'great'),
													'custom'=>__('Custom Size', 'great')),
							),
							'site_size_percent' => array(
                                'type' => 'rangeslider',
                                'label' => __('Custom Size', 'great'),
								'default' => '100',
                                'sanitize_callback' => 'esc_attr',
								'choices' => array( 'min' => 10,
													'max'=> 100,)							
                            ),
							'separotor_sidebar' => array(
								'label' => __('Sidebar', 'great'),
                                'type' => 'sep-title',
                            ),
							'layout' => array(
								'type' => 'select',
								'label' => __('Alignment', 'great'),
								'default' => 'left',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'left'=>__('Align Right', 'great'),
													'right'=>__('Align Left', 'great')),
							),
							'separotor_logo_settings' => array(
								'label' => __('Logo', 'great'),
                                'type' => 'sep-title',
                            ),
							'logo_size' => array(
								'type' => 'rangeslider',
								'label' => sprintf('%1$s &rarr; %2$s (%3$s)', __('Logo', 'great'), __('Size', 'great'), __('Set to 0 for default.', 'great')),
								'default' => '0',
								'sanitize_callback' => 'esc_attr',
								'choices' => array(
									'min'   => 0,
									'max'   => 100,
								),
							),
							'logo_top_margin' => array(
								'type' => 'number',
								'label' => sprintf('%1$s &rarr; %2$s', __('Logo', 'great'), __('Vertical space', 'great')),
								'default' => '-20',
								'sanitize_callback' => 'esc_attr',
								'input_attrs' => array(
									'min'   => -50,
									'max'   => 500,
									'step'  => 1,
								),
							),
							'logo_left_margin' => array(
								'type' => 'number',
								'label' => sprintf('%1$s &rarr; %2$s', __('Logo', 'great'), __('Horizontal space', 'great')),
								'default' => '0',
								'sanitize_callback' => 'esc_attr',
								'input_attrs' => array(
									'min'   => 0,
									'max'   => 100,
									'step'  => 1,
								),
							),
							'logo_alignment' => array(
								'type' => 'select',
								'label' => sprintf('%1$s &rarr; %2$s', __('Logo', 'great'), __('Alignment', 'great')),
								'default' => 'left',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'left'=>__('Align Left', 'great'),
													'center'=>__('Align Center', 'great'),
													'right'=>__('Align Right', 'great')),
							),
						),
					),
					'menu_settings' => array(
						'title' => __('Menu Settings', 'great'),
						'fields' => array(
							'menu_hide' => array(
                                'type' => 'checkbox',
                                'label' => sprintf('%1$s [ %2$s ]', __('Hide', 'great'), __('Main menu', 'great')),
                                'default' => 0,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'menu_alignment' => array(
                                'type' => 'disabled-select',
                                'label' => __('Alignment', 'great'),
                                'default' => "left",
								'choices' => array(
												'center' => __('Align center', 'great'),
												'left' => __('Align left', 'great'),
												'right' => __('Align right', 'great'),
												),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'menu_font_size' => array(
                                'type' => 'select',
								'label' => __('Font Sizes', 'great'),
                                'default' => '18',
								'choices' => great_fontsize_array(),
                                'sanitize_callback' => 'absint',
                            ),
							'menu_font_color' => array(
                                'type' => 'color',
								'label' => __('Text color', 'great'),
                                'default' => '#f5f4f3',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'menu_font_color_hover' => array(
                                'type' => 'color',
								'label' => sprintf('%s #2', __('Color', 'great')),
                                'default' => '#feea3a',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'menu_bg_image' => array(
								'default' => get_template_directory_uri() . '/images/menu_bg.png',
                                'type' => 'image',
                                'label' => __('Background Image', 'great'),
                                'sanitize_callback' => 'esc_url_raw',
                            ),
							'menu_bg_image_size' => array(
								'type' => 'select',
								'label' => __('Image size', 'great'),
								'default' => 'default',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'default'=>__('Default', 'great'),
													'cover'=>__('Fit to menu', 'great')),
							),
							'menu_bg_image_position' => array(
								'type' => 'select',
								'label' => __('Background Position', 'great'),
								'default' => 'bottom',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'top'=>__('Top', 'great'),
													'bottom'=>__('Bottom', 'great')),
							),
						),
					),
					
					'slider' => array(
                        'title' => __('Slider', 'great'),
                        'fields' => great_generate_array ("slider"),
                    ),
					'featured_page' => array(
                        'title' => __('Featured Pages', 'great'),
                        'fields' => great_generate_array ("featured-page"),
                    ),
					'social' => array(
                        'title' => __('Social Media', 'great'),
                        'fields' => great_generate_array ("social"),
                    ),
					'services' => array(
						'title' => __('Services', 'great'),
						'fields' => great_generate_array ("services"),
					),
					'projects' => array(
						'title' => __('Projects', 'great'),
						'fields' => great_generate_array ("projects"),
					),
					'clients' => array(
						'title' => __('Clients', 'great'),
						'fields' => great_generate_array ("clients"),
					),
					'about' => array(
						'title' => __('About', 'great'),
						'fields' => array(
							'sep_about_info' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("About", 'great')),
                                'type' => 'info',
								'desc' => "<a href='http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme/' target='_blank'>How to add widgets?</a>",
                            ),
							'sep_about_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'about_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'about_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'about_description' => array(
                                'type' => 'textarea',
                                'label' => __('In a few words, explain what this site is about.', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'about_source' => array(
                                'type' => 'list-pages',
								'default' => '',
                                'label' => __('Add an About page', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'about_text_alignment' => array(
								'type' => 'select',
								'label' => __('Alignment', 'great'),
								'default' => 'center',
								'sanitize_callback' => 'esc_attr',
								'choices' => array( 'left'=>__('Align Left', 'great'),
													'center'=>__('Align Center', 'great'),
													'right'=>__('Align Right', 'great')),
							),
						),
					),
					'blog' => array(
						'title' => __('Blog', 'great'),
						'fields' => array(
							'sep_blog_info' => array(
								'label' => sprintf(__("First, please enable '%s' widget.", 'great'), __("Blog", 'great')),
                                'type' => 'info',
								'desc' => "<a href='http://dinozoom.com/add-widgets-wordpress-blogsidebar-free-wordpress-theme/' target='_blank'>How to add widgets?</a>",
                            ),
							'sep_blog_header' => array(
								'label' => __("Header", 'great'),
                                'type' => 'sep-title',
                            ),
                            'blog_header' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'blog_header_icon' => array(
								'default' => '',
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'blog_description' => array(
                                'type' => 'textarea',
                                'label' => __('Description', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sep_blog_source' => array(
								'label' => __("Source", 'great'),
                                'type' => 'sep-title',
                            ),
							'blog_source_category' => array(
                                'type' => 'category',
								'default' => 1,
                                'label' => __('Select Category', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'sep_blog_display_options' => array(
								'label' => __("Display Options", 'great'),
                                'type' => 'sep-title',
                            ),							
							'disable_blog_title' => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Title', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'disable_blog_excerpt' => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Display item content?', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
							'disable_blog_date' => array(
                                'type' => 'disabled-checkbox',
                                'label' => __('Display post date?', 'great'),
                                'default' => 1,
                                'sanitize_callback' => 'great_boolean',
                            ),
						),
					),
					'footer' => array(
                        'title' => __('Footer', 'great'),
                        'fields' => array(
							'separotor_quote' => array(
								'label' => __("Quote", 'great'),
                                'type' => 'sep-title',
                            ),
							'footer_quote_title' => array(
                                'type' => 'text',
                                'label' => __('Title', 'great'),
								'default' => '',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_quote' => array(
                                'type' => 'text',
                                'label' => __('Quote', 'great'),
								'default' => '"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_author' => array(
                                'type' => 'text',
								'default' => 'Dolor sit Amet',
                                'label' => __('Author', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_quote_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Color', 'great'), __('Quote', 'great')),
                                'default' => '#444545',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'footer_link' => array(
                                'type' => 'text',
								'default' => esc_url( home_url( '/' ) ),
                                'label' => __('Link', 'great'),
                                'sanitize_callback' => 'esc_url',
                            ),
							'footer_linktext' => array(
                                'type' => 'text',
								'default' => __('Read more...', 'great'),
                                'label' => __('Link Text', 'great'),
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_link_icon' => array(
                                'type' => 'fa',
                                'label' => __('Icon', 'great'),
								'default' => 'fa-arrow-circle-right',
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_link_color' => array(
                                'type' => 'color',
								'label' => sprintf('%1$s [ %2$s ]', __('Color', 'great'), __('Link', 'great')),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'separotor_footer_menu' => array(
								'label' => __("Menu", 'great'),
                                'type' => 'sep-title',
                            ),
							'footer_menu_color' => array(
                                'type' => 'color',
								'label' => __('Text color', 'great'),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'separotor_info_text' => array(
								'label' => __("Footer information text", 'great'),
                                'type' => 'sep-title',
                            ),
							'footer_infotext' => array(
                                'type' => 'text',
								'default' => '',
                                'label' => __('Text', 'great'), 
                                'sanitize_callback' => 'esc_attr',
                            ),
							'footer_infotext_color' => array(
                                'type' => 'color',
								'label' => __('Text color', 'great'),
                                'default' => '',
                                'sanitize_callback' => 'sanitize_hex_color',
                            ),
							'footer_infotext_size' => array(
								'type' => 'rangeslider',
								'label' => __('Font Sizes', 'great'),
								'default' => '12',
								'sanitize_callback' => 'esc_attr',
								'choices' => array(
									'min'   => 8,
									'max'   => 64,
								),
							),
                        ),
                    ),
					'advanced' => array(
						'title' => __('Advanced Options', 'great'),
						'fields' => array(
							'css' => array(
								'type' => 'textarea',
								'label' => __('Custom CSS Styles', 'great'),
								'default' => '',
								'sanitize_callback' => 'esc_html',
							),
							'reset' => array(
								'type' => 'checkbox',
								'label' => __('Restore Defaults', 'great'),
								'default' => 0,
								'sanitize_callback' => 'great_reset_all_settings',
							),
							'separotor_menu_external_links' => array(
								'label' => __("Links", 'great'),
                                'type' => 'sep-title',
                            ),
							'external_links' => array(
								'label' => '',
                                'type' => 'externallinks',
                            ),
						),
					),
					///////////////////////////////////////////////////////////
                )
            ),
        )
    );

function great_boolean($value) {
    if(is_bool($value)) {
        return $value;
    } else {
        return false;
    }
}
function great_fontsize_array($min=9,$max=42) {
	$sizes = array();
	for ( $min; $min<=$max; $min++ ) {
		$sizes [$min] = $min.'px';
	}
	return $sizes;
}
function great_breadcrumb_char_choices($value='') {
    $choices = array('1','2','3');

    if( in_array($value, $choices)) {
        return $value;
    } else {
        return '1';
    }
}
/**
 * Reset all settings to default
 * @param  $input entered value
 * @return sanitized output
 *
 */
function great_reset_all_settings( $input ) {
	if ( $input == 1 ) {
		//Remove all set values
		remove_theme_mods();
		return new WP_Error( 'warning', __('Refresh the page to view full effects.', 'great') );
    } 
    else {
        return '';
    }
}
?>