<?php
use Ctct\Auth\CtctOAuth2;
use Ctct\Exceptions\OAuth2Exception;
use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Components\Contacts\ContactList;
use Ctct\Components\Contacts\EmailAddress;
use Ctct\Exceptions\CtctException;

if(!is_admin()) {
require_once('wp-includes/pluggable.php');
if( current_user_can('manage_options') && isset($_GET['code']) && isset($_GET['username'])) {
			if(time() >= get_option('constantcontact_token_expiration_date', 0)) {			
				if(get_option('constantcontact_api_key') && get_option('constantcontact_consumer_secret') && get_option('constantcontact_redirect_uri')) {
	
					include_once(EPS_BASEDIR . 'api/constantcontact/src/Ctct/autoload.php');
					$a = get_option('constantcontact_api_key');
					$s = get_option('constantcontact_consumer_secret');
					$r = get_option('constantcontact_redirect_uri');
					
						$oauth = new CtctOAuth2($a, $s, $r);
					    // print any error from Constant Contact that occurs during the authorization process
						if (isset($_GET['error'])) {
							echo '<div class="labels_and_input">';						
							echo 'Error: ' . $_GET['error'];
							echo '<br />Description: ' . $_GET['error_description'];
							echo '</div>';
							die();
						}
						
						if (isset($_GET['code'])) {
							try {
								$accessToken = $oauth->getAccessToken($_GET['code']);								
							} catch (OAuth2Exception $ex) {
								echo '<div class="labels_and_input">';	
								echo 'Error: ' . $ex->getMessage();
								echo '</div>';								
								die();
							}
								// print_r($accessToken);
								update_option('constantcontact_access_token', $accessToken['access_token']);
								$expire_date = time() + $accessToken['expires_in'];
								update_option('constantcontact_token_expiration_date', $expire_date);
								header("Location: " . get_option('eps_setting_url'));

						} else {
							echo '<div class="labels_and_input">';
							echo "<a href='" . $oauth->getAuthorizationUrl() . "' target='_blank'> <b>Get Access Token </b></a>";
							echo '</div>';
						}	
						
				}
			}
	}
}	
?>