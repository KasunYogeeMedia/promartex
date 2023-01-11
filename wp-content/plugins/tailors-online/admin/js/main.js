jQuery(document).ready(function () {
	 
	 jQuery(document).on('click','.tg-accordion', function (e) {
		e.preventDefault();
		var _this = jQuery(this);
		
		if ( _this.parents('.action-wrap').next('h4').next('div.tg-inner').hasClass('show') ) {
			_this.parents('.action-wrap').next('h4').next('div.tg-inner').removeClass('show');
			_this.parents('.action-wrap').next('h4').next('div.tg-inner').slideUp();
		} else {
			_this.parents('.action-wrap').next('h4').next('div.tg-inner').toggleClass('show');
			_this.parents('.action-wrap').next('h4').next('div.tg-inner').slideToggle();
		}
	
	});
	
	/*--------------------------------------
	 Apparel Upload Images	
	 --------------------------------------*/
	jQuery(document).on('click', '.apparel_back_img', function (e) {
		e.preventDefault();
		var _this = jQuery(this);
		var custom_uploader = wp.media({
			title: 'Select File',
			button: {
				text: 'Add File'
			},
			multiple: false
		}).on('select', function () {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			_this.parents('.apparel_back').find('#apparel_back_img_id').val(attachment.id);
			_this.parents('.apparel_back').find('#apparel_back_img_url').val(attachment.url);
			_this.parents('.apparel_back').find('#apparel_back_image').attr('src', attachment.url);
			_this.parents('.apparel_back').show();
			_this.parents('.apparel_back').addClass('image-back-added');
		}).open();
	
	});
	
	jQuery(document).on('click', '.delete_apparel_back_logo', function (e) {
		var _this = jQuery(this);
		var placeholder = _this.parents('.image-back-added').find('#apparel_back_image').data('placeholder');
		_this.parents('.apparel_back').find('#apparel_back_image').attr('src', placeholder);
		_this.parents('.apparel_back').find('#apparel_back_img_id').val('');
		_this.parents('.apparel_back').find('#apparel_back_img_url').val('');
	});
	
	jQuery(document).on('click', '.apparel_front_img', function (e) {
		e.preventDefault();
		var _this = jQuery(this);
		var custom_uploader = wp.media({
			title: 'Select File',
			button: {
				text: 'Add File'
			},
			multiple: false
		}).on('select', function () {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			_this.parents('.apparel_front').find('#apparel_front_img_id').val(attachment.id);
			_this.parents('.apparel_front').find('#apparel_front_img_url').val(attachment.url);
			_this.parents('.apparel_front').find('#apparel_front_image').attr('src', attachment.url);
			_this.parents('.apparel_front').show();
			_this.parents('.apparel_front').addClass('image-front-added');
		}).open();
	
	});
	
	jQuery(document).on('click', '.delete_apparel_front_logo', function (e) {
		var _this = jQuery(this);
		var placeholder = _this.parents('.image-front-added').find('#apparel_front_image').data('placeholder');
		_this.parents('.apparel_front').find('#apparel_front_image').attr('src', placeholder);
		_this.parents('.apparel_front').find('#apparel_front_img_id').val('');
		_this.parents('.apparel_front').find('#apparel_front_img_url').val('');
	});
	
	//Color Pickr
	 jQuery('.plugin_color').wpColorPicker();
	
});

