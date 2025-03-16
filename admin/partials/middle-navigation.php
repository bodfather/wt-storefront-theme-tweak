<?php
// admin/partials/middle-navigation.php
defined( 'ABSPATH' ) || exit;
?>
<nav class="middle-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Middle Navigation', 'wt-storefront-theme-tweak' ); ?>">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'mid_menu',
			'fallback_cb'    => '',
		)
	);
	?>
</nav><!-- .middle-navigation -->
