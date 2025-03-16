<?php
defined( 'ABSPATH' ) || exit;

define( 'WT_SFTT_AUTH_IV', substr( AUTH_SALT, 0, 16 ) );

function wt_sftt_handle_api_token_submission() {
	if ( isset( $_POST['save_api_key'] ) ) {
		$api_key       = sanitize_text_field( $_POST['api_key'] );
		$encrypted_key = base64_encode( openssl_encrypt( $api_key, 'aes-256-cbc', AUTH_KEY, 0, WT_SFTT_AUTH_IV ) );
		update_option( 'wt_sftt_github_api_token', $encrypted_key );
		echo '<div class="updated"><p>API Key saved!</p></div>';
	}
}
add_action( 'admin_init', 'wt_sftt_handle_api_token_submission' );

function wt_sftt_get_api_token() {
	$encrypted_key = get_option( 'wt_sftt_github_api_token' );
	return $encrypted_key ? openssl_decrypt( base64_decode( $encrypted_key ), 'aes-256-cbc', AUTH_KEY, 0, WT_SFTT_AUTH_IV ) : '';
}
