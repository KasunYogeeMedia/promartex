jQuery(document).ready(function() {

	var $wrapper = jQuery('.wcbv-wrapper'),
		$variationsForm = jQuery('.variations_form'),
		$wcSelects = $variationsForm.find('.variations select'),
		$cartForm = jQuery('[name="_wcbv_variations"]:first').parents('form:first'),
		$lastChangingSelect = null,
		enableVariationHide = true;

	var _addRow = function(values) {

		$lastChangingSelect = null;

		$variationsForm.find('select').val('').change(); //reset wc selects to get all options

		var $row = $wrapper.children('.wcbv-variations').append('<div class="wcbv-row wcbv-clearfix"><div class="wcbv-fields wcbv-clearfix"><div class="wcbv-selects wcbv-columns wcbv-two"></div></div><div class="wcbv-price"></div></div>').children('.wcbv-row:last'),
			$fields = $row.children('.wcbv-fields');

		//loop through
		$wcSelects.each(function(i, select){

			var $select = jQuery(select),
				defaultValue = values && values.hasOwnProperty(select.name) ? values[select.name] : '',
				$selectItem = jQuery('<div><select data-attribute="'+select.name+'" value="'+defaultValue+'"></select></div>');

			$selectItem.children('select').html($select.html()).val(defaultValue);

			$fields.children('.wcbv-selects').append($selectItem);

		});

		$fields.append('<div class="wcbv-quantity"><input type="number" value=1 min=0 step=1></div><div class="wcbv-remove"><span class="wcbv-remove-row">x</span></div>');

		if(jQuery().select2 && wcbvOptions.enableSelect) {
			$fields.find('select').select2({dropdownCssClass: 'wcbv-select2', width: '100%'});
		}

		$fields.find('select:last').change(); //change to update wc selects

	};

	var _checkOnCompleteness = function() {

		var addToCart = true;

		$wrapper.find('.wcbv-fields > div').removeClass('wcbv-error') //remove error class from column
		.find('select').each(function(i, select){

			if(select.value.length == 0) {
				jQuery(select).parent('div').addClass('wcbv-error');
				addToCart = false;
			}

		});

		return addToCart;

	};

	var _getVariationsJSON = function() {

		var varsJSON = [];
		$wrapper.find('.wcbv-variations .wcbv-row').each(function(i, row) {

			var $row = jQuery(row);

			if($row.data('variation') && $row.find('.wcbv-quantity input').val().length > 0) {

				var rowQuantity = $row.find('.wcbv-quantity input').val(),
					rowVariation = $row.data('variation');

				if(!isNaN(rowQuantity) && rowQuantity > 0) {
					rowVariation.wcbv_quantity = parseInt($row.find('.wcbv-quantity input').val());
					varsJSON.push(rowVariation);
				}

			}

		});

		return varsJSON;

	};

	var _priceHandler = function() {

		var totalPrice = 0,
			tempPrice = Number($wrapper.find('.wcbv-total-price .wcbv-price-value').text()),
			fpdPrice = 0;


		if(typeof fancyProductDesigner !== 'undefined') {
			fpdPrice = parseFloat(fancyProductDesigner.calculatePrice());
		}

		//loop through all rows to calculate variation price * quantity
		$wrapper.find('.wcbv-variations .wcbv-row').each(function(i, row) {

			var $row = jQuery(row);

			if($row.data('variation') && $row.find('.wcbv-quantity input').val().length > 0) {

				var rowQuantity = $row.find('.wcbv-quantity input').val(),
					rowVariation = $row.data('variation');

				if(!isNaN(rowQuantity) && rowQuantity > 0 && rowVariation.price) {

					var rowPrice = (rowVariation.price + fpdPrice) * rowQuantity;
					rowPrice = _calulateDiscount(rowPrice, rowVariation.wcbv_discounts, rowQuantity);

					totalPrice += rowPrice;

					//is decimal: fix rounding problem in JS
					if(totalPrice % 1 != 0) {
						totalPrice = Number(totalPrice.toFixed(2));
					}

				}

			}

		});

		$wrapper.find('.wcbv-total-price .wcbv-price-value').text(_formatPrice(totalPrice))
		.parents('.wcbv-total-price').toggle(totalPrice > 0);

		if(totalPrice !== tempPrice) {
			$wrapper.trigger('priceChange', [totalPrice]);
		}

	};

	var _calulateDiscount = function(price, discountsData, variationQty) {

		if(discountsData) {

			discountsData.some(function(rule) {

				if(_operator(rule.operator, variationQty, rule.qty)) {

					if(rule.type == 'perc') {
						var percDiscount = Number(rule.discount) / 100,
							priceDiscount = price * percDiscount;

						price = price - priceDiscount;

					}
					else {
						price -= rule.discount;
					}

					return true;

				}

				return false;

			})

		}

		return price;

	};

	var _operator = function(oper, prop, value) {

		prop = parseInt(prop);
		value = parseInt(value);

		if(oper === '=') {
			return prop === value;
		}
		else if(oper === '>') {
			return prop > value;
		}
		else if(oper === '<') {
			return prop < value;
		}
		else if(oper === '>=') {
			return prop >= value;
		}
		else if(oper === '<=') {
			return prop <= value;
		}

	};

	var _formatPrice = function(price) {


		var thousandSep = wcbvOptions.priceThousandSep,
			decimalSep = wcbvOptions.priceDecimalSep;

		var splitPrice = price.toString().split('.'),
			absPrice = splitPrice[0],
			decimalPrice = splitPrice[1],
			tempAbsPrice = '';

		if (typeof absPrice != 'undefined') {

			for (var i=absPrice.length-1; i>=0; i--) {
				tempAbsPrice += absPrice.charAt(i);
			}

			tempAbsPrice = tempAbsPrice.replace(/(\d{3})/g, "$1" + thousandSep);
			if (tempAbsPrice.slice(-thousandSep.length) == thousandSep) {
				tempAbsPrice = tempAbsPrice.slice(0, -thousandSep.length);
			}

			absPrice = '';
			for (var i=tempAbsPrice.length-1; i>=0 ;i--) {
				absPrice += tempAbsPrice.charAt(i);
			}

			if (typeof decimalPrice != 'undefined' && decimalPrice.length > 0) {
				//if only one decimal digit add zero at end
				if(decimalPrice.length == 1) {
					decimalPrice += '0';
				}
				else if(decimalPrice.length > 2) {
					decimalPrice = decimalPrice.substring(0, 2);
				}
				absPrice += decimalSep + decimalPrice;
			}

		}

		return absPrice;


	};

	//set first option text to attribute name
	if(wcbvOptions.replaceChooseOption) {

		$wcSelects.each(function(i, select) {
			jQuery(select).children('option:first').text(wcbvOptions.attributeNames[i]);
		});

	}

	//copy clear variations element
	var $resetVariations = $cartForm.find('.reset_variations').clone().removeClass('reset_variations').addClass('wcbv-reset-variations');
	$wrapper.find('.wcbv-actions').append($resetVariations);

	$wrapper.on('change', '.wcbv-fields select', function() {

		$lastChangingSelect = jQuery(this);

		var $row = $lastChangingSelect.parents('.wcbv-row:first');

		$lastChangingSelect.parent('div').removeClass('wcbv-error'); //remove column error

		$variationsForm.find('select').each(function(i, wcSelect) {

			//set wc selects to the same value as for the wcbv selects in a row
			jQuery(wcSelect).val($row.find('select[data-attribute="'+wcSelect.name+'"]').val()).change();

		}).filter('select[name="'+$lastChangingSelect.data('attribute')+'"]').val($lastChangingSelect.val()).change(); //change target wc select again to show correct content

		//set options for wcbv select from wc select and set wcbv select to saved value
		var $wcSiblingSelects = $variationsForm.find('select:not([name="'+$lastChangingSelect.data('attribute')+'"])');
		$wcSiblingSelects.each(function(i, formSelect) {

			var $rowSelect = $row.find('[data-attribute="'+this.name+'"]'),
				tempVal = $rowSelect.val();

			$rowSelect.html(jQuery(formSelect).html()).val(tempVal);

		});

	});

	$wrapper
	.on('click', '#wcbv-add-row', function() {
		_addRow(wcbvOptions.selectedAttributes);
	})
	.on('change keyup', '.wcbv-quantity input', function() {
		_priceHandler();
	})
	.on('click', '.wcbv-remove-row', function() {

		enableVariationHide = false;

		jQuery(this).parents('.wcbv-row').remove();

		//set wc selects options to wcbv select options
		$wrapper.find('.wcbv-row:first select').each(function(i, select) {

			var $select = jQuery(select);
			$variationsForm.find('select[name="'+$select.data('attribute')+'"]').val($select.val());

		}).last().change(); //change one to reset wc selects

		enableVariationHide = true;

	})
	.on('click', '.wcbv-reset-variations', function(evt) {

		evt.preventDefault();

		$wrapper.find('.wcbv-variations select').val('').change();
		$wrapper.find('.wcbv-quantity input').val('1');
		$cartForm.find('.reset_variations').click();

	});

	$cartForm
	.on('show_variation', function(evt, variation, purchasable) {

		if($lastChangingSelect && variation.display_price !== undefined) {

			var variationObj = {variation_id: variation.variation_id, price: variation.display_price, wcbv_discounts: variation.wcbv_discounts},
				attributes = {};

			$wcSelects.each(function(i, wcSelect) {
				attributes[wcSelect.name] = wcSelect.value;
			});
			variationObj.attributes = attributes;

			if(variation.price_html && variation.price_html.length > 0) { //different prices in the variations
				$lastChangingSelect.parents('.wcbv-row:first').data('variation', variationObj).addClass('wcbv-show-price')
				.children('.wcbv-price').html(jQuery(variation.price_html).find('.amount:last').text());
			}
			else if(variation.display_price !== undefined) { //same price in the variations
				$lastChangingSelect.parents('.wcbv-row:first').data('variation', variationObj);
			}

			_priceHandler();

		}

	}).
	on('hide_variation', function(evt) {

		if($lastChangingSelect && enableVariationHide) {
			$lastChangingSelect.parents('.wcbv-row:first').data('variation', '').removeClass('wcbv-show-price');
		}

		_priceHandler();

	});

	//fill custom form with values and then submit
	$cartForm.on('click', ':submit', function(evt) {

		evt.preventDefault();

		//check all wcbv selects having a value and add-to-cart button is not disabled
		if(_checkOnCompleteness() && !$cartForm.find('.single_add_to_cart_button').hasClass('disabled')) {

			$cartForm.find('[name="_wcbv_variations"]').val(JSON.stringify(_getVariationsJSON()));

			if(typeof fancyProductDesigner !== 'undefined') {
				$cartForm.find('[name="_wcbv_fpd_price"]').val(parseFloat(fancyProductDesigner.calculatePrice()));
			}

			setTimeout(function() {
				$cartForm.submit();
			}, 10);

		}

	});

	if(typeof fancyProductDesigner !== 'undefined') {

		jQuery('.fpd-container').on('priceChange', function() {
			_priceHandler();
		});

	}

	if(wcbvOptions.fixedAmount === undefined || wcbvOptions.fixedAmount === 0) {
		_addRow(wcbvOptions.selectedAttributes);
	}
	else {

		for(var i=0; i < wcbvOptions.fixedAmount; ++i) {
			_addRow(wcbvOptions.selectedAttributes);
		}

	}


});