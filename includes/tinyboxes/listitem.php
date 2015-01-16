<?php

class listItem {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$limage = get_post_meta($poid, '_eps_liimage_key', true);
	$licss = get_post_meta($poid, '_licss_value_details', true);
	$lihvrcss = get_post_meta($poid, '_lihvrcss_value_details', true);
	$lihvrmage = get_post_meta($poid, '_eps_lihoverimage_key', true); 
	?>
	<tr class="set_tr">
	<td class="list_td">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 	
		 <div class="default_css">
		 
	<input type="checkbox" name="usethis[li]" value="li_usethis_style" id="li_usethis" <?php echo isset($use_this['li']) && $use_this['li'] != '' ? 'checked' : ''; ?>/><label for="li_usethis">Use this style</label>  
	<input type="hidden" name="li_selector" value=".lists|.lists ul|.lists ul li|.li_text"/>		
	<div class="settop">
	<div class="stleft">	
	<label for="li_color">text color :</label><input class="elmnt_color" type="text" id="li_color" name="li_style[color]" value="<?php echo isset($licss['color']) && $licss['color'] != '' ? $licss['color'] : ''; ?>"/>	
	<label for="li_ff">font family :</label>
		<select id="li_ff" name="li_style[fontfmly]">
		<option value="">predefined</option>
		 <?php		
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($licss['fontfmly']) && $licss['fontfmly'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	
	<div class="stright">	
	<label for="li_fs">font style :</label>
	<select id="li_fs" name="li_style[fontsty]">
	<option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($licss['fontsty']) && $licss['fontsty'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="li_fw">font weight :</label>
	<select id="li_fw" name="li_style[fontwght]">
	<option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($licss['fontwght']) && $licss['fontwght'] == $fw ? ' selected' : '';
				echo ">" . $fw . "</option>";
			}
		 ?>				
	</select>
	</div>
	</div>
	<div class="clear"></div>
	</div>
	
<div class="hover_css">	
	<input type="checkbox" name="usethis[lihover]" value="lihover_usethis_style" id="lihover_usethis" <?php echo isset($use_this['lihover']) && $use_this['lihover'] != '' ? 'checked' : ''; ?>/><label for="lihover_usethis">Use this style</label>  
	<input type="hidden" name="lihover_selector" value=".lists:hover|.lists ul:hover|.lists ul li:hover|.li_text:hover"/>		
	<div class="settop">
	<div class="stleft">	
	<label for="lihover_tcolor">text color :</label><input class="elmnt_color" type="text" id="lihover_tcolor" name="lihover_style[color]" value="<?php echo isset($lihvrcss['color']) && $lihvrcss['color'] != '' ? $lihvrcss['color'] : ''; ?>"/>	
	<label for="lihover_ffamily">font family :</label>
		<select id="lihover_ffamily" name="lihover_style[fontfamily]">
		<option value="">predefined</option>
		 <?php
			foreach($fonts as $font) {
				echo "<option value='" . $font . "'";
				echo isset($lihvrcss['fontfamily']) && $lihvrcss['fontfamily'] == $font ? ' selected' : '';
				echo ">" . $font . "</option>";
			}
		 ?>				
		</select>
	</div>
	
	<div class="stright">	
	<label for="lihover_fstyle">font style :</label>
	<select id="lihover_fstyle" name="lihover_style[fontstyle]"><option value="">predefined</option>
		 <?php
			foreach($fstyle as $fs) {
				echo "<option value='" . $fs . "'";
				echo isset($lihvrcss['fontstyle']) && $lihvrcss['fontstyle'] == $fs ? ' selected' : '';
				echo ">" . $fs . "</option>";
			}
		 ?>				
	</select>

	<label for="lihover_fweight">font weight :</label>
	<select id="lihover_fweight" name="lihover_style[fontweight]"><option value="">predefined</option>
		 <?php
			foreach($fweight as $fw) {
				echo "<option value='" . $fw . "'";
				echo isset($lihvrcss['fontweight']) && $lihvrcss['fontweight'] == $fw ? ' selected' : '';
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