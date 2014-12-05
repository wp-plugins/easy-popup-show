<?php
		?>
		<div id="eps_background_overlay" style="display: none;"></div>
		<div class="loading"><img src="<?php echo THEME_DIR_URL . "/theming/img/load.gif"; ?>"/></div>
			<div id="eps_popup_front" style="display: none;">			
			<div class="eps_pop_close"></div>
				<div id="eps_popup_inner">
				
				<div id="eps_popup_left">
					<div id="headline">
					<?php echo $headline != '' ? '<h1 class="epshone">' . $headline . '</h1>' : '';?>
					</div>
					<?php
					if($short_desc != '') {
					?>
					<div id="short_desc">
					<?php echo $short_desc != '' ? '<span class="shortdescr">' . $short_desc . '</span>' : '';?>
					</div>
					<?php
					}
					?>
					<div id="middle_area">				
						
						<?php if(!empty($lists)) { ?>
						<div class="lists">
						<ul>
						<?php
							foreach($lists as $li ) {
								if($li != '') {
									echo "<li><span class='li_text'>" . $li . "</span></li>";
								}
							}
						// $css = get_post_meta($id, '_eps_general_styles', true);
						// print_r($css);	
						?>
						</ul>
						</div>
						<?php 
						}
						?>			
						</div>
						</div>
						<?php 
						if(filter_var($urlim, FILTER_VALIDATE_URL) == true) {
						?>
						<div class="epsfront_image">
						<img src='<?php echo $urlim; ?>' class='eps_img'/>
						</div>				
						<?php
						}					
						?>
					</div>	
					<div class="clear"> </div>
					<?php
					
					if($name_placeholder != '' || $email_placeholder != '' || $eps_button != '' 
					|| $cta != '') { 
					?>				
						
					<div id="email_form_container">
					<?php if($cta != '') { ?>
					<div id="call_to_act">
					<?php echo $cta; ?>			
					</div>
					<?php } 
					 ?>
					<div id="email_form">

								<?php
								if($name_placeholder != '') {				
				
									?>

										<?php echo "<input type='text' name='eps_user_name' id='eps_user_name' placeholder='" . $name_placeholder . "' value=''/>"; ?>
	
									<?php
									}
									if($email_placeholder != '') {			
									?>

										<?php echo "<input type='email' name='eps_user_email' id='eps_user_email' placeholder='" . $email_placeholder . "' value=''/>"; ?>
								
									<?php
									}							
									?>									
									<input type="submit" name="eps_submit_button" class="eps_submit_button" value="<?php echo $eps_button; ?>"/>
					<div class="clear"></div>					
					</div>			
					</div>
					<?php
					}

					if ($timyse != "") {
					?>
					<div id="tm_container">
					<div class="tiny_message">
					<?php echo $timyse; ?>
					</div>					
					</div>
					<?php
					}
			if(get_option('eps_redir_url') != '') { // check if global redirect url is set
				?>
					<input type="hidden" id="redir_url" value="<?php echo get_option('eps_redir_url'); ?>" />
				<?php
			} elseif (is_array($rules)) { 
				// check if specific redirect url is set
				if (in_array('redirect_url_check', $rules) && $url != "" ) {
				 ?>
					<input type="hidden" id="redir_url" value="<?php echo $url; ?>" />
				 <?php
				}			
			} 	
			// if(!isset($usethis['hd'])){
			if(filter_var($urlim, FILTER_VALIDATE_URL) == true) {
			?>
			<style type="text/css">
				#headline h1{
				font-size: 25px !important;
				text-align: left;
				font-weight: normal !important;				
				}
			</style>
			<?php
			} else {
			?>
			<style type="text/css">
				#headline h1{
				text-align: center;
				font-size: 35px !important;
				font-weight: bold !important;
				}
			</style>				
			<?php
			}
			// }
			?>
					<div id="result_message">
					<div class="success_message"><?php echo get_option('eps_success_message', 'Thank you for your subscription. Please check your email for confirmation!'); ?></div>
					<div class="subscriber_exist"><?php echo get_option('eps_alexis_message', 'Subscribe failed! This email already subscribed!'); ?></div>
					<div class="other_error"><?php echo get_option('eps_unkn_message', 'An unknown error occured! Please try again!'); ?>
					<p><button class="try_again"> Try Again </button>
					</div>
					</div>
					<?php 
		if(is_array($rules) && isset($rules['timer']) && $rules['timer'] != ''){
					?>
					<div id="timer_container">
					Please subscribe or wait for: 
					<span class="tiny_timer">
					<?php echo $rules['timer']; ?>
					</span>	seconds!
					</div>
					<?php 
					}
					?>		
					</div>



<?php
?>