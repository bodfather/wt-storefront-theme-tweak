<?php
// admin/includes/class-admin-settings.php
defined( 'ABSPATH' ) || exit;

class WT_Admin_Settings {
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	public function register_menu() {
		add_submenu_page(
			'wootweaks',
			__( 'WT StoreFront Theme Tweak Settings', 'wt-storefront-theme-tweak' ),
			__( 'WT StoreFront Theme Tweak', 'wt-storefront-theme-tweak' ),
			'manage_options',
			'wt-storefront-theme-tweak',
			array( $this, 'settings_page' )
		);
	}

	public function settings_page() {
		require_once WT_STOREFRONT_PATH . 'admin/includes/class-form-handler.php';
		$form_handler = new WT_Form_Handler();
		$form_handler->init();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'WooTweaks StoreFront Theme Tweak Settings', 'wt-storefront-theme-tweak' ); ?></h1>
			<nav class="settings-tabs">
				<a href="#general" class="active"><?php esc_html_e( 'General', 'wt-storefront-theme-tweak' ); ?></a>
				<a href="#apitoken"><?php esc_html_e( 'API Token', 'wt-storefront-theme-tweak' ); ?></a>
			</nav>
			<?php
			include WT_STOREFRONT_PATH . 'admin/partials/tab-general.php';
			include WT_STOREFRONT_PATH . 'admin/partials/tab-apitoken.php';
			?>
		</div>
		<?php
	}

	public function enqueue_admin_scripts( $hook ) {
		if ( $hook !== 'wootweaks_page_wt-storefront-theme-tweak' ) {
			return;
		}
		// Enqueue existing styles and scripts
		wp_enqueue_style( 'wt-storefront-admin-style', WT_STOREFRONT_URL . 'admin/css/wtsf-admin-style.css', array(), WT_STOREFRONT_VERSION );
		wp_enqueue_script( 'wt-toggle-script', WT_STOREFRONT_URL . 'admin/js/admin-toggles.js', array( 'jquery' ), WT_STOREFRONT_VERSION, true );
		wp_localize_script( 'wt-toggle-script', 'wtToggleParams', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		// Enqueue CodeMirror
		wp_enqueue_style( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.css', array(), '5.65.17' );
		wp_enqueue_script( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.js', array(), '5.65.17', true );
		wp_enqueue_script( 'codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/mode/css/css.min.js', array( 'codemirror' ), '5.65.17', true );
		// Optional: Add a theme for modern look
		wp_enqueue_style( 'codemirror-theme', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/theme/monokai.min.css', array(), '5.65.17' );
	}
}
