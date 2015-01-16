<?php
use Ctct\Auth\CtctOAuth2;
use Ctct\Exceptions\OAuth2Exception;
use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Components\Contacts\ContactList;
use Ctct\Components\Contacts\EmailAddress;
use Ctct\Exceptions\CtctException;
class settingEps {

	function __construct() {
		// additional sub menu page
		add_action('admin_menu', array($this, 'eps_options_page'));
		add_action('admin_enqueue_scripts', array($this, 'settingsPageScript'));
	}

	function settingsPageScript() {
		if(isset($_GET['page']) && $_GET['page'] === 'eps-setting_controller_page') {
		
			// JQUERY
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-effects-core' ); 	 
			wp_enqueue_script( 'eps_settings_js', plugins_url('js/settings.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-effects-core'), time(), true );
			
			// STYLE			
			wp_register_style( 'eps_settings_css', plugins_url('css/settings.css', __FILE__));
			wp_enqueue_style('eps_settings_css');
		
		}
	}
	
	function eps_options_page() { 
		add_submenu_page('edit.php?post_type=easy_popup_show', 'EPS Settings', 'Settings', 'manage_options', 'eps-setting_controller_page', array($this, 'eps_setting_controller_page'));
	}
	
	function eps_setting_controller_page() {

	if(isset($_GET['post_type']) && $_GET['post_type'] === 'easy_popup_show' && isset($_GET['page']) && $_GET['page'] === 'eps-setting_controller_page') {
		$eps_setting_url = admin_url() . 'edit.php?post_type=easy_popup_show&page=eps-setting_controller_page';
		if(get_option('eps_setting_url') == '') {
			update_option('eps_setting_url', $eps_setting_url);
		}
	}

		?>
		<h2>Settings</h2>
		 <?php
		 if(isset($_POST['general_set_button']) || isset($_POST['m_chimp_submit']) || isset($_POST['g_response_submit']) || isset($_POST['constantcontact_submit']) || isset($_POST['aweber_submit'])) {
		?>
		<div id="message" class="updated fade"><p><strong>SETTINGS SAVED!</strong> <img src="<?php echo plugins_url('img/refresh.gif', __FILE__); ?>"/> Refreshing page and form data...</p></div>
		<?php 
		header('refresh:1; url= ' . $_SERVER['PHP_SELF'] . '?post_type=easy_popup_show&page=eps-setting_controller_page'); 		
		} ?>	
		
		<script type="text/javascript">
			jQuery(window ).on('load', function() {
				jQuery("#cover").fadeOut(750);
				jQuery("#settings_wrapper").fadeIn(1000);
			});
		</script>
		<div id="cover" style="">	</div>
		<div id="settings_wrapper" >			

		<form class="eps_form" method="post" action="">		
		<div class="header_area">
		<div class="open_close">		
			<div class="header_3"><div class="plus_min hide"></div><h3>General</h3></div>				
		</div>
		<div class="clear"></div>
		</div>
		
		<div class="settings_content">
		
			<div class="labels_and_input">
			<label for="email_service">Email Service</label>
				<select name="email_service" id="email_service">
				
				<option value="mailchimp" <?php echo get_option('email_service') == 'mailchimp' ? 'selected': ''; ?>>Mailchimp</option>
				<option value="getresponse" <?php echo get_option('email_service') == 'getresponse' ? 'selected': ''; ?>>Get Response</option>
				<option value="constantcontact" <?php echo get_option('email_service') == 'constantcontact' ? 'selected': ''; ?>>Constant Contact</option>
				<option value="aweber" <?php echo get_option('email_service') == 'aweber' ? 'selected': ''; ?>>Aweber</option>
				</select>
			<div class="help">
			<span class="value_help">
			Choose email service provider you want to use!
			</span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="eps_redir_url">General Redirect URL</label>		
			<input type="text" name="eps_redir_url" value="<?php echo get_option('eps_redir_url') != '' ? get_option('eps_redir_url') : ''; ?>" id="eps_redir_url"/>			
			<div class="help">
			<span class="value_help">
			Leave this empty if you don't want to redirect all pop ups to another page after user successfully subscribe. You can set redirection for specific pop up if you leave this empty!
			</span>
			</div>
			<div class="clear"></div>
			</div>
			
			<div class="labels_and_input">
			<label for="eps_success_message">Success message</label>		
			<textarea name="eps_success_message" id="eps_success_message"><?php echo get_option('eps_success_message', 'Thank you for your subscription. Please check your email for confirmation!'); ?></textarea>
			<div class="help">
			<span class="value_help">
			Message to be displayed after successful subscription.
			</span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="eps_unkn_message">Unknown error message</label>		
			<textarea name="eps_unkn_message" id="eps_unkn_message"><?php echo get_option('eps_unkn_message', 'An unknown error occured! Please try again!'); ?></textarea>			
			<div class="help">
			<span class="value_help">
			Message to be displayed if unknown error occur.
			</span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="eps_alexis_message">Subscriber already exist error</label>		
			<textarea name="eps_alexis_message" id="eps_alexis_message"><?php echo get_option('eps_alexis_message', 'Subscribe failed! This email already subscribed!'); ?></textarea>					
			<div class="help">
			<span class="value_help">
			Message to be displayed if subscriber already exist.
			</span>
			</div>
			</div>
			
			
		<div class="labels_and_input"><input type="submit" name="general_set_button" class="button button-primary button-large eps_save_button" value="Save settings"/>
		<div class="clear"></div>
		</div>			
		</div>
		</form>				
		
<!--
														MAILCHIMP
 -->			
		<form class="eps_form" method="post" action="">		
		<div class="header_area">
		<div class="open_close">		
			<div class="header_3"><div class="plus_min hide"></div><h3>Mailchimp</h3></div>				
		</div>
		<div class="clear"></div>
		</div>
		
		<div class="settings_content">
		
			<div class="labels_and_input">
			<label for="mc_api">API Key</label>
			<input type="text" name="mchimp_api_key" value="<?php echo get_option('mchimp_api_key'); ?>" id="mc_api"/>
			<div class="help">
			<span class="value_help"><a href="http://kb.mailchimp.com/article/where-can-i-find-my-api-key/" target="_blank">Get your API key >> </a></span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="mc_lid">List ID</label>		
			<input type="text" name="mchimp_list_id" value="<?php echo get_option('mchimp_list_id'); ?>" id="mc_lid"/>
			<div class="help">
			<span class="value_help"><a href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id" target="_blank">Find your list ID >> </a></span>
			</div>
			</div>
			
		<div class="labels_and_input"><input type="submit" name="m_chimp_submit" class="button button-primary button-large eps_save_button" value="Save settings"/>
		<div class="clear"></div>
		</div>			
		</div>
		</form>
		
<!--
														GETRESPONSE
 -->		
		<form class="eps_form" method="post" action="">		
		<div class="header_area">
		<div class="open_close">		
			<div class="header_3"><div class="plus_min hide"></div><h3>GETRESPONSE</h3></div>				
		</div>
		<div class="clear"></div>
		</div>
		
		<div class="settings_content">
		
			<div class="labels_and_input">
			<label for="gr_api">API Key</label>
			<input type="text" name="getresponse_api_key" value="<?php echo get_option('getresponse_api_key'); ?>" id="gr_api"/>
			<div class="help">
			<span class="value_help"><a href="http://support.getresponse.com/faq/where-i-find-api-key" target="_blank">Get your API key >> </a></span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="gr_camp_name">Campaign Name</label>		
			<input type="text" name="getresponse_camp_name" value="<?php echo get_option('getresponse_camp_name'); ?>" id="gr_camp_name"/>
			<div class="help">
			<span class="value_help"><a href="" target="_blank">Find your Campaign Name >> </a></span>
			</div>
			</div>
			
		<div class="labels_and_input"><input type="submit" name="g_response_submit" class="button button-primary button-large eps_save_button" value="Save settings"/>
		<div class="clear"></div>
		</div>			
		</div>
		</form>
		

		
<!--
														CONSTANT CONTACT
 -->		
		<form class="eps_form" method="post" action="">		
		<div class="header_area">
		<div class="open_close">		
			<div class="header_3"><div class="plus_min hide"></div><h3>constant contact</h3></div>				
		</div>
		<div class="clear"></div>
		</div>
		
		<div class="settings_content">
		
			<div class="labels_and_input">
			<label for="ccon_api">API Key</label>
			<input type="text" name="constantcontact_api_key" value="<?php echo get_option('constantcontact_api_key'); ?>" id="ccon_api"/>
			<div class="help">
			<span class="value_help"><a href="http://developer.constantcontact.com/api-keys.html" target="_blank">Get your API key >> </a></span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="ccon_cscret">Consumer Secret</label>
			<input type="text" name="constantcontact_consumer_secret" value="<?php echo get_option('constantcontact_consumer_secret'); ?>" id="ccon_cscret"/>
			<div class="help">
			<span class="value_help"><a href="http://developer.constantcontact.com/api-keys.html" target="_blank">Get your Consumer Secret >> </a></span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="ccon_ruri">Redirect URI</label>
			<input type="text" name="constantcontact_redirect_uri" value="<?php echo get_option('constantcontact_redirect_uri'); ?>" id="ccon_ruri"/>
			<div class="help">
			<span class="value_help"><a href="http://developer.constantcontact.com/api-keys.html" target="_blank">Find Redirect URI >> </a></span>
			</div>
			</div>
				<?php
			if(get_option('constantcontact_access_token') != '') {
			?>
			
				<div class="labels_and_input">
				<label for="ccon_accestok">Access Token</label>		
				<input type="text" name="constantcontact_access_token" value="<?php echo get_option('constantcontact_access_token'); ?>" id="ccon_accestok"/>
				<div class="help">
				<span class="value_help"></span>
				</div>
				</div>
			
			<?php
			}
			
			if(get_option('constantcontact_api_key') !='' && get_option('constantcontact_access_token') != '') {
			include_once(EPS_BASEDIR . 'api/constantcontact/src/Ctct/autoload.php');
				$a = get_option('constantcontact_api_key');
				$cc = new ConstantContact($a);
				try {
					$lists = $cc->getLists(get_option('constantcontact_access_token'));
				} catch (CtctException $ex) {
					echo '<div class="labels_and_input">';
					foreach ($ex->getErrors() as $error) {
						print_r($error);
					}
					echo '</div>';
				}

                ?>			
			<div class="labels_and_input">
			<label for="ccon_lid">List Name</label>		
			    <select name="constantcontact_list_id" id="ccon_lid">
                    <?php
                    foreach ($lists as $list) {
                        echo '<option value="' . $list->id . '"';
						echo get_option('constantcontact_list_id') == $list->id ? ' selected' : '';
						echo '>' . $list->name . '</option>';
                    }
                    ?>
                </select>			
			<div class="help">
			<span class="value_help"></span>
			</div>
			</div>
			<?php
			if(get_option('constantcontact_list_id') == '') {			
				echo '<div class="labels_and_input">';
				echo "Please select a list name where you wish your visitor subscribe to and then click <b>save</b> button below for one more time!";
				echo '</div>';
			}
			}			
			?>
			
		<div class="labels_and_input"><input type="submit" name="constantcontact_submit" class="button button-primary button-large eps_save_button" value="Save settings"/>
		<div class="clear"></div>
		</div>			
		</div>
		</form>
		
		
<!--
														AWEBER
 -->
		<form class="eps_form" method="post" action="">		
		<div class="header_area">
		<div class="open_close">		
			<div class="header_3"><div class="plus_min hide"></div><h3>aweber</h3></div>				
		</div>
		<div class="clear"></div>
		</div>
		
		<div class="settings_content">
		
			<div class="labels_and_input">
			<label for="aw_api">Consumer Key</label>
			<input type="text" name="aweber_app_apikey" value="<?php echo get_option('aweber_app_apikey'); ?>" id="aw_api"/>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Get your Consumer key >> </a></span>
			</div>
			</div>
			
			<div class="labels_and_input">
			<label for="aw_conscrt">Consumer Secret</label>		
			<input type="text" name="aweber_app_consumerSecret" value="<?php echo get_option('aweber_app_consumerSecret'); ?>" id="aw_conscrt"/>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Find your Consumer Secret >> </a></span>
			</div>
			</div>
			<?php
			if(get_option('email_service') == 'aweber') {
			if(get_option('aweber_app_accessKey') == '' && get_option('aweber_app_accessSecret') == '' &&  get_option('aweber_app_account_id') == '' ) {
				if(get_option('aweber_app_apikey') != "" && get_option('aweber_app_consumerSecret') != "" ) {
					require_once(EPS_BASEDIR . 'api/aweber/aweber_api/aweber_api.php');
					$ckey = get_option('aweber_app_apikey');
					$csecret = get_option('aweber_app_consumerSecret');
					$aweber = new AWeberAPI($ckey, $csecret);
					
					if (empty($_COOKIE['accessToken'])) {
						if (empty($_GET['oauth_token'])) {
							$callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];					
							list($requestToken, $tokenSecret) = $aweber->getRequestToken($callbackUrl);
							setcookie('requestTokenSecret', $requestTokenSecret);
							setcookie('callbackUrl', $callbackUrl);
							header("Location: {$aweber->getAuthorizeUrl()}");
							exit();
						}
						
						$aweber->user->tokenSecret = $_COOKIE['requestTokenSecret'];
						$aweber->user->requestToken = $_GET['oauth_token'];
						$aweber->user->verifier = $_GET['oauth_verifier'];
						list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();
						setcookie('accessToken', $accessToken);
						setcookie('accessTokenSecret', $accessTokenSecret);
						update_option('aweber_app_accessKey', $accessToken);
						update_option('aweber_app_accessSecret', $accessTokenSecret);						
					
						try {
						$account = $aweber->getAccount($aKey, $aSecret);
						$account_id = $account->id;
						update_option('aweber_app_account_id', $account_id);
						
						} catch(AWeberAPIException $exc) {
							echo '<div class="labels_and_input">';
							echo "<h3>AWeberAPIException:<h3>";
							echo " <li> Type: $exc->type <br>";
							echo " <li> Msg : $exc->message <br>";
							echo " <li> Docs: $exc->documentation_url <br>";
							echo "<hr>";
							echo '</div>';
							exit(1);						
						}
						
						header('Location: '.$_COOKIE['callbackUrl']);
						exit();				
					}						
					
				}
			}
			}	
			if(get_option('aweber_app_accessKey') != '' && get_option('aweber_app_accessSecret') != '' &&  get_option('aweber_app_account_id') != '' ) {			
			require_once(EPS_BASEDIR . 'api/aweber/aweber_api/aweber_api.php');
			$ckey = get_option('aweber_app_apikey');
			$csecret = get_option('aweber_app_consumerSecret');
			$aweber = new AWeberAPI($ckey, $csecret);
			
			$aweber->adapter->debug = false;
			$account = $aweber->getAccount(get_option('aweber_app_accessKey'), get_option('aweber_app_accessSecret'));
			
			?>
			
			<div class="labels_and_input">
			<label for="aw_accs_key">Access Key</label>		
			<input type="text" name="aweber_app_accessKey" value="<?php echo get_option('aweber_app_accessKey'); ?>" id="aw_accs_key"/>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Find your Access Key >> </a></span>
			</div>
			</div>	

			<div class="labels_and_input">
			<label for="aw_accs_scr">Access Secret</label>		
			<input type="text" name="aweber_app_accessSecret" value="<?php echo get_option('aweber_app_accessSecret'); ?>" id="aw_accs_scr"/>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Find your Access Secret >> </a></span>
			</div>
			</div>	
			
			<div class="labels_and_input">
			<label for="aw_acc_id">Account ID</label>		
			<input type="text" name="aweber_app_account_id" value="<?php echo get_option('aweber_app_account_id'); ?>" id="aw_acc_id"/>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Find your Account ID >> </a></span>
			</div>
			</div>


			
			<div class="labels_and_input">
			<label for="aw_list_id">List ID</label>	
			<select name="aweber_app_list_id" id="aw_list_id">
			<?php
			foreach($account->lists as $offset => $list) {
			?>
			
			<option value="<?php echo $list->id; ?>" <?php echo get_option('aweber_app_list_id') == $list->id ? ' selected' : ''; ?> > <?php echo $list->name; ?> </option>
			
			<?php
			}
			?>			
			</select>
			<div class="help">
			<span class="value_help"><a href="https://labs.aweber.com/getting_started/main" target="_blank">Find your List ID >> </a></span>
			</div>
			</div>
			
			<?php			
			}			
			if(get_option('aweber_app_accessKey') != '' && get_option('aweber_app_accessSecret') != '' &&  get_option('aweber_app_account_id') != '' && get_option('aweber_app_list_id') == '') {
			?>
			<div class="labels_and_input">
			<b>Please select list name where you want your user subscribe to and then save it!</b>
			</div>
			<?php	
			}
			?>
			
