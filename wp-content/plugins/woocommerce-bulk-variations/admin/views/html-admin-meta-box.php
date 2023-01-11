<div id="wcbv_data" class="panel woocommerce_options_panel wc-metaboxes-wrapper">
	<div class="options_group">

		<p class="form-field">
			<label for="wcbv-position"><?php _e( 'Position', 'radykal' ); ?></label>
			<select name="wcbv_position" id="wcbv-position" style="width: 400px;">
				<?php
					foreach($options['position'] as $key  => $value) {
						echo '<option value="'.$key.'" '.selected($stored_options['position'], $key, false).'>'.$value.'</option>';
					}
				?>
			</select>
		</p>

		<p class="form-field">
			<label for="wcbv-layout"><?php _e( 'Layout', 'radykal' ); ?></label>
			<select name="wcbv_layout" id="wcbv-layout" style="width: 400px;">
				<?php
					foreach($options['layout'] as $key  => $value) {
						echo '<option value="'.$key.'" '.selected($stored_options['layout'], $key, false).'>'.$value.'</option>';
					}
				?>
			</select>
		</p>

		<p class="form-field">
			<label for="wcbv-enable-select2"><?php _e( 'Enable Select2', 'radykal' ); ?></label>
			<input type="checkbox" class="checkbox" id="wcbv-enable-select2" name="wcbv_enable_select2" value="yes" <?php checked($stored_options['enable_select2'], 'yes'); ?> />
			<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Enable a searchable dropdown.', 'radykal' ); ?>"></span>
		</p>

		<p class="form-field">
			<label for="wcbv-replace-choose" style="line-height: 14px;"><?php _e( 'Select Placeholder = Attribute Name', 'radykal' ); ?></label>
			<input type="checkbox" class="checkbox" id="wcbv-replace-choose" name="wcbv_replace_choose_option" value="yes" <?php checked($stored_options['replace_choose_option'], 'yes'); ?> />
			<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Will replace the default placeholder with the attribute name.', 'radykal' ); ?>"></span>
		</p>

		<p class="form-field">
			<label for="wcbv-fixed-amount" style="line-height: 14px;"><?php _e( 'Fixed Amount Of Variations', 'radykal' ); ?></label>
			<input type="number" min="0" step="1" class="short" id="wcbv-fixed-amount" name="wcbv_fixed_amount" placeholder="0" value="<?php echo $stored_options['fixed_amount']; ?>" />
			<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Set a fixed amount of variations. Any value greater than 0 will disable the "Add Varations" button.', 'radykal' ); ?>"></span>
		</p>

		<p class="form-field">
			<label for="wcbv-discounts-display"><?php _e( 'Discounts Table Display', 'radykal' ); ?></label>
			<select name="wcbv_discounts_display" id="wcbv-discounts-display" style="width: 400px;">
				<?php
					foreach($options['discounts_display'] as $key  => $value) {
						echo '<option value="'.$key.'" '.selected($stored_options['discounts_display'], $key, false).'>'.$value.'</option>';
					}
				?>
			</select>
			<span class="woocommerce-help-tip" data-tip="<?php esc_attr_e( 'Display a table with all discount rules. The variation description will be used as variation discount title in the table.', 'radykal' ); ?>"></span>
		</p>

	</div>

	<div id="wcbv-discount-rule-template" style="display: none;">

		<div class="wcbv-discount-rule">

			<div>
				<label><?php _e( 'Quantity', 'radykal' ); ?></label>
				<input type="number" value="1" name="qty" />
			</div>
			<div>
				<label><?php _e( 'Operator', 'radykal' ); ?></label>
				<select name="operator">
					<option value="="><?php _e( 'Equal', 'radykal' ) ; ?></option>
					<option value=">"><?php _e( 'Greater than', 'radykal' ) ; ?></option>
					<option value="<"><?php _e( 'Less than', 'radykal' ) ; ?></option>
					<option value=">="><?php _e( 'Greater than or equal', 'radykal' ) ; ?></option>
					<option value="<="><?php _e( 'Less than or equal', 'radykal' ) ; ?></option>
				</select>
			</div>
			<div>
				<label><?php _e( 'Discount', 'radykal' ); ?></label>
				<input type="number" value="1" name="discount" />
			</div>
			<div>
				<label><?php _e( 'Type', 'radykal' ); ?></label>
				<select name="type">
					<option value="perc"><?php _e( 'Percentage', 'radykal' ) ; ?></option>
					<option value="fixed"><?php _e( 'Fixed', 'radykal' ) ; ?></option>
				</select>
			</div>

			<div>

				<span class="wcbv-rule-action" data-type="sort">
					<span class="dashicons dashicons-move"></span>
				</span>

				<span class="wcbv-rule-action" data-type="remove">
					<span class="dashicons dashicons-no-alt"></span>
				</span>

			</div>

		</div>

	</div>

</div>