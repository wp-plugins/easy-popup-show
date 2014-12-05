<?php
// require_once( PLUGIN_DIR . '/class.styleedit.php');

class saveEpsSettings {

function __construct(){
$this->hook();
}

function hook(){
add_action( 'save_post', array( $this, 'eps_save' ) );
}

	function eps_save($post_id) {	
		global $post;
		global $poid;
		// SECURITY
		// Check if our nonce is set.
		if ( !isset($_POST['eps_elements_metabox_nonce']) || !isset($_POST['eps_settings_metabox_nonce']))
		{
			return $post_id;		
		}
		$el_nonce = $_POST['eps_elements_metabox_nonce'];
		$set_nonce = $_POST['eps_settings_metabox_nonce'];
		// Verify that the nonce is valid.
		if (!wp_verify_nonce($el_nonce, 'eps_elements_metabox') || !wp_verify_nonce($set_nonce, 'eps_settings_metabox')){
			return $post_id;
		}
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		
		// Check the user's permissions.		
		if ( 'page' == $_POST['post_type'] ) {
				if (!current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		} else {
				if (!current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		/* OK, ITS SAFE FOR US TO SAVE THE DATA NOW. */		
		
		
		/* SAVING ELEMENTS */
		
		// THEME
		if(isset($_POST['eps_theme'])) {
		$theme = sanitize_text_field($_POST['eps_theme']);
		update_post_meta($post_id, '_eps_popup_theme', $theme);
		}		
		
		// main headline
		if(isset($_POST['first_headline'])) {
			$headline = sanitize_text_field($_POST['first_headline']);
			update_post_meta( $post_id, '_eps_first_headline_key', $headline);
		}		
		//endof		
		
		// list items
		if(isset($_POST['short_description'])) {
			$short_desc = sanitize_text_field($_POST['short_description']);
			update_post_meta( $post_id, '_eps_short_description_key', $short_desc);
		}		
		//endof		
		
		// list items
		if(isset($_POST['list_items'])) {
			$lists = $_POST['list_items'];
			update_post_meta( $post_id, '_eps_list_items_key', $lists);
		}		
		//endof
		
		// call to action
		if(isset($_POST['second_headline'])) {
			$cta = sanitize_text_field($_POST['second_headline']);
			update_post_meta( $post_id, '_eps_second_headline_key', $cta);
		}		
		//endof		

		// name placeholder
		if(isset($_POST['name_field_placeholder'])) {
			$nmplchldr = sanitize_text_field($_POST['name_field_placeholder']);
			update_post_meta( $post_id, '_eps_name_field_placeholder_key', $nmplchldr);
		}		
		//endof
		
		// email placeholder
		if(isset($_POST['email_field_placeholder'])) {
			$empchldr = sanitize_text_field($_POST['email_field_placeholder']);
			update_post_meta( $post_id, '_eps_email_field_placeholder_key', $empchldr);
		}		
		//endof
		
		
		// submit button
		if(isset($_POST['button_field_value'])) {
			$sbmbutton = sanitize_text_field($_POST['button_field_value']);
			update_post_meta( $post_id, '_eps_button_field_value_key', $sbmbutton);
		}		
		//endof
		
		if(isset($_POST['tiny_message'])) {
			$timise = $_POST['tiny_message'];
			update_post_meta($post_id, '_tiny_little_message', $timise);
		}
		
		
		// image upload
		if ( ! function_exists( 'wp_handle_upload' ) ) 
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		
		if(!empty($_FILES['eps_image']) && isset($_FILES['eps_image']) && $_POST['eps_image_text'] != '') {
		$uploadedfile = $_FILES['eps_image'];
		$upload_overrides = array( 'test_form' => false );
		$allowed = array('image/jpg', 'image/png', 'image/bmp', 'image/gif', 'image/jpeg');
		$file_type = wp_check_filetype(basename($_FILES['eps_image']['name']));
		$type = $file_type['type'];
		$maxFileSize = 64 * 1024 * 1024;
		
			if(in_array($type, $allowed) && $_FILES['eps_image']['size'] <= $maxFileSize) {
				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );			
				if ( $movefile ) {
					$result = $movefile['url'];
				} else {
					$result = "An Unknown Error has happened while uploading the file! Please contact your hosting provider for support!";
				}
			} elseif($type != '' && !in_array($type, $allowed)) {
				$result = "File type not allowed! Please make sure your file is in one of these format: <b>'jpeg', 'png', 'gif', 'bmp'</b>";
			} elseif($_FILES['eps_image']['size'] > $maxFileSize) {
				$result = "File size is too big! Please make sure that your file size is less than: <b>" . ($maxFileSize / 1024) / 1024 . " Mb</b>";
			}
			
		update_post_meta( $post_id, '_eps_image_key', $result);
		} 
		// endof

		/* END SAVE ELEMENT */
	
		
		/* SAVE SETTINGS */		
		if(isset($_POST['onoffswitch'])) {
			$switch = $_POST['onoffswitch'];
			update_post_meta( $post_id, '_on_off_switch', $switch);
		} else {
			delete_post_meta( $post_id, '_on_off_switch', 'switch_on');
		}		
		
		$location = array();
		//$location[] = $post_id;
		if(isset($_POST['all_location'])) {
		
			$location[] = $_POST['all_location'];
			
		} else {
		
			if(isset($_POST['exclude_home'])) {
				$location[] = $_POST['exclude_home'];
			} elseif(isset($_POST['home_only'])) {
				$location[] = $_POST['home_only'];
			} 
			
			if(isset($_POST['exclude_archive'])) {
				$location[] = $_POST['exclude_archive'];
			} elseif(isset($_POST['archive_only'])) {
				$location[] = $_POST['archive_only'];
			}
			
/* 			if(isset($_POST['deeps']) && $_POST['deeps'] != "") {
					$deeps = $_POST['deeps'];
			} */					
		}

		if(isset($_POST['404_page'])) {
			$location[] = $_POST['404_page'];
		} elseif(isset($_POST['no_404_page'])) {
			$location[] = $_POST['no_404_page'];
		}
		
		if(isset($_POST['by_date'])) {
		$date = $_POST['by_date'];
		update_post_meta( $post_id, '_eps_date_key', $date);
		}
		
		// $post_types = get_post_types($args);
	
/* 		if(!empty($deeps)){
			$locations = array_merge($location, $deeps);
		} else {
			$locations = $location;
		}	 */	
		update_post_meta( $post_id, '_eps_locations_key', $location);
		
		$epsRules = array();
		if(isset($_POST['eps_rules'])) {
			$epsRule[] = $_POST['eps_rules'];
		}
		
		// COOKIE
		if(isset($_POST['use_cookies']) && $_POST['cookies_expr'] != "") {
			$epsRule[] = $_POST['use_cookies'];
			$cookie_val = sanitize_text_field($_POST['cookies_expr']);
			update_post_meta( $post_id, '_eps_cookie_rule', $cookie_val);
		}
		
		// REDIRECT URL
		if(isset($_POST['redirect_url_check']) && $_POST['redirect_url'] != "") {
			$epsRule[] = $_POST['redirect_url_check'];
			$redirurl_val = sanitize_text_field($_POST['redirect_url']);
			update_post_meta( $post_id, '_eps_redirect_destination', $redirurl_val);
		}		
		
		$epsRules = array();
		foreach($epsRule as $rule){
			if(is_array($rule)){
			foreach($rule as $re)
			$epsRules[] = $re;			
			} else {
			$epsRules[] = $rule;
			}
		}

		if(isset($_POST['eps_show_delay'])) {
			$epsRules['delay'] = $_POST['eps_show_delay'];
		}
		
		if(isset($_POST['eps_show_timer'])) {
			$epsRules['timer'] = $_POST['eps_show_timer'];
		}
		
		update_post_meta( $post_id, '_eps_display_rules', $epsRules);	
		// endof
		

	} 

}

new saveEpsSettings();
?>