<?php
// admin/includes/class-form-handler.php
defined( 'ABSPATH' ) || exit;

class WTSF_Form_Handler {
	public function init() {
		add_action( 'wp_ajax_wt_toggle_style_action', array( $this, 'toggle_style_callback' ) );
		add_action( 'wp_ajax_wt_toggle_admin_css_action', array( $this, 'toggle_admin_css_callback' ) );
		add_action( 'admin_init', array( $this, 'handle_css_submission' ) );
	}

	public function toggle_style_callback() {
		$status = sanitize_text_field( $_POST['status'] );
		update_option( 'wt_sftt_toggle_status', $status );
		echo 'Toggle style updated to ' . $status;
		wp_die();
	}

	public function toggle_admin_css_callback() {
		$status = sanitize_text_field( $_POST['status'] );
		update_option( 'wt_sftt_admin_css_toggle', $status );
		echo 'Admin CSS toggle updated to ' . $status;
		wp_die();
	}

	public function handle_css_submission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle Main CSS save
		if ( isset( $_POST['wt_save_css'] ) && isset( $_POST['wt_css_content'] ) ) {
			if ( ! wp_verify_nonce( $_POST['wt_sftt_css_nonce'], 'wt_sftt_save_css' ) ) {
				return;
			}
			$css_content = $_POST['wt_css_content']; // Raw input, preserve slashes
			$css_content = strip_tags( $css_content ); // Remove HTML tags, keep backslashes
			$css_content = stripslashes( $css_content );
			// Optional: Add CSS-specific sanitization here if needed (e.g., regex to allow valid CSS only)
			file_put_contents( WT_STOREFRONT_PATH . 'wt-storefront-theme-tweak-style.css', $css_content );
		}

		// Handle Admin CSS save
		if ( isset( $_POST['wt_save_admin_css'] ) && isset( $_POST['wt_admin_css_content'] ) ) {
			if ( ! wp_verify_nonce( $_POST['wt_sftt_admin_css_nonce'], 'wt_sftt_save_admin_css' ) ) {
				return;
			}
			$admin_css_content = $_POST['wt_admin_css_content']; // Raw input, preserve slashes
			$admin_css_content = strip_tags( $admin_css_content );
			$admin_css_content = stripslashes( $admin_css_content );

			file_put_contents( WT_STOREFRONT_PATH . 'admin/css/wtsf-admin-style.css', $admin_css_content );
		}
	}
}
