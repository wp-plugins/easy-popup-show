<?php
require_once(EPS_BASEDIR . 'api/api.config.php');
add_action( 'wp_ajax_mchimp_subscribe', 'autoresponder_service_subscribe' );
add_action( 'wp_ajax_nopriv_mchimp_subscribe', 'autoresponder_service_subscribe' );
function autoresponder_service_subscribe() {
	global $wpdb;
	check_ajax_referer( 'eps-secure-subscribe', 'security' );
	$name = ( $_POST['name'] );
	$email = ( $_POST['email'] );
    
// MAILCHIMP
	if(get_option('email_service') == 'mailchimp') {
		global $apikey, $list_id;
		$Mailchimp = new Mailchimp($apikey);
		
		if(strpos($name, " ")) {
			list($fname, $lname) = explode(' ', $name, 2);
		$merge_vars = array('FNAME' => $fname,
							'LNAME' => $lname);
		} else {
		$merge_vars = array('FNAME' => $name);
		}
		
		$subscribe = $Mailchimp->lists->subscribe(
										$list_id,
										array('email'=>urldecode($email)),
										$merge_vars,
										false,
										true,
										false,
										false	
										);
		 // print_r($subscribe);
		
		if($subscribe[email] != '' && $subscribe[euid] != '' && $subscribe[leid] != '' ) {
			echo "EPS Success Message!";
		}
	}

	
	die();
}
?>