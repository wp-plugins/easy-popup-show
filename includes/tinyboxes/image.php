<?php

class epsImg {
	function __construct() {
	$this->tinybox();	
	}
	
	function tinybox(){
	global $poid, $post;
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$imgcss = get_post_meta($poid, '_imgcss_value_details', true);
	$imgcsshvr = get_post_meta($poid, '_imghvrcss_value_details', true);	
	?>
	<td class="list_td">
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox">
		<ul class="eps_tabs">	<li class="first_tab">Default<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="second_tab">Hover<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 	
		

<div class="default_css"> 
		<input type="checkbox" name="usethis[img]" value="usethisimg" id="usethisimg" <?php  echo isset($use_this['img']) && $use_this['img'] != '' ? 'checked' : ''; ?>/><label for="usethisimg">Use this style</label> 
		<input type="hidden" name="img_selector" value=".eps_img"/>	
	<div class="settop">
	<div class="stleft">
	<label for="img_opac">opacity :</label><input type="text" id="img_opac" class="epsimg_spinner" name="img_style[opacity]" value="<?php echo isset($imgcss['opacity']) && $imgcss['opacity'] != '' ? $imgcss['opacity'] : ''; ?>"/>
	</div>
	<div class="stright">
	<label for="img_mh">maximum height :</label><input class="epsheight_spinner" type="text" id="img_mh" name="img_style[maxheight]" value="<?php echo isset($imgcss['maxheight']) && $imgcss['maxheight'] != '' ? $imgcss['maxheight'] : ''; ?>"/>
	</div>
	</div>
</div>

<div class="hover_css">	
		<input type="checkbox" name="usethis[imghvr]" value="usethisimghvr" id="usethisimghvr" <?php  echo isset($use_this['imghvr']) && $use_this['imghvr'] != '' ? 'checked' : ''; ?>/><label for="usethisimghvr">Use this style</label> 
		<input type="hidden" name="imghvr_selector" value=".eps_img:hover"/>	
	<div class="settop">
	<div class="stleft">
	<label for="imghvr_opac">opacity :</label><input type="text" id="imghvr_opac" class="epsimg_spinner" name="imghvr_style[opacity]" value="<?php echo isset($imgcsshvr['opacity']) && $imgcsshvr['opacity'] != '' ? $imgcsshvr['opacity'] : ''; ?>"/>
	</div>
	<div class="stright">
	<label for="imghvr_mh">maximum height :</label><input class="epsheight_spinner" type="text" id="imghvr_mh" name="imghvr_style[maxheight]" value="<?php echo isset($imgcsshvr['maxheight']) && $imgcsshvr['maxheight'] != '' ? $imgcsshvr['maxheight'] : ''; ?>"/>
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