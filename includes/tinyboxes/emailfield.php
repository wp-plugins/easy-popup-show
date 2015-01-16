<?php

class emailField {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln, $borderstyle, $borderstyletxt, $brdrcount;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$efcss = get_post_meta($poid, '_efcss_value_details', true);
	$efhvrcss = get_post_meta($poid, '_efhvrcss_value_details', true);		
	
	?>
	<td class="thfieldcss">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 	 
		
		<div class="default_css" id="emailFieldsStyle"> 
		<input type="checkbox" name="usethis[ef]" value="ef" id="ef_usethis" <?php echo isset($use_this['ef']) && $use_this['ef'] != '' ? 'checked' : ''; ?>/><label for="ef_usethis">Use this style</label> 
			<input type="hidden" name="ef_selector" value="#eps_user_email"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="ef_textcolor">text color :</label><input class="elmnt_color" type="text" id="ef_textcolor" name="ef_style[textcolor]" value="<?php echo isset($efcss['textcolor']) && $efcss['textcolor'] != '' ? $efcss['textcolor'] : ''; ?>"/>	
	<label for="ef_fontfamily">font family :</label>
		<select id="ef_fontfamily" name="ef_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($efcss['fontfamily']) && $efcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="ef_fontstyle">font style :</label>
	<select id="ef_fontstyle" name="ef_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($efcss['fontstyle']) && $efcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="ef_fontweight">font weight :</label>
	<select id="ef_fontweight" name="ef_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($efcss['fontweight']) && $efcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
		<div class="clear"></div>
	<hr>
	<label for="exportEmailStyle"><span class="leading_text">Export To Name Field's Style?</span></label>
		<div class="settop">
		<div class="stcenter">
		<button id="exportEmailStyle">Export!</button>			
		</div>
		</div>	
	</div>
	
<div class="hover_css" id="emailFieldsStyleHover">		
<input type="checkbox" name="usethis[efhvr]" value="efhvr" id="efhvr_usethis" <?php echo isset($use_this['efhvr']) && $use_this['efhvr'] != '' ? 'checked' : ''; ?>/><label for="efhvr_usethis">Use this style</label> 
			<input type="hidden" name="efhvr_selector" value="#eps_user_email:hover, #eps_user_email:focus"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="efhvr_textcolor">text color :</label><input class="elmnt_color" type="text" id="efhvr_textcolor" name="efhvr_style[textcolor]" value="<?php echo isset($efhvrcss['textcolor']) && $efhvrcss['textcolor'] != '' ? $efhvrcss['textcolor'] : ''; ?>"/>	
	<label for="efhvr_fontfamily">font family :</label>
		<select id="efhvr_fontfamily" name="efhvr_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($efhvrcss['fontfamily']) && $efhvrcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="efhvr_fontstyle">font style :</label>
	<select id="efhvr_fontstyle" name="efhvr_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($efhvrcss['fontstyle']) && $efhvrcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="efhvr_fontweight">font weight :</label>
	<select id="efhvr_fontweight" name="efhvr_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($efhvrcss['fontweight']) && $efhvrcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
		<div class="clear"></div>
	<hr>
	<label for="exportEmailStyleHover"><span class="leading_text">Export To Name Field's Hover Style?</span></label>
		<div class="settop">
		<div class="stcenter">
		<button id="exportEmailStyleHover">Export!</button>			
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