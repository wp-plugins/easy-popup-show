<?php
require_once(EPS_BASEDIR . 'api/api.config.php');
		use Ctct\ConstantContact;
		use Ctct\Components\Contacts\Contact;
		use Ctct\Components\Contacts\ContactList;
		use Ctct\Components\Contacts\EmailAddress;
		use Ctct\Exceptions\CtctException;

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
	// GETRESPONSE
	} elseif(get_option('email_service') == 'getresponse') {
		global $apikey, $camp_name, $api_url;
	if($apikey != '' && $camp_name != '') {

		$client = new jsonRPCClient($api_url);

		$campaigns = $client->get_campaigns(
				$apikey,
				array (
					# find by name literally
					'name' => array ( 'EQUALS' => $camp_name )
				)
			);
			
		$campaign_id = array_pop(array_keys($campaigns));
		$result = $client->add_contact(
			$apikey,
			array (
				# identifier of 'test' campaign
				'campaign'  => $campaign_id,

				# basic info
				'name'      => $name,
				'email'     => $email
			)
		);
	} 
		# uncomment following line to preview Response
			if($result['queued'] == 1) {
				echo "EPS Success Message!";
			}
			
// CONSTANTCONTACT
	} elseif(get_option('email_service') == 'constantcontact') {
			global $apikey, $list_id, $access_token;
			$cc = new ConstantContact($apikey);			

			// $action = "Getting Contact By Email Address";

				try {
					// check to see if a contact with the email addess already exists in the account
					$response = $cc->getContactByEmail($access_token, $email);

					// create a new contact if one does not exist
					if (empty($response->results)) {
						// $action = "Creating Contact";

						$contact = new Contact();
						$contact->addEmail($email);
						$contact->addList($list_id);
						
						if(strpos($name, " ")) {
							list($fname, $lname) = explode(' ', $name, 2);
							$contact->first_name = $fname;
							$contact->last_name = $lname;							
						} else {
							$contact->first_name = $name;
						}

						$returnContact = $cc->addContact($access_token, $contact, false);
						echo "EPS Success Message!";
					
					} else {     
						echo 'List Already Subscribed!';					
					}

					// catch any exceptions thrown during the process and print the errors to screen
				} catch (CtctException $ex) {
					// echo $action;
					die();
				}
				
	// AWEBER			
	} elseif(get_option('email_service') == 'aweber') {
				global $apikey, $list_id;
				global $consumerSecret, $accessKey, $accessSecret, $account_id;
				$aweber = new AWeberAPI($apikey, $consumerSecret);
			
			try {
				$account = $aweber->getAccount($accessKey, $accessSecret);
				// $account_id = $account->id;
			 

				//create a subscriber				
				$listURL = "/accounts/{$account_id}/lists/{$list_id}";
				$list = $account->loadFromUrl($listURL);
				$params = array(
					'email' => $email,
					'name' => $name
				);
				$subscribers = $list->subscribers;
				$new_subscriber = $subscribers->create($params);
				// print "{$test_email} was added to the {$list->name} list!";			
				echo "EPS Success Message!";
			} catch(AWeberAPIException $exc) {
				echo "<h3>AWeberAPIException:<h3>";
				echo " <li> Type: $exc->type <br>";
				echo " <li> Msg : $exc->message <br>";
				echo " <li> Docs: $exc->documentation_url <br>";
				echo "<hr>";
				exit(1);
			}
	}
	
	die();
}
?>