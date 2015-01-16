<?php
include_once(PLUGIN_DIR . "theming/functions.php");

class epsThemeMaster {
	function __construct() {
	add_shortcode('eps_pop', array($this, 'eps_popup_front_end'), 9999);
	add_shortcode('link_eps_pop', array($this, 'eps_popup_front_end'), 9999);
	}
	
	function eps_popup_front_end($atts, $content = null, $tag) {
	// global $shortcode_tags;
		global $post;
		extract( shortcode_atts( array(
		'id' => '',
		'link' => '',
		'name' => '',
		'text' => '',
		'tn' => '',
		'lt' => ''
		),	$atts ) );
/* print_r($shortcode_tags);
	if(array_key_exists("link_eps_pop", $shortcode_tags)){
	echo "Don't include!";
	} */
		$pop_theme = themeData($id, '_eps_popup_theme');
		$headline = themeData($id, '_eps_first_headline_key');
		$short_desc = themeData($id, '_eps_short_description_key');
		$lists = themeData($id, '_eps_list_items_key');
		$urlim = themeData($id, '_eps_image_key');
		$cta = themeData($id, '_eps_second_headline_key');
		$name_label = themeData($id, '_eps_name_field_label_key');		
		$name_placeholder = themeData($id, '_eps_name_field_placeholder_key');
		$email_label = themeData($id, '_eps_email_field_label_key');
		$email_placeholder = themeData($id, '_eps_email_field_placeholder_key');		
		$eps_button = themeData($id, '_eps_button_field_value_key'); 	
		$timyse = themeData($id, '_tiny_little_message');
		$rules = themeData($id, "_eps_display_rules");
		$url = themeData($id, '_eps_redirect_destination');
		$usethis = themeData($id, '_eps_usethis_style');
			wp_enqueue_script( 'epspop_js_script', THEME_DIR_URL . "/theming/js/popup.js", array(), "1.0.0", true);
			// wp_enqueue_script( 'epspop_js_script', THEME_DIR_URL . "/theming/js/jquery.copycss.js", array(), "1.0.0", true);
			wp_localize_script( 'epspop_js_script', 'epsSubmit', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'security' => wp_create_nonce( 'eps-secure-subscribe' )
			));		
		
		
		if($tag == "link_eps_pop") {
			if($tn == 'yes') {
				$thnm = ucwords($pop_theme);
			} elseif($tn == '' || $tn == 'no') {
				$thnm = '';		
			}

			if($lt == '' || $lt == 'link') {
			echo "<a class='epslinkshortcode' href='" . $link . "' name='" . $name . "'>" . $thnm . " " . $text . "</a>";
			} elseif($lt == 'button') {
			echo "<button class='epslinkshortcode epslinkshortcodebutton' name='" . $name . "'>" . $thnm . " " . $text . "</button>";	
			}			
				
			
		} else {
			wp_enqueue_script( 'epspop_js_scriptopen', THEME_DIR_URL . "/theming/js/pop.js", array(), "1.0.0", true);
		}
			
		wp_enqueue_style( 'epsfrontPluginReset', MAIN_DIR_URL . 'css/front/reset.css');
		wp_enqueue_style( 'epsfrontPluginStylesheeta', THEME_DIR_URL . '/theming/' .$pop_theme . '/css/style.css');
		wp_enqueue_style( 'epsfrontPluginStylesheetb', THEME_DIR_URL . '/theming/css/ajaxload.css');
		include_once(PLUGIN_DIR . "/theming/" .$pop_theme . "/css/style.php");
		include_once(PLUGIN_DIR . "/theming/" .$pop_theme . "/css/dynamic.php");
				
		// HEADER CSS
		$h_elm = 'header';
		$h_path = '/theming/' . $pop_theme . '/' . $h_elm . '/custom/' . $h_elm . '_' . $id . '.css';
		$hhvr_path = '/theming/' . $pop_theme . '/' . $h_elm . '/custom/' . $h_elm . '_hover' . $id . '.css';
		$dh_path = '/theming/' . $pop_theme . '/' . $h_elm . '/default/' . $h_elm . '.css';
		$h_fname = PLUGIN_DIR . $h_path;
		$hhvr_fname = PLUGIN_DIR . $hhvr_path;	
		
