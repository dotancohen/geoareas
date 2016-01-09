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



add_action('init', 'dc_gt_israel_add_terms');
function dc_gt_israel_add_terms()
{
	$areas = get_areas();

}



function get_areas()
{
	$sub_north = array (
		'haifa' => 'חיפה והסביבה',
		'kraiot' => 'קריות והסביבה',
		'ako_naharia' => 'עכו - נהריה והסביבה',
		'galil_top' => 'גליל עליון',
		'kinneret' => 'הכנרת והסביבה',
		'carmiel' => 'כרמיאל והסביבה',
		'natzrat' => 'נצרת - שפרעם והסביבה',
		'rosh_pina' => 'ראש פינה החולה',
		'galil_bottom' => 'גליל תחתון',
		'golan' => 'הגולן'
	);

	$sub_hadera = array (
		'zichron' => 'זכרון וחוף הכרמל',
		'hadera' => 'חדרה והסביבה',
		'cesaria' => 'קיסריה והסביבה',
		'yokneam' => 'יקנעם טבעון והסביבה',
		'house_of_shaan' => 'עמק בית שאן',
		'afula' => 'עפולה והעמקים',
		'meshane_heights' => 'רמת מנשה'
	);

	$sub_hasharon = array (
		'netanya' => 'נתניה והסביבה',
		'hertzelia' => 'רמת השרון - הרצליה',
		'raanana' => 'רעננה - כפר סבא',
		'hod_hasharon' => 'הוד השרון והסביבה',
		'south_sharon' => 'דרום השרון',
		'north_sharon' => 'צפון השרון'
	);

	$sub_center = array (
		'tel_aviv' => 'תל אביב',
		'rishon' => 'ראשון לציון והסביבה',
		'bat_yam' => 'חולון - בת ים',
		'ramat_gan' => 'רמת גן - גבעתיים',
		'petach_tikva' => 'פתח תקווה והסביבה',
		'rosh_haain' => 'ראש העין והסביבה',
		'ono' => 'בקעת אונו',
		'lod' => 'רמלה - לוד',
		'bnei_brak' => 'בני ברק - גבעת שמואל',
		'ayalon' => 'עמק  איילון',
		'shoham' => 'שוהם והסביבה',
		'modiin' => 'מודיעין והסביבה'
	);

	$sub_jerusalem = array (
		'jerusalem' => 'ירושלים',
		'beit_shemesh' => 'בית שמש והסביבה',
		'mivreshet' => 'הרי יהודה - מבשרת והסביבה',
		'maale_adomim' => 'מעלה אדומים והסביבה'
	);

	$sub_aiosh = array (
		'south_hebron' => 'ישובי דרום ההר',
		'shomron' => 'ישובי שומרון',
		'gush_atzion' => 'גוש עציון',
		'north_dead_sea' => 'בקעת הירדן וצפון ים המלח',
		'ariel' => 'אריאל וישובי יהודה'
	);

	$sub_shefela = array (
		'ness_tziona' => 'נס ציונה - רחובות',
		'ashdod' => 'אשדוד - אשקלון והסביבה',
		'gdera' => 'גדרה - יבנה והסביבה',
		'kiryat_gat' => 'קרית גת והסביבה',
		'shfela' => 'שפלה'
	);

	$sub_south = array (
		'beersheba' => 'באר שבע והסביבה',
		'eilat' => 'אילת וערבה',
		'negev' => 'ישובי הנגב',
		'west_negev' => 'הנגב המערבי',
		'south_dead_sea' => 'דרום ים המלח'
	);
 


	$main_areas = array(
		array('north' => 'צפון', 'inner' => $sub_north),
		array('hadera' => 'חדרה זכרון ועמקים', 'inner' => $sub_hadera),
		array('hasharon' => 'השרון', 'inner' => $sub_hasharon),
		array('center' => 'מרכז', 'inner' => $sub_center),
		array('jerusalem' => 'אזור ירושלים', 'inner' => $sub_jerusalem),
		array('aiosh' => 'יהודה שומרון ובקעת הירדן', 'inner' => $sub_aiosh),
		array('shefela' => 'שפלה מישור חוף דרומי', 'inner' => $sub_shefela),
		array('south' => 'דרום', 'inner' => $sub_south)
	);



	return array(
		'everything' => 'כל האזורים',
		'inner' => $main_areas
	);

		
}

