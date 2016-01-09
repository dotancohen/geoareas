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
'חיפה והסביבה',
'קריות והסביבה',
'עכו - נהריה והסביבה',
'גליל עליון',
'הכנרת והסביבה',
'כרמיאל והסביבה',
'נצרת - שפרעם והסביבה',
'ראש פינה החולה',
'גליל תחתון',
'הגולן'
);


$sub_hadera = array (
'זכרון וחוף הכרמל',
'חדרה והסביבה',
'קיסריה והסביבה',
'יקנעם טבעון והסביבה',
'עמק בית שאן',
'עפולה והעמקים',
'רמת מנשה'
);


$sub_hasharon = array (
'נתניה והסביבה',
'רמת השרון - הרצליה',
'רעננה - כפר סבא',
'הוד השרון והסביבה',
'דרום השרון',
'צפון השרון'
);


$sub_center = array (
'תל אביב',
'ראשון לציון והסביבה',
'חולון - בת ים',
'רמת גן - גבעתיים',
'פתח תקווה והסביבה',
'ראש העין והסביבה',
'בקעת אונו',
'רמלה - לוד',
'בני ברק - גבעת שמואל',
'עמק  איילון',
'שוהם והסביבה',
'מודיעין והסביבה'
);


$sub_jerusalem = array (
'ירושלים',
'בית שמש והסביבה',
'הרי יהודה - מבשרת והסביבה',
'מעלה אדומים והסביבה'
);


$sub_aiosh = array (
'ישובי דרום ההר',
'ישובי שומרון',
'גוש עציון',
'בקעת הירדן וצפון ים המלח',
'אריאל וישובי יהודה'
);


$sub_shefela = array (
'נס ציונה - רחובות',
'אשדוד - אשקלון והסביבה',
'גדרה - יבנה והסביבה',
'קרית גת והסביבה',
'שפלה'
);


$sub_south = array (
'באר שבע והסביבה',
'אילת וערבה',
'ישובי הנגב',
'הנגב המערבי',
'דרום ים המלח'
);
 



$north = array('north' => 'צפון', 'inner' => $sub_north);
$hadera = array('hadera' => 'חדרה זכרון ועמקים', 'inner' => $sub_hadera);
$hasharon = array('hasharon' => 'השרון', 'inner' => $sub_hasharon);
$center = array('center' => 'מרכז', 'inner' => $sub_center);
$jerusalem = array('jerusalem' => 'אזור ירושלים', 'inner' => $sub_jerusalem);
$aiosh = array('aiosh' => 'יהודה שומרון ובקעת הירדן', 'inner' => $sub_aiosh);
$shefela = array('shefela' => 'שפלה מישור חוף דרומי', 'inner' => $sub_shefela);
$south = array('south' => 'דרום', 'inner' => $sub_south);

	return array(
		'everything' => 'כל האזורים',
		'inner' => $main_areas
	);

		
}

