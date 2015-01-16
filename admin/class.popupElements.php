<?php
require_once( PLUGIN_DIR . '/tinyboxes/header.php');
require_once( PLUGIN_DIR . '/tinyboxes/shortdescription.php');
require_once( PLUGIN_DIR . '/tinyboxes/listitem.php');
require_once( PLUGIN_DIR . '/tinyboxes/image.php');
require_once( PLUGIN_DIR . '/tinyboxes/secondheadline.php');
require_once( PLUGIN_DIR . '/tinyboxes/namefield.php');
require_once( PLUGIN_DIR . '/tinyboxes/emailfield.php');
require_once( PLUGIN_DIR . '/tinyboxes/buttoneditor.php');
require_once( PLUGIN_DIR . '/tinyboxes/tinymessage.php');

class epsPopupElements {

function __construct(){
	$this->tocall();
}

function tocall(){
add_action( 'add_meta_boxes', array($this, 'container' ));
}

function container($post_type) {
	$post_types = array('easy_popup_show');
	
		if ( in_array( $post_type, $post_types )) {
			
			// POPUP ELEMENTS
			add_meta_box(
				'eps_elements'
				,__( 'Pop up Elements', 'eps_txtdmns' )
				,array( $this, 'baseElement' )
				,$post_type
				,'normal'
			);
		}	
}


function baseElement() {	
	global $post, $fonts, $fstyle, $fweight, $txtaln, $borderstyle, $borderstyletxt, $brdrcount;
	global $poid;	
	$theme = get_post_meta($poid, '_eps_popup_theme', true);
	$eps_button = get_post_meta($poid, '_eps_button_field_value_key', true);
	$email_placeholder = get_post_meta($poid, '_eps_email_field_placeholder_key', true);
	$email_label = get_post_meta($poid, '_eps_email_field_label_key', true);
	$name_placeholder = get_post_meta($poid, '_eps_name_field_placeholder_key', true);
	$name_label = get_post_meta($poid, '_eps_name_field_label_key', true);
	$cta = get_post_meta($poid, '_eps_second_headline_key', true);
	$list = get_post_meta($poid, '_eps_list_items_key', true);
	$headline = get_post_meta($poid, '_eps_first_headline_key', true);
	$short_desc = get_post_meta($poid, '_eps_short_description_key', true);
	$urlim = get_post_meta($poid, '_eps_image_key', true);
	if(filter_var($urlim, FILTER_VALIDATE_URL) == true) {
	$images = parse_url($urlim);
	$images = pathinfo($images['path'], PATHINFO_EXTENSION);
	$img_types = array('jpg', 'bmp', 'gif', 'png');
	if(in_array($images, $img_types)) {
		$images = "<div class='img_in_admin'><img src='" . $urlim . "' style='max-width:150px; max-height:130px;'/><button class='rmv_img'>X</button></div>";
	}
	} else {
		$images = "<div style='width:125px; height:150px; text-align:center;'>" . get_post_meta($poid, '_eps_image_key', true) . "</div>";
	}
	
	$timyse = get_post_meta($poid, '_tiny_little_message', true);
	
	// Add an nonce field so we can check for it later.
		wp_nonce_field( 'eps_elements_metabox', 'eps_elements_metabox_nonce' );
		// echo 'enctype="multipart/form-data"';
		/* print_r(get_option('test_debug')); */
	?>
	<span class="contstylemenu" style="float: right; margin: 0 0 10px;">Need Help?</span>
	<div class="clear"></div>
		<!-- THEME -->
	<label for="eps_theme">
	<?php echo _e( '<h3 class="epsh30">Theme:</h3>', 'eps_txtdmns' ); ?>
	</label>

	<select name="eps_theme" id="eps_theme">
		<?php
		$dir = PLUGIN_DIR . "/themes";
		foreach(glob($dir."/*.*") as $file) {
		?>
		<option value="<?php echo pathinfo(basename($file), PATHINFO_FILENAME); ?>" <?php echo $theme == pathinfo(basename($file), PATHINFO_FILENAME) ? "selected" : "";?> ><?php echo ucwords(pathinfo(basename($file), PATHINFO_FILENAME)); ?></option> ;
		<?php
		}
		?>
	</select>
	<h3 class="epsh30">Elements</h3>
	<table style="width:100%;">
	<tbody>
	<tr><td><input type="text" class="eps_type_text" name="first_headline" placeholder="Your compelling headline goes here!" value="<?php echo $headline != '' ? $headline : ''; ?>" style="width:100%;"/></td>
	<?php
	// HEADER
	new headStyle();
	?>
	</tr>
	<tr><td><textarea name="short_description" id="short_description" style="width:100%;height:70px;"  maxlength="130" placeholder="Short description. 130 characters max!"><?php echo $short_desc != '' ? $short_desc : ''; ?></textarea></td>
<!-- FIELDS SETTINGS -->
<!--SHORT DESCRIPTION-->
	<?php
	new shortDesc();
	?>
<!-- END FIELDS SETTINGS -->	
	</tr>
	</tbody>
	</table>
	
	<div style="margin: 10px 0">
	<table style="border: 1px solid #DDDDDD; float:left;">
	<tbody>
<!-- FIELDS SETTINGS -->	
<!--LIST ITEMS-->
<?php
new listItem();
?>
<!-- END FIELDS SETTINGS -->		
	<tr><td><input type="text" name="list_items[]" placeholder="List item #1" value="<?php echo !empty($list) && isset($list[0]) ? $list[0] : ''; ?>" /></td></tr>
	<tr><td><input type="text" name="list_items[]" placeholder="List item #2" value="<?php echo !empty($list) && isset($list[1]) ? $list[1] : ''; ?>" /></td></tr>
	<tr><td><input type="text" name="list_items[]" placeholder="List item #3" value="<?php echo !empty($list) && isset($list[2]) ? $list[2] : ''; ?>" /></td></tr>
	<tr><td><input type="text" name="list_items[]" placeholder="List item #4" value="<?php echo !empty($list) && isset($list[3]) ? $list[3] : ''; ?>" /></td></tr>
	<tr><td><input type="text" name="list_items[]" placeholder="List item #5" value="<?php echo !empty($list) && isset($list[4]) ? $list[4] : ''; ?>" /></td></tr>
	<tr><td><input type="text" name="list_items[]" placeholder="List item #6" value="<?php echo !empty($list) && isset($list[5]) ? $list[5] : ''; ?>" /></td></tr>
	</tbody>
	</table>
	
	<div style=" float:right; width: 50%;">
	<table style="border: 1px solid #DDDDDD;">
	<tbody>
	<tr>
	<td>
	<input type="text" name="eps_image_text" id="eps_image_text" style="width:100%;"/>
	</td>
	<td>
	<div class="eps_img_button">
	<input type="file" name="eps_image" class="eps_image"/>
	</div>
	</td>
	</tr>
	<tr>
	<td>
		<?php
			echo $images;
		?>		
	</td>
<!-- FIELDS SETTINGS -->
<!--IMAGE-->
<?php
new epsImg();
?>
<!-- END FIELDS SETTINGS -->	
	</tr>
	</tbody>
	</table>	
	</div>	
	</div>
	<div class="clear" style="clear:both;"></div>
	
	<table style="width:100%; margin: 10px 0 0">
	<tbody>
	<tr><td><input type="text" class="eps_type_text" name="second_headline" placeholder="Your call to action goes here!" value="<?php echo $cta != '' ? $cta : ''; ?>" style="width:100%;"/></td>
	
<!-- FIELDS SETTINGS -->
<!--SECOND HEADLINE-->
<?php
new secondHeadline();
?>
<!-- END FIELDS SETTINGS -->	
	</tr>
	</tbody>
	</table>
	<div class="email_form_area">
	<!-- FIELDS SETTINGS -->
	<!--EMAIL FORM WRAPPER-->
<!-- END FIELDS SETTINGS -->
	<table style="width:100%; padding-right: 2.5px;">
	<tbody>
	
	<tr><td><input type="text" class="eps_type_text" name="name_field_placeholder" placeholder="ex.: Enter your name here!" value="<?php echo $name_placeholder != '' ? $name_placeholder : ''; ?>" style="width:100%;"/></td>
<!-- FIELDS SETTINGS -->
<!--NAME-->
<?php
new nameField();
?>
<!-- END FIELDS SETTINGS -->		
	</tr>
	
	<tr><td><input type="text" class="eps_type_text" name="email_field_placeholder" placeholder="ex.: Please enter a valid email address!" value="<?php echo $email_placeholder != ''? $email_placeholder : ''; ?>" style="width:100%;"/></td>
<!-- FIELDS SETTINGS -->
<!--EMAIL-->
<?php
new emailField();
?>
<!-- END FIELDS SETTINGS -->			
	</tr>
	
	</tbody>
	</table>
	
	<table style="width:100%;">
	<tbody>	
	<tr><td style="text-align:center;"><input style="color:#ffffff !important;" type="text" name="button_field_value" class="button_field_value"  value="<?php echo $eps_button != '' ? $eps_button : 'Submit'; ?>" style="text-align:center;"/></td>
	<?php
	new buttonEditor();
	?>
	</tr>
	</tbody>
	</table>
	</div>
	<table style="width:100%;">
	<tbody>	
	<tr><td style="text-align:center;">	
<input type="text" class="eps_type_text" name="tiny_message" class="" value="<?php  echo $timyse != '' ? $timyse : ''; ?>" placeholder="Tiny footer message" style="width:100%;"/>
</td>
	<?php
	new tinyMessage();	
?>
	</tbody>
	</table>
<?php
}

}

new epsPopupElements();


?>