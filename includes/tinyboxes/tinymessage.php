<?php

class tinyMessage {
	function __construct() {
	$this->tinybox();
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$timessimage = get_post_meta($poid, '_eps_timessimage_key', true);
	$timesscss = get_post_meta($poid, '_timesscss_value_details', true);
	$timesshvrcss = get_post_meta($poid, '_timesshvrcss_value_details', true);
	$timesshvrmage = get_post_meta($poid, '_eps_timesshoverimage_key', true); 
	?>

	<td class="list_td">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 	
		 <div class="default_css">
		 
	<input type="checkbox" name="usethis[timess]" value="timess_usethis_style" id="timess_usethis" <?php echo isset($use_this['timess']) && $use_this['timess'] != '' ? 'checked' : ''; ?>/><label for="timess_usethis">Use this style</label>  
	<input type="hidden" name="timess_selector" value=".tiny_message"/>		
	<div class="settop">
	<div class="stleft">	
	<label for="timess_color">text color :</label><input class="elmnt_color" type="text" id="timess_color" name="timess_style[color]" value="<?php echo isset($timesscss['color']) && $timesscss['color'] != '' ? $timesscss['color'] : ''; ?>"/>	
	<label for="timess_ff">font family :</label>
		<select id="timess_ff" name="timess_style[fontfmly]">
		<option value="">predefined</option>
		 <?php		
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($timesscss['fontfmly']) && $timesscss['fontfmly'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	
	<div class="stright">	
	<label for="timess_fs">font style :</label>
	<select id="timess_fs" name="timess_style[fontsty]">
	<option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($timesscss['fontsty']) && $timesscss['fontsty'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="timess_fw">font weight :</label>
	<select id="timess_fw" name="timess_style[fontwght]">
	<option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($timesscss['fontwght']) && $timesscss['fontwght'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
	</div>
	
<div class="hover_css">	
	<input type="checkbox" name="usethis[timesshover]" value="timesshover_usethis_style" id="timesshover_usethis" <?php echo isset($use_this['timesshover']) && $use_this['timesshover'] != '' ? 'checked' : ''; ?>/><label for="timesshover_usethis">Use this style</label>  
	<input type="hidden" name="timesshover_selector" value=".tiny_message:hover"/>		
	<div class="settop">
	<div class="stleft">	
	<label for="timesshover_tcolor">text color :</label><input class="elmnt_color" type="text" id="timesshover_tcolor" name="timesshover_style[color]" value="<?php echo isset($timesshvrcss['color']) && $timesshvrcss['color'] != '' ? $timesshvrcss['color'] : ''; ?>"/>	
	<label for="timesshover_ffamily">font family :</label>
		<select id="timesshover_ffamily" name="timesshover_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($timesshvrcss['fontfamily']) && $timesshvrcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	
	<div class="stright">	
	<label for="timesshover_fstyle">font style :</label>
	<select id="timesshover_fstyle" name="timesshover_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($timesshvrcss['fontstyle']) && $timesshvrcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="timesshover_fweight">font weight :</label>
	<select id="timesshover_fweight" name="timesshover_style[fontweight]">
	<option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($timesshvrcss['fontweight']) && $timesshvrcss['fontweight'] == $fw ? ' selected' : '';
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
	</tr>
	<?php
	}

}
?>