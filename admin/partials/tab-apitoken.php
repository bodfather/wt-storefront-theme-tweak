<?php
// admin/partials/tab-apitoken.php
defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . '../../includes/api-token-manager.php';
$options = get_option( 'wtsf_plugin_options', array() );
$api_key = isset( $options['api_key'] ) ? wt_sftt_get_api_token() : ''; // Decrypt for display
?>
<div id="apitoken" class="tab-pane">
	<div class="wrap">
		<h2><?php esc_html_e( 'API Token', 'wt-storefront-theme-tweak' ); ?></h2>
		<table class="form-table wt-storefront-theme-tweak-settings">
			<tr>
				<th scope="row"><?php esc_html_e( 'API License Key', 'wt-storefront-theme-tweak' ); ?></th>
				<td colspan="2">
					<input type="text" name="wtsf_plugin_options[api_key]" id="api_key" value="<?php echo esc_attr( $api_key ); ?>" class="regular-text">
				</td>
			</tr>
		</table>
	</div>
</div>
