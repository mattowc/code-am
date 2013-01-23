<?php
/* 
Plugin name:  Mail Chimp Integration
Plugin URI:  http://onewebcentric.com
Description:  Built for One Web Centric, allows users to subscribe to a Mail Chimp email list
Author:  Jonathon McDonald
Author URI:  http://onwebcentric.com
*/

// Define the plugin path
define( 'JM_MC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Include the MC API class
require_once( JM_MC_PLUGIN_PATH . 'classes/MCAPI.php' );

// Include the options class
require_once( JM_MC_PLUGIN_PATH . 'classes/JM_Options.php' );

// Include contact form integration
require_once( JM_MC_PLUGIN_PATH . 'classes/JM_Contact.php' );

?>