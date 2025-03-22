<?php
// admin/partials/middle-navigation.php
defined( 'ABSPATH' ) || exit;
?>
<nav class="middle-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Middle Navigation', 'wt-storefront-theme-tweak' ); ?>">
	<?php
	if ( get_option( 'wt_sftt_middle_menu_toggle', 'off' ) === 'on' ) {
		wp_nav_menu(
			array(
				'theme_location'  => 'mid_menu',
				'container'       => 'div',
				'container_id'    => 'middle-menu',
				'container_class' => 'middle-menu-class',
			)
		);
	}
	?>
</nav><!-- .middle-navigation -->
