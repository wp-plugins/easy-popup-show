<?php
$css = get_post_meta($id, '_eps_general_styles', true);
if((isset($css['open']) && $css['open'] != 'none') || (isset($css['out']) && $css['out'] != 'none')) {
?>
<link href="<?php echo THEME_DIR_URL . "/theming/css/animate/animate.min.css" ?>" type="text/css" rel="stylesheet">
<?php
} 
?>
<style type="text/css">
#eps_background_overlay{
	background: <?php echo isset($css['backov']) && $css['backov'] != '' ? $css['backov'] : '#dddddd'; ?>;
}

#eps_popup_front {
	background: <?php echo isset($css['backmain']) && $css['backmain'] != '' ? $css['backmain'] : '#ffffff'; ?>;
	border: <?php echo isset($css['brdrsize']) && $css['brdrsize'] != '' ? $css['brdrsize'] : 10; ?>px <?php echo isset($css['brdrstyle']) && $css['brdrstyle'] != '' ? $css['brdrstyle'] : ' solid'; ?> <?php echo isset($css['sborder']) && $css['sborder'] != '' ? $css['sborder'] : '#ffffff'; ?>;
}

#eps_popup_front, .loading {
	width: <?php echo isset($css['ecwidth']) && $css['ecwidth'] != '' ? $css['ecwidth'] : ' 70%'; ?>;
	height: <?php echo isset($css['echeight']) && $css['echeight'] != '' ? $css['echeight'] : ' 400px'; ?>;
	<?php if(isset($css['topposy']) && $css['topposy'] != '') { echo "top: " . $css['topposy'] . ";"; } ?>	
	<?php if(isset($css['leftposx']) && $css['leftposx'] != '') { echo "left: " . $css['leftposx'] . ";" ; } else { echo "left: 0; right: 0; margin: auto;"; } ?>		
}


</style>
<?php
?>