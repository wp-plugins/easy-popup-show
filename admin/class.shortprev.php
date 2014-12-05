<?php
class shortcodePreview{
function __construct(){
$this->hook();
}
function hook(){
add_action( 'add_meta_boxes', array( $this, 'container' ) );
}
function container($post_type){
			$post_types = array('easy_popup_show');
				if ( in_array( $post_type, $post_types )) {
					add_meta_box(
							'eps_shortcodepreview'
							,__( 'SHORTCODE AND PREVIEW', 'eps_txtdmns' )
							,array( $this, 'content' )
							,$post_type
							,'side',
							'low'
					);	
				} 
}
function content($post){
global $wpdb, $post;
global $poid;
if($poid != ""){
do_shortcode('[link_eps_pop id="'. $poid . '" tn="no" text="Preview" lt="button"]');
echo '<hr>';
echo "<input type='text' id='epsshortcode_container' value='";
echo '[link_eps_pop id="' . $_GET['post'] . '" tn="no" text="Show Pop Up"]';
echo "'/>";
} else {
echo "Create First!";
}
 
}

}
new shortcodePreview();
?>