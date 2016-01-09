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
	return array(



	<option value="">כל האזורים</option>


	<option value="25" style="font-weight: bold; color: red">צפון</option>
	<option value="5" style="font-weight: bold; color: black">חיפה והסביבה</option>
	<option value="6" style="font-weight: bold; color: black">קריות והסביבה</option>
	<option value="68" style="font-weight: bold; color: black">עכו - נהריה והסביבה</option>
	<option value="20" style="font-weight: bold; color: black">גליל עליון</option>
	<option value="14" style="font-weight: bold; color: black">הכנרת והסביבה</option>
	<option value="53" style="font-weight: bold; color: black">כרמיאל והסביבה</option>
	<option value="91" style="font-weight: bold; color: black">נצרת - שפרעם והסביבה</option>
	<option value="96" style="font-weight: bold; color: black">ראש פינה החולה</option>
	<option value="74" style="font-weight: bold; color: black">גליל תחתון</option>
	<option value="83" style="font-weight: bold; color: black">הגולן</option>


	<option value="101" style="font-weight: bold; color: red">חדרה זכרון ועמקים</option>
	<option value="67" style="font-weight: bold; color: black">זכרון וחוף הכרמל</option>
	<option value="15" style="font-weight: bold; color: black">חדרה והסביבה</option>
	<option value="16" style="font-weight: bold; color: black">קיסריה והסביבה</option>
	<option value="87" style="font-weight: bold; color: black">יקנעם טבעון והסביבה</option>
	<option value="93" style="font-weight: bold; color: black">עמק בית שאן</option>
	<option value="13" style="font-weight: bold; color: black">עפולה והעמקים</option>
	<option value="97" style="font-weight: bold; color: black">רמת מנשה</option>


	<option value="19" style="font-weight: bold; color: red">השרון</option>
	<option value="17" style="font-weight: bold; color: black">נתניה והסביבה</option>
	<option value="18" style="font-weight: bold; color: black">רמת השרון - הרצליה</option>
	<option value="42" style="font-weight: bold; color: black">רעננה - כפר סבא</option>
	<option value="54" style="font-weight: bold; color: black">הוד השרון והסביבה</option>
	<option value="81" style="font-weight: bold; color: black">דרום השרון</option>
	<option value="70" style="font-weight: bold; color: black">צפון השרון</option>


	<option value="2" style="font-weight: bold; color: red">מרכז</option>
	<option value="1" style="font-weight: bold; color: black">תל אביב</option>
	<option value="9" style="font-weight: bold; color: black">ראשון לציון והסביבה</option>
	<option value="11" style="font-weight: bold; color: black">חולון - בת ים</option>
	<option value="3" style="font-weight: bold; color: black">רמת גן - גבעתיים</option>
	<option value="4" style="font-weight: bold; color: black">פתח תקווה והסביבה</option>
	<option value="71" style="font-weight: bold; color: black">ראש העין והסביבה</option>
	<option value="10" style="font-weight: bold; color: black">בקעת אונו</option>
	<option value="51" style="font-weight: bold; color: black">רמלה - לוד</option>
	<option value="78" style="font-weight: bold; color: black">בני ברק - גבעת שמואל</option>
	<option value="92" style="font-weight: bold; color: black">עמק  איילון</option>
	<option value="98" style="font-weight: bold; color: black">שוהם והסביבה</option>
	<option value="8" style="font-weight: bold; color: black">מודיעין והסביבה</option>


	<option value="100" style="font-weight: bold; color: red">אזור ירושלים</option>
	<option value="7" style="font-weight: bold; color: black">ירושלים</option>
	<option value="69" style="font-weight: bold; color: black">בית שמש והסביבה</option>
	<option value="86" style="font-weight: bold; color: black">הרי יהודה - מבשרת והסביבה</option>
	<option value="90" style="font-weight: bold; color: black">מעלה אדומים והסביבה</option>


	<option value="75" style="font-weight: bold; color: red">יהודה שומרון ובקעת הירדן</option>
	<option value="88" style="font-weight: bold; color: black">ישובי דרום ההר</option>
	<option value="45" style="font-weight: bold; color: black">ישובי שומרון</option>
	<option value="80" style="font-weight: bold; color: black">גוש עציון</option>
	<option value="79" style="font-weight: bold; color: black">בקעת הירדן וצפון ים המלח</option>
	<option value="77" style="font-weight: bold; color: black">אריאל וישובי יהודה</option>


	<option value="41" style="font-weight: bold; color: red">שפלה מישור חוף דרומי</option>
	<option value="12" style="font-weight: bold; color: black">נס ציונה - רחובות</option>
	<option value="21" style="font-weight: bold; color: black">אשדוד - אשקלון והסביבה</option>
	<option value="52" style="font-weight: bold; color: black">גדרה - יבנה והסביבה</option>
	<option value="72" style="font-weight: bold; color: black">קרית גת והסביבה</option>
	<option value="99" style="font-weight: bold; color: black">שפלה</option>


	<option value="43" style="font-weight: bold; color: red">דרום</option>
	<option value="22" style="font-weight: bold; color: black">באר שבע והסביבה</option>
	<option value="24" style="font-weight: bold; color: black">אילת וערבה</option>
	<option value="89" style="font-weight: bold; color: black">ישובי הנגב</option>
	<option value="85" style="font-weight: bold; color: black">הנגב המערבי</option>
	<option value="82" style="font-weight: bold; color: black">דרום ים המלח</option>
 

		
	);
}

