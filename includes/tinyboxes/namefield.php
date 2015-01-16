<?php

class nameField {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln, $borderstyle, $borderstyletxt, $brdrcount;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$nfcss = get_post_meta($poid, '_nfcss_value_details', true);
	$nfhvrcss = get_post_meta($poid, '_nfhvrcss_value_details', true);		
	?>
	<td class="thfieldcss">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 
		
		<div class="default_css" id="nameFieldsStyle"> 
		<input type="checkbox" name="usethis[nf]" value="nf" id="nf_usethis" <?php echo isset($use_this['nf']) && $use_this['nf'] != '' ? 'checked' : ''; ?>/><label for="nf_usethis">Use this style</label> 
			<input type="hidden" name="nf_selector" value="#eps_user_name"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="nf_textcolor">text color :</label><input class="elmnt_color" type="text" id="nf_textcolor" name="nf_style[textcolor]" value="<?php echo isset($nfcss['textcolor']) && $nfcss['textcolor'] != '' ? $nfcss['textcolor'] : ''; ?>"/>	
	<label for="nf_fontfamily">font family :</label>
		<select id="nf_fontfamily" name="nf_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($nfcss['fontfamily']) && $nfcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="nf_fontstyle">font style :</label>
	<select id="nf_fontstyle" name="nf_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($nfcss['fontstyle']) && $nfcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="nf_fontweight">font weight :</label>
	<select id="nf_fontweight" name="nf_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($nfcss['fontweight']) && $nfcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
	<hr>
	<label for="exportNameStyle"><span class="leading_text">Export To Email Field's Style?</span></label>
		<div class="settop">
		<div class="stcenter">
		<button id="exportNameStyle">Export!</button>			
		</div>
		</div>	
	</div>		
	
<div class="hover_css" id="nameFieldsStyleHover">
		<input type="checkbox" name="usethis[nfhvr]" value="nfhvr" id="nfhvr_usethis" <?php echo isset($use_this['nfhvr']) && $use_this['nfhvr'] != '' ? 'checked' : ''; ?>/><label for="nfhvr_usethis">Use this style</label> 
			<input type="hidden" name="nfhvr_selector" value="#eps_user_name:hover, #eps_user_name:focus"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="nfhvr_textcolor">text color :</label><input class="elmnt_color" type="text" id="nfhvr_textcolor" name="nfhvr_style[textcolor]" value="<?php echo isset($nfhvrcss['textcolor']) && $nfhvrcss['textcolor'] != '' ? $nfhvrcss['textcolor'] : ''; ?>"/>	
	<label for="nfhvr_fontfamily">font family :</label>
		<select id="nfhvr_fontfamily" name="nfhvr_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($nfhvrcss['fontfamily']) && $nfhvrcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="nfhvr_fontstyle">font style :</label>
	<select id="nfhvr_fontstyle" name="nfhvr_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($nfhvrcss['fontstyle']) && $nfhvrcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="nfhvr_fontweight">font weight :</label>
	<select id="nfhvr_fontweight" name="nfhvr_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($nfhvrcss['fontweight']) && $nfhvrcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>		
		<div class="clear"></div>
	<hr>
	<label for="exportNameStyleHover"><span class="leading_text">Export To Email Field's Hover Style?</span></label>
		<div class="settop">
		<div class="stcenter">
		<button id="exportNameStyleHover">Export!</button>			
		</div>
		</div>	
</div>
<div class="eps_helptab">	
</div>	
	</div>
	</td>
	<?php
	}

}
?>