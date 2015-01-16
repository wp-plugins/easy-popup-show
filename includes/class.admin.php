<?php
require_once( EPS_BASEDIR . '/admin/class.enqueuestyle.php');
require_once( EPS_BASEDIR . '/admin/class.popupElements.php');
require_once( EPS_BASEDIR . '/admin/class.containerStyle.php');
require_once( EPS_BASEDIR . '/admin/class.shortprev.php');
require_once( EPS_BASEDIR . '/admin/class.epsSettings.php');
require_once( EPS_BASEDIR . '/admin/class.freefeatures.php');
require_once( EPS_BASEDIR . '/admin/class.save.php');
class epsadminSettings {

	function __construct() {
	$this->epsadmin();	
	}

	function epsadmin() { 
		$this->epsHooks();
		$this->epsFilters();
	}

	function epsHooks() {
	// add CPT
	add_action( 'init', array($this, 'custom_post_type'), 0 );

		
	add_filter( 'gettext', array( $this, 'change_publish_button'), 10, 2 );
	add_action('post_edit_form_tag',array($this, 'edit_form_type_eps'));	
	
	if(get_option('eps_writing_css_error') != '' || get_option('eps_writingcss_not_direct') != '') {
		add_action('admin_notice', array($this, 'error_saving_css')); 
	}
	
	}
	
	function change_publish_button( $translation, $text ) {
		if ( 'easy_popup_show' == get_post_type()){
			if ( $text == 'Publish' ){
				return 'Create';
			}
		}
		return $translation;
	}
	
	function error_saving_css() {
	if(get_option('eps_writing_css_error') != '') {
		echo get_option('eps_writing_css_error'); 
	}
	
	if(get_option('eps_writingcss_not_direct') != '') {
		echo get_option('eps_writingcss_not_direct');
	}
	
	}
	
	function epsFilters() {
		// custom message
		add_filter('post_updated_messages', array($this, 'eps_updated_messages'));
	} 
	

			
		function custom_post_type() {

			$labels = array(
				'name'                => _x( 'Easy PopUp Show', 'Easy PopUp Show', 'eps_txtdmns' ),
				'singular_name'       => _x( 'Easy PopUp Show', 'Easy PopUp Show', 'eps_txtdmns' ),
				'menu_name'           => __( 'Easy PopUp', 'eps_txtdmns' ),
				'parent_item_colon'   => __( 'Parent PopUp:', 'eps_txtdmns' ),
				'all_items'           => __( 'All PopUps', 'eps_txtdmns' ),
				'view_item'           => __( 'View PopUp', 'eps_txtdmns' ),
				'add_new_item'        => __( 'Create New PopUp', 'eps_txtdmns' ),
				'add_new'             => __( 'New PopUp', 'eps_txtdmns' ),
				'edit_item'           => __( 'Edit PopUp', 'eps_txtdmns' ),
				'update_item'         => __( 'Update PopUp', 'eps_txtdmns' ),
				'search_items'        => __( 'Search PopUp', 'eps_txtdmns' ),
				'not_found'           => __( 'Not found', 'eps_txtdmns' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'eps_txtdmns' ),
			);
			$args = array(
				'label'               => __( 'easy_popup_show', 'eps_txtdmns' ),
				'description'         => __( 'Create Nice Wordpress Pop Up Easily', 'eps_txtdmns' ),
				'labels'              => $labels,
				'supports'            => array('title'/*, 'editor'*/),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => null,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
			);
			register_post_type( 'easy_popup_show', $args );
		}
		
	
	// Custom message
	function eps_updated_messages( $messages ) {
	global $pagenow, $typenow;
		if (($pagenow == 'edit.php' || $pagenow == 'post.php' || $pagenow == 'post-new.php') && $typenow ==='easy_popup_show' && !isset($_GET['page'])) {	
			$post             = get_post();
			$post_type        = get_post_type( $post );
			$post_type_object = get_post_type_object( $post_type );
			
				$messages['easy_popup_show'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'PopUp updated.', 'eps_txtdmns' ),
				2  => __( 'Custom field updated.', 'eps_txtdmns' ),
				3  => __( 'Custom field deleted.', 'eps_txtdmns' ),
				4  => __( 'PopUp updated.', 'eps_txtdmns' ),
				/* translators: %s: date and time of the revision */
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'PopUp restored to revision from %s', 'eps_txtdmns' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6  => __( 'PopUp created.', 'eps_txtdmns' ),
				7  => __( 'PopUp saved.', 'eps_txtdmns' ),
				8  => __( 'PopUp submitted.', 'eps_txtdmns' ),
				9  => sprintf(
					__( 'PopUp scheduled for: <strong>%1$s</strong>.', 'eps_txtdmns' ),
					// translators: Publish box date format, see http://php.net/date
					date_i18n( __( 'M j, Y @ G:i', 'eps_txtdmns' ), strtotime( $post->post_date ) )
				),
				10 => __( 'PopUp draft updated.', 'eps_txtdmns' )
				);
				
				if ( $post_type_object->publicly_queryable ) {
				$permalink = get_permalink( $post->ID );

				$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View PopUp', 'eps_txtdmns' ) );
				$messages[ $post_type ][1] .= $view_link;
				$messages[ $post_type ][6] .= $view_link;
				$messages[ $post_type ][9] .= $view_link;

				$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
				$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview PopUp', 'eps_txtdmns' ) );
				$messages[ $post_type ][8]  .= $preview_link;
				$messages[ $post_type ][10] .= $preview_link;
			}
		}
		return $messages;
	}
	
	function edit_form_type_eps() {
    echo ' enctype="multipart/form-data"';
	}
}

new epsadminSettings();
?>