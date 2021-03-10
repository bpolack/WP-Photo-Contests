<?php
/**
* Plugin Name: WP Photo Contests
* Plugin URI: https://github.com/bpolack/WP-Photo-Contests
* Description: Photo contests plugin for user testing.
* Version: 0.1.0
* Author: Braighton Polack
**/
defined( 'ABSPATH' ) or die( 'Direct script access disallowed.' );

// Project Constants
define("PREFIX", "jw");
define("PLUGIN_URL", plugin_dir_url( __FILE__ )); // includes trailing slash
define("ENQUEUE_URL", plugin_dir_url( __FILE__ ) . 'src');
define("INCLUDES_PATH", plugin_dir_path( __FILE__ ) . '/includes');
define("ENQUEUE_PATH", plugin_dir_path( __FILE__ ) . '/src');

//Register scripts and styles
function wp_siema_register_scripts() {
    wp_register_style( PREFIX . '-contest-style', ENQUEUE_URL . '/wp-photo-contests.css', array(), filemtime(ENQUEUE_PATH . '/wp-photo-contests.css'), false );
    wp_register_script( PREFIX . '-siema-slider', ENQUEUE_URL . '/siema.min.js', array(), '', true );
    wp_register_script( PREFIX . '-contest-scripts-siema', ENQUEUE_URL . '/wp-photo-contests-siema.js', array(), filemtime(ENQUEUE_PATH . '/wp-photo-contests-siema.js'), true );
    wp_register_script( PREFIX . '-contest-scripts', ENQUEUE_URL . '/wp-photo-contests.js', array(), filemtime(ENQUEUE_PATH . '/wp-photo-contests.js'), true );
}
add_action( 'wp_enqueue_scripts', 'wp_siema_register_scripts' );

// Include required php files
require('includes/backend.php');
require('includes/shortcodes.php');
