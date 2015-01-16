<?php
class headStyle {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln;
	
	 $use_this = get_post_meta($poid, '_eps_usethis_style', true);
	 $css = get_post_meta($poid, '_hdcss_value_details', true);
	 $csshvr = get_post_meta($poid, '_hdhvrcss_value_details', true);
	 ?>	 
	<!-- FIELDS SETTINGS -->
<!--HEADER-->
	<td class="thfieldcss">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
	<ul class="eps_tabs">	
		<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		
		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		
		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	
	</ul>	
	 <div class="default_css"> 
	<input type="checkbox" name="usethis[hd]" value="hd_usethis_style" id="hd_usethis" <?php echo isset($use_this['hd']) && $use_this['hd'] != '' ? 'checked' : ''; ?>/><label for="hd_usethis">Use this style</label>  
	<input type="hidden" name="hd_selector" value="#headline h1"/>
		
	<div class="settop">
	<div class="stleft">	
	<label for="hd_color">text color :</label><input class="elmnt_color" type="text" id="hd_color" name="hd_style[color]" value="<?php echo isset($css['color']) && $css['color'] != '' ? $css['color'] : ''; ?>"/>	
	<label for="hd_ff">font family :</label>
		<select id="hd_ff" name="hd_style[fontfmly]">
		<option value="">predefined</option>
		 <?php		
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($css['fontfmly']) && $css['fontfmly'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="hd_fs">font style :</label>
	<select id="hd_fs" name="hd_style[fontsty]">
	<option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($css['fontsty']) && $css['fontsty'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="hd_fw">font weight :</label>
	<select id="hd_fw" name="hd_style[fontwght]">
	<option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($css['fontwght']) && $css['fontwght'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
	</div>
<!--HOVER-->
	<div class="hover_css">	
	<input type="checkbox" name="usethis[hdhvr]" value="hdhvr_usethis_style" id="hdhvr_usethis_style" <?php echo isset($use_this['hdhvr']) && $use_this['hdhvr'] != '' ? 'checked' : ''; ?>/><label for="hdhvr_usethis_style">Use this style</label>
	<input type="hidden" name="hdhvr_selector" value="#headline h1:hover"/>
	<div class="settop">
	<div class="stleft">	
	<label for="hdhvr_tcolor">text color :</label><input class="elmnt_color" type="text" id="hdhvr_tcolor" name="hdhvr_style[color]" value="<?php echo isset($csshvr['color']) && $csshvr['color'] != '' ? $csshvr['color'] : ''; ?>"/>	
	<label for="hdhvr_ffamily">font family :</label>
		<select id="hdhvr_ffamily" name="hdhvr_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($csshvr['fontfamily']) && $csshvr['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="hdhvr_fstyle">font style :</label>
	<select id="hdhvr_fstyle" name="hdhvr_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($csshvr['fontstyle']) && $csshvr['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="hdhvr_fweight">font weight :</label>
	<select id="hdhvr_fweight" name="hdhvr_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($csshvr['fontweight']) && $csshvr['fontweight'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
</div>
<!--HELP-->
<div class="eps_helptab">	
</div>
	</div>
	</td>
<!-- END FIELDS SETTINGS -->
	<?php
	}

}
?>