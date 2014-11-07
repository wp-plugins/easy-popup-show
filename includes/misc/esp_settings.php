<?php
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
		 if(isset($_POST['general_set_button']) || isset($_POST['m_chimp_submit'])) {
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
		
	}
}
	new settingEps();
?>