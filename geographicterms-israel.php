<?php
/*
Plugin Name: Geographic Terms: Israel
Description: Provide a geography taxonomy containing the hierarchical areas inside the State of Israel.
Version:     0.1
Author:      Dotan Cohen
Author URI:  http://dotancohen.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or die('Nice try!');


add_action('init', 'dc_gt_israel_register_taxonomy');
function dc_gt_israel_register_taxonomy()
{
	$labels = array(
		'name'              => _x('Area', 'taxonomy general name'),
		'singular_name'     => _x('Areas', 'taxonomy singular name'),
		'search_items'      => __('Search Area'),
		'all_items'         => __('All Areas'),
		'parent_item'       => __('Parent Area'),
		'parent_item_colon' => __('Parent Area:'),
		'edit_item'         => __('Edit Area'),
		'update_item'       => __('Update Area'),
		'add_new_item'      => __('Add New Area'),
		'new_item_name'     => __('New Area Name'),
		'menu_name'         => __('Area')
	);

	$args = array(
		'hierarchical' => TRUE,
		'labels'       => $labels,
		'show_ui'      => TRUE,
		'query_var'    => TRUE,
		'rewrite'      => array( 'slug' => 'state' ),
	);

	$post_types = array('post', 'request', 'offering', 'page', 'partner');

	register_taxonomy('geographicterms-israel', $post_types, $args);

}