		<div class="labels_and_input"><input type="submit" name="aweber_submit" class="button button-primary button-large eps_save_button" value="Save settings"/>
		<div class="clear"></div>
		</div>			
		</div>
		</form>	

		
		</div>
		
		<?php
	// GENERAL
	if(isset($_POST['general_set_button'])) {
		if(isset($_POST['email_service']) && $_POST['email_service'] != '') {
			update_option('email_service', $_POST['email_service']);
		} else {
			delete_option('email_service');
		}
		
		if(isset($_POST['eps_redir_url']) && $_POST['eps_redir_url'] != '') {
			update_option('eps_redir_url', $_POST['eps_redir_url']);
		} else {
			delete_option('eps_redir_url');
		}
		
		if(isset($_POST['eps_success_message']) && $_POST['eps_success_message'] != '') {
			update_option('eps_success_message', $_POST['eps_success_message']);
		} else {
			delete_option('eps_success_message');
		}		
		
		if(isset($_POST['eps_unkn_message']) && $_POST['eps_unkn_message'] != '') {
			update_option('eps_unkn_message', $_POST['eps_unkn_message']);
		} else {
			delete_option('eps_unkn_message');
		}

		if(isset($_POST['eps_alexis_message']) && $_POST['eps_alexis_message'] != '') {
			update_option('eps_alexis_message', $_POST['eps_alexis_message']);
		} else {
			delete_option('eps_alexis_message');
		}
		
	}
	
