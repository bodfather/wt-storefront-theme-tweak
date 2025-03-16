<?php
/**
 * Updater for this WooTweaks plugin
 * Dynamically sets GitHub URL and slug, integrates private repo token
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the Plugin Update Checker library
require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// Include the API token manager (assumes it's in includes/)
require_once __DIR__ . '/api-token-manager.php';

// Set up the updater with a dynamic plugin file path and slug
function wt_sftt_setup_plugin_updater( $plugin_file ) {
	// Get plugin data from the main file
	$plugin_data = get_file_data( $plugin_file, array( 'PluginURI' => 'Plugin URI' ) );
	$github_url  = ! empty( $plugin_data['PluginURI'] ) ? $plugin_data['PluginURI'] : 'https://github.com/bodfather';

	// Derive the slug from the plugin file's directory name
	$slug = basename( dirname( $plugin_file ) );

	// Set up the update checker
	$myUpdateChecker = PucFactory::buildUpdateChecker(
		$github_url,   // GitHub repo URL from header
		$plugin_file,  // Path to main plugin file (dynamic)
		$slug          // Slug derived from directory name (dynamic)
	);

	// Optional: Set the stable branch (defaults to 'master')
	$myUpdateChecker->setBranch( 'main' );

	// Set the GitHub API token for private repo access
	$api_token = wt_sftt_get_api_token();
	if ( ! empty( $api_token ) ) {
		$myUpdateChecker->setAuthentication( $api_token );
	}
}
