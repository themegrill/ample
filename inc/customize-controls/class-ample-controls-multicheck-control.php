<?php
/**
 * Extend WP_Customize_Control for Multicheck Custom Control.
 *
 * Class AMPLE_Controls_MultiCheck_Control
 *
 * @since 1.2.5
 */

// Multicheck Custom Control
class AMPLE_Controls_MultiCheck_Control extends WP_Customize_Control {

	public $type = 'multicheck';

	public function render_content() { ?>

		<script type="text/javascript">

			jQuery( document ).ready( function () {
				jQuery( '.customize-control-multicheck input[type="checkbox"]' ).on( 'change', function () {
						checkbox_values = jQuery( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
							function () {
								return this.value;
							}
						).get().join( ',' );
						jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
					}
				);
			} );
		</script>

		<?php if ( empty( $this->choices ) ) {
			return;
		}

		if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>

		<?php $multi_values = ( ! is_array( $this->value() ) ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
						<?php echo esc_html( $label ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	<?php }
}
