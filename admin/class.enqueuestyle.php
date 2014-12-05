<?php
class epsAdminScriptStyle {
	function __construct() {
	$this->enqueuescripts();
	}
	
	function enqueuescripts() {
	add_action('admin_enqueue_scripts', array($this, 'eps_admin_script_style'));	
	}

	function eps_admin_script_style() {
	global $pagenow, $typenow;
		if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='easy_popup_show' && !isset($_GET['page'])) {
			wp_enqueue_script( 'jquery' );						
			wp_enqueue_script( 'jquery-ui-core' ); 
			wp_enqueue_script( 'jquery-ui-datepicker');
			wp_enqueue_script( 'jquery-ui-slider');
			wp_enqueue_script( 'jquery-ui-draggable');
			wp_enqueue_script( 'jquery-ui-spinner');
			wp_enqueue_script( 'jquery-ui-widget');
			wp_enqueue_script( 'iris' );
			
			// JQUERY
			wp_enqueue_script( 'eps_js_script', plugins_url('../js/epsjs.js', __FILE__ ), array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-slider', 'jquery-ui-draggable', 'jquery-ui-spinner', 'iris'), time(), true );
			wp_enqueue_script( 'eps_btnjs_script', plugins_url('../js/controlmain.js', __FILE__ ));
			wp_enqueue_script( 'eps_btnprev_script', plugins_url('../js/preview.js', __FILE__ ));
			// STYLE			
			wp_register_style( 'eps_css_style', plugins_url('../css/admin/eps.css',  __FILE__) );
			wp_enqueue_style('eps_css_style');			
			wp_register_style('eps_jqui_css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/overcast/jquery-ui.css',false,"1.9.0",false);
			wp_enqueue_style('eps_jqui_css');
/* 			wp_register_style( 'eps_btncss_style', plugins_url('../css/admin/css3buttonultgenerator.css',  __FILE__) );
			wp_enqueue_style('eps_btncss_style'); */
		}

	}	
	
}

new epsAdminScriptStyle();
?>