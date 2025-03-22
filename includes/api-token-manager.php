<?php
// includes/api-token-manager.php
defined( 'ABSPATH' ) || exit;

define( 'WT_SFTT_AUTH_IV', substr( AUTH_SALT, 0, 16 ) );

function wt_sftt_get_api_token() {
	$options       = get_option( 'wtsf_plugin_options', array() );
	$encrypted_key = isset( $options['api_key'] ) ? $options['api_key'] : '';
	return $encrypted_key ? openssl_decrypt( base64_decode( $encrypted_key ), 'aes-256-cbc', AUTH_KEY, 0, WT_SFTT_AUTH_IV ) : '';
}

function wt_sftt_display_api_key_notice() {
	if ( get_transient( 'wt_sftt_api_key_saved' ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>API Key saved!</p></div>';
		delete_transient( 'wt_sftt_api_key_saved' );
	}
}
add_action( 'admin_notices', 'wt_sftt_display_api_key_notice' );

function wt_sftt_set_api_key_transient( $old_value, $new_value ) {
	if ( isset( $new_value['api_key'] ) && $new_value['api_key'] !== ( $old_value['api_key'] ?? '' ) ) {
		set_transient( 'wt_sftt_api_key_saved', true, 30 );
	}
}
add_action( 'update_option_wtsf_plugin_options', 'wt_sftt_set_api_key_transient', 10, 2 );

// Migrate old API key to new location and clean up
function wt_sftt_migrate_api_key() {
	if ( get_option( 'wt_sftt_api_key_migrated' ) ) {
		return; // Run once
	}
	$old_key = get_option( 'wt_sftt_github_api_token', false );
	$options = (array) get_option( 'wtsf_plugin_options', array() ); // Force array
	if ( $old_key && ! isset( $options['api_key'] ) ) { // Safer check
		$options['api_key'] = $old_key; // Copy old token to new location
		update_option( 'wtsf_plugin_options', $options );
		delete_option( 'wt_sftt_github_api_token' ); // Delete old option
	}
	update_option( 'wt_sftt_api_key_migrated', true ); // Mark as done
}
add_action( 'admin_init', 'wt_sftt_migrate_api_key' );
