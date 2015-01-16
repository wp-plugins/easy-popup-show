<?php

class shortDesc {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){	
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln;	

	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$sdcss = get_post_meta($poid, '_sdcss_value_details', true);
	$sdcsshvr = get_post_meta($poid, '_sdhvrcss_value_details', true);
	?>
	 
	<!-- FIELDS SETTINGS -->
<!--SHORT DESCRIPTION-->
	<td class="thfieldcss">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
	<ul class="eps_tabs">	
		<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		
		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		
		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	
	</ul>	
	 <div class="default_css"> 
	<input type="checkbox" name="usethis[sd]" value="sd_usethis_style" id="sd_usethis" <?php echo isset($use_this['sd']) && $use_this['sd'] != '' ? 'checked' : ''; ?>/><label for="sd_usethis">Use this style</label>  
	<input type="hidden" name="sd_selector" value="#short_desc span"/>		
	<div class="settop">
	<div class="stleft">	
	<label for="sd_color">text color :</label><input class="elmnt_color" type="text" id="sd_color" name="sd_style[color]" value="<?php echo isset($sdcss['color']) && $sdcss['color'] != '' ? $sdcss['color'] : ''; ?>"/>	
	<label for="sd_ff">font family :</label>
		<select id="sd_ff" name="sd_style[fontfmly]">
		<option value="">predefined</option>
		 <?php		
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($sdcss['fontfmly']) && $sdcss['fontfmly'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="sd_fs">font style :</label>
	<select id="sd_fs" name="sd_style[fontsty]">
	<option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($sdcss['fontsty']) && $sdcss['fontsty'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="sd_fw">font weight :</label>
	<select id="sd_fw" name="sd_style[fontwght]">
	<option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($sdcss['fontwght']) && $sdcss['fontwght'] == $fw ? ' selected' : '';
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
	<input type="checkbox" name="usethis[sdhvr]" value="sdhvr_usethis_style" id="sdhvr_usethis_style" <?php echo isset($use_this['sdhvr']) && $use_this['sdhvr'] != '' ? 'checked' : ''; ?>/><label for="sdhvr_usethis_style">Use this style</label>
	<input type="hidden" name="sdhvr_selector" value="#short_desc span:hover"/>
	<div class="settop">
	<div class="stleft">	
	<label for="sdhvr_tcolor">text color :</label><input class="elmnt_color" type="text" id="sdhvr_tcolor" name="sdhvr_style[color]" value="<?php echo isset($sdcsshvr['color']) && $sdcsshvr['color'] != '' ? $sdcsshvr['color'] : ''; ?>"/>	
	<label for="sdhvr_ffamily">font family :</label>
		<select id="sdhvr_ffamily" name="sdhvr_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($sdcsshvr['fontfamily']) && $sdcsshvr['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	<div class="stright">	
	<label for="sdhvr_fstyle">font style :</label>
	<select id="sdhvr_fstyle" name="sdhvr_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($sdcsshvr['fontstyle']) && $sdcsshvr['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="sdhvr_fweight">font weight :</label>
	<select id="sdhvr_fweight" name="sdhvr_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($sdcsshvr['fontweight']) && $sdcsshvr['fontweight'] == $fw ? ' selected' : '';
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