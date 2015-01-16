<?php
require_once( PLUGIN_DIR . '/class.styleedit.php');
class saveEpsSettings {

function __construct(){
$this->hook();
}

function hook(){
add_action( 'save_post', array( $this, 'eps_save' ) );
}

	function eps_save($post_id) {	
		global $post;
		// SECURITY
		// Check if our nonce is set.
		if ( !isset($_POST['eps_elements_metabox_nonce']) || !isset($_POST['eps_settings_metabox_nonce']) || !isset($_POST['eps_styles_metabox_nonce']))
		{
			return $post_id;		
		}
		$el_nonce = $_POST['eps_elements_metabox_nonce'];
		$set_nonce = $_POST['eps_settings_metabox_nonce'];
		$style_nonce = $_POST['eps_styles_metabox_nonce'];
		// Verify that the nonce is valid.
		if (!wp_verify_nonce($el_nonce, 'eps_elements_metabox') || !wp_verify_nonce($set_nonce, 'eps_settings_metabox') || !wp_verify_nonce($style_nonce, 'eps_styles_metabox')){
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
		
		// USE THIS STYLE - checkbox
		if(isset($_POST['usethis'])) {
			update_post_meta($post_id, '_eps_usethis_style', $_POST['usethis']);
		}		
				//TINY BOX STYLE SETTINGS			
						// START WP_FILESYSTEM
						$access_type = get_filesystem_method();
						if($access_type === 'direct') {
							delete_option('eps_writingcss_not_direct');
							$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

							$creds = request_filesystem_credentials($url, '', false, false, array());
								
								/* initialize the API */
								if ( ! WP_Filesystem($creds) ) {
									update_option('eps_writing_css_error', 'Unable to connect to your server and save your settings!');
									/* any problems and we exit */
									return false;
								} else {
									delete_option('eps_writing_css_error');
								}
								global $wp_filesystem;
								$cssEditor = new cssEditor();
						
		// HEADER DEAFULT
						if(isset($_POST['hd_style'])) {
							$h_onecss = $_POST['hd_style'];
							$h1_selector = $_POST['hd_selector'];
							$h_onecssf = array_filter($h_onecss);
							if(!empty($h_onecssf)) {
								$hd_file = PLUGIN_DIR . '/theming/' . $theme . '/header/default/header.css';

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/header/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/header/custom/');
								}
								
								$hd_path = PLUGIN_DIR . '/theming/' . $theme . '/header/custom/header_' . $post_id . '.css';
								
								$hd_content = $wp_filesystem->get_contents($hd_file);
								
								update_post_meta($post_id, '_hdcss_value_details', $h_onecss);
								$userDefinedStyle = '';
								if($h_onecss['color'] != '') {
									$userDefinedStyle .= 'color: ' . $h_onecss['color'] . ' !important;';									
								}
								if($h_onecss['fontfmly'] != '') {
									$userDefinedStyle .= 'font-family: ' . $h_onecss['fontfmly'] . ' !important;';
								}
								if($h_onecss['fsize'] != '') {
									$userDefinedStyle .= 'font-size: ' . $h_onecss['fsize'] . 'px !important;';
								}								
								if($h_onecss['fontsty'] != '') {
									$userDefinedStyle .= 'font-style: ' . $h_onecss['fontsty'] . ' !important;';
								}
								if($h_onecss['fontwght'] != '') {
									$userDefinedStyle .= 'font-weight: ' . $h_onecss['fontwght'] . ' !important;';
								}
								
								$hd_css = $h1_selector . "{\n";
								$hd_css .= $userDefinedStyle;
								$hd_css .= '}';								
								
								$finalStyle = $cssEditor->editCss($hd_content, $hd_css, array($h1_selector));	
								$wp_filesystem->put_contents($hd_path, $finalStyle, FS_CHMOD_FILE);
								}
							}
			// end HEADER DEAFULT			
			
			// HEADER HOVER
						if(isset($_POST['hdhvr_style'])) {
							$hdhvr_onecss = $_POST['hdhvr_style'];
							$hdhvr_selector = $_POST['hdhvr_selector'];
							$hdhvr_onecssf = array_filter($hdhvr_onecss);
							if(!empty($hdhvr_onecssf)) {
							
								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/header/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/header/custom/');
								}
								
								$hdhvr_path = PLUGIN_DIR . '/theming/' . $theme . '/header/custom/header_hover' . $post_id . '.css';
																							
								update_post_meta($post_id, '_hdhvrcss_value_details', $hdhvr_onecss);
								
								$userHDHover = '';
								if($hdhvr_onecss['color'] != '') {
									$userHDHover .= 'color: ' . $hdhvr_onecss['color'] . " !important;\n";									
								}
								if($hdhvr_onecss['fontfamily'] != '') {
									$userHDHover .= 'font-family: ' . $hdhvr_onecss['fontfamily'] . " !important;\n";
								}
								if($hdhvr_onecss['fontsize'] != '') {
									$userHDHover .= 'font-size: ' . $hdhvr_onecss['fontsize'] . "px !important;\n";
								}								
								if($hdhvr_onecss['fontstyle'] != '') {
									$userHDHover .= 'font-style: ' . $hdhvr_onecss['fontstyle'] . " !important;\n";
								}
								if($hdhvr_onecss['fontweight'] != '') {
									$userHDHover .= 'font-weight: ' . $hdhvr_onecss['fontweight'] . " !important;\n";
								}
								
								$hdhvr_css = $hdhvr_selector . "{\n";
								$hdhvr_css .= $userHDHover;
								$hdhvr_css .= '}';								

								$wp_filesystem->put_contents($hdhvr_path, $hdhvr_css, FS_CHMOD_FILE);
								}
							}						
			// End HEADER HOVER
			
			
			// SHORT DESCRIPTION DEAFULT
						if(isset($_POST['sd_style'])) {
							$sd_css = $_POST['sd_style'];
							$sd_selector = $_POST['sd_selector'];
							$sd_cssf = array_filter($sd_css);
							if(!empty($sd_cssf)) {
								$sd_file = PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/default/shortdescription.css';

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/');
								}
								
								$sd_path = PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/shortdescription_' . $post_id . '.css';
								
								$sd_content = $wp_filesystem->get_contents($sd_file);
								
								update_post_meta($post_id, '_sdcss_value_details', $sd_css);
								$userShortdescStyle = '';
								if($sd_css['color'] != '') {
									$userShortdescStyle .= 'color: ' . $sd_css['color'] . ' !important;';									
								}
								if($sd_css['fontfmly'] != '') {
									$userShortdescStyle .= 'font-family: ' . $sd_css['fontfmly'] . ' !important;';
								}
								if($sd_css['fsize'] != '') {
									$userShortdescStyle .= 'font-size: ' . $sd_css['fsize'] . 'px !important;';
								}								
								if($sd_css['fontsty'] != '') {
									$userShortdescStyle .= 'font-style: ' . $sd_css['fontsty'] . ' !important;';
								}
								if($sd_css['fontwght'] != '') {
									$userShortdescStyle .= 'font-weight: ' . $sd_css['fontwght'] . ' !important;';
								}
								
								$sd_css = $sd_selector . "{\n";
								$sd_css .= $userShortdescStyle;
								$sd_css .= '}';								
								
								$finalSDStyle = $cssEditor->editCss($sd_content, $sd_css, array($sd_selector));	
								$wp_filesystem->put_contents($sd_path, $finalSDStyle, FS_CHMOD_FILE);
								}
							}
			// End SHORT DESCRIPTION  DEAFULT			
			
			// SHORT DESCRIPTION HOVER			
						if(isset($_POST['sdhvr_style'])) {
							$sdhvr_css = $_POST['sdhvr_style'];
							$sdhvr_selector = $_POST['sdhvr_selector'];
							$sdhvr_cssf = array_filter($sdhvr_css);
							if(!empty($sdhvr_cssf)) {

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/');
								}
								
								$sdhvr_path = PLUGIN_DIR . '/theming/' . $theme . '/shortdescription/custom/shortdescription_hover' . $post_id . '.css';

								update_post_meta($post_id, '_sdhvrcss_value_details', $sdhvr_css);
								
								$userSDHover = '';
								if($sdhvr_css['color'] != '') {
									$userSDHover .= 'color: ' . $sdhvr_css['color'] . " !important;\n";
								}
								if($sdhvr_css['fontfamily'] != '') {
									$userSDHover .= 'font-family: ' . $sdhvr_css['fontfamily'] . " !important;\n";
								}
								if($sdhvr_css['fontsize'] != '') {
									$userSDHover .= 'font-size: ' . $sdhvr_css['fontsize'] . "px !important;\n";
								}								
								if($sdhvr_css['fontstyle'] != '') {
									$userSDHover .= 'font-style: ' . $sdhvr_css['fontstyle'] . " !important;\n";
								}
								if($sdhvr_css['fontweight'] != '') {
									$userSDHover .= 'font-weight: ' . $sdhvr_css['fontweight'] . " !important;\n";
								}
								
								$sdhvrcss = $sdhvr_selector . "{\n";
								$sdhvrcss .= $userSDHover;
								$sdhvrcss .= '}';						
								$wp_filesystem->put_contents($sdhvr_path, $sdhvrcss, FS_CHMOD_FILE);
								}
							}			
			// End SHORT DESCRIPTION  HOVER			
			
			// LIST ITEM DEFAULT
						if(isset($_POST['li_style']) || (!empty($_FILES['li_style_image']) && isset($_FILES['li_style_image']) && $_POST['eps_li_image_text'] != '')) {
							$li_css = $_POST['li_style'];
							$li_selectors = explode("|", $_POST['li_selector']);
							$li_cssf = array_filter($li_css);
							if(!empty($li_cssf)) {
								$li_file = PLUGIN_DIR . '/theming/' . $theme . '/listitems/default/listitems.css';

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/');
								}
								
								$li_path = PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/listitems_' . $post_id . '.css';
								
								$li_content = $wp_filesystem->get_contents($li_file);
								
								update_post_meta($post_id, '_licss_value_details', $li_css);
								// $userLIStyle = '';
								$lists = '';
								$listsli = '';
								$li_text = '';
								
								if($li_css['color'] != '') {
									$li_text .= 'color: ' . $li_css['color'] . " !important;\n";								
								}
								if($li_css['fontfmly'] != '') {
									$lists .= 'font-family: ' . $li_css['fontfmly'] . " !important;\n";
								}
								if($li_css['fsize'] != '') {
									$listsli .= 'font-size: ' . $li_css['fsize'] . "px !important;\n";
								}								
								if($li_css['fontsty'] != '') {
									$lists .= 'font-style: ' . $li_css['fontsty'] . " !important;\n";
								}
								if($li_css['fontwght'] != '') {
									$li_text .= 'font-weight: ' . $li_css['fontwght'] . " !important;\n";	
								}								
								$newLiCssByUser = ".lists { \n" . $lists . "}\r\n";
								$newLiCssByUser .= ".lists ul li { \n" . $listsli . "}\r\n";
								$newLiCssByUser .= ".li_text { \n" . $li_text . "\n}";
								// endof													
								// update_post_meta($post_id, 'test_array', $cssEditor->getCssArray($li_content, $newLiCssByUser, $li_selectors));
								$finalLIStyle = $cssEditor->editCss($li_content, $newLiCssByUser, $li_selectors);	
								$wp_filesystem->put_contents($li_path, $finalLIStyle, FS_CHMOD_FILE); 
								}
							}
			// End LIST ITEM DEAFULT			
			
						
			// LIST ITEM HOVER
						if(isset($_POST['lihover_style']) || (!empty($_FILES['lihvr_style_image']) && isset($_FILES['lihvr_style_image']) && $_POST['eps_lihvr_image_text'] != '')) {
							$lihvr_css = $_POST['lihover_style'];
							$lihvr_selectors = explode("|", $_POST['lihover_selector']);
							$lihvr_cssf = array_filter($lihvr_css);
							if(!empty($lihvr_cssf)) {
								// $lihvr_file = PLUGIN_DIR . '/theming/' . $theme . '/listitems/default/listitems.css';

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/');
								}
								
								$lihvr_path = PLUGIN_DIR . '/theming/' . $theme . '/listitems/custom/listitems_hover' . $post_id . '.css';
								
								// $lihvr_content = $wp_filesystem->get_contents($lihvr_file);
								
								update_post_meta($post_id, '_lihvrcss_value_details', $lihvr_css);
								// $userLIStyle = '';
								$listshover = '';
								$listshoverli = '';
								$lihvr_text = '';
								
								if($lihvr_css['color'] != '') {
									$lihvr_text .= 'color: ' . $lihvr_css['color'] . " !important;\n";								
								}
								if($lihvr_css['fontfamily'] != '') {
									$listshover .= 'font-family: ' . $lihvr_css['fontfamily'] . " !important;\n";
								}
								if($lihvr_css['fontsize'] != '') {
									$listshover .= 'font-size: ' . $lihvr_css['fontsize'] . "px !important;\n";
								}								
								if($lihvr_css['fontstyle'] != '') {
									$listshover .= 'font-style: ' . $lihvr_css['fontstyle'] . " !important;\n";
								}
								if($lihvr_css['fontweight'] != '') {
									$listshover .= 'font-weight: ' . $lihvr_css['fontweight'] . " !important;\n";
								}											
								
								$newLiCssByUser = '';								
									if($listshover != '') {
									$newLiCssByUser .= ".lists:hover { \n" . $listshover . "}\r\n";
									}
									if($listshoverli != '') {
									$newLiCssByUser .= ".lists ul li:hover { \n" . $listshoverli . "}\r\n";
									}
									if($lihvr_text != '') {
									$newLiCssByUser .= ".li_text:hover { \n" . $lihvr_text . "}";
									}											
								
								// $finalLIStyle = $cssEditor->editCss($lihvr_content, $newLiCssByUser, $lihvr_selectors);	
								$wp_filesystem->put_contents($lihvr_path, $newLiCssByUser, FS_CHMOD_FILE); 
								}
							}			
			// End LIST ITEM HOVER	
			
			// IMAGE DEFAULT
			if(isset($_POST['img_style']))
			{
				$imgcss = $_POST['img_style'];
				$imgselector = $_POST['img_selector'];
				$imgcssf = array_filter($imgcss);
				if(!empty($imgcssf)) 
				{
						$img_file = PLUGIN_DIR . '/theming/' . $theme . '/images/default/imgexist.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/images/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/images/custom/');
						}
								
						$img_path = PLUGIN_DIR . '/theming/' . $theme . '/images/custom/imgexist_' . $post_id . '.css';
								
						$img_content = $wp_filesystem->get_contents($img_file);
								
						update_post_meta($post_id, '_imgcss_value_details', $imgcss);
						
						$opacity = "";
						$maxheight = "";
						
						if($imgcss['opacity'] != '')
						{
							$opacity .= "opacity: " . $imgcss['opacity'] . " !important;\n";
							$opacity .= "-moz-opacity: " . $imgcss['opacity'] . " !important;\n";
							$opacity .= "filter: alpha(opacity=" . $imgcss['opacity'] * 100 . ") !important;\n";
						}
						
						if($imgcss['maxheight'] != '') {
							$maxheight .= "max-height: " . $imgcss['maxheight'] . "px !important;\n";
						}
						$userImgSetting = $imgselector . "{" . $maxheight . $opacity . "}\n";
						
						$finalImgStyle = $cssEditor->editCss($img_content, $userImgSetting, array($imgselector));	
						$wp_filesystem->put_contents($img_path, $finalImgStyle, FS_CHMOD_FILE);					
				}				
			}
			// End IMAGE DEFAULT

			// IMAGE HOVER
			if(isset($_POST['imghvr_style']))
			{
				$imghvrcss = $_POST['imghvr_style'];
				$imghvrselector = $_POST['imghvr_selector'];
				$imghvrcssf = array_filter($imghvrcss);
				if(!empty($imghvrcssf)) 
				{
						// $img_file = PLUGIN_DIR . '/theming/' . $theme . '/images/default/imgexist.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/images/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/images/custom/');
						}
								
						$imghvr_path = PLUGIN_DIR . '/theming/' . $theme . '/images/custom/imgexist_hover' . $post_id . '.css';
						// $img_content = $wp_filesystem->get_contents($img_file);
								
						update_post_meta($post_id, '_imghvrcss_value_details', $imghvrcss);
						
						$opacity = "";
						$maxheight = "";
						
						if($imghvrcss['opacity'] != '')
						{
							$opacity .= "opacity: " . $imghvrcss['opacity'] . " !important;\n";
							$opacity .= "-moz-opacity: " . $imghvrcss['opacity'] . " !important;\n";
							$opacity .= "filter: alpha(opacity=" . $imghvrcss['opacity'] * 100 . ") !important;\n";
						}
						
						if($imghvrcss['maxheight'] != '') {
							$maxheight .= "max-height: " . $imghvrcss['maxheight'] . "px !important;\n";
						}

						
						$userImghvrSetting = $imghvrselector . "{" . $maxheight . $opacity . "}\n";

						
						// $finalImgStyle = $cssEditor->editCss($img_content, $userImgSetting, $imgselector);	
						$wp_filesystem->put_contents($imghvr_path, $userImghvrSetting, FS_CHMOD_FILE);
				}				
			}
			// End IMAGE HOVER

			
			// SECOND HEADLINE DEFAULT
			if(isset($_POST['sh_style']))
			{
				$sh_css = $_POST['sh_style'];
				$sh_selector = $_POST['sh_selector'];
				$sh_cssf = array_filter($sh_css);
				if(!empty($sh_cssf)) 
				{
						$sh_file = PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/default/calltoaction.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/');
						}
								
						$sh_path = PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/calltoaction_' . $post_id . '.css';
								
						$sh_content = $wp_filesystem->get_contents($sh_file);
								
						update_post_meta($post_id, '_shcss_value_details', $sh_css);
						
						$userSHSetting = "";
						
						if($sh_css['textcolor'] != '') {
						$userSHSetting .= "color: " . $sh_css['textcolor'] . " !important;\n";						
						}
						
						if($sh_css['fontfamily'] != '') {
						$userSHSetting .= "font-family: " . $sh_css['fontfamily'] . " !important;\n";						
						}
						if($sh_css['fontsize'] != '') {
						$userSHSetting .= "font-size: " . $sh_css['fontsize'] . " !important;\n";						
						}

						if($sh_css['fontstyle'] != '') {
						$userSHSetting .= "font-style: " . $sh_css['fontstyle'] . " !important;\n";						
						}
						if($sh_css['fontweight'] != '') {
						$userSHSetting .= "font-weight: " . $sh_css['fontweight'] . " !important;\n";
						}
						$lshcss = $sh_selector . "{\n";
						$lshcss .= $userSHSetting;						
						$lshcss .= "}";
						
						$finalSHStyle = $cssEditor->editCss($sh_content, $lshcss, array($sh_selector));	
						$wp_filesystem->put_contents($sh_path, $finalSHStyle, FS_CHMOD_FILE);					
				}				
			}

		// End SECOND HEADLINE DEFAULT
		
			// SECOND HEADLINE HOVER
			if(isset($_POST['shhvr_style']))
			{
				$shhvr_css = $_POST['shhvr_style'];
				$shhvr_selector = $_POST['shhvr_selector'];
				$shhvr_cssf = array_filter($shhvr_css);
				if(!empty($shhvr_cssf)) 
				{
						// $shhvr_file = PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/default/calltoaction.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/');
						}
								
						$shhvr_path = PLUGIN_DIR . '/theming/' . $theme . '/secondheadline/custom/calltoaction_hover' . $post_id . '.css';
								
						// $shhvr_content = $wp_filesystem->get_contents($shhvr_file);
								
						update_post_meta($post_id, '_shhvrcss_value_details', $shhvr_css);
						
						$userSHHVRSetting = "";
						
						if($shhvr_css['textcolor'] != '') {
						$userSHHVRSetting .= "color: " . $shhvr_css['textcolor'] . " !important;\n";						
						}
						
						if($shhvr_css['fontfamily'] != '') {
						$userSHHVRSetting .= "font-family: " . $shhvr_css['fontfamily'] . " !important;\n";						
						}
						if($shhvr_css['fontsize'] != '') {
						$userSHHVRSetting .= "font-size: " . $shhvr_css['fontsize'] . " !important;\n";						
						}

						if($shhvr_css['fontstyle'] != '') {
						$userSHHVRSetting .= "font-style: " . $shhvr_css['fontstyle'] . " !important;\n";						
						}
						if($shhvr_css['fontweight'] != '') {
						$userSHHVRSetting .= "font-weight: " . $shhvr_css['fontweight'] . " !important;\n";
						}
						$lshhvrcss = $shhvr_selector . "{\n";
						$lshhvrcss .= $userSHHVRSetting;						
						$lshhvrcss .= "}";
						$wp_filesystem->put_contents($shhvr_path, $lshhvrcss, FS_CHMOD_FILE);					
				}				
			}

		// End SECOND HEADLINE HOVER
		
		// NAME FIELD DEFAULT
			if(isset($_POST['nf_style']))
			{
				$nf_css = $_POST['nf_style'];
				$nf_selector = $_POST['nf_selector'];
				$nf_cssf = array_filter($nf_css);
				if(!empty($nf_cssf)) 
				{
						$nf_file = PLUGIN_DIR . '/theming/' . $theme . '/namefield/default/namefield.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/');
						}
								
						$nf_path = PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/namefield_' . $post_id . '.css';
								
						$nf_content = $wp_filesystem->get_contents($nf_file);
								
						update_post_meta($post_id, '_nfcss_value_details', $nf_css);
						
						$userNFSetting = "";
						if($nf_css['textcolor'] != '') {
						$userNFSetting .= "color: " . $nf_css['textcolor'] . " !important;\n";						
						}
						
						if($nf_css['fontfamily'] != '') {
						$userNFSetting .= "font-family: " . $nf_css['fontfamily'] . " !important;\n";
						}
						if($nf_css['fontsize'] != '') {
						$userNFSetting .= "font-size: " . $nf_css['fontsize'] . " !important;\n";
						}

						if($nf_css['fontstyle'] != '') {
						$userNFSetting .= "font-style: " . $nf_css['fontstyle'] . " !important;\n";
						}
						if($nf_css['fontweight'] != '') {
						$userNFSetting .= "font-weight: " . $nf_css['fontweight'] . " !important;\n";
						}
						
						$lnfcss = $nf_selector . "{\n";
						$lnfcss .= $userNFSetting;						
						$lnfcss .= "}";
						
						$finalNFStyle = $cssEditor->editCss($nf_content, $lnfcss, array($nf_selector));	
						$wp_filesystem->put_contents($nf_path, $finalNFStyle, FS_CHMOD_FILE);					
				}				
			}

		// End NAME FIELD DEFAULT
		
		// NAME FIELD HOVER
			if(isset($_POST['nfhvr_style']))
			{
				$nfhvr_css = $_POST['nfhvr_style'];
				$nfhvr_selector = $_POST['nfhvr_selector'];
				$nfhvr_cssf = array_filter($nfhvr_css);
				if(!empty($nfhvr_cssf)) 
				{
						$nfhvr_file = PLUGIN_DIR . '/theming/' . $theme . '/namefield/default/namefieldhover.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/');
						}
								
						$nfhvr_path = PLUGIN_DIR . '/theming/' . $theme . '/namefield/custom/namefieldhover_' . $post_id . '.css';
								
						$nfhvr_content = $wp_filesystem->get_contents($nfhvr_file);
								
						update_post_meta($post_id, '_nfhvrcss_value_details', $nfhvr_css);
						
						$userNFHVRSetting = "";

						
						if($nfhvr_css['textcolor'] != '') {
						$userNFHVRSetting .= "color: " . $nfhvr_css['textcolor'] . " !important;\n";
						}
						
						if($nfhvr_css['fontfamily'] != '') {
						$userNFHVRSetting .= "font-family: " . $nfhvr_css['fontfamily'] . " !important;\n";
						}
						if($nfhvr_css['fontsize'] != '') {
						$userNFHVRSetting .= "font-size: " . $nfhvr_css['fontsize'] . " !important;\n";
						}

						if($nfhvr_css['fontstyle'] != '') {
						$userNFHVRSetting .= "font-style: " . $nfhvr_css['fontstyle'] . " !important;\n";
						}
						if($nfhvr_css['fontweight'] != '') {
						$userNFHVRSetting .= "font-weight: " . $nfhvr_css['fontweight'] . " !important;\n";
						}
						$lnfhvrcss = $nfhvr_selector . "{\n";
						$lnfhvrcss .= $userNFHVRSetting;						
						$lnfhvrcss .= "}";
						
						$finalNFHVRStyle = $cssEditor->editCss($nfhvr_content, $lnfhvrcss, array($nfhvr_selector));	
						$wp_filesystem->put_contents($nfhvr_path, $finalNFHVRStyle, FS_CHMOD_FILE);					
				}				
			}

		// End NAME FIELD HOVER

		// EMAIL FIELD DEFAULT
			if(isset($_POST['ef_style']))
			{
				$ef_css = $_POST['ef_style'];
				$ef_selector = $_POST['ef_selector'];
				$ef_cssf = array_filter($ef_css);
				if(!empty($ef_cssf)) 
				{
						$ef_file = PLUGIN_DIR . '/theming/' . $theme . '/emailfield/default/emailfield.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/');
						}
								
						$ef_path = PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/emailfield_' . $post_id . '.css';
								
						$ef_content = $wp_filesystem->get_contents($ef_file);
								
						update_post_meta($post_id, '_efcss_value_details', $ef_css);
						
						$userEFSetting = "";
						
						if($ef_css['textcolor'] != '') {
						$userEFSetting .= "color: " . $ef_css['textcolor'] . " !important;\n";						
						}
						
						if($ef_css['fontfamily'] != '') {
						$userEFSetting .= "font-family: " . $ef_css['fontfamily'] . " !important;\n";
						}
						if($ef_css['fontsize'] != '') {
						$userEFSetting .= "font-size: " . $ef_css['fontsize'] . " !important;\n";
						}

						if($ef_css['fontstyle'] != '') {
						$userEFSetting .= "font-style: " . $ef_css['fontstyle'] . " !important;\n";
						}
						if($ef_css['fontweight'] != '') {
						$userEFSetting .= "font-weight: " . $ef_css['fontweight'] . " !important;\n";
						}
						$lefcss = $ef_selector . "{\n";
						$lefcss .= $userEFSetting;						
						$lefcss .= "}";
						
						$finalEFStyle = $cssEditor->editCss($ef_content, $lefcss, array($ef_selector));	
						$wp_filesystem->put_contents($ef_path, $finalEFStyle, FS_CHMOD_FILE);					
				}				
			}

		// End EMAIL FIELD DEFAULT		
		
		
		// EMAIL FIELD HOVER
			if(isset($_POST['efhvr_style']))
			{
				$efhvr_css = $_POST['efhvr_style'];
				$efhvr_selector = $_POST['efhvr_selector'];
				$efhvr_cssf = array_filter($efhvr_css);
				if(!empty($efhvr_cssf)) 
				{
					$efhvr_file = PLUGIN_DIR . '/theming/' . $theme . '/emailfield/default/emailfieldhover.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/');
						}
								
						$efhvr_path = PLUGIN_DIR . '/theming/' . $theme . '/emailfield/custom/emailfield_hover' . $post_id . '.css';
								
						$efhvr_content = $wp_filesystem->get_contents($efhvr_file);
								
						update_post_meta($post_id, '_efhvrcss_value_details', $efhvr_css);
						
						$userEFHVRSetting = "";
						if($efhvr_css['textcolor'] != '') {
						$userEFHVRSetting .= "color: " . $efhvr_css['textcolor'] . " !important;\n";
						}
						
						if($efhvr_css['fontfamily'] != '') {
						$userEFHVRSetting .= "font-family: " . $efhvr_css['fontfamily'] . " !important;\n";
						}
						if($efhvr_css['fontsize'] != '') {
						$userEFHVRSetting .= "font-size: " . $efhvr_css['fontsize'] . " !important;\n";
						}

						if($efhvr_css['fontstyle'] != '') {
						$userEFHVRSetting .= "font-style: " . $efhvr_css['fontstyle'] . " !important;\n";
						}
						if($efhvr_css['fontweight'] != '') {
						$userEFHVRSetting .= "font-weight: " . $efhvr_css['fontweight'] . " !important;\n";
						}
						$lefhvrcss = $efhvr_selector . "{\n";
						$lefhvrcss .= $userEFHVRSetting;						
						$lefhvrcss .= "}";
						
						$finalEFHVRStyle = $cssEditor->editCss($efhvr_content, $lefhvrcss, array($efhvr_selector));	
						$wp_filesystem->put_contents($efhvr_path, $finalEFHVRStyle, FS_CHMOD_FILE);
						
				}				
			}

		// End EMAIL FIELD HOVER

	// BUTTON STYLE
			if(isset($_POST['btn_style']))
			{
				$btn_css = $_POST['btn_style'];
				$btn_selector = str_getcsv($_POST['btn_selector'], '');
				
				$btn_cssf = array_filter($btn_css);
				if(!empty($btn_cssf)) 
				{
						$btn_file = PLUGIN_DIR . '/theming/' . $theme . '/submitbutton/default/submitbutton.css';

						if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/submitbutton/custom/')) 
						{
						$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/submitbutton/custom/');
						}
								
						$btn_path = PLUGIN_DIR . '/theming/' . $theme . '/submitbutton/custom/submitbutton_' . $post_id . '.css';
								
						$btn_content = $wp_filesystem->get_contents($btn_file);
								
						update_post_meta($post_id, '_btncss_value_details', $btn_css);
						$lbtncss = $_POST['eps_btn_style'];
						$finalBtnStyle = $cssEditor->editCss($btn_content, $lbtncss, array('#eps_popup_front input[type="submit"]', '#eps_popup_front input[type="submit"]:hover', '#eps_popup_front input[type="submit"]:active'));	
						
						/* update_option('test_debug', $btn_selector $cssEditor->getCssArray($btn_content, $lbtncss, array('#eps_popup_front input[type="submit"]', '#eps_popup_front input[type="submit"]:hover', '#eps_popup_front input[type="submit"]:active'))); */
						
						$wp_filesystem->put_contents($btn_path, $finalBtnStyle, FS_CHMOD_FILE);					
				}
			}
		// End BUTTON STYLE		
		
		// TINY NOTE
						if(isset($_POST['timess_style']) || (!empty($_FILES['timess_style_image']) && isset($_FILES['timess_style_image']) && $_POST['eps_timess_image_text'] != '')) {
							$timess_css = $_POST['timess_style'];
							$timess_selectors = $_POST['timess_selector'];
							
							if(!empty($timess_css)) {
								$timess_file = PLUGIN_DIR . '/theming/' . $theme . '/tinynote/default/tinynote.css';

								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/');
								}
								
								$timess_path = PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/tinynote_' . $post_id . '.css';
								
								$timess_content = $wp_filesystem->get_contents($timess_file);
								
								update_post_meta($post_id, '_timesscss_value_details', $timess_css);

								$timess = '';
								
								if($timess_css['color'] != '') {
									$timess .= 'color: ' . $timess_css['color'] . " !important;\n";
								}
								if($timess_css['fontfmly'] != '') {
									$timess .= 'font-family: ' . $timess_css['fontfmly'] . " !important;\n";
								}
								if($timess_css['fsize'] != '') {
									$timess .= 'font-size: ' . $timess_css['fsize'] . "px !important;\n";
								}								
								if($timess_css['fontsty'] != '') {
									$timess .= 'font-style: ' . $timess_css['fontsty'] . " !important;\n";
								}
								if($timess_css['fontwght'] != '') {
									$timess .= 'font-weight: ' . $timess_css['fontwght'] . " !important;\n";
								}
								
								$newtimessCssByUser = $timess_selectors . " { \n" . $timess. "}\r\n";
								$finaltimessStyle = $cssEditor->editCss($timess_content, $newtimessCssByUser, array($timess_selectors));	
								$wp_filesystem->put_contents($timess_path, $finaltimessStyle, FS_CHMOD_FILE); 
								}
							}
			// End TINY NOTE			
			
	// TINY NOTE HOVER
						if(isset($_POST['timesshover_style']) || (!empty($_FILES['timesshvr_style_image']) && isset($_FILES['timesshvr_style_image']) && $_POST['eps_timesshvr_image_text'] != '')) {
							$timesshvr_css = $_POST['timesshover_style'];
							$timesshvr_selectors = $_POST['timesshover_selector'];
							
							if(!empty($timesshvr_css)) {
								if(!$wp_filesystem->is_dir(PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/')) 
								{
								$wp_filesystem->mkdir(PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/');
								}
								
								$timesshvr_path = PLUGIN_DIR . '/theming/' . $theme . '/tinynote/custom/tinynote_hover' . $post_id . '.css';
								
								update_post_meta($post_id, '_timesshvrcss_value_details', $timesshvr_css);

								$timesshover = '';
								if($timesshvr_css['color'] != '') {
									$timesshover .= 'color: ' . $timesshvr_css['color'] . " !important;\n";
								}
								if($timesshvr_css['fontfamily'] != '') {
									$timesshover .= 'font-family: ' . $timesshvr_css['fontfamily'] . " !important;\n";
								}
								if($timesshvr_css['fontsize'] != '') {
									$timesshover .= 'font-size: ' . $timesshvr_css['fontsize'] . "px !important;\n";
								}								
								if($timesshvr_css['fontstyle'] != '') {
									$timesshover .= 'font-style: ' . $timesshvr_css['fontstyle'] . " !important;\n";
								}
								if($timesshvr_css['fontweight'] != '') {
									$timesshover .= 'font-weight: ' . $timesshvr_css['fontweight'] . " !important;\n";
								}										
								
								$newtimessCssByUser = '';								
									if($timesshover != '') {
									$newtimessCssByUser .= $timesshvr_selectors . " { \n" . $timesshover . "}\r\n";
									}
								$wp_filesystem->put_contents($timesshvr_path, $newtimessCssByUser, FS_CHMOD_FILE); 
								}
							}			
			// End TINY NOTE HOVER
			
//																													
						} else {
							/* don't have direct write access. Prompt user with our notice */
							update_option('eps_writingcss_not_direct', 'No direct access allowed!');	
						}		
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
		
	// SAVE GENERAL STYLES	
		$epsGStyles = array();
		if(isset($_POST['eps_containerWidth'])) {
			$epsGStyles['ecwidth'] = $_POST['eps_containerWidth'];
		}
		if(isset($_POST['eps_containerHeight'])) {
			$epsGStyles['echeight'] = $_POST['eps_containerHeight'];
		}			
		if(isset($_POST['eps_in_animation'])) {
			$epsGStyles['open'] = $_POST['eps_in_animation'];
		}
		if(isset($_POST['eps_out_animation'])) {
			$epsGStyles['out'] = $_POST['eps_out_animation'];
		}
		if(isset($_POST['eps_backoverly_color'])) {
			$epsGStyles['backov'] = $_POST['eps_backoverly_color'];
		}
		if(isset($_POST['eps_backmain_color'])) {
			$epsGStyles['backmain'] = $_POST['eps_backmain_color'];
		}
		if(isset($_POST['eps_border_size'])) {
			$epsGStyles['brdrsize'] = $_POST['eps_border_size'];
		}
		if(isset($_POST['eps_border_style']) && $_POST['eps_border_style'] != 'predefined') {
			$epsGStyles['brdrstyle'] = $_POST['eps_border_style'];
		}
		if(isset($_POST['eps_border_color'])) {
			$epsGStyles['sborder'] = $_POST['eps_border_color'];
		} 
		if(isset($_POST['eps_containerleftposx'])) {
			$epsGStyles['topposy'] = $_POST['eps_containerleftposx'];
		} 
		if(isset($_POST['eps_containertopposy'])) {
			$epsGStyles['leftposx'] = $_POST['eps_containertopposy'];
		}		
		update_post_meta( $post_id, '_eps_general_styles', $epsGStyles);
	} 

}

new saveEpsSettings();
?>