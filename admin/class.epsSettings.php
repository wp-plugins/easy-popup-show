<?php
class epsSetting{
		
		function __construct(){
			$this->hook();
		}
		
		function hook(){
			add_action( 'add_meta_boxes', array( $this, 'container' ) );
		}
		
		function container($post_type) {
			$post_types = array('easy_popup_show');
			
				if ( in_array( $post_type, $post_types )) {
					
					// POP UP SETTINGS
					add_meta_box(
							'eps_settings'
							,__( 'DISPLAY OPTIONS', 'eps_txtdmns' )
							,array( $this, 'content' )
							,$post_type
							,'side',
							'low'
					);				
				
				}	
			}
			
		function content($post) {
			global $wpdb, $post;
			/* echo $eps_id = $post->ID; */
			$on = get_post_meta( $post->ID, '_on_off_switch', true);		
			$location = get_post_meta($post->ID, "_eps_locations_key", true);
			$dates = get_post_meta($post->ID, "_eps_date_key", true);
			$rules = get_post_meta($post->ID, "_eps_display_rules", true);
			$cookie = get_post_meta($post->ID, '_eps_cookie_rule', true);
			$url = get_post_meta($post->ID, '_eps_redirect_destination', true);
			// Add an nonce field so we can check for it later.
			wp_nonce_field( 'eps_settings_metabox', 'eps_settings_metabox_nonce' );
				
			//set template
			?>
			<!-- STATUS -->
			<h3 class="epshtop">Status</h3>
			<div class="onoffswitch">
			<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" value="switch_on" <?php echo isset($on) && $on != '' ? ' checked': ''; ?> />
			<label class="onoffswitch-label" for="myonoffswitch">
			<span class="onoffswitch-inner"></span>
			<span class="onoffswitch-switch"></span>
			</label>
			</div> 
			
			<div clas="clear" style="clear:both;"></div>

			<!-- POP UP LOCATION -->
			<h3 class="epsh31">Pop Up Location:</h3>
			<table style="border: 1px solid #DDDDDD; width:100%;" id="mainboard">
			<tbody>
			<tr><td style="width:65%;"><input type="checkbox" id="all_location" name="all_location" value="all_loc" <?php echo (is_array($location)) ? (in_array('all_loc', $location)) ? ' checked' : '' : ''; ?> /><label for="all_location">All Locations</label></td></tr>
			<tr><td><input type="checkbox" id="exclude_home" name="exclude_home" value="excl_home" <?php echo (is_array($location)) ? (in_array('excl_home', $location)) ? ' checked' : '' : ''; ?> /><label for="exclude_home">Exclude Homepage</label></td></tr><tr><td><input type="checkbox" id="home_only" name="home_only" value="home_only" <?php echo (is_array($location)) ? (in_array('home_only', $location)) ? ' checked' : '' : ''; ?>	/><label for="home_only">On Homepage</label></td></tr>
			<tr><td><input type="checkbox" id="exclude_archive" name="exclude_archive" value="excl_arch" <?php echo (is_array($location)) ? (in_array('excl_arch', $location)) ? ' checked' : '' : ''; ?> /><label for="exclude_archive">Exclude Archive Page</label></td></tr><tr><td><input type="checkbox" id="archive_only" name="archive_only" value="archive_only" <?php echo (is_array($location)) ? (in_array('archive_only', $location)) ? ' checked' : '' : ''; ?> /><label for="archive_only">On Archive Page</label></td></tr>
			
			<tr><td><input type="checkbox" id="404_page" name="404_page" value="404_page" <?php echo (is_array($location)) ? (in_array('404_page', $location)) ? ' checked' : '' : ''; ?> /><label for="404_page">On 404 Page</label></td></tr><tr><td><input type="checkbox" id="no_404_page" name="no_404_page" value="no_404_page" <?php echo (is_array($location)) ? (in_array('no_404_page', $location)) ? ' checked' : '' : ''; ?> /><label for="no_404_page">Exclude 404 Page</label></td></tr>
			</tbody>
			</table>	
			<?php
			echo "<br/>";
			if(is_array($dates)){
			$val_1 = "";
			$val_2 = "";
			$count = count($dates);
			for($i = 0; $i < $count; $i++) {
				if($i == 0) {
					$val_1 .= $dates[$i];
				} else {
					$val_2 .= $dates[$i];
				}
			}
			}
			?>
			<table style="border: 1px solid #DDDDDD; width:100%;">
			<tbody>
			<tr><td><label><b>Specific Date Range:</b> </label></td></tr>
			<tr>
			<td><input type="text" class="eps_input_date" id="by_datea" name="by_date[]" value="<?php echo (isset($val_1) && $val_1 != "") ? $val_1 : ""; ?>" size="20"/>
			<b>-</b> 
			<input type="text" class="eps_input_date" id="by_dateb" name="by_date[]" value="<?php echo (isset($val_2) && $val_2 != "") ? $val_2 : ""; ?>"  size="20"/></td>
			<td><input type="button" id="clear_dates" class="button button-small" value="clear all"/></td>
			</tr>
			</tbody>
			</table>
			
			<!-- RULES -->
			<h3 class="epsh31">Rules:</h3>
			<table style="border: 1px solid #DDDDDD; width:100%;">
			<tbody>
			<tr><td><input type="checkbox" id="to_login_user" name="eps_rules[]" value="to_login_user" <?php echo (is_array($rules)) ? (in_array('to_login_user', $rules)) ? ' checked' : '' : ' checked'; ?> /><label for="to_login_user"><b>Show to logged-in user</b></label></td></tr>
			<tr><td><input type="checkbox" id="exclude_mobile" name="eps_rules[]" value="exclude_mobile" <?php echo (is_array($rules)) ? (in_array('exclude_mobile', $rules)) ? ' checked' : '' : ''; ?> /><label for="exclude_mobile"><b>Hide on mobile devices</b></label></td></tr>
			<tr><td><input type="checkbox" id="sev_only" name="eps_rules[]" value="sev_only" <?php echo (is_array($rules)) ? (in_array('sev_only', $rules)) ? ' checked' : '' : ''; ?> /><label for="sev_only"><b>Search engine visitors only</b></label></td></tr>
			<tr><td><input type="checkbox" id="use_cookies" name="use_cookies" value="use_cookies" <?php echo (is_array($rules)) ? (in_array('use_cookies', $rules)) ? ' checked' : '' : ''; ?> /><label for="use_cookies"><b>Show Pop Up Every <i>(use cookie)</i>:</b></label></td></tr>
			<tr><td><input type="text" class="medium_input_field" id="cookies_expr" name="cookies_expr" value="<?php echo $cookie != "" ? $cookie : ''; ?>"  placeholder="Expire after ..."/> Days</td></tr>
			
			<tr><td><input type="checkbox" id="redirect_url_check" name="redirect_url_check" value="redirect_url_check" <?php echo (is_array($rules)) ? (in_array('redirect_url_check', $rules)) ? ' checked' : '' : ''; ?> /><label for="redirect_url_check"><b>Redirect To: </b></label></td></tr>
			
			<tr><td><input type="text" class="medium_input_field" id="redirect_url" name="redirect_url" value="<?php echo $url != "" ? $url : ''; ?>" placeholder="Redirect to url"/></td></tr>
			</tbody>
			</table>
			<?php
			}

}
new epsSetting();
?>