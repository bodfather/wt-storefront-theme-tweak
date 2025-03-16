<?php
// admin/partials/variation-buttons.php
defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="variation-buttons-wrapper">
	<?php foreach ( $attributes as $attribute_name => $options ) : ?>
		<span class="attribute-name"><?php echo wc_attribute_label( $attribute_name ); ?>: </span>
		<?php
		$attribute_slug = sanitize_title( $attribute_name );
		foreach ( $options as $option ) :
			$option_slug = sanitize_title( $option );
			?>
			<button type="button" class="variation-option variation-option-<?php echo esc_attr( $option_slug ); ?>" 
					data-attribute-name="attribute_<?php echo esc_attr( $attribute_slug ); ?>" 
					data-value="<?php echo esc_attr( $option ); ?>">
				<?php echo esc_html( $option ); ?>
			</button>
		<?php endforeach; ?>
		<select hidden name="attribute_<?php echo esc_attr( $attribute_slug ); ?>"></select>
	<?php endforeach; ?>
</div>
