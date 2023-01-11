<?php
/**
 * The template for displaying loop item for cart
 *
 * @link       https://themeforest.net/user/codezel
 * @since      1.0
 *
 * @package    Tailors Online
 * @subpackage Tailors Online/public
 */
if( !empty( $cart_data ) ) {
?>
<div class="cart-main-wrap">
	<?php 
		$counter	= 0;
		foreach( $cart_data as $key => $cart_items ){
			$counter++;
			$style	= !empty( $cart_items['cart_data']['style'] ) ?  $cart_items['cart_data']['style'] : '';
			$quantity	= !empty( $cart_items['quantity'] ) ?  $cart_items['quantity'] : 1;
			$quantity	= !empty( $cart_items['quantity'] ) ?  $cart_items['quantity'] : '';
			if( !empty( $cart_items['cart_data']['apparels'] ) ){
			?>
			<div class="cart-product">
				<h3><?php echo get_the_title($cart_items['product_id']);?><span class="cus-quantity">×<?php echo esc_attr( $quantity );?></span></h3>
				<div class="cart-data-wrap">
					<div class="category-heading"><h3><?php esc_html_e('Style?','tailors-online');?></h3></div>
					<div class="selection-wrap">
						<div class="cart-style">
							<span class="style-lable"><?php echo esc_html_e( 'Your selected style','tailors-online' );?></span>
							<span class="style-name"><?php echo esc_attr( $style );?></span>
						</div>
					</div>
				</div>
				<?php if( !empty( $cart_items['cart_data']['apparels'] ) ){?>
				<div class="cart-data-wrap">
					<?php 
						foreach( $cart_items['cart_data']['apparels'] as $key => $selections ){
							$title	= !empty( $selections['title'] ) ?  $selections['title'] : '';
						?>
						<div class="category-heading"><h3><?php echo esc_attr( $title );?></h3></div>
						<?php if( !empty( $selections ) ){?>
							<div class="selection-wrap">
								<?php 
									foreach( $selections['data'] as $key => $choice ){
										$label	= !empty( $choice['label'] ) ?  $choice['label'] : '';
										$value	= !empty( $choice['value'] ) ?  $choice['value'] : '';
									?>
									<div class="cart-style">
										<span class="style-lable"><?php echo esc_attr( $label );?></span>
										<span class="style-name"><?php echo esc_attr( $value );?></span>
									</div>
								<?php }?>
							</div>
						<?php }?>
					<?php }?>
				</div>
				<?php }?>
				
				<?php 
				if( !empty( $cart_items['cart_data']['measurements'] ) ){?>
				<div class="cart-data-wrap">
					<div class="category-heading"><h3><?php esc_html_e('Measurements','tailors-online');?></h3></div>
					<div class="selection-wrap">
						<?php								 	
							foreach( $cart_items['cart_data']['measurements'] as $key => $measurement ){
								$measurement_type	=  !empty( $measurement['type'] ) ? $measurement['type'] : '';
								$type	= esc_html__('Inches','tailors-online');
								if( $measurement_type === 'cm' ){
									$type	= esc_html__('Centimeter','tailors-online');
								}
							?>

							<div class="cart-style">
								<span class="style-lable"><?php echo esc_attr( $measurement['label'] );?></span>
								<span class="style-name"><?php echo esc_attr( $measurement['value'] );?>&nbsp;<?php echo esc_attr( $type );?></span>
							</div>
						<?php }?>
					</div>
				</div>
				<?php }?>
			</div>
		<?php }?>
	<?php }?>
</div>
<?php
}