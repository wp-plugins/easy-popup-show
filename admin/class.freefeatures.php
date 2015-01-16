<?php

class epsFreefeatures {

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
					'more_features_for_free'
					,__( 'GET MORE FEATURES FOR FREE', 'eps_txtdmns' )
					,array( $this, 'baseElement' )
					,$post_type
					,'normal'
				);
			}	
	}
	
	function baseElement() {
		$features = array("Fully Responsive", "Fully Customizable PopUp Appearance", "Display PopUp By Page/ Post Title, Taxonomy, Category, Tags, Author, Post Format and Post Type", "Font Customization (size, color, font-family, etc.)", "Mailchimp, Aweber, Constant Contact, Getresponse, Wysija, Campaign Monitor, Direct Mail, Infusionsoft, Mad Mimi and Sendy", "Add Image To Your Pop Up", "37 Animations for your Pop Up (In and Exit)", "Background Overlay Color Customization", "Add Shadows To The Wrapper and Text", "Set Your Pop Up Position", "Set The Width and High of Your PopUp", "Change The Border", "More BUTTON Customization, including size, font, shadow, color, border, etc.", "Change the shadow, color, font and size of your PopUp's input fields", "And More...! And It's FREE");
		?>
		<div id="more_free" style="padding:10px;">
		<h3>GET The Following EPS Features For FREE (LIMITED COPY)!</h3>
		<hr>
		<table style="border-collapse:collapse;">
		<tbody>
		<?php
		$ff = count($features);
		for($i=0;$i<$ff;$i++) {
		
		?>
		
		<tr style="border-collapse:collapse; border:1px solid #000;"><td style="padding:5px;"><?php echo $i + 1 . ". "; ?></td><td style="padding:5px;"><b><?php echo $features[$i] . "."; ?></b></td></tr>
		
		<?php
		
		}
		
		?>
		</tbody>
		</table>
		<p>
		<a class="button button-primary button-large" style="margin:0 auto;display:block;text-align:center;width:25%;" href="http://eepurl.com/7juwH" target="_blank">Download Here!</a>
		</div>
		<?php
	}

}

new epsFreefeatures();
?>