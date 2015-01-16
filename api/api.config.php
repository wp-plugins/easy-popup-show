<?php
	// mailchimp
	if(get_option('email_service') == 'mailchimp') {
	
			require_once(EPS_BASEDIR . 'api/mailchimp/Mailchimp.php');
			$apikey = get_option('mchimp_api_key');
			$list_id = get_option('mchimp_list_id');
			
	// getresponse
	} elseif(get_option('email_service') == 'getresponse') {
	
			require_once(EPS_BASEDIR . 'api/getresponse/jsonRPCClient.php');
			
			$apikey = get_option('getresponse_api_key');
			$camp_name = get_option('getresponse_camp_name');
			$api_url = 'http://api2.getresponse.com';	

	// constantcontact
	} elseif(get_option('email_service') == 'constantcontact') {

		require_once(EPS_BASEDIR . 'api/constantcontact/src/Ctct/autoload.php');
		$apikey = get_option('constantcontact_api_key');
		$consumer_secret = get_option('constantcontact_consumer_secret');
		$redirect_uri = get_option('constantcontact_redirect_uri');
		$access_token = get_option('constantcontact_access_token');
		$list_id = get_option('constantcontact_list_id');
		
	// aweber
	} elseif(get_option('email_service') == 'aweber') {
		require_once(EPS_BASEDIR . 'api/aweber/aweber_api/aweber_api.php');
		// owHijhwxh3rbx
		// $app_id = get_option('aweber_app_id');
		// $app_url = "https://auth.aweber.com/1.0/oauth/authorize_app/" . $app_id;
		$apikey = get_option('aweber_app_apikey');
		$consumerSecret = get_option('aweber_app_consumerSecret');
		$accessKey = get_option('aweber_app_accessKey');
		$accessSecret = get_option('aweber_app_accessSecret');
		$account_id =  get_option('aweber_app_account_id');
		$list_id = get_option('aweber_app_list_id');
	} 
?>