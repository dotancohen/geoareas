<?php
/*
Plugin Name: GeoAreas
Description: Provide a geography taxonomy containing hierarchical geographic areas.
Version:     0.1
Author:      Dotan Cohen
Author URI:  http://dotancohen.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

defined('ABSPATH') or die('Nice try!');

global $taxonomy;
$taxonomy = 'geoareas';

class GeographicArea {

	public $slug;
	public $name;
	public $children;

	public function __construct($slug, $name, $children=NULL)
	{
		$this->slug = $slug;
		$this->name = $name;
		$this->children = $children;
	}
}



add_action('init', 'geoareas_register_taxonomy');
function geoareas_register_taxonomy()
{
	global $taxonomy;

	$labels = array(
		'name'              => _x('GeoArea', 'taxonomy general name'),
		'singular_name'     => _x('GeoAreas', 'taxonomy singular name'),
		'search_items'      => __('Search GeoArea'),
		'all_items'         => __('All GeoAreas'),
		'parent_item'       => __('Parent GeoArea'),
		'parent_item_colon' => __('Parent GeoArea:'),
		'edit_item'         => __('Edit GeoArea'),
		'update_item'       => __('Update GeoArea'),
		'add_new_item'      => __('Add New GeoArea'),
		'new_item_name'     => __('New GeoArea Name'),
		'menu_name'         => __('GeoAreas')
	);

	$args = array(
		'hierarchical' => TRUE,
		'labels'       => $labels,
		'show_ui'      => TRUE,
		'query_var'    => TRUE,
		'rewrite'      => array( 'slug' => 'state' ),
	);

	$post_types = array('post', 'request', 'offering', 'page', 'partner');

	$post_types = apply_filters('geoareas_post_types', $post_types);
	$args = apply_filters('geoareas_register_taxonomy', $args);

	register_taxonomy($taxonomy, $post_types, $args);

}



add_action('init', 'geoareas_add_terms');
function geoareas_add_terms()
{
	global $taxonomy;

	$check = get_terms($taxonomy);

	if ( !$check ) {
		$areas = geoareas_get_areas();
		$areas = apply_filters('geoareas_areas', $areas);
		geoareas_add_area($taxonomy, $areas);
	}

}



function geoareas_add_area($taxonomy, $areas, $parent_id=0) {

	foreach ( $areas as $area ) {

		$term = term_exists($area->name, $taxonomy, $parent_id);
		if ( $term == 0 ) {
			$args = array('slug'=>$area->slug, 'parent'=>$parent_id);
			$args = apply_filters('geoareas_insert_term', $args);
			$term = wp_insert_term($area->name, $taxonomy, $args);
		}

		if ( $area->children !== NULL ) {
			geoareas_add_area($taxonomy, $area->children, $term['term_id']);
		}

	}
}



function geoareas_get_areas()
{
	$sub_north = array (
		new GeographicArea('haifa', 'חיפה והסביבה'),
		new GeographicArea('kraiot', 'קריות והסביבה'),
		new GeographicArea('ako_naharia', 'עכו - נהריה והסביבה'),
		new GeographicArea('galil_top', 'גליל עליון'),
		new GeographicArea('kinneret', 'הכנרת והסביבה'),
		new GeographicArea('carmiel', 'כרמיאל והסביבה'),
		new GeographicArea('natzrat', 'נצרת - שפרעם והסביבה'),
		new GeographicArea('rosh_pina', 'ראש פינה החולה'),
		new GeographicArea('galil_bottom', 'גליל תחתון'),
		new GeographicArea('golan', 'הגולן')
	);

	$sub_hadera = array (
		new GeographicArea('zichron', 'זכרון וחוף הכרמל'),
		new GeographicArea('hadera', 'חדרה והסביבה'),
		new GeographicArea('cesaria', 'קיסריה והסביבה'),
		new GeographicArea('yokneam', 'יקנעם טבעון והסביבה'),
		new GeographicArea('house_of_shaan', 'עמק בית שאן'),
		new GeographicArea('afula', 'עפולה והעמקים'),
		new GeographicArea('meshane_heights', 'רמת מנשה')
	);

	$sub_hasharon = array (
		new GeographicArea('netanya', 'נתניה והסביבה'),
		new GeographicArea('hertzelia', 'רמת השרון - הרצליה'),
		new GeographicArea('raanana', 'רעננה - כפר סבא'),
		new GeographicArea('hod_hasharon', 'הוד השרון והסביבה'),
		new GeographicArea('south_sharon', 'דרום השרון'),
		new GeographicArea('north_sharon', 'צפון השרון')
	);

	$sub_center = array (
		new GeographicArea('tel_aviv', 'תל אביב'),
		new GeographicArea('rishon', 'ראשון לציון והסביבה'),
		new GeographicArea('bat_yam', 'חולון - בת ים'),
		new GeographicArea('ramat_gan', 'רמת גן - גבעתיים'),
		new GeographicArea('petach_tikva', 'פתח תקווה והסביבה'),
		new GeographicArea('rosh_haain', 'ראש העין והסביבה'),
		new GeographicArea('ono', 'בקעת אונו'),
		new GeographicArea('lod', 'רמלה - לוד'),
		new GeographicArea('bnei_brak', 'בני ברק - גבעת שמואל'),
		new GeographicArea('ayalon', 'עמק איילון'),
		new GeographicArea('shoham', 'שוהם והסביבה'),
		new GeographicArea('modiin', 'מודיעין והסביבה')
	);

	$sub_jerusalem = array (
		new GeographicArea('jerusalem', 'ירושלים'),
		new GeographicArea('beit_shemesh', 'בית שמש והסביבה'),
		new GeographicArea('mivreshet', 'הרי יהודה - מבשרת והסביבה'),
		new GeographicArea('maale_adomim', 'מעלה אדומים והסביבה')
	);

	$sub_aiosh = array (
		new GeographicArea('south_hebron', 'ישובי דרום ההר'),
		new GeographicArea('shomron', 'ישובי שומרון'),
		new GeographicArea('gush_atzion', 'גוש עציון'),
		new GeographicArea('north_dead_sea', 'בקעת הירדן וצפון ים המלח'),
		new GeographicArea('ariel', 'אריאל וישובי יהודה')
	);

	$sub_shefela = array (
		new GeographicArea('ness_tziona', 'נס ציונה - רחובות'),
		new GeographicArea('ashdod', 'אשדוד - אשקלון והסביבה'),
		new GeographicArea('gdera', 'גדרה - יבנה והסביבה'),
		new GeographicArea('kiryat_gat', 'קרית גת והסביבה'),
		new GeographicArea('shfela', 'שפלה')
	);

	$sub_south = array (
		new GeographicArea('beersheba', 'באר שבע והסביבה'),
		new GeographicArea('eilat', 'אילת וערבה'),
		new GeographicArea('negev', 'ישובי הנגב'),
		new GeographicArea('west_negev', 'הנגב המערבי'),
		new GeographicArea('south_dead_sea', 'דרום ים המלח')
	);
 


	$main_areas = array(
		new GeographicArea('north', 'צפון', $sub_north),
		new GeographicArea('hadera', 'חדרה זכרון ועמקים', $sub_hadera),
		new GeographicArea('hasharon', 'השרון', $sub_hasharon),
		new GeographicArea('center', 'מרכז', $sub_center),
		new GeographicArea('jerusalem', 'אזור ירושלים', $sub_jerusalem),
		new GeographicArea('aiosh', 'יהודה שומרון ובקעת הירדן', $sub_aiosh),
		new GeographicArea('shefela', 'שפלה מישור חוף דרומי', $sub_shefela),
		new GeographicArea('south', 'דרום', $sub_south)
	);



	return array(
		new GeographicArea('everything', 'כל האזורים', $main_areas),
	);

		
}

