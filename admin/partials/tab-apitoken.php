<?php
// admin/partials/tab-apitoken.php
defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . '../../includes/api-token-manager.php';
?>
<div id="apitoken" class="tab-pane">
    <div class="wrap">
        <h2><?php esc_html_e( 'API Token', 'wt-storefront-theme-tweak' ); ?></h2>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=wt-storefront-theme-tweak&tab=apitoken' ) ); ?>">
            <table class="form-table wt-storefront-theme-tweak-settings">
                <tr>
                    <th scope="row"><?php esc_html_e( 'API License Key', 'wt-storefront-theme-tweak' ); ?></th>
                    <td colspan="2">
                        <input type="text" name="api_key" id="api_key" value="<?php echo esc_attr( wt_sftt_get_api_token() ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>
            <input type="hidden" name="form_id" value="wt-storefront-theme-tweak">
            <?php wp_nonce_field( 'wt_sftt_save_api_key', 'wt_sftt_nonce' ); ?>
            <p class="submit">
                <input type="submit" name="save_api_key" id="save_api_key" class="button button-primary" value="<?php esc_attr_e( 'Save API Key', 'wt-storefront-theme-tweak' ); ?>">
            </p>
        </form>
    </div>
</div>