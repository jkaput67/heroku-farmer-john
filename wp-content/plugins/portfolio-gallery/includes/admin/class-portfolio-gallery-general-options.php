<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Portfolio_Gallery_General_Options {
	
	public function __construct() {
		add_action( 'portfolio_gallery_save_general_options', array($this,'save_options') );
	}

	/**
	 * Loads General options page
	 */
	public function load_page(){
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'Options_portfolio_styles' ) {
			if ( isset( $_GET['task'] ) ) {
				if ( $_GET['task'] == 'save' ) {
					do_action( 'portfolio_gallery_save_general_options' );
				}
			} else {
				$this->show_page();
			}
		}
	}

	/**
	 * Shows General options page
	 */
	public function show_page(){
		$portfolio_gallery_get_option = portfolio_gallery_get_general_options();
		require( PORTFOLIO_GALLERY_TEMPLATES_PATH.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'portfolio-gallery-admin-general-options-html.php' );
	}

	/**
	 * Save General Options
	 */
	public function save_options(){
		if ( !isset( $_REQUEST['portfolio_gallery_nonce_save_gen_options'] ) || ! wp_verify_nonce( $_REQUEST['portfolio_gallery_nonce_save_gen_options'], 'portfolio_gallery_nonce_save_gen_options' ) ) {
			wp_die( 'Security check fail' );
		}
		if ( isset( $_POST['params'] ) ) {
			$params = array_map('sanitize_text_field',( $_POST['params'] ));
			foreach ( $params as $name => $value ) {
				if( get_option( $name ) !=  $value) {
					update_option($name, wp_unslash($value));
				}
			}
			?>
			<div class="updated"><p><strong><?php _e( 'Item Saved' ); ?></strong></p></div>
			<?php
		}
		$this->show_page();
	}
}