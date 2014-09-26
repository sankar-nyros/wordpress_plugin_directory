<?php
    /*
    Plugin Name: Telephone-Directory
    Description: This is a plugin for save contacts
    Author: G. Gowri Sankar
    Version: 1.0
    Author URI: http://www.gowrisankar.com
    */
?>
<?php

// Full path and plugin basename of the main plugin file
$td_plugin_file = dirname ( dirname ( __FILE__ ) ) . '/custom-plugin.php';
$td_plugin_basename = plugin_basename ( $td_plugin_file );

function directory_admin() {
    include('directory_admin.php');
}

function directory_admin_actions() {
	add_options_page("Telephone Directory", "Telephone Directory", 1, "Telephone_directory", "directory_admin");  
	//read  -> 1 (only admin)
}
 
add_action('admin_menu', 'directory_admin_actions');


/*
 * Creating short code for contacts directory
 */
 
function shortcode_directory($args) {
	return include('directory_admin.php');
}

add_shortcode('directory', 'shortcode_directory');


/*
 * Create database tables 
 */
 
global $contacts_db_version;
$contacts_db_version = "1.0";

function directory_install() {
   global $wpdb;
   global $contacts_db_version;

   $table_name = $wpdb->prefix . "directory";
      
   $sql = "CREATE TABLE $table_name (
			  id int(11) NOT NULL AUTO_INCREMENT,
			  name text NOT NULL,
			  contact varchar(50) NOT NULL,
			  user_id int(11) NOT NULL,
			  PRIMARY KEY (id)
    	   );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "contacts_db_version", $contacts_db_version );
}

register_activation_hook( __FILE__, 'directory_install' );

add_action ( 'admin_menu' , 'td_options_page' ) ;

// Add the options page
function td_options_page () {
	global $td_plugin_basename;
	add_filter("plugin_action_links", 'td_filter_plugin_actions' );
}

// Add the setting link to the plugin actions
function td_filter_plugin_actions ( $links ) {
        $settings_link = '<a href="options-general.php?page=Telephone_directory">' . __( 'Settings' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
}


