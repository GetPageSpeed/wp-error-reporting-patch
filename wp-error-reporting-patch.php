<?php
/*
 * Plugin Name: WP Error Reporting Patch
 * Description: Stop Wordpress from changing error reporting level
 * Version: 0.1.1
 * Author: Danila Vershinin (www.getpagespeed.com)
 * Author URI: https://www.getpagespeed.com/
 * License: AGPLv3 or later
 * Text Domain: wp-error-reporting-patch
 * Domain Path: /languages/
*/
// disable error_reporting calls in wp-includes/load.php
add_filter('enable_wp_debug_mode_checks', '__return_false');     

// patch wp-load.php file upon Wordpress upgrades or plugin install
function gps_error_reporting_patch_activate() {
    // Activation code here...
    $wp_load = ABSPATH . '/wp-load.php';          
    $wp_load_contents = file_get_contents($wp_load); 
    $search = '/^error_reporting/m'; 
    $replace = '//error_reporting';   
    $new_wp_load_contents = preg_replace($search, $replace, $wp_load_contents);
    if (null !== $new_wp_load_contents && $new_wp_load_contents != $wp_load_contents) {
        file_put_contents($wp_load, $new_wp_load_contents); 
        opcache_invalidate($wp_load);
    }
}    

register_activation_hook( __FILE__, 'gps_error_reporting_patch_activate' ); 
// priority "9" ensures that the patch runs before the opcache clear
add_action('upgrader_process_complete', 'gps_error_reporting_patch_activate', 9, 2);
