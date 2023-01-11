jQuery(document).ready(function($) {

	$('#_wcbv').change(function() {
		if($(this).is(':checked')) {
			$('.hide_if_wcbv').show();
			$('#variable_product_options').removeClass('wcbv-hidden');
		}
		else {
			$('.hide_if_wcbv').hide();
			$('#variable_product_options').addClass('wcbv-hidden');
		}
	}).change();

	var $discountRule = $('#wcbv-discount-rule-template:first').children();

	$('body')
	.on('click', '#wcbv-add-discount-rule', function(evt) {

		evt.preventDefault();

		_addDiscountRule($(this).prev('.wcbv-discount-rules'));

	})
	.on('click', '.wcbv-rule-action[data-type="remove"]', function(evt) {

		evt.preventDefault();

		var $rule = $(this).parents('.wcbv-discount-rule'),
			$list = $rule.parents('.wcbv-discount-rules:first');

		$rule.remove();
		_setVariationDiscounts($list);

	})
	.on('change', '.wcbv-discount-rule input, .wcbv-discount-rule select', function() {

		_setVariationDiscounts($(this).parents('.wcbv-discount-rules:first'));

	})

	$( '#woocommerce-product-data' )
	.on( 'woocommerce_variations_loaded', function() {

		$('.wcbv-discounts-data').each(function(i, discountsData) {

			var $discountsData = $(discountsData),
				$list = $discountsData.prevAll('.wcbv-discount-rules:first');

			try {

				var dataArr = JSON.parse($discountsData.val());

				dataArr.forEach(function(ruleData) {
					_addDiscountRule($list, ruleData);
				})

			}
			catch(e) {
				$discountsData.val('');
			}

		})

	});

	function _addDiscountRule($list, data) {

		var $ruleClone = $discountRule.clone();

		if(data) {

			Object.keys(data).forEach(function(prop) {
				$ruleClone.find('[name="'+prop+'"]').val(data[prop]);
			})

		}

		$ruleClone.appendTo($list);

		$list.sortable({
			axis: 'y',
			handle: '[data-type="sort"]',
			update: function(evt, ui) {
				_setVariationDiscounts($(this))
			}
		})

		_setVariationDiscounts($list);

	}

	function _setVariationDiscounts($list) {

		var variationDiscountData = [];

		$list.children().each(function(i, rule) {

			var $rule = $(rule),
				ruleObj = {
					qty: parseInt($(rule).find('[name="qty"]').val()),
					operator: $(rule).find('[name="operator"]').val(),
					discount: Number($(rule).find('[name="discount"]').val()),
					type: $(rule).find('[name="type"]').val(),
				}

			ruleObj.qty = isNaN(ruleObj.qty) ? 1 : ruleObj.qty;
			ruleObj.discount = isNaN(ruleObj.discount) ? 1 : ruleObj.discount;

			variationDiscountData.push(ruleObj);

		})

		$list.nextAll('.wcbv-discounts-data:first').val(JSON.stringify(variationDiscountData));

	}

});