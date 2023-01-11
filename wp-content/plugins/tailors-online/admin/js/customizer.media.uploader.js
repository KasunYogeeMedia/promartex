jQuery(document).ready(function () {
    CURRENT_STEP_NUMBER = 1;
    ACTIVE_STEP = 1;
    ACTIVE_APPAREL = 1;
	
	apparel_number = 1;
    step_number = 1;
	assets_length	= 1;
	gallery_images = '';
	
    jQuery(document).on('click',".media_upload_button", function () {
        var _this = jQuery(this);
        $elem = _this;
        inputfield = _this.parent().prev().find('input').attr('id');
        screenshot = _this.parent().parent().find('.screenshot');
        selector = _this.parents('.section-upload');
        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
                .on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    itemurl = attachment.url;
                    btnContent = '<a href="' + itemurl + '"><img class="zaraar-upload-image" src="' + itemurl + '" alt="" /></a>';
                    selector.find('.remove-item').css('display', 'inline-block');
                    jQuery('#' + inputfield).val(itemurl);
                    screenshot.fadeIn().html(btnContent);
                }).open();

    });

	//Remove item
    jQuery('.remove-item').on('click', function () {
        var _this = jQuery(this);
        selector = _this.parents('.section-upload')
        selector.find('.remove-item').hide().addClass('hide');//hide "Remove" button
        selector.find('.upload').val('');
        selector.find('.screenshot').slideUp();
    });
    /*---------------------------------------------------------------------
     * Z Multi Uploader
     *---------------------------------------------------------------------*/

    var gallery_container = jQuery('.tg-displaybox');
    var gallery_frame;
    var styles_gallery_frame;
    var gallery_ids = jQuery('#gallery_ids');
    var reset_gallery = jQuery('#reset_gallery');
    var gallery_images = '';
    var styles_gallery_images = '';
	
	//Uplaod Styles
    jQuery(document).on('click', '.styles_upload', function (event) {
        styles_gallery_images = jQuery(this).parents('.tg-group').find('.assets_container');
        var _this = jQuery(this);
        event.preventDefault();
        assets_length = _this.parents('.tg-mediafilesanduploader').find('.assets_container div.tg-displaybox').length;

		var load_assets = wp.template('load-styles-assets');
		var _assets = load_assets(assets_length);
		styles_gallery_images.append(_assets);
    });
	
	//Upload style images
	jQuery(document).on('click',".upload_asset", function () {
        var _this = jQuery(this);

        _inputfield 	= _this.parents('.tg-displaybox').find('.media_id');
        _media_url 	 = _this.parents('.tg-displaybox').find('.media_url');
		_screenshot 	= _this.parents('.tg-displaybox').find('._screenshot img');

        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
		.on('select', function () {
			var attachment  = custom_uploader.state().get('selection').first().toJSON();
			_itemurl 		= attachment.url;
			_itemid	 	 	= attachment.id;
			_inputfield.val(_itemid);
			_media_url.val(_itemurl);
			_screenshot.attr("src",_itemurl);
		}).open();

    });
	
	
	//Add Step assets
	jQuery(document).on('click', '.add_step_asset', function (event) {
        asset_container = jQuery(this).parents('.step-counter').find('.assets_container');
        var _this = jQuery(this);
        event.preventDefault();
        asset_counter 		= _this.parents('.tg-mediafilesanduploader').find('.assets_container div.step-asset-main').length;
		step_number   		= _this.parents('.step-counter').data('step_number');
		apparel_number 		= _this.parents('.apparel-counter').data('apparel_number');
		
		var load_assets 	= wp.template('load-step-data');
		var _assets 		= load_assets({apparel_number:apparel_number, asset_counter:asset_counter+1, step_number:step_number});
		asset_container.append(_assets);
    });
	
	//Upload step assets
	jQuery(document).on('click',".upload_step_asset", function () {
        var _this = jQuery(this);

        _inputfield 	= _this.parents('.tg-displaybox').find('.media_id');
        _media_url 	 = _this.parents('.tg-displaybox').find('.media_url');
		_screenshot 	= _this.parents('.tg-displaybox').find('._screenshot img');

        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
		.on('select', function () {
			var attachment  = custom_uploader.state().get('selection').first().toJSON();
			_itemurl 		= attachment.url;
			_itemid	 	 = attachment.id;
			_inputfield.val(_itemid);
			_media_url.val(_itemurl);
			_screenshot.attr("src",_itemurl);
		}).open();

    });
	
    /*---------------------------------------------------------------------------
     * Measurements Upload Functionality
     *-------------------------------------------------------------------------*/
    jQuery('.measurement_assets').sortable({
		delay: 300,
		opacity: 0.6,
		cursor: 'move',
		update: function() {}
	});
	
    var measurement_container = jQuery('.tg-displaybox');
    var measurement_frame;
    var reset_measurement = jQuery('#reset_gallery');
    var measurement_images = '';

    jQuery('body').on('click', '.measurement_assets_upload', function (event) {
        measurement_images = jQuery(this).parents('.tg-addparameter').find('.measurement_assets');
        var _this = jQuery(this);
        event.preventDefault();
        measurement_assets_length = _this.parents('.tg-mediafilesanduploader').find('.measurement_assets div.tg-displaybox').length;
        if (measurement_frame) {
            measurement_frame.open();
            return;
        }

        // Create the media frame.
        measurement_frame = wp.media.frames.gallery = wp.media({
            title: _this.data('choose'),
            library: {type: 'image'},
            button: {
                text: _this.data('update'),
            },
            states: [
                new wp.media.controller.Library({
                    title: _this.data('choose'),
                    filterable: 'image',
                    multiple: true,
                })
            ]
        });

        // When an image is selected, run a callback.
        measurement_frame.on('select', function () {
            var selection = measurement_frame.state().get('selection');
            selection.map(function (attachment) {
                attachment = attachment.toJSON();

                measurement_assets_length = measurement_assets_length + 1;
                attachment.asset_counter = measurement_assets_length;

                if (attachment.id) {
                    measurement_container.show();
                    reset_measurement.show();
                    var load_assets = wp.template('load-measurement-asset');
                    var _assets = load_assets(attachment);
                    measurement_images.append(_assets);
                }

            });

        });
        // Finally, open the modal.
        measurement_frame.open();

    });

    jQuery(function () {
        
        /*---------------------------------------------------------------------
         * delete assets
         *---------------------------------------------------------------------*/
        jQuery(document).on("click",'.assets_container .delete_asset', function () {
            jQuery(this).parent('.tg-displaybox').fadeOut('slow', function () {
                jQuery(this).remove();
            });
        });

        /*Delete Measurement*/
        jQuery(document).on("click",'.measurement_assets .delete_asset', function () {
            jQuery(this).parent('.tg-displaybox').fadeOut('slow', function () {
                jQuery(this).remove();
            });
        });

        /*---------------------------------------------------------------------
         * reset gallery
         *---------------------------------------------------------------------*/
        jQuery('.zaraar-buttons').delegate("#reset_gallery", "click", function () {
            jQuery('.gallery-list').html('');
            jQuery(this).hide();
        });
    });

}); // End mediaUpload

	