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

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


register_activation_hook( __FILE__, 'gtisrael_activate' );
function gtisrael_activate()
{

}


register_deactivation_hook( __FILE__, 'gtisrael_deactivate' );
function gtisrael_deactivate()
{

}