	//MAILCHIMP
	if(isset($_POST['m_chimp_submit'])) {
		if(isset($_POST['mchimp_api_key']) && $_POST['mchimp_api_key'] != '') {		
			update_option('mchimp_api_key', $_POST['mchimp_api_key']);
		} else {
			delete_option('eps_alexis_message');
		}
		
		if(isset($_POST['mchimp_list_id']) && $_POST['mchimp_list_id'] != '') {
			update_option('mchimp_list_id', $_POST['mchimp_list_id']);
		} else {
			delete_option('eps_alexis_message');
		}
	}
	
	//GETRESPONSE
	if(isset($_POST['g_response_submit'])) {
		if(isset($_POST['getresponse_api_key']) && $_POST['getresponse_api_key'] != '') {		
			update_option('getresponse_api_key', $_POST['getresponse_api_key']);
		} else {
			delete_option('getresponse_api_key');
		}
		
		if(isset($_POST['getresponse_camp_name']) && $_POST['getresponse_camp_name'] != '') {
			update_option('getresponse_camp_name', $_POST['getresponse_camp_name']);
		} else {
			delete_option('getresponse_camp_name');
		}
	}
	
	
	//CONSTANT CONTACT
	if(isset($_POST['constantcontact_submit'])) {
		if(isset($_POST['constantcontact_api_key']) && $_POST['constantcontact_api_key'] != '') {		
			update_option('constantcontact_api_key', $_POST['constantcontact_api_key']);
		} else {
			delete_option('constantcontact_api_key');
		}
		
		if(isset($_POST['constantcontact_consumer_secret']) && $_POST['constantcontact_consumer_secret'] != '') {
			update_option('constantcontact_consumer_secret', $_POST['constantcontact_consumer_secret']);
		} else {
			delete_option('constantcontact_consumer_secret');
		}
		
		if(isset($_POST['constantcontact_redirect_uri']) && $_POST['constantcontact_redirect_uri'] != '') {
			update_option('constantcontact_redirect_uri', $_POST['constantcontact_redirect_uri']);
		} else {
			delete_option('constantcontact_redirect_uri');
		}

		if(isset($_POST['constantcontact_access_token']) && $_POST['constantcontact_access_token'] != '') {
			update_option('constantcontact_access_token', $_POST['constantcontact_access_token']);
		} else {
			delete_option('constantcontact_access_token');
		}	

		if(isset($_POST['constantcontact_list_id']) && $_POST['constantcontact_list_id'] != '') {
			update_option('constantcontact_list_id', $_POST['constantcontact_list_id']);
		} else {
			delete_option('constantcontact_list_id');
		}		
		
	}	
	

