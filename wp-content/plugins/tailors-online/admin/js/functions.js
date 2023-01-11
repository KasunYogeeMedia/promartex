"use strict";
jQuery(document).ready(function () {
	
	//Steps sortables
	function steps_sortables(){
		jQuery('.assets_container, .steps-main-wrap').sortable({
			delay: 300,
			opacity: 0.6,
			cursor: 'move',
			update: function() {}
		});
	}
	steps_sortables();
	
    /*Save Customizer Tab Data*/
    jQuery('#customizer_form').submit(function (e) {
        e.preventDefault();
        var customizer_form_data = jQuery('#customizer_form').serialize();
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: customizer_form_data + '&action=save_customizer_data',
            dataType: "json",
            success: function (response) {
				jQuery.sticky(scripts_vars.settings_saved, {classList: 'success', speed: 200, autoclose: 5000,position: 'top-right',});
                if( response.is_return !== '' ){
					window.location.replace(response.is_return);
				}
            }
        });
    });

    /*Save Measurements Data*/
    jQuery('#measurements_form').submit(function (e) {
        e.preventDefault();
        var measurements_form_data = jQuery('#measurements_form').serialize();
        jQuery.ajax({
            type: "POST",
            url: scripts_vars.ajaxurl,
            data: measurements_form_data + '&action=save_measurement_data',
            dataType: "json",
            success: function (response) {
				if( response.type === 'error' ){
					jQuery.sticky(response.msg, {classList: 'important', speed: 200, autoclose: 5000,position: 'top-right',});
				} else{ 
					jQuery.sticky(scripts_vars.settings_saved, {classList: 'success', speed: 200, autoclose: 5000,position: 'top-right',});
					if( response.is_return !== '' ){
						window.location.replace(response.is_return);
					}
				}
                
            }
        });
    });

    /*Add New Step Code*/
	jQuery(document).on('click', '.add_new_customizer_tab', function (e) {
		e.preventDefault();
		var _this	= jQuery(this);
		var load_customizer_tab = wp.template('load-customizer-tab');
		var length = _this.parents('.apparel-steps-main').find('.steps-main-wrap .step-counter').length;
		
		CURRENT_STEP_NUMBER = length + 1;
		
		var apparel_length = _this.parents('.apparel-counter').data('apparel_number');
		var data = {apparel:apparel_length, step:CURRENT_STEP_NUMBER};
		var customizer_tab = load_customizer_tab(data);
		_this.parents('.apparel-steps-main').find('.steps-main-wrap').append(customizer_tab);
	});
	
    /*Add New Apparel Code*/
    jQuery(document).on('click', '#add_new_apparel_tab', function (e) {
        e.preventDefault();
		var _this	= jQuery(this);
        var load_apparel_tab = wp.template('load-apparel-tab');
        var apparel_length = _this.parents('.apparel-listing').find('.customizer-apparel-data .apparel-counter').length;
        
		CURRENT_STEP_NUMBER = length + 1;
		var data = {apparel:apparel_length+1, step:1};
        var customizer_tab = load_apparel_tab(data);
        
		_this.parents('.apparel-listing').find('.customizer-apparel-data').append(customizer_tab);
		
		steps_sortables();
    });

    //Customizer Apparel remove
    jQuery(document).on('click', '.cus-apparel-action i.fa-trash-o', function (e) {
        var _this = jQuery(this);

        jQuery.confirm({
            'title': scripts_vars.del_apparel_title,
            'message': scripts_vars.del_apparel_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.apparel-counter').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });

    });
	
    //Customizer Steps remove
    jQuery(document).on('click', '.cus-step-action i.fa-trash-o', function (e) {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': scripts_vars.del_step_title,
            'message': scripts_vars.del_step_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.step-counter').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }	// Nothing to do in this case. You can as well omit the action property.
                }
            }
        });

    });
	
	//Customizer Steps assets remove
    jQuery(document).on('click', '.cus-asset-action i.fa-trash-o', function (e) {
        var _this = jQuery(this);
        jQuery.confirm({
            'title': scripts_vars.del_step_title,
            'message': scripts_vars.del_step_message,
            'buttons': {
                'Yes': {
                    'class': 'blue',
                    'action': function () {
                        _this.parents('.step-asset-main').remove();
                    }
                },
                'No': {
                    'class': 'gray',
                    'action': function () {
                        return false;
                    }   // Nothing to do in this case. You can as well omit the action property.
                }
            }
        });

    });
	
	//Show admin order detail
    jQuery('.view-order-detail').on('click', 'a', function () {
		jQuery('.admin-order-detail-wrap').toggleClass('show-order-info');
	});
	
	/* ---------------------------------------
      Modal box Window
     --------------------------------------- */
	jQuery('.order-edit-wrap').on('click',".cus-open-modal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		jQuery(_this.data("target")).show();
		jQuery(_this.data("target")).addClass('in');
		jQuery('body').addClass('cus-modal-open');
	});
	
	jQuery('.order-edit-wrap').on('click',".cus-close-modal", function(event){
		event.preventDefault();
		var _this	= jQuery(this);
		
		jQuery(_this.data("target")).removeClass('in');
		jQuery(_this.data("target")).hide();
		jQuery('body').removeClass('cus-modal-open');
	});
	
});