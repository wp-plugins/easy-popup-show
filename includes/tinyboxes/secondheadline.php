<?php
class secondHeadline {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln, $borderstyle, $borderstyletxt, $brdrcount;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$shcss = get_post_meta($poid, '_shcss_value_details', true);
	$shhvrcss = get_post_meta($poid, '_shhvrcss_value_details', true);
	?>
	<td class="thfieldcss">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 	 
		
		<div class="default_css"> 
		<input type="checkbox" name="usethis[sh]" value="sh" id="sh_usethis" <?php echo isset($use_this['sh']) && $use_this['sh'] != '' ? 'checked' : ''; ?>/><label for="sh_usethis">Use this style</label> 
			<input type="hidden" name="sh_selector" value="#call_to_act"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="sh_textcolor">text color :</label><input class="elmnt_color" type="text" id="sh_textcolor" name="sh_style[textcolor]" value="<?php echo isset($shcss['textcolor']) && $shcss['textcolor'] != '' ? $shcss['textcolor'] : ''; ?>"/>	
	<label for="sh_fontfamily">font family :</label>
		<select id="sh_fontfamily" name="sh_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($shcss['fontfamily']) && $shcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="sh_fontstyle">font style :</label>
	<select id="sh_fontstyle" name="sh_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($shcss['fontstyle']) && $shcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="sh_fontweight">font weight :</label>
	<select id="sh_fontweight" name="sh_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($shcss['fontweight']) && $shcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
	</div>
<div class="hover_css">
		<input type="checkbox" name="usethis[shhvr]" value="shhvr" id="shhvr_usethis" <?php echo isset($use_this['shhvr']) && $use_this['shhvr'] != '' ? 'checked' : ''; ?>/><label for="shhvr_usethis">Use this style</label> 
			<input type="hidden" name="shhvr_selector" value="#call_to_act:hover"/>
		<div class="clear"></div>
	<div class="settop">
	<div class="stleft">	
	<label for="shhvr_textcolor">text color :</label><input class="elmnt_color" type="text" id="shhvr_textcolor" name="shhvr_style[textcolor]" value="<?php echo isset($shhvrcss['textcolor']) && $shhvrcss['textcolor'] != '' ? $shhvrcss['textcolor'] : ''; ?>"/>	
	<label for="shhvr_fontfamily">font family :</label>
		<select id="shhvr_fontfamily" name="shhvr_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($shhvrcss['fontfamily']) && $shhvrcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="shhvr_fontstyle">font style :</label>
	<select id="shhvr_fontstyle" name="shhvr_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($shhvrcss['fontstyle']) && $shhvrcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="shhvr_fontweight">font weight :</label>
	<select id="shhvr_fontweight" name="shhvr_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($shhvrcss['fontweight']) && $shhvrcss['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
</div>
<div class="eps_helptab">	
</div>	
	</div>
	</td>
	<?php
	}

}
?>