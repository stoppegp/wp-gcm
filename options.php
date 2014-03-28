<?php 
$version = get_bloginfo('version');
if ($version < 3.8) {
 function px_gcm_menu() {
	add_menu_page('GCM', 'GCM', 'manage_options', 'px-gcm','');
        add_submenu_page( 'px-gcm', __('New Message','px_gcm'), __('New Message','px_gcm'), 'manage_options', 'px-gcm', 'px_display_page_msg');
        add_submenu_page( 'px-gcm', __('Settings','px_gcm'), __('Settings','px_gcm'), 'manage_options', 'px-gcm-settings', 'px_display_page_setting');
 }
 add_action('admin_menu', 'px_gcm_menu');
} else { 
   function px_gcm_menu() {
	add_menu_page('GCM', 'GCM', 'manage_options', 'px-gcm','','dashicons-cloud');
        add_submenu_page( 'px-gcm', __('New Message','px_gcm'), __('New Message','px_gcm'), 'manage_options', 'px-gcm', 'px_display_page_msg');
        add_submenu_page( 'px-gcm', __('Settings','px_gcm'), __('Settings','px_gcm'), 'manage_options', 'px-gcm-settings', 'px_display_page_setting');  
 }
 add_action('admin_menu', 'px_gcm_menu');
}

/*
*
* All the functions for the settings page
*
*/
function px_register_settings() {
	add_settings_section('gcm_setting-section', '', 'gcm_section_callback', 'px-gcm');
	add_settings_field('api-key', __('Api Key','px_gcm'), 'api_key_callback', 'px-gcm', 'gcm_setting-section');
	add_settings_field('snpi', __('New post info','px_gcm'), 'snpi_callback', 'px-gcm', 'gcm_setting-section');
        add_settings_field('supi', __('Updated post info','px_gcm'), 'supi_callback', 'px-gcm', 'gcm_setting-section');
        add_settings_field('abd', __('Display admin bar link','px_gcm'), 'abd_callback', 'px-gcm', 'gcm_setting-section' );
	register_setting( 'px-gcm-settings-group', 'gcm_setting', 'px_gcm_settings_validate' );
}
 
function px_gcm_load_textdomain() {
  load_plugin_textdomain( 'px_gcm', false, basename( dirname( __FILE__ ) ) . '/lang' ); 
}

function gcm_section_callback() {
    echo __('Required settings for the plugin and the App.','px_gcm');
}

function api_key_callback() {
    $options = get_option('gcm_setting');
    ?><input type="text" name="gcm_setting[api-key]" size="39" value="<?php echo $options['api-key']; ?>" /><?php
}

function snpi_callback(){
        $options = get_option('gcm_setting');
	$html = '<input type="checkbox" id="snpi" name="gcm_setting[snpi]" value="1"' . checked( 1, $options['snpi'], false ) . '/>';
	echo $html;
}

function supi_callback(){
        $options = get_option('gcm_setting');
	$html= '<input type="checkbox" id="supi" name="gcm_setting[supi]" value="1"' . checked( 1, $options['supi'], false ) . '/>';
	echo $html;
}

function abd_callback() {
    $options = get_option('gcm_setting');
    $html = '<input type="checkbox" id="abd" name="gcm_setting[abd]" value="1"' . checked( 1, $options['abd'], false ) . '/>';
	echo $html;
}

function px_gcm_settings_validate($arr_input) {
        $options = get_option('gcm_setting');
        $options['api-key'] = trim( $arr_input['api-key'] );
	$options['snpi'] = trim( $arr_input['snpi'] );
        $options['supi'] = trim( $arr_input['supi'] );
        $options['abd'] = trim( $arr_input['abd'] );      
        return $options;
}

/*
*
* Send notification for post update
*
*/
$options = get_option('gcm_setting');
if($options['snpi'] != false && is_single()){
function px_update_notification( $new_status, $old_status, $post ) {
    if ( $old_status != 'publish' && $new_status == 'publish' ) {

	$post_title = get_the_title($post);
	$post_url = get_permalink($post);
	$message = __('Post updated','px_gcm').":\n";
	$message .= $post_title . ": " . $post_url;

    // Send notification
    px_sendGCM($message);
   }
 }
}

/*
*
* Send notification for new post
*
*/
$options = get_option('gcm_setting');
if($options['snpi'] != false && is_single() == true){
function px_new_notification( $new_status, $old_status, $post ) {
    if ( $old_status != 'publish' && $new_status == 'publish' ) {

	$post_title = get_the_title($post);
	$post_url = get_permalink($post);
	$message = __('New post','px_gcm').":\n";
	$message .= $post_title . ": " . $post_url;

    // Send notification
    px_sendGCM($message);
   }
 }
}

/*
*
* Register ToolBar
*
*/
$options = get_option('gcm_setting');
if($options['abd'] != false){
function px_gcm_toolbar() {
	global $wp_admin_bar;
	$page = get_site_url().'/wp-admin/admin.php?page=px-gcm';
	$args = array(
		'id'     => 'px_gcm',
		'title'  => '<img class="dashicons dashicons-cloud">GCM</img>', 'px_gcm',
		'href'   =>  "$page",
	);
	$wp_admin_bar->add_menu($args);
}
}

/*
*
* GCM Send Notification
*
*/
function px_sendGCM($message) {
    $id = px_getIds();
    $options = get_option('gcm_setting');
    $apiKey = $options['api-key'];
    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
        'registration_ids' => $id,
        'data' => array( "message" => $message ),);
    $headers = array(
    'Authorization: key=' . $apiKey,
    'Content-Type: application/json');
    
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields ));
 
    $result = curl_exec($ch);
    $answer = json_decode($result);
    $suc = $answer->{'success'};
    $fail = $answer->{'failure'};
    $inf= "<div id='message' class='updated'><p><b>".__('Message sent.','px_gcm')."</b><i>&nbsp;&nbsp;($message)</i></p><p>".__('success:','px_gcm')." $suc  &nbsp;&nbsp;".__('fail:','px_gcm')." $fail </p></div>";
    print_r($inf);
    curl_close($ch);
    return $result;
}

function px_getIds() {
    global $wpdb;
    $px_table_name = $wpdb->prefix.'gcm_users';
    $devices = array();
    $sql = "SELECT gcm_regid FROM $px_table_name";
    $res = $wpdb->get_results($sql);
    if ($res != false) {
        foreach($res as $row){
            array_push($devices, $row->gcm_regid);
        }
    }
    return $devices;
}

add_action( 'plugins_loaded', 'px_gcm_load_textdomain' );
add_action('admin_init', 'px_register_settings');
add_action( 'transition_post_status', 'px_update_notification');
add_action( 'new', 'px_new_notification' );
add_action( 'wp_before_admin_bar_render', 'px_gcm_toolbar', 999 );

?>