<?php

class epscontainerStyles{
	function __construct(){
	$this->hook();
	}

	function hook(){
	add_action( 'add_meta_boxes', array($this, 'container' ));
	}
	
	function container($post_type) {
	$post_types = array('easy_popup_show');
		if ( in_array( $post_type, $post_types )) {
			// CONTAINER STYLES
			add_meta_box(
					'eps_styles'
					,__( 'CONTAINER STYLES', 'eps_txtdmns' )
					,array( $this, 'content' )
					,$post_type
					,'normal'
			);			
		
		}	
	}

	function content($post) {
	global $post, $wpdb, $borderstyle, $borderstyletxt, $brdrcount;
	if(isset($_GET['post'])) {
	$poid = $_GET['post'];
	} else {
	$poid = '';
	}	
	$style = get_post_meta( $poid, '_eps_general_styles', true);
	wp_nonce_field( 'eps_styles_metabox', 'eps_styles_metabox_nonce' );
	
	$open_arr_val = array('none', 'bounce', 'rubberBand', 'tada', 'fadeInUp');	
	
	$open_arr = array('None', 'Bounce', 'Rubber Band', 'Tada', 'Fade In Up');	
	$opencount = count($open_arr_val);

	$close_arr_val = array('none', 'bounce', 'rubberBand', 'tada', 'fadeOutUp');

	$close_arr = array('None', 'Bounce', 'Rubber Band', 'Tada', 'Fade Out Up');
	$closecount = count($close_arr_val);
	?>	
	
	<table style="width:100%;">
	<tbody>
	<tr>
		<td></td>
		<td><span class="contstylemenu" style="float: right; margin: 0 0 10px;">Need Help?</span></td>
	</tr>
		
	<tr>
		<td><label for="eps_in_animation">Pupup Open Style</label></td>
		<td class="td_right">
		<select name="eps_in_animation" id="eps_in_animation" class="eps_style_class">
		<?php
		for($i = 0; $i<$opencount; $i++) {
			echo "<option value='" . $open_arr_val[$i] . "'";
			echo isset($style['open']) &&  $style['open'] == $open_arr_val[$i] ? ' selected' : '';
			echo ">" . $open_arr[$i] . "</option>";
		}
		?>
		</select>
		</td>
	</tr>	
	<tr>
		<td><label for="eps_out_animation">Pupup Close Style</label></td>
		<td class="td_right">
		<select name="eps_out_animation" id="eps_out_animation" class="eps_style_class">
		<?php
		for($i = 0; $i<$closecount; $i++) {
			echo "<option value='" . $close_arr_val[$i] . "'";
			echo isset($style['out']) &&  $style['out'] == $close_arr_val[$i] ? ' selected' : '';
			echo ">" . $close_arr[$i] . "</option>";
		}
		?>			
		</select>
		</td>
	</tr>		
	<tr>
		<td><label for="eps_backoverly_color">Background Overly Color</label></td>
		<td><input type="text" name="eps_backoverly_color" id="eps_backoverly_color" class="eps_style_class eps_type_text" value="<?php echo isset($style['backov']) &&  $style['backov'] != "" ? $style['backov'] : '#dddddd'; ?>"/></td>
	</tr>
	<tr>
		<td><label for="eps_backmain_color">Background Color</label></td>
		<td><input type="text" name="eps_backmain_color" id="eps_backmain_color" class="eps_style_class eps_type_text" value="<?php echo isset($style['backmain']) &&  $style['backmain'] != "" ? $style['backmain'] : '#ffffff'; ?>"/></td>
	</tr>
		<tr>
		<td><label for="eps_border_color">Border Color</label></td>
		<td><input type="text" name="eps_border_color" id="eps_border_color" class="eps_style_class eps_type_text" value="<?php echo isset($style['sborder']) &&  $style['sborder'] != "" ? $style['sborder'] : '#ffffff'; ?>"/></td>
	</tr>
	</tbody>
	</table>
	<?php
	// do_shortcode('[eps_pop id="5"]');
	}
}
new epscontainerStyles();
?>