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
		$features = array("Responsive Style", "Font Customization (size, color, font-family, etc.)", "Mailchimp, Aweber, Constant Contact and Getresponse integration", "Customize Button Color", "Add Image To Your Pop Up", "Pop Up In and Exit Animations", "Background Overlay Color Customization");
		?>
		<div id="more_free" style="border: 1px solid #000000;padding:10px;margin:0 auto 10px  auto;">
		<h3>GET The Following EPS Features For FREE (LIMITED COPY)!</h3>
		<hr>
		<table>
		<tbody>
		<?php
		$ff = count($features);
		for($i=0;$i<$ff;$i++) {
		
		?>
		
		<tr><td><?php echo $i + 1 . ". "; ?></td><td><b><?php echo $features[$i]; ?></b></td></tr>
		
		<?php
		
		}
		
		?>
		</tbody>
		</table>
		<p>
		<a class="button button-primary button-large" style="margin:0 auto;display:block;text-align:center;width:25%;" href="http://eepurl.com/7juwH" target="_blank">Download Here!</a>
		</div>
		<a class="button button-secondary button-large" style="margin:0 auto;display:block;float:left;width:45%;text-align:center;color:#990000;" href="http://codecanyon.net/popular_item/by_category?category=wordpress&ref=QuickCodes" target="_blank"><b>Browse Amazing WP Plugins >></b></a>
		<a class="button button-secondary button-large" style="margin:0 auto;display:block;float:right;width:45%;text-align:center;color:#990000;" href="http://themeforest.net/popular_item/by_category?category=wordpress&ref=QuickCodes" target="_blank"><b>Browse Amazing WP Themes >></b></a>
		<div style="clear:both;"></div>
		<?php
	}

}

new epsFreefeatures();
?>