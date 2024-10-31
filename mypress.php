<?php
/*
Plugin Name: MyPress WordPress
Plugin URI: https://www.danilo.rocks
Description: Connect MyBB with WordPress
Version: 1.01
Author: Grork
Author URI: https://www.danilo.rocks
 */
 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$mybb_path = ( is_dir( $_SERVER['DOCUMENT_ROOT'] .'/forum' ) ? '/forum/' : '' );

/*
 *
 * Admin settings
 *
*/
add_option( 'mp_mybb_path', $mybb_path );
update_option( 'users_can_register', 0 );

function mypress_settings_page() {
	add_options_page( __('MyPress settings', 'mypress'), 'MyPress', 'manage_options', 'mypress', 'mypress_settings' );
}

function mypress_add_action_links( $links ) {
	
	$mylinks = array(
		'<a href="' . admin_url( 'options-general.php?page=mypress' ) . '">Settings</a>',
	);
	return array_merge( $links, $mylinks );
	
}

add_action('admin_menu', 'mypress_settings_page');
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mypress_add_action_links' );

function mypress_settings() {
	
	if ( isset( $_POST['mybb_path'] ) ) update_option( 'mp_mybb_path', addslashes( $_POST['mybb_path'] ) );
	?>
	<div class="wrap">
    <h1><?php _e('MyPress settings', 'mypress'); ?></h1>
    <form action="options-general.php?page=mypress" method="POST">

      <table class="form-table">
        <tbody>
          <tr>
            <th scope="row"><label for="mybb_path"><?php _e('MyBB Path', 'mypress'); ?></label></th>
            <td><input type="text" class="regular-text" id="mybb_path" name="mybb_path" value="<?php echo get_option('mp_mybb_path'); ?>" required /></td>
          </tr>
        </tbody>
      </table>
      <input type="submit" class="button button-primary" id="submit" value="<?php _e('Save Changes') ?>" />
    </form>
	</div>
	<?php
	
}

/*
 *
 * Core
 *
*/
add_action( 'wp_login', 'mypress_login_mybb', 10, 2 );
function mypress_login_mybb( $user_login, $user ) {
    
	list( $db, $prefix ) = mp_load_mybb();
	$mybb_uinfo = $db->query( "SELECT uid, loginkey FROM `".$prefix."users` WHERE idwp=".$user->ID );
	if ( $mybb_uinfo->num_rows > 0 ) {
		
		$info = $mybb_uinfo->fetch_assoc();
		
		setcookie( 'mybbuser', $info['uid'].'_'.$info['loginkey'], time()+3600, '/' );
			
	}
	
}

add_action( 'wp_logout', 'mp_logout_mybb', 10, 2 );
function mp_logout_mybb() {
    
	setcookie( 'mybbuser', '', -1, '/' );
	
}


/*
 *
 * Core - MyBB Inclusion
 *
*/
function mp_load_mybb() {

	$mybb_config = $_SERVER['DOCUMENT_ROOT'] . get_option( 'mp_mybb_path' ) . 'inc/config.php';
	if ( !file_exists($mybb_config) ) {
		
		die( 'Error loading WordPress.<br />File not found: <strong>config.php</strong>.<br />Path: '.$mybb_config );
			
	}
	
	require_once $mybb_config;
	
	$db = new mysqli( $config['database']['hostname'], $config['database']['username'], $config['database']['password'], $config['database']['database'] );
	
	return array( $db, $config['database']['table_prefix'] );
	
}

?>