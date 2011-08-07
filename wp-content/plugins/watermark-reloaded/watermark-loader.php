<?php
/*
Plugin Name: Watermark RELOADED
Plugin URI: http://randomplac.es/wordpress-plugins/watermark-reloaded/
Description: Add watermark to your uploaded images and customize your watermark appearance in user friendly settings page.
Version: 1.2.4
Author: Sandi Verdev
Author URI: http://randomplac.es/
*/

register_activation_hook(__FILE__, 'watermark_reloaded_activate');

// display error message to users
if ($_GET['action'] == 'error_scrape') {                                                                                                   
    die("Sorry, Watermark RELOADED requires PHP 5.0 or higher. Please deactivate Watermark RELOADED.");                                 
}

function watermark_reloaded_activate() {
	if ( version_compare( phpversion(), '5.0', '<' ) ) {
		trigger_error('', E_USER_ERROR);
	}
}

// require Watermark RELOADED if PHP 5 installed
if ( version_compare( phpversion(), '5.0', '>=') ) {
	define('WR_LOADER', __FILE__);

	require_once(dirname(__FILE__) . '/watermark-reloaded.php');
}
?>