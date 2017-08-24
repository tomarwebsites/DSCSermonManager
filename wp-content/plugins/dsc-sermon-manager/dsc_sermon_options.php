<?php 
// create custom plugin settings menu
add_action('admin_menu', 'baw_create_menu');

function baw_create_menu() {

	//create new top-level menu
	add_options_page('Sermons', 'DSC Sermons', 'administrator', __FILE__, 'baw_settings_page',plugins_url('/images/icon.png', __FILE__));
	// add_menu_page('BAW Plugin Settings', 'BAW Settings', 'administrator', __FILE__, 'baw_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'baw-settings-group', 'dsc_bible_Version' );
	register_setting( 'baw-settings-group', 'dsc_bible_language' );
	register_setting( 'baw-settings-group', 'dsc_paypal_id' );
	register_setting( 'baw-settings-group', 'dsc_date_format' );
	register_setting( 'baw-settings-group', 'dsc_am' );
	register_setting( 'baw-settings-group', 'dsc_pm' );
	register_setting( 'baw-settings-group', 'googledocs_ID' );
}

function baw_settings_page() {
?>

<div class="wrap">
<h2>Sermons OPTIONS</h2>
Options relating to the DSC Sermons Plugin.
<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Bible Version</th>
        <td><input type="text" size="5" name="dsc_bible_Version" value="<?php echo esc_attr( get_option('dsc_bible_Version') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Bible Language</th>
        <td><input type="text" size="5" name="dsc_bible_language" value="<?php echo esc_attr( get_option('dsc_bible_language') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PayPal ID</th>
        <td><input type="text" size="50" name="dsc_paypal_id" value="<?php echo esc_attr( get_option('dsc_paypal_id') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Date Format</th>
        <td><input type="text" size="10" name="dsc_date_format" value="<?php echo esc_attr( get_option('dsc_date_format') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">AM</th>
        <td><input type="text" size="10" name="dsc_am" value="<?php echo esc_attr( get_option('dsc_am') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">PM</th>
        <td><input type="text" size="10" name="dsc_pm" value="<?php echo esc_attr( get_option('dsc_pm') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Preaching Programme DOCS ID</th>
        <td><input type="text" size="65" name="googledocs_ID" value="<?php echo esc_attr( get_option('googledocs_ID') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php }
?>