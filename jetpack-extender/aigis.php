<?php
/*
Plugin Name: Aigis Shortener for WordPress
Plugin URI: http://example.org/extend/plugins/aigis/
Description: This plugin extends Jetpack Sharing Service.
Version: 0.1-dev
Author: Shield-9 (Extend Wings, Daisuke)
Author URI: http://www.extendwings.com
License: GPLv2
License URI: COPYING.txt
Text Domain: aigis
Domain Path: /languages/
*/

if(!function_exists('add_action')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
//add_action( 'init', 'aigis_jetpack_loader' );
//function aigis_jetpack_loader() {
	include_once(dirname( __FILE__ ) . '/jetpack.php');
//}

if(is_admin())
	include_once(dirname( __FILE__ ) . '/admin.php');

?>