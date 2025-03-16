<?php
// admin/partials/tab-general.php
defined( 'ABSPATH' ) || exit;

$css_content_current       = file_get_contents( WT_STOREFRONT_PATH . 'wt-storefront-theme-tweak-style.css' );
$admin_css_content_current = file_get_contents( WT_STOREFRONT_PATH . 'admin/css/wtsf-admin-style.css' );
$toggle_status             = get_option( 'wt_sftt_toggle_status', false );
$middle_menu_toggle_status = get_option( 'wt_sftt_middle_menu_toggle', 'off' );
$admin_css_toggle_status   = get_option( 'wt_sftt_admin_css_toggle', false );
?>

<div id="general" class="tab-pane">
	<div class="wrap">
		<h2><?php esc_html_e( 'General Settings', 'wt-storefront-theme-tweak' ); ?></h2>

		<table class="form-table">
			<tr>
				<th scope="row">
					<label for="wt-toggle-style"><?php esc_html_e( 'Use WooTweaks StoreFront Theme Tweak Style:', 'wt-storefront-theme-tweak' ); ?></label>
				</th>
				<td>
					<input type="checkbox" id="wt-toggle-style" class="wt-toggle-container" name="wt_sftt_style_toggle" <?php checked( $toggle_status, 'on' ); ?>>
					<label for="wt-toggle-style" class="wt-toggle-slider"></label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="wt-middle-menu-toggle"><?php esc_html_e( 'Activate Middle Menu:', 'wt-storefront-theme-tweak' ); ?></label>
				</th>
				<td>
					<input type="checkbox" id="wt-middle-menu-toggle" class="wt-toggle-container" name="wt_sftt_middle_menu_toggle" <?php checked( $middle_menu_toggle_status, 'on' ); ?>>
					<label for="wt-middle-menu-toggle" class="wt-toggle-slider"></label>
					<span class="normal-text">(Assign a menu to the "Middle Menu" here: <a href="<?php echo admin_url( 'nav-menus.php?action=locations' ); ?>">Menu Locations</a>)</span>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="wt-admin-css-toggle"><?php esc_html_e( 'Show/Hide Admin CSS:', 'wt-storefront-theme-tweak' ); ?></label>
				</th>
				<td>
					<input type="checkbox" id="wt-admin-css-toggle" class="wt-toggle-container" name="wt_sftt_admin_css_toggle" <?php checked( $admin_css_toggle_status, 'on' ); ?>>
					<label for="wt-admin-css-toggle" class="wt-toggle-slider"></label>
				</td>
			</tr>
		</table>

		<!-- Admin CSS Editor -->
		<div id="wt-admin-css-form" style="<?php echo $admin_css_toggle_status === 'on' ? 'display: block;' : 'display: none;'; ?>">
			<form method="post" action="">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label for="wt-admin-css-content"><?php esc_html_e( 'Edit Admin CSS:', 'wt-storefront-theme-tweak' ); ?></label>
							<div class="normal-text">(admin/css/wtsf-admin-style.css)</div>
						</th>
						<td>
							<div id="wt-admin-css-editor" class="css-editor" data-content="<?php echo esc_attr( $admin_css_content_current ); ?>"></div>
							<input type="hidden" name="wt_admin_css_content" id="wt-admin-css-hidden">
							<br>
							<input type="submit" name="wt_save_admin_css" value="<?php esc_attr_e( 'Save Admin CSS', 'wt-storefront-theme-tweak' ); ?>" class="button button-primary">
						</td>
					</tr>
				</table>
			</form>
			<hr>
		</div>

		<!-- Main CSS Editor -->
		<form method="post" action="">
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="wt-css-content"><?php esc_html_e( 'Edit Main CSS:', 'wt-storefront-theme-tweak' ); ?></label>
						<div class="normal-text">(wt-storefront-theme-tweak-style.css)</div>
					</th>
					<td>
						<div id="wt-css-editor" class="css-editor" data-content="<?php echo esc_attr( $css_content_current ); ?>"></div>
						<input type="hidden" name="wt_css_content" id="wt-css-hidden">
						<br>
						<input type="submit" name="wt_save_css" value="<?php esc_attr_e( 'Save Main CSS', 'wt-storefront-theme-tweak' ); ?>" class="button button-primary">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
