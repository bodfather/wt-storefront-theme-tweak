<?php
// admin/includes/class-form-handler.php
defined( 'ABSPATH' ) || exit;

class WT_Form_Handler {
	public function init() {
		// Handle CSS form submissions
		add_action( 'admin_init', array( $this, 'handle_css_submission' ) );
		// AJAX handlers for toggles
		add_action( 'wp_ajax_wt_toggle_style_action', array( $this, 'toggle_style_callback' ) );
		add_action( 'wp_ajax_wt_toggle_middle_menu_action', array( $this, 'toggle_middle_menu_callback' ) );
		add_action( 'wp_ajax_wt_toggle_admin_css_action', array( $this, 'toggle_admin_css_callback' ) );
	}

	public function handle_css_submission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Handle Main CSS save
		if ( isset( $_POST['wt_save_css'] ) ) {
			$css_content = wp_unslash( $_POST['wt_css_content'] );
			$css_content = strip_tags( $css_content ); // Basic sanitization
			file_put_contents( WT_STOREFRONT_PATH . 'wt-storefront-theme-tweak-style.css', $css_content );
		}

		// Handle Admin CSS save
		if ( isset( $_POST['wt_save_admin_css'] ) ) {
			$admin_css_content = wp_unslash( $_POST['wt_admin_css_content'] );
			$admin_css_content = strip_tags( $admin_css_content ); // Basic sanitization
			file_put_contents( WT_STOREFRONT_PATH . 'admin/css/wtsf-admin-style.css', $admin_css_content );
		}
	}

	public function toggle_style_callback() {
		update_option( 'wt_sftt_toggle_status', sanitize_text_field( $_POST['status'] ) );
		wp_die();
	}

	public function toggle_middle_menu_callback() {
		update_option( 'wt_sftt_middle_menu_toggle', sanitize_text_field( $_POST['status'] ) );
		wp_die();
	}

	public function toggle_admin_css_callback() {
		update_option( 'wt_sftt_admin_css_toggle', sanitize_text_field( $_POST['status'] ) );
		wp_die();
	}
}
