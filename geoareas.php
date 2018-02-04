<?php
/*
Plugin Name: GeoAreas
Description: Provide a geography taxonomy containing hierarchical geographic areas.
Version:     0.4
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

	$post_types = array('post', 'page');

	$post_types = apply_filters('geoareas_post_types', $post_types);
	$args = apply_filters('geoareas_register_taxonomy', $args);

	register_taxonomy($taxonomy, $post_types, $args);

}



register_activation_hook(__FILE__, 'geoareas_add_terms');
function geoareas_add_terms()
{
	global $taxonomy;

	$check = get_terms($taxonomy);

	if ( !$check ) {
		$areas = geoareas_get_areas();
		$areas = apply_filters('geoareas_insert_areas', $areas);
		geoareas_add_area($taxonomy, $areas);
	}

}



function geoareas_add_area($taxonomy, $areas, $parent_id=0) {

	foreach ( $areas as $area ) {

		$term = term_exists($area->name, $taxonomy, $parent_id);
		if ( $term == 0 ) {
			$args = array('slug'=>$area->slug, 'parent'=>$parent_id);
			$args = apply_filters('geoareas_insert_area', $args);
			$term = wp_insert_term($area->name, $taxonomy, $args);
		}

		if ( $area->children !== NULL ) {
			geoareas_add_area($taxonomy, $area->children, $term['term_id']);
		}

	}
}



register_deactivation_hook( __FILE__, 'geoareas_delete_areas' );
function geoareas_delete_areas()
{
	global $taxonomy;

	$areas = geoareas_get_areas();
	geoareas_delete_area($taxonomy, $areas);

}



function geoareas_delete_area($taxonomy, $areas)
{
	foreach ( $areas as $area ) {
		$tid = get_term_by('slug', $area->slug, $taxonomy);
		wp_delete_term($tid, $taxonomy);

		if ( $area->children !== NULL ) {
			geoareas_delete_area($taxonomy, $area->children);
		}
	}
}



function geoareas_get_areas()
{
	$israel_north = array (
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

	$israel_hadera = array (
		new GeographicArea('zichron', 'זכרון וחוף הכרמל'),
		new GeographicArea('hadera', 'חדרה והסביבה'),
		new GeographicArea('cesaria', 'קיסריה והסביבה'),
		new GeographicArea('yokneam', 'יקנעם טבעון והסביבה'),
		new GeographicArea('house_of_shaan', 'עמק בית שאן'),
		new GeographicArea('afula', 'עפולה והעמקים'),
		new GeographicArea('meshane_heights', 'רמת מנשה')
	);

	$israel_hasharon = array (
		new GeographicArea('netanya', 'נתניה והסביבה'),
		new GeographicArea('hertzelia', 'רמת השרון - הרצליה'),
		new GeographicArea('raanana', 'רעננה - כפר סבא'),
		new GeographicArea('hod_hasharon', 'הוד השרון והסביבה'),
		new GeographicArea('south_sharon', 'דרום השרון'),
		new GeographicArea('north_sharon', 'צפון השרון')
	);

	$israel_center = array (
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

	$israel_jerusalem = array (
		new GeographicArea('jerusalem', 'ירושלים'),
		new GeographicArea('beit_shemesh', 'בית שמש והסביבה'),
		new GeographicArea('mivreshet', 'הרי יהודה - מבשרת והסביבה'),
		new GeographicArea('maale_adomim', 'מעלה אדומים והסביבה')
	);

	$israel_aiosh = array (
		new GeographicArea('south_hebron', 'ישובי דרום ההר'),
		new GeographicArea('shomron', 'ישובי שומרון'),
		new GeographicArea('gush_atzion', 'גוש עציון'),
		new GeographicArea('north_dead_sea', 'בקעת הירדן וצפון ים המלח'),
		new GeographicArea('ariel', 'אריאל וישובי יהודה')
	);

	$israel_shefela = array (
		new GeographicArea('ness_tziona', 'נס ציונה - רחובות'),
		new GeographicArea('ashdod', 'אשדוד - אשקלון והסביבה'),
		new GeographicArea('gdera', 'גדרה - יבנה והסביבה'),
		new GeographicArea('kiryat_gat', 'קרית גת והסביבה'),
		new GeographicArea('shfela', 'שפלה')
	);

	$israel_south = array (
		new GeographicArea('beersheba', 'באר שבע והסביבה'),
		new GeographicArea('eilat', 'אילת וערבה'),
		new GeographicArea('negev', 'ישובי הנגב'),
		new GeographicArea('west_negev', 'הנגב המערבי'),
		new GeographicArea('south_dead_sea', 'דרום ים המלח')
	);
 
	$israel = array(
		new GeographicArea('north', 'צפון', $israel_north),
		new GeographicArea('hadera', 'חדרה זכרון ועמקים', $israel_hadera),
		new GeographicArea('hasharon', 'השרון', $israel_hasharon),
		new GeographicArea('center', 'מרכז', $israel_center),
		new GeographicArea('jerusalem', 'אזור ירושלים', $israel_jerusalem),
		new GeographicArea('aiosh', 'יהודה שומרון ובקעת הירדן', $israel_aiosh),
		new GeographicArea('shefela', 'שפלה מישור חוף דרומי', $israel_shefela),
		new GeographicArea('south', 'דרום', $israel_south)
	);



	$main_areas = array(
		new GeographicArea('afghanistan', 'Afghanistan'),
		new GeographicArea('albania', 'Albania'),
		new GeographicArea('algeria', 'Algeria'),
		new GeographicArea('andorra', 'Andorra'),
		new GeographicArea('angola', 'Angola'),
		new GeographicArea('antigua_and_barbuda', 'Antigua and Barbuda'),
		new GeographicArea('argentina', 'Argentina'),
		new GeographicArea('armenia', 'Armenia'),
		new GeographicArea('australia', 'Australia'),
		new GeographicArea('austria', 'Austria'),
		new GeographicArea('azerbaijan', 'Azerbaijan'),
		new GeographicArea('bahamas', 'Bahamas'),
		new GeographicArea('bahrain', 'Bahrain'),
		new GeographicArea('bangladesh', 'Bangladesh'),
		new GeographicArea('barbados', 'Barbados'),
		new GeographicArea('belarus', 'Belarus'),
		new GeographicArea('belgium', 'Belgium'),
		new GeographicArea('belize', 'Belize'),
		new GeographicArea('benin', 'Benin'),
		new GeographicArea('bhutan', 'Bhutan'),
		new GeographicArea('bolivia', 'Bolivia'),
		new GeographicArea('bosnia_and_herzegovina', 'Bosnia and Herzegovina'),
		new GeographicArea('botswana', 'Botswana'),
		new GeographicArea('brazil', 'Brazil'),
		new GeographicArea('brunei', 'Brunei'),
		new GeographicArea('bulgaria', 'Bulgaria'),
		new GeographicArea('burkina_faso', 'Burkina Faso'),
		new GeographicArea('burma', 'Burma'),
		new GeographicArea('burundi', 'Burundi'),
		new GeographicArea('cambodia', 'Cambodia'),
		new GeographicArea('cameroon', 'Cameroon'),
		new GeographicArea('canada', 'Canada'),
		new GeographicArea('cape_verde', 'Cape Verde'),
		new GeographicArea('central_african_republic', 'Central African Republic'),
		new GeographicArea('chad', 'Chad'),
		new GeographicArea('chile', 'Chile'),
		new GeographicArea('china', 'China'),
		new GeographicArea('colombia', 'Colombia'),
		new GeographicArea('comoros', 'Comoros'),
		new GeographicArea('congo, democratic_republic', 'Congo, Democratic Republic'),
		new GeographicArea('congo, republic_of', 'Congo, Republic of'),
		new GeographicArea('costa_rica', 'Costa Rica'),
		new GeographicArea('cote dIvoire', 'Côte d\'Ivoire'),
		new GeographicArea('croatia', 'Croatia'),
		new GeographicArea('cuba', 'Cuba'),
		new GeographicArea('cyprus', 'Cyprus'),
		new GeographicArea('czech_republic', 'Czech Republic'),
		new GeographicArea('denmark', 'Denmark'),
		new GeographicArea('djibouti', 'Djibouti'),
		new GeographicArea('dominica', 'Dominica'),
		new GeographicArea('dominican_republic', 'Dominican Republic'),
		new GeographicArea('east_timor', 'East Timor'),
		new GeographicArea('ecuador', 'Ecuador'),
		new GeographicArea('egypt', 'Egypt'),
		new GeographicArea('el_salvador', 'El Salvador'),
		new GeographicArea('equatorial_guinea', 'Equatorial Guinea'),
		new GeographicArea('eritrea', 'Eritrea'),
		new GeographicArea('estonia', 'Estonia'),
		new GeographicArea('ethiopia', 'Ethiopia'),
		new GeographicArea('fiji', 'Fiji'),
		new GeographicArea('finland', 'Finland'),
		new GeographicArea('france', 'France'),
		new GeographicArea('gabon', 'Gabon'),
		new GeographicArea('gambia', 'Gambia'),
		new GeographicArea('georgia', 'Georgia'),
		new GeographicArea('germany', 'Germany'),
		new GeographicArea('ghana', 'Ghana'),
		new GeographicArea('greece', 'Greece'),
		new GeographicArea('grenada', 'Grenada'),
		new GeographicArea('guatemala', 'Guatemala'),
		new GeographicArea('guinea', 'Guinea'),
		new GeographicArea('guinea-bissau', 'Guinea-Bissau'),
		new GeographicArea('guyana', 'Guyana'),
		new GeographicArea('haiti', 'Haiti'),
		new GeographicArea('honduras', 'Honduras'),
		new GeographicArea('hungary', 'Hungary'),
		new GeographicArea('iceland', 'Iceland'),
		new GeographicArea('india', 'India'),
		new GeographicArea('indonesia', 'Indonesia'),
		new GeographicArea('iran', 'Iran'),
		new GeographicArea('iraq', 'Iraq'),
		new GeographicArea('ireland', 'Ireland'),
		new GeographicArea('israel', 'Israel', $israel),
		new GeographicArea('italy', 'Italy'),
		new GeographicArea('jamaica', 'Jamaica'),
		new GeographicArea('japan', 'Japan'),
		new GeographicArea('jordan', 'Jordan'),
		new GeographicArea('kazakhstan', 'Kazakhstan'),
		new GeographicArea('kenya', 'Kenya'),
		new GeographicArea('kiribati', 'Kiribati'),
		new GeographicArea('korea, north', 'Korea, North'),
		new GeographicArea('korea, south', 'Korea, South'),
		new GeographicArea('kuwait', 'Kuwait'),
		new GeographicArea('kyrgyzstan', 'Kyrgyzstan'),
		new GeographicArea('laos', 'Laos'),
		new GeographicArea('latvia', 'Latvia'),
		new GeographicArea('lebanon', 'Lebanon'),
		new GeographicArea('lesotho', 'Lesotho'),
		new GeographicArea('liberia', 'Liberia'),
		new GeographicArea('libya', 'Libya'),
		new GeographicArea('liechtenstein', 'Liechtenstein'),
		new GeographicArea('lithuania', 'Lithuania'),
		new GeographicArea('luxembourg', 'Luxembourg'),
		new GeographicArea('macedonia', 'Macedonia'),
		new GeographicArea('madagascar', 'Madagascar'),
		new GeographicArea('malawi', 'Malawi'),
		new GeographicArea('malaysia', 'Malaysia'),
		new GeographicArea('maldives', 'Maldives'),
		new GeographicArea('mali', 'Mali'),
		new GeographicArea('malta', 'Malta'),
		new GeographicArea('marshall_islands', 'Marshall Islands'),
		new GeographicArea('mauritania', 'Mauritania'),
		new GeographicArea('mauritius', 'Mauritius'),
		new GeographicArea('mexico', 'Mexico'),
		new GeographicArea('micronesia', 'Micronesia'),
		new GeographicArea('moldova', 'Moldova'),
		new GeographicArea('monaco', 'Monaco'),
		new GeographicArea('mongolia', 'Mongolia'),
		new GeographicArea('montenegro', 'Montenegro'),
		new GeographicArea('morocco', 'Morocco'),
		new GeographicArea('mozambique', 'Mozambique'),
		new GeographicArea('myanmar', 'Myanmar'),
		new GeographicArea('namibia', 'Namibia'),
		new GeographicArea('nauru', 'Nauru'),
		new GeographicArea('nepal', 'Nepal'),
		new GeographicArea('netherlands', 'Netherlands'),
		new GeographicArea('new zealand', 'New Zealand'),
		new GeographicArea('nicaragua', 'Nicaragua'),
		new GeographicArea('nigeria', 'Nigeria'),
		new GeographicArea('northern_ireland', 'Northern Ireland'),
		new GeographicArea('norway', 'Norway'),
		new GeographicArea('oman', 'Oman'),
		new GeographicArea('pakistan', 'Pakistan'),
		new GeographicArea('palau', 'Palau'),
		new GeographicArea('palestine', 'Palestine'),
		new GeographicArea('panama', 'Panama'),
		new GeographicArea('papua new_guinea', 'Papua New Guinea'),
		new GeographicArea('paraguay', 'Paraguay'),
		new GeographicArea('peru', 'Peru'),
		new GeographicArea('philippines', 'Philippines'),
		new GeographicArea('poland', 'Poland'),
		new GeographicArea('portugal', 'Portugal'),
		new GeographicArea('qatar', 'Qatar'),
		new GeographicArea('romania', 'Romania'),
		new GeographicArea('russia', 'Russia'),
		new GeographicArea('rwanda', 'Rwanda'),
		new GeographicArea('samoa', 'Samoa'),
		new GeographicArea('san_marino', 'San Marino'),
		new GeographicArea('sao_tome_and_principe', 'São Tomé and Príncipe'),
		new GeographicArea('saudi_arabia', 'Saudi Arabia'),
		new GeographicArea('senegal', 'Senegal'),
		new GeographicArea('serbia', 'Serbia'),
		new GeographicArea('seychelles', 'Seychelles'),
		new GeographicArea('sierra_leone', 'Sierra Leone'),
		new GeographicArea('singapore', 'Singapore'),
		new GeographicArea('slovakia', 'Slovakia'),
		new GeographicArea('slovenia', 'Slovenia'),
		new GeographicArea('solomon_islands', 'Solomon Islands'),
		new GeographicArea('somalia', 'Somalia'),
		new GeographicArea('south_africa', 'South Africa'),
		new GeographicArea('spain', 'Spain'),
		new GeographicArea('sri_lanka', 'Sri Lanka'),
		new GeographicArea('st_kitts_and_nevis', 'St. Kitts and Nevis'),
		new GeographicArea('st_lucia', 'St. Lucia'),
		new GeographicArea('st_vincent_and_grenadines', 'St. Vincent and the Grenadines'),
		new GeographicArea('sudan', 'Sudan'),
		new GeographicArea('suriname', 'Suriname'),
		new GeographicArea('swaziland', 'Swaziland'),
		new GeographicArea('sweden', 'Sweden'),
		new GeographicArea('switzerland', 'Switzerland'),
		new GeographicArea('syria', 'Syria'),
		new GeographicArea('taiwan', 'Taiwan'),
		new GeographicArea('tajikistan', 'Tajikistan'),
		new GeographicArea('tanzania', 'Tanzania'),
		new GeographicArea('thailand', 'Thailand'),
		new GeographicArea('togo', 'Togo'),
		new GeographicArea('tonga', 'Tonga'),
		new GeographicArea('trinidad_and_tobago', 'Trinidad and Tobago'),
		new GeographicArea('tunisia', 'Tunisia'),
		new GeographicArea('turkey', 'Turkey'),
		new GeographicArea('turkmenistan', 'Turkmenistan'),
		new GeographicArea('tuvalu', 'Tuvalu'),
		new GeographicArea('uganda', 'Uganda'),
		new GeographicArea('ukraine', 'Ukraine'),
		new GeographicArea('united_arab_emirates', 'United Arab Emirates'),
		new GeographicArea('united_kingdom', 'United Kingdom'),
		new GeographicArea('united_states', 'United States'),
		new GeographicArea('uruguay', 'Uruguay'),
		new GeographicArea('uzbekistan', 'Uzbekistan'),
		new GeographicArea('vanuatu', 'Vanuatu'),
		new GeographicArea('vatican_city', 'Vatican City (Holy See)'),
		new GeographicArea('venezuela', 'Venezuela'),
		new GeographicArea('vietnam', 'Vietnam'),
		new GeographicArea('western_sahara', 'Western Sahara'),
		new GeographicArea('yemen', 'Yemen'),
		new GeographicArea('zaire', 'Zaire'),
		new GeographicArea('zambia', 'Zambia'),
		new GeographicArea('zimbabwe', 'Zimbabwe'),
	);

	return $main_areas;
}

