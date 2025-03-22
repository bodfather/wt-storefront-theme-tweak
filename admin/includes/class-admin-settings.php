<?php
// admin/includes/class-admin-settings.php
defined( 'ABSPATH' ) || exit;

class WTSF_Admin_Settings {
	public function init() {
		add_action( 'admin_menu', array( $this, 'register_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function register_menu() {
		add_submenu_page(
			'wt-wootweaks',
			__( 'WT StoreFront Theme Tweak Settings', 'wt-storefront-theme-tweak' ),
			__( 'StoreFront Tweak', 'wt-storefront-theme-tweak' ),
			'manage_options',
			'wt-storefront-theme-tweak',
			array( $this, 'settings_page' )
		);
	}

	public function settings_page() {
		$this->options = get_option( 'wtsf_plugin_options' );
		$plugin_slug   = 'wtsf-storefront';
		$tabs          = array(
			'general'  => 'General',
			'apitoken' => 'API Token',
		);
		$active_tab    = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
		?>
		<div class="wrap wootweaks <?php echo esc_attr( $plugin_slug ); ?>">
			<div class="wootweaks-header header-wrap">
				<h1><?php echo esc_html( 'WooTweaks ' . ucfirst( str_replace( 'wtsf-', '', $plugin_slug ) ) . ' Settings' ); ?></h1>
			</div>
			<div class="wootweaks-content content-wrap">
				<nav class="wootweaks-tabs settings-tabs" role="tablist">
					<?php foreach ( $tabs as $tab_key => $tab_label ) : ?>
						<a href="?page=wt-storefront-theme-tweak&tab=<?php echo esc_attr( $tab_key ); ?>" 
							class="nav-tab <?php echo $active_tab === $tab_key ? 'nav-tab-active' : ''; ?>"
							role="tab"
							aria-selected="<?php echo $active_tab === $tab_key ? 'true' : 'false'; ?>">
							<?php echo esc_html( $tab_label ); ?>
						</a>
					<?php endforeach; ?>
				</nav>
				<div class="wootweaks-form">
				<form method="post" action="options.php">
		<?php
		if ( $active_tab !== 'general' ) {
			settings_fields( 'wtsf_plugin_option_group' );
			do_settings_sections( 'wt-storefront-theme-tweak' );
		}
		if ( array_key_exists( $active_tab, $tabs ) ) {
			include WT_STOREFRONT_PATH . "admin/partials/tab-{$active_tab}.php";
		}
		if ( $active_tab !== 'general' ) {
			submit_button( __( 'Save Changes', 'wt-storefront-theme-tweak' ) );
		}
		?>
	</form>
				</div>
			</div>
		</div>
		<?php
	}

	public function enqueue_admin_scripts( $hook ) {
		if ( $hook !== 'wootweaks_page_wt-storefront-theme-tweak' ) {
			return;
		}
		wp_enqueue_style( 'wt-storefront-admin-style', WT_STOREFRONT_URL . 'admin/css/wtsf-admin-style.css', array(), WT_STOREFRONT_VERSION );
		wp_enqueue_script( 'wt-toggle-script', WT_STOREFRONT_URL . 'admin/js/wt-sftt-admin.js', array( 'jquery' ), WT_STOREFRONT_VERSION, true );
		wp_localize_script( 'wt-toggle-script', 'wtToggleParams', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		wp_enqueue_style( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.css', array(), '5.65.17' );
		wp_enqueue_script( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/codemirror.min.js', array(), '5.65.17', true );
		wp_enqueue_script( 'codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/mode/css/css.min.js', array( 'codemirror' ), '5.65.17', true );
		wp_enqueue_style( 'codemirror-theme', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.17/theme/monokai.min.css', array(), '5.65.17' );
	}

	public function register_settings() {
		register_setting(
			'wtsf_plugin_option_group',
			'wtsf_plugin_options',
			array( $this, 'sanitize_options' ) // Add sanitization callback
		);
	}

	public function sanitize_options( $input ) {
		$sanitized_input = get_option( 'wtsf_plugin_options', array() );

		// Handle API key encryption
		if ( isset( $input['api_key'] ) ) {
			$api_key                    = sanitize_text_field( $input['api_key'] );
			$sanitized_input['api_key'] = base64_encode( openssl_encrypt( $api_key, 'aes-256-cbc', AUTH_KEY, 0, WT_SFTT_AUTH_IV ) );
		}

		return $sanitized_input;
	}
}