		if(file_exists($h_fname) && isset($usethis['hd'])) {
		if($usethis['hd'] != '' ){
		wp_enqueue_style( 'epsfrontPluginStylesheetc', THEME_DIR_URL . $h_path);
			}
		} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetd', THEME_DIR_URL . $dh_path);
			
		}
		
		if(file_exists($hhvr_fname) && isset($usethis['hdhvr'])) {
		if($usethis['hdhvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheete', THEME_DIR_URL . $hhvr_path);
			}
		}
		// End HEADER CSS
		
		// SHORT DESCRIPTION CSS
		$sd_elm = 'shortdescription';
		$sd_path = '/theming/' . $pop_theme . '/' . $sd_elm . '/custom/' . $sd_elm . '_' . $id . '.css';
		$sdhvr_path = '/theming/' . $pop_theme . '/' . $sd_elm . '/custom/' . $sd_elm . '_hover' . $id . '.css';
		$dsd_path = '/theming/' . $pop_theme . '/' . $sd_elm . '/default/' . $sd_elm . '.css';
		$sd_fname = PLUGIN_DIR . $sd_path;
		$sdhvr_fname = PLUGIN_DIR . $sdhvr_path;
		
		if(file_exists($sd_fname) && isset($usethis['sd'])) {
		if($usethis['sd'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetf', THEME_DIR_URL . $sd_path);
			}
		} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetg', THEME_DIR_URL . $dsd_path);
		}			

		if(file_exists($sdhvr_fname) && isset($usethis['sdhvr'])) {
		if($usethis['sdhvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheeth', THEME_DIR_URL . $sdhvr_path);
			}
		}		
		// End SHORT DESCRIPTION CSS
		
		
	//LIST ITEM CSS
		$li = 'listitems';
		$li_path = '/theming/' . $pop_theme . '/' . $li . '/custom/' . $li . '_' . $id . '.css';
		$lihvr_path = '/theming/' . $pop_theme . '/' . $li . '/custom/' . $li . '_hover' . $id . '.css';
		$dli_path = '/theming/' . $pop_theme . '/' . $li . '/default/' . $li . '.css';
		$li_fname = PLUGIN_DIR . $li_path;
		$lihvr_fname = PLUGIN_DIR . $lihvr_path;
		
		if(file_exists($li_fname) && isset($usethis['li'])) {
		if($usethis['li'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheeti', THEME_DIR_URL . $li_path);
		}
		} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetj', THEME_DIR_URL . $dli_path);
		}			

		if(file_exists($lihvr_fname) && isset($usethis['lihover'])) {
		if($usethis['lihover'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetk', THEME_DIR_URL . $lihvr_path);
		}
		}		
	//End LIST ITEM CSS
		
	//IMAGE CSS		

		$im = 'images';
		
		
		$im_path = '/theming/' . $pop_theme . '/' . $im . '/custom/imgexist_' . $id . '.css';
		$imhvr_path = '/theming/' . $pop_theme . '/' . $im . '/custom/imgexist_hover' . $id . '.css';
		
		$dim_path = '/theming/' . $pop_theme . '/' . $im . '/default/imgexist.css';
		$dnoim_path = '/theming/' . $pop_theme . '/' . $im . '/default/noimage.css';
		
		$im_fname = PLUGIN_DIR . $im_path;
		$imhvr_fname = PLUGIN_DIR . $imhvr_path;
		if(filter_var($urlim, FILTER_VALIDATE_URL) == true) {	
			if(file_exists($im_fname) && isset($usethis['img'])) {
			if($usethis['img'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetl', THEME_DIR_URL . $im_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetm', THEME_DIR_URL . $dim_path);
			}

			if(file_exists($imhvr_fname) && isset($usethis['imghvr'])) {
			if($usethis['imghvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetn', THEME_DIR_URL . $imhvr_path);
			}
			}
		} else {
		wp_enqueue_style( 'epsfrontPluginStylesheeto', THEME_DIR_URL . $dnoim_path);
		}
		
	//End IMAGE CSS			

	// SECOND HEADLINE CSS		

		$sh = 'secondheadline';		
		$sh_path = '/theming/' . $pop_theme . '/' . $sh . '/custom/calltoaction_' . $id . '.css';
		$shhvr_path = '/theming/' . $pop_theme . '/' . $sh . '/custom/calltoaction_hover' . $id . '.css';
		
		$dsh_path = '/theming/' . $pop_theme . '/' . $sh . '/default/calltoaction.css';
		
		$sh_fname = PLUGIN_DIR . $sh_path;
		$shhvr_fname = PLUGIN_DIR . $shhvr_path;
	
			if(file_exists($sh_fname) && isset($usethis['sh'])) {
			if($usethis['sh'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetp', THEME_DIR_URL . $sh_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetq', THEME_DIR_URL . $dsh_path);
			}
			
			if(file_exists($shhvr_fname) && isset($usethis['shhvr'])) {
			if($usethis['shhvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetr', THEME_DIR_URL . $shhvr_path);
			}
			}
		
	//End SECOND HEADLINE CSS			

	// EMAIL WRAPPER CSS		

		$ew = 'emailformdiv';		
		$ew_path = '/theming/' . $pop_theme . '/' . $ew . '/custom/emailwrapper_' . $id . '.css';
		$ewhvr_path = '/theming/' . $pop_theme . '/' . $ew . '/custom/emailwrapper_hover' . $id . '.css';
		
		$dew_path = '/theming/' . $pop_theme . '/' . $ew . '/default/emailwrapper.css';
		
		$ew_fname = PLUGIN_DIR . $ew_path;
		$ewhvr_fname = PLUGIN_DIR . $ewhvr_path;
	
			if(file_exists($ew_fname) && isset($usethis['ew'])) {
			if($usethis['ew'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheets', THEME_DIR_URL . $ew_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheett', THEME_DIR_URL . $dew_path);
			}
			
			if(file_exists($ewhvr_fname) && isset($usethis['ewhvr'])) {
			if($usethis['ewhvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetu', THEME_DIR_URL . $ewhvr_path);
			}
			}
		
	//End EMAIL WRAPPER CSS			

	// NAME FIELD CSS		

		$nf = 'namefield';		
		$nf_path = '/theming/' . $pop_theme . '/' . $nf . '/custom/namefield_' . $id . '.css';
		$nfhvr_path = '/theming/' . $pop_theme . '/' . $nf . '/custom/namefield_hover' . $id . '.css';
		
		$dnf_path = '/theming/' . $pop_theme . '/' . $nf . '/default/namefield.css';
		$dnfhvr_path = '/theming/' . $pop_theme . '/' . $nf . '/default/namefieldhover.css';
		
		$nf_fname = PLUGIN_DIR . $nf_path;
		$nfhvr_fname = PLUGIN_DIR . $nfhvr_path;
	
			if(file_exists($nf_fname) && isset($usethis['nf'])) {
			if($usethis['nf'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetv', THEME_DIR_URL . $nf_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetw', THEME_DIR_URL . $dnf_path);
			}
			
			if(file_exists($nfhvr_fname) && isset($usethis['nfhvr'])) {
			if($usethis['nfhvr'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetx', THEME_DIR_URL . $nfhvr_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheety', THEME_DIR_URL . $dnfhvr_path);
			}
		
	//End NAME FIELD CSS			

	// EMAIL FIELD CSS		

		$ef = 'emailfield';
		$def_path = '/theming/' . $pop_theme . '/' . $ef . '/default/emailfield.css';
		$defhvr_path = '/theming/' . $pop_theme . '/' . $ef . '/default/emailfieldhover.css';

		wp_enqueue_style( 'epsfrontPluginStylesheetaa', THEME_DIR_URL . $def_path);

		wp_enqueue_style( 'epsfrontPluginStylesheetac', THEME_DIR_URL . $defhvr_path);
	
		
	//End EMAIL FIELD CSS

	// BUTTON CSS		

		$btn = 'submitbutton';		
		$btn_path = '/theming/' . $pop_theme . '/' . $btn . '/custom/submitbutton_' . $id . '.css';
		
		$dbtn_path = '/theming/' . $pop_theme . '/' . $btn . '/default/submitbutton.css';
		
		$btn_fname = PLUGIN_DIR . $btn_path;
	
			if(file_exists($btn_fname) && isset($usethis['btn'])) {
			if($usethis['btn'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetad', THEME_DIR_URL . $btn_path);
			}
			} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetae', THEME_DIR_URL . $dbtn_path);
			}	
		
		
	//End BUTTON CSS
	
	// TINYNOTE
		$timess = 'tinynote';
		$timess_path = '/theming/' . $pop_theme . '/' . $timess . '/custom/' . $timess . '_' . $id . '.css';
		$timesshvr_path = '/theming/' . $pop_theme . '/' . $timess . '/custom/' . $timess . '_hover' . $id . '.css';
		$dtimess_path = '/theming/' . $pop_theme . '/' . $timess . '/default/' . $timess . '.css';
		$timess_fname = PLUGIN_DIR . $timess_path;
		$timesshvr_fname = PLUGIN_DIR . $timesshvr_path;
		
		if(file_exists($timess_fname) && isset($usethis['timess'])) {
			if($usethis['timess'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetaf', THEME_DIR_URL . $timess_path);
			}
		} else {
		wp_enqueue_style( 'epsfrontPluginStylesheetag', THEME_DIR_URL . $dtimess_path);
		}			

		if(file_exists($timesshvr_fname) && isset($usethis['timesshover'])) {
			if($usethis['timesshover'] != ''){
		wp_enqueue_style( 'epsfrontPluginStylesheetah', THEME_DIR_URL . $timesshvr_path);
			}
		}		
	// End TINYNOTE
		if(is_array($rules) && isset($rules['delay']) && $rules['delay'] != '') {
			?>
			<input type="hidden" id="eps_showedup_delay" value="<?php echo $rules['delay']; ?>" />
			<?php				
		}
		if(isset($css['open']) && $css['open'] != 'none') {
			?>
			<input type="hidden" id="eps_animation_in" value="<?php echo $css['open']; ?>" />
			<?php	
		}
		if(isset($css['out']) && $css['out'] != 'none') {
			?>
			<input type="hidden" id="eps_animation_out" value="<?php echo $css['out']; ?>" />
			<?php
		}
	wp_enqueue_style( 'epsfrontPluginResponsive', MAIN_DIR_URL . 'css/front/responsive.css');	
include_once("themes/" . $pop_theme . ".php");
// return ob_get_clean();	
	}
}
new epsThemeMaster;
?>