<?php
include_once('misc/cookies.php');
new createCookie;
define('EPS_BASEDIR', dirname(plugin_dir_path(__FILE__)) . '/');
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('THEME_DIR_URL', plugins_url('', __FILE__));
define('MAIN_DIR_URL', dirname(plugins_url('', __FILE__)) . '/');
$fonts = array("Arial", "Arial Black", "Book Antiqua", "Charcoal", "Comic Sans MS", "Courier", "Courier New", "Gadget", "Geneva", "Georgia", "Helvetica", "Impact", "Palatino Linotype", "Lucida Console", "Lucida Grande", "Lucida Sans Unicode", "Monaco", "Tahoma", "Times New Roman", "Trebuchet MS", "Verdana");
$fstyle = array("normal", "italic", "oblique");
$fweight = array("normal", "bold");
$txtaln = array("left", "right", "center", "justify");	
$borderstyle = array("", "solid", "dotted", "dashed", "double", "groove", "ridge", "inset", "outset", "none");
$borderstyletxt = array("predefined", "Solid", "Dotted", "Dashed", "Double", "Groove", "Ridge", "Inset", "Outset", "None");
$brdrcount = count($borderstyle);
	if(isset($_GET['post'])) {
	$poid = $_GET['post'];
	} else {
	$poid = '';
	}
?>