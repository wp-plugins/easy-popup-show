<?php
ob_start();
class createCookie {
function __construct() {
add_action('init', array($this, 'epsSetcookiee'));
}

function epsSetcookiee() {
global $wpdb;
$results = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_type = "easy_popup_show" AND post_status = "publish"', OBJECT );
	foreach($results as $key => $res){
	$popid = $res -> ID;
		$rules = get_post_meta($popid, "_eps_display_rules", true);
		$cookie = get_post_meta($popid, '_eps_cookie_rule', true);
		$cookie = strtotime($cookie . 'day', 0);
		$expiry = get_post_meta($popid, '_eps_cookie_history', true);
		if(is_array($rules)){
		if(in_array('use_cookies', $rules) && $cookie > 0 && !isset($_COOKIE[$popid . "_eps"])){
			setcookie($popid . "_eps", "ShowPopUp", time()+$cookie);
			update_post_meta($popid, '_eps_cookie_history', time()+$cookie);						
		}
		}
	}
}
}
?>