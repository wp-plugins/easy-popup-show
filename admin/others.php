<?php

class epsMisc {

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
					'other_notes'
					,__( 'Need Help With Wordpress ?', 'eps_txtdmns' )
					,array( $this, 'baseElement' )
					,$post_type
					,'normal'
				);
			}	
	}
	
	function baseElement() {
		?>
		<span> I am available for only <b><u>$5/hour</u></b>! Contact me at: <b><i>atblogad1@gmail.com</i></b></span>
		<?php
	}

}

new epsMisc();
?>