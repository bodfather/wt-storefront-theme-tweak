<?php
/*
Plugin Name: Orig WooTweaks Storefront Theme Tweak
Description: A plugin designed to tweak the Storefront Theme.
Version: 0.0.2
Author: bodfather
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Plugin URI: https://github.com/bodfather/wt-storefront-theme-tweak
Author URI: https://github.com/bodfather
Requires at Least: 5.0
Tested Up To: 6.7.2
Text Domain: wt-storefront-theme-tweak
Tags: storefront, woocommerce, customization
Requires PHP: 7.4
Update URI: https://api.github.com/repos/bodfather/wt-storefront-theme-tweak/releases/latest
*/

// Safety first.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Location: https://bodmerch.com/welcome.php' );
	exit;
}

// Define plugin constants.
define( 'WT_STOREFRONT_VERSION', '0.0.2' );
define( 'WT_STOREFRONT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WT_STOREFRONT_URL', plugin_dir_url( __FILE__ ) );

// Load required files.
require_once WT_STOREFRONT_PATH . 'includes/updater.php';
require_once WT_STOREFRONT_PATH . 'admin/includes/class-admin-settings.php';
require_once WT_STOREFRONT_PATH . 'admin/includes/class-form-handler.php';
require_once WT_STOREFRONT_PATH . 'includes/api-token-manager.php';

// Initialize updater.
wt_sftt_setup_plugin_updater( __FILE__ );

// Activation and Deactivation Hooks.
register_activation_hook( __FILE__, array( 'WT_sftt', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WT_sftt', 'deactivate' ) );

// Main Plugin Class.
class WT_Storefront_Theme_Tweak {
	public static function init() {
		// Load text domain for translations.
		load_plugin_textdomain( 'wt-storefront-theme-tweak', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// Initialize admin settings.
		$admin_settings = new WTSF_Admin_Settings();
		$admin_settings->init();

		// Initialize form handler.
		$form_handler = new WTSF_Form_Handler();
		$form_handler->init();

		// Frontend hooks.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend_scripts' ), 100 );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ) );
		add_action( 'woocommerce_before_add_to_cart_button', array( __CLASS__, 'display_variation_buttons' ) );
		add_action( 'init', array( __CLASS__, 'register_additional_menu' ) );
		add_action( 'storefront_header', array( __CLASS__, 'storefront_middle_navigation' ), 42 );
		add_action( 'woocommerce_before_shop_loop', array( __CLASS__, 'add_view_toggle_buttons' ) );
		add_filter( 'body_class', array( __CLASS__, 'add_wt_list_view_class' ) );
		add_action( 'woocommerce_before_main_content', array( __CLASS__, 'custom_shop_breadcrumbs' ), 5 );
		add_action( 'wp_ajax_toggle_middle_menu', array( __CLASS__, 'ajax_toggle_middle_menu' ) );
	}

	public static function activate() {
		set_theme_mod( 'wt_storefront_toggle_stylesheet', false );
		set_theme_mod( 'wt_storefront_list_style_toggle_stylesheet', false );
		add_option( 'wt_sftt_middle_menu_toggle', false );
		add_option( 'wt_sftt_admin_css_toggle', false );
	}

	public static function deactivate() {
		remove_theme_mod( 'wt_storefront_toggle_stylesheet' );
		remove_theme_mod( 'wt_storefront_list_style_toggle_stylesheet' );
		delete_option( 'wt_sftt_middle_menu_toggle' );
		delete_option( 'wt_sftt_admin_css_toggle' );
	}

	public static function enqueue_frontend_scripts() {
		if ( get_option( 'wt_sftt_toggle_status', false ) === 'on' ) {
			wp_enqueue_style(
				'wt-storefront-theme-tweak-style',
				WT_STOREFRONT_URL . 'wt-storefront-theme-tweak-style.css',
				array(),
				WT_STOREFRONT_VERSION
			);
		}
		wp_enqueue_script(
			'wt-custom-variations',
			WT_STOREFRONT_URL . 'admin/js/custom-variations.js',
			array( 'jquery' ),
			WT_STOREFRONT_VERSION,
			true
		);
	}

	public static function enqueue_admin_scripts( $hook ) {
		// Check for this plugin's admin page
		if ( strpos( $hook, 'wt-storefront-theme-tweak' ) === false ) {
			return;
		}
		wp_enqueue_style(
			'wt-sftt-admin-style',
			WT_STOREFRONT_URL . 'admin/css/wtsf-admin-style.css',
			array( 'wt-admin-style' ),
			WT_STOREFRONT_VERSION
		);
		wp_enqueue_script(
			'wt-toggle-script', // Use consistent handle
			WT_STOREFRONT_URL . 'admin/js/wt-sftt-admin.js',
			array( 'jquery', 'codemirror' ),
			WT_STOREFRONT_VERSION,
			true
		);

		// Localize for both objects
		wp_localize_script(
			'wt-toggle-script',
			'wtToggleParams',
			array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		);
		wp_localize_script(
			'wt-toggle-script',
			'wtSfttAjax',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wt_sftt_toggle_middle_menu' ),
			)
		);

		// CodeMirror dependencies (moved here for consistency)
		wp_enqueue_style( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.css', array(), '5.65.17' );
		wp_enqueue_script( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.js', array(), '5.65.17', true );
		wp_enqueue_script( 'codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/mode/css/css.min.js', array( 'codemirror' ), '5.65.17', true );
		wp_enqueue_style( 'codemirror-theme', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/theme/monokai.min.css', array(), '5.65.17' );
	}

	public static function display_variation_buttons() {
		global $product;
		if ( $product->is_type( 'variable' ) ) {
			$attributes = $product->get_variation_attributes();
			include WT_STOREFRONT_PATH . 'admin/partials/variation-buttons.php';
		}
	}

	public static function register_additional_menu() {
		register_nav_menu( 'mid_menu', __( 'Middle Menu', 'wt-storefront-theme-tweak' ) );
	}

	public static function storefront_middle_navigation() {
		if ( get_option( 'wt_sftt_middle_menu_toggle', 'off' ) === 'on' && has_nav_menu( 'mid_menu' ) ) {
			include WT_STOREFRONT_PATH . 'admin/partials/middle-navigation.php';
		}
	}

	public static function add_view_toggle_buttons() {
		include WT_STOREFRONT_PATH . 'admin/partials/view-toggle.php';
	}

	public static function add_wt_list_view_class( $classes ) {
		if ( isset( $_GET['wt_view'] ) && sanitize_text_field( $_GET['wt_view'] ) === 'list' ) {
			$classes[] = 'wt-list-view';
		}
		return $classes;
	}

	public static function custom_shop_breadcrumbs() {
		if ( is_shop() && is_front_page() ) {
			woocommerce_breadcrumb();
		}
	}

	public static function ajax_toggle_middle_menu() {
		// Verify nonce for security.
		check_ajax_referer( 'wt_sftt_toggle_middle_menu', 'nonce' );

		// Update the option based on the request.
		$status = sanitize_text_field( $_POST['status'] );
		update_option( 'wt_sftt_middle_menu_toggle', $status );

		// Return the updated status.
		wp_send_json_success( array( 'status' => $status ) );
	}
}

// Bootstrap the plugin.
add_action( 'plugins_loaded', array( 'WT_Storefront_Theme_Tweak', 'init' ) );