	//AWEBER
	if(isset($_POST['aweber_submit'])) {
		if(isset($_POST['aweber_app_apikey']) && $_POST['aweber_app_apikey'] != '') {		
			update_option('aweber_app_apikey', $_POST['aweber_app_apikey']);
		} else {
			delete_option('aweber_app_apikey');
		}
		
		if(isset($_POST['aweber_app_consumerSecret']) && $_POST['aweber_app_consumerSecret'] != '') {
			update_option('aweber_app_consumerSecret', $_POST['aweber_app_consumerSecret']);
		} else {
			delete_option('aweber_app_consumerSecret');
		}
		
		if(isset($_POST['aweber_app_accessKey']) && $_POST['aweber_app_accessKey'] != '') {
			update_option('aweber_app_accessKey', $_POST['aweber_app_accessKey']);
		} else {
			delete_option('aweber_app_accessKey');
		}

		if(isset($_POST['aweber_app_accessSecret']) && $_POST['aweber_app_accessSecret'] != '') {
			update_option('aweber_app_accessSecret', $_POST['aweber_app_accessSecret']);
		} else {
			delete_option('aweber_app_accessSecret');
		}	

		if(isset($_POST['aweber_app_account_id']) && $_POST['aweber_app_account_id'] != '') {
			update_option('aweber_app_account_id', $_POST['aweber_app_account_id']);
		} else {
			delete_option('aweber_app_account_id');
		}	

		if(isset($_POST['aweber_app_list_id']) && $_POST['aweber_app_list_id'] != '') {
			update_option('aweber_app_list_id', $_POST['aweber_app_list_id']);
		} else {
			delete_option('aweber_app_list_id');
		}		
		
	}
		
	}
}
	new settingEps();
?>