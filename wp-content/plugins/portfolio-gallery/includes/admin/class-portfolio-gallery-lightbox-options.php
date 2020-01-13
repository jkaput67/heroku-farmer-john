<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Portfolio_Gallery_Lightbox_Options {

	public function __construct() {
		add_action( 'portfolio_gallery_save_lightbox_options', array( $this, 'save_options' ) );
	}

	/**
	 * Loads Lightbox options page
	 */
	public function load_page() {
		if ( isset( $_GET['page'] ) && $_GET['page'] == 'Options_portfolio_lightbox_styles' ) {
			if ( isset( $_GET['task'] ) ) {
				if ( $_GET['task'] == 'save' ) {
					do_action( 'portfolio_gallery_save_lightbox_options' );
				}
			} else {
				$this->show_page();
			}
		}
	}

	/**
	 * Shows Lightbox options page
	 */
	public function show_page() {
		$portfolio_gallery_get_option = portfolio_gallery_get_general_options();
		require( PORTFOLIO_GALLERY_TEMPLATES_PATH.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'portfolio-gallery-admin-lightbox-options-html.php' );
	}

	/**
	 * Save Lightbox Options
	 */
	public function save_options() {
		if ( !isset( $_REQUEST['portfolio_gallery_nonce_save_lightbox_options'] ) || ! wp_verify_nonce( $_REQUEST['portfolio_gallery_nonce_save_lightbox_options'], 'portfolio_gallery_nonce_save_lightbox_options' ) ) {
			wp_die( 'Security check fail' );
		}
		if ( isset( $_POST['params'] ) ) {
			$share_params_keys = array(
				'portfolio_gallery_lightbox_facebookButton',
				'portfolio_gallery_lightbox_twitterButton',
				'portfolio_gallery_lightbox_googleplusButton',
				'portfolio_gallery_lightbox_pinterestButton',
				'portfolio_gallery_lightbox_linkedinButton',
				'portfolio_gallery_lightbox_tumblrButton',
				'portfolio_gallery_lightbox_redditButton',
				'portfolio_gallery_lightbox_bufferButton',
				'portfolio_gallery_lightbox_diggButton',
				'portfolio_gallery_lightbox_vkButton',
				'portfolio_gallery_lightbox_yummlyButton'
			);
			$params = array_map('sanitize_text_field',( $_POST['params'] ));
			foreach ( $params as $name => $value ) {
				update_option( $name, wp_unslash( $value ) );
			}
			if ( isset( $_POST['share_params'] ) ) {
				foreach ( $share_params_keys as $share_params_key ) {
					update_option( $share_params_key, 'off' );
				}
				foreach ( $_POST['share_params'] as $name => $value ) {
					if( in_array( $name, $share_params_keys )) {
						update_option( $name, sanitize_text_field( $value ) );
					}
				}
			}
			?>
			<div class="updated"><p><strong><?php _e( 'Item Saved' ); ?></strong></p></div>
			<?php
		}
		$this->show_page();
	}

}