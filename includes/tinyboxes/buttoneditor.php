<?php

class buttonEditor{

	function __construct() {
		$this->tinybox();
	}

	function tinybox() {
	global $poid, $post, $fonts, $fstyle, $fweight, $txtaln, $borderstyle, $borderstyletxt, $brdrcount;	
	$use_this = get_post_meta($poid, '_eps_usethis_style', true);
	$btncss = get_post_meta($poid, '_btncss_value_details', true);
	?>
	<td class="btnfieldcss">
	<input type="hidden" class="savebuttoneditor" value=""/>
	<img class="setting_gear" src="<?php echo THEME_DIR_URL . '/misc/img/setting.png'; ?>"/>
	<div class="settingsbox main_tinybox" id="btn_ruler">
		<div id="spforbtnfield">
		<ul class="eps_tabs">	<li class="first_tab">Button Style<div class="arrow_wrapper"><div class="arrow_down">
		</div>
		</div>
		</li>
		<li class="third_tab">Need help?<div class="arrow_wrapper"><div class="arrow_down"></div></div></li>	</ul> 
		
		<div class="default_css">
		<input type="checkbox" name="usethis[btn]" value="btn" id="btn_usethis" <?php echo isset($use_this['btn']) && $use_this['btn'] != '' ? 'checked' : ''; ?>/><label for="btn_usethis">Use this style</label> 
		<input type="hidden" name="btn_selector" value='#eps_popup_front input[type="submit"]|#eps_popup_front input[type="submit"]:hover|#eps_popup_front input[type="submit"]:active'/>
		<div class="clear"></div>
		<div class="settop_left">
		<hr>
		<span style="display:inline-block;font-weight:bold;text-align: center; width: 100%;">BACKGROUND</span>
		<input id="enablegradient" name="btn_style[enablegrad]" type="checkbox" checked/>
		<label for="enablegradient">GRADIENT</label>
		<div class="clear">	</div>			
		<div class="stleft">
		<label for="EPSBtngradienttop">Top</label><br>
		<input id="EPSBtngradienttop" name="btn_style[gradienttop]" value="<?php echo isset($btncss['gradienttop']) && $btncss['gradienttop'] != '' ? $btncss['gradienttop'] : ''; ?>" type="text">		
		</div>
		
		<div class="stright">
		<label for="EPSBtngradientbottom">Bottom</label><br>
		<input id="EPSBtngradientbottom" name="btn_style[gradientbottom]" value="<?php echo isset($btncss['gradientbottom']) && $btncss['gradientbottom'] != '' ? $btncss['gradientbottom'] : ''; ?>"  type="text">		
		</div>
		<div class="clear"></div>
		<textarea name="eps_btn_style" id="eps_btn_style"></textarea>		
</div>	


		<div class="eps_helptab">	

		</div>		
		
		</div>
	<div class="clear"></div>			
		</div>	
	
		</div>		
		</td>
	<?php		
	}

}

?>