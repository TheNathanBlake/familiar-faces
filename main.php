<?php
/*
Plugin Name: Familiar Faces
Version: 0.9.1
Plugin URI: http://nathan.pavlovagency.com/
Description: Put your team members in the spotlight, anywhere on your site, however you like!
Author: Nathan Smith
Author URI: nathanspage.neocities.com
*/
defined('ABSPATH') or die('Nice try.');

include 'shortcode.php';
include 'admin_page.php';
include 'coffee.php';
include 'table_classes.php';

if(is_admin())
{
	/*
	add the admin menu to the client
	TODO test chaining includes to each other to prevent overlap
	 */	
	add_action('admin_menu', 'pavlov_faces_menu');
	add_action('admin_enqueue_scripts', 'admin_beautiful_things');
	add_action('admin_enqueue_scripts', 'wp_enqueue_media');
	add_action('admin_menu', 'add_this_plugin_to_the_dashboard');
}

function add_this_plugin_to_the_dashboard()
{
	add_menu_page('Familiar Faces', 'Familiar Faces', 'manage_options', 'facespage', 'admin_page', plugin_dir_url(__FILE__).'images/dashicon.png', '25.1966205712');
}

function admin_beautiful_things()
{
	wp_enqueue_style('admin_pavlov', plugin_dir_url(__FILE__)."styles/admin_page.css", array(), null);
}


function add_beautiful_things()
{
	wp_enqueue_style('faces_of_pavlov', plugin_dir_url(__FILE__)."styles/four_faces.css");
}

function add_nouveautiful_things()
{
	wp_enqueue_style('faces_full', plugin_dir_url(__FILE__)."styles/presentation.css");
}

add_shortcode('pavlov_faces', 'random_faces_count_handler');
add_shortcode('pavlov_faces_full', 'listed_faces_handler');

$maintable = new MainFaceTable();
register_activation_hook(__FILE__, array($maintable, 'make_tables'));

$datatable = new FaceInfoTable();
register_activation_hook(__FILE__, array($datatable, 'make_tables'));

add_action('wp_enqueue_scripts', 'add_beautiful_things');
add_action('wp_enqueue_scripts', 'add_nouveautiful_things');

//AJAX hooks for the presentation.
add_action('wp_ajax_test_the_waters', 'coffee');
add_action('wp_ajax_nopriv_test_the_waters', 'coffee');

add_action('vc_before_init', 'make_element');
add_action('vc_before_init', 'make_full_element');

//add a URL variable because Wordpress doesn't like it when developers do normal things normally. >:(
function add_query_vars_filter($vars) {
	$vars[] = "face_id";
	return $vars;
}
add_filter('query_vars', 'add_query_vars_filter');
?>