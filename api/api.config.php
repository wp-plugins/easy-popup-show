<?php
	// mailchimp
	if(get_option('email_service') == 'mailchimp') {
	
			require_once(EPS_BASEDIR . 'api/mailchimp/Mailchimp.php');
			$apikey = get_option('mchimp_api_key');
			$list_id = get_option('mchimp_list_id');
			
	// getresponse
	} 
?>