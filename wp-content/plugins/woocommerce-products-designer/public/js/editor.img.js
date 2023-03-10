var WPD_EDITOR = (function ($, wpd_editor) {
    $(document).ready(function () {
        var wpd_get_active_skin = wpd.skin;
        var windowsize = $(window).width();
            
        if(wpd_get_active_skin ==='WPD_Skin_Porto_Novo'){
            if (windowsize <= 1024) {
                wpd_get_active_skin = 'WPD_Skin_Porto_Novo_Mobile';
            }
            else{
               wpd_get_active_skin = 'WPD_Skin_Porto_Novo'; 
            }
        }
        
        function init_lazy_loader(container)
        {
            $("img.o-lazy").lazyload({
                placeholder: wpd.lazy_placeholder,
                container: $(container),
                skip_invisible: true
            });
        }

        init_lazy_loader("#wpd-cliparts-wrapper");
        
        

        if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo' || wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
            
            $(document).on("click", ".wpd-cliparts-groups>li,#wpd-search-cliparts-group-results > li", function (e) {
            show_all_cliparts();
            var group_id = $(this).data("groupid");
            var group_name = $(this).html();
            $(".wpd-cliparts-container").hide();
            $(".wpd-cliparts-groups>li").removeClass("selected");
            $(this).addClass("selected");
            $(".wpd-cliparts-container[data-groupid=" + group_id + "]").css('display', 'contents');
            setTimeout(function () {
                $(".wpd-cliparts-container[data-groupid=" + group_id + "]").trigger("scroll");
            }, 500);
            $('#wpd-clipart-group-selected').html(group_name);
            $('#cliparts-panel-content-child').addClass('is-open');

            });
            
            //setup before functions
            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 5 second for example
            var $input = $('#wpd-cliparts-search');
            var $input_group = $('#wpd-cliparts-group-search');

            //on keyup, start the countdown
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //clipart_group
            $input_group.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping_group, doneTypingInterval);
            });

            //on keydown, clear the countdown 
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            //clipart_group
            $input_group.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            //user is "finished typing," do something
            function doneTyping() {
                $("#wpd-search-cliparts-results").html("");
                var preview_list = $('#wpd-all-cliparts').html();
                var searched_value = $input.val().toLowerCase();
                if (searched_value.length > 0) {
                    var results = $('.wpd-cliparts-groups li').filter(function () {
                        return $(this).attr('data-group-name').toLowerCase().indexOf(searched_value) > -1;
                    });
                    if (results.length) {
                        var get_result_list = {};
                        var result = [];
                        var get_id;
                        $.each(results, function (index, value) {
                            get_result_list = value;
                            get_id = $(this).attr('data-groupid');
                            result.push(get_id);
                        });

                        var unique = result.filter(function (get_id, i, a) {
                            return i == result.indexOf(get_id);
                        });
                        if (unique.length) {
                            var recup = $('#wpd-all-cliparts .wpd-cliparts-container').filter(function () {
                                if ($.inArray($(this).attr('data-groupid'), unique) >= 0)
                                    return 1;
                            });
                            if (recup.length) {
                                var get_result_clone = recup.clone();
                                $("#wpd-search-cliparts-results").html(get_result_clone);
                            }
                        } else {
                            $("#wpd-search-cliparts-results").html(wpd.translated_strings.cliparts_search_no_result);
                        }

                    } 
                    else {
                        $("#wpd-search-cliparts-results").html(wpd.translated_strings.cliparts_search_no_result);
                    }
                    show_cliparts_search_results();
                } else {
                    $("#wpd-all-cliparts").css('display', 'contents');
                    $("#wpd-search-cliparts-results").hide();
                }

            }

            //clipart_group
            function doneTyping_group() {
            $("#wpd-search-cliparts-group-results").html("");
            var preview_list = $('.wpd-cliparts-groups').html();
            var searched_value = $input_group.val().toLowerCase();
            if (searched_value.length > 0) {
                var results = $('.wpd-cliparts-groups li').filter(function () {
                    return $(this).attr('data-group-name').toLowerCase().indexOf(searched_value) > -1;
                });
                if (results.length) {
                    var get_result_list = {};
                    var result = [];
                    var get_id;
                    $.each(results, function (index, value) {
                        get_result_list = value;
                        get_id = $(this).attr('data-groupid');
                        result.push(get_id);
                    });
                    var unique = result.filter(function (get_id, i, a) {
                        return i == result.indexOf(get_id);
                    });
                    if (unique.length) {
                        var recup = $('#wpd-all-cliparts .wpd-cliparts-container').filter(function () {
                            if ($.inArray($(this).attr('data-groupid'), unique) >= 0)
                                return 1;
                        });
                        if (recup.length) {
                            var get_result_clone = recup.clone();
                            $("#wpd-search-cliparts-group-results").html(get_result_clone);
                        }
                    } else {
                        $("#wpd-search-cliparts-group-results").html(wpd.translated_strings.cliparts_search_no_result);
                    }

                } else {
                    $("#wpd-search-cliparts-group-results").html(wpd.translated_strings.cliparts_search_no_result);
                }

            } else {
                $("#wpd-search-cliparts-group-results").html(preview_list);
            }

            show_cliparts_group_search_results();
        }

            function show_cliparts_group_search_results()
                {
            $(".wpd-cliparts-groups").hide();
            $("#wpd-search-cliparts-group-results").css('display', 'contents');
            $("#wpd-search-cliparts-group-results .wpd-cliparts-container").css('display', 'contents');
            init_lazy_loader("#wpd-search-cliparts-group-results");
        }

            function show_cliparts_search_results()
            {
            $("#wpd-all-cliparts").hide();
            $("#wpd-search-cliparts-results").css('display', 'contents');
            $("#wpd-search-cliparts-results .wpd-cliparts-container").css('display', 'contents');
            init_lazy_loader("#wpd-search-cliparts-results");
        }

            function show_all_cliparts()
            {
            $("#wpd-all-cliparts").css('display', 'contents');
            $("#wpd-search-cliparts-results").hide();
        }
            
         $(document).on('click', '.clipart-img:not(.test)', function ()
        {
            var medium_url = $(this).attr("data-url");
            if (typeof medium_url == "undefined")
                medium_url = $(this).attr("data-original");
            var price = $(this).data("price");
            add_img_on_editor(medium_url, price);
            wp.hooks.doAction('WPD_EDITOR.after_click_clipart');

            
        });   
          
        }
        else{
            $(document).on("click", ".wpd-cliparts-groups>li", function (e) {
                show_all_cliparts();
                var group_id = $(this).data("groupid");
                $(".wpd-cliparts-container").hide();
                $(".wpd-cliparts-groups>li").removeClass("selected");
                $(this).addClass("selected");
                $(".wpd-cliparts-container[data-groupid=" + group_id + "]").show();
                setTimeout(function () {
                    $(".wpd-cliparts-container[data-groupid=" + group_id + "]").trigger("scroll");
                }, 500);
            });
            
            $(".wpd-cliparts-container").bind('scrollstop', function (e) {
                $(".wpd-cliparts-container:visible").trigger("scroll");
            });

            $(document).on("click", "#wpd-cliparts-opener", function (e) {
                $(".wpd-cliparts-groups>li").first().click();
            });
            
             //setup before functions
            var typingTimer;                //timer identifier
            var doneTypingInterval = 1000;  //time in ms, 5 second for example
            var $input = $('#wpd-cliparts-search');

            //on keyup, start the countdown
            $input.on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            //on keydown, clear the countdown 
            $input.on('keydown', function () {
                clearTimeout(typingTimer);
            });

            //user is "finished typing," do something
            function doneTyping() {
                $("#wpd-search-cliparts-results").html("");
                var searched_value = $input.val().toLowerCase();
                var results = $('#wpd-all-cliparts .clipart-img').filter(function () {
                    return $(this).attr('data-src').toLowerCase().indexOf(searched_value) > -1;
                });
                if (results.length)
                    results.clone().appendTo("#wpd-search-cliparts-results");
                else
                    $("#wpd-search-cliparts-results").html(wpd.translated_strings.cliparts_search_no_result);

                show_cliparts_search_results();
            }

            function show_cliparts_search_results()
            {
                $("#wpd-all-cliparts").hide();
                $("#wpd-search-cliparts-results").show();
                setTimeout(function () {
                    init_lazy_loader("#wpd-search-cliparts-results");
                }, 500);
            }

            function show_all_cliparts()
            {
                $("#wpd-all-cliparts").show();
                $("#wpd-search-cliparts-results").hide();
            }
            
            //Images
            $(document).on('click', '.clipart-img img', function ()
            {
                var medium_url = $(this).attr("src");
                if (typeof medium_url == "undefined")
                    medium_url = $(this).attr("data-original");
                var price = $(this).data("price");
                add_img_on_editor(medium_url, price);
                $('#wpd-cliparts-modal').omodal("hide");
            });
            
            
        }   

        

        

        $(document).on("click", "#wpc-add-img", function (e) {
            e.preventDefault();
            var selector = $(this).attr('data-selector');
            var trigger = $(this);
            var uploader = wp.media({
                title: 'Add image on the design area',
                button: {
                    text: "Add image"
                },
                multiple: false
            })
                    .on('select', function () {
                        var selection = uploader.state().get('selection');
                        selection.map(
                                function (attachment) {
                                    attachment = attachment.toJSON();
                                    add_img_on_editor(attachment.url);
                                }
                        )
                    })
                    .open();
        });

        $(".native-uploader #userfile").change(function () {
            var file = $(this).val().toLowerCase();
            if (file != "")
            {
                $("#userfile_upload_form").ajaxForm({
                    success: upload_image_callback
                }).submit();
            }
        });
        $('.drop a').click(function () {
            // Simulate a click on the file input button
            // to show the file browser dialog
            $(this).parent().find('input').click();
        });

        if ($('#userfile_upload_form.custom-uploader').length)
        {
            var userfile_ul = $('#userfile_upload_form.custom-uploader .acd-upload-info');
            // Initialize the jQuery File Upload plugin
            $('#userfile_upload_form.custom-uploader').fileupload({
                // This element will accept file drag/drop uploading
                dropZone: $('.drop'),
                url: ajax_object.ajax_url,
                // This function is called when a file is added to the queue;
                // either via the browse button, or via drag/drop:
                add: function (e, data) {
                    var tpl = $('<div class="working"><div class="acd-info"></div><div class="acd-progress-bar"><div class="acd-progress"></div></div></div>');

                    // Append the file name and file size
                    tpl.find('.acd-info').text(data.files[0].name).append('<i>' + formatFileSize(data.files[0].size) + '</i>');

                    // Add the HTML to the UL element
                    userfile_ul.html("");
                    data.context = tpl.appendTo(userfile_ul);

                    // Initialize the knob plugin
                    tpl.find('input').knob();

                    // Listen for clicks on the cancel icon
                    tpl.find('span').click(function () {

                        if (tpl.hasClass('working')) {
                            jqXHR.abort();
                        }

                        tpl.fadeOut(function () {
                            tpl.remove();
                        });

                    });

                    // Automatically upload the file once it is added to the queue
                    var jqXHR = data.submit();



                },
                progress: function (e, data) {

                    // Calculate the completion percentage of the upload
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    // Update the hidden input field and trigger a change
                    // so that the jQuery knob plugin knows to update the dial
                    data.context.find('.acd-progress').css("width", progress + "%");

                    if (progress == 100) {
                        data.context.removeClass('working');
                    }
                },
                fail: function (e, data) {
                    // Something has gone wrong!
                    data.context.addClass('error');
                },
                done: function (e, data) {
                    var name = data.files[0].name;
                    upload_image_callback(data.result, false, false, false);
                }
            });
        }


        // Prevent the default action when a file is dropped on the window
        $(document).on('drop dragover', function (e) {
            e.preventDefault();
        });

        $('.acd-grayscale').change(function ()
        {
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Grayscale(), $(this).is(':checked'));
            
        });

        $('.acd-invert').change(function () {
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Invert(), $(this).is(':checked'));
        });

        $('.acd-sepia').change(function () {
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Sepia(), $(this).is(':checked'));         
        });

        $('.acd-sepia2').change(function () {
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Sepia2(), $(this).is(':checked'));   
        });

        $('.acd-blur').change(function () {
            if ($(this).is(':checked'))
                $("#sharpen, #emboss").removeAttr('checked');
            
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Convolute({
                matrix: [1 / 9, 1 / 9, 1 / 9,
                    1 / 9, 1 / 9, 1 / 9,
                    1 / 9, 1 / 9, 1 / 9]
            }),
                    $(this).is(':checked')); 
        });


        $('.acd-sharpen').change(function () {
            if ($(this).is(':checked'))
                $("#blur, #emboss").removeAttr('checked');
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Convolute({
                matrix: [0, -1, 0,
                    -1, 5, -1,
                    0, -1, 0]
            }),
                    $(this).is(':checked'));        
        });

        $('.acd-emboss').change(function () {
            if ($(this).is(':checked'))
                $("#sharpen, #blur").removeAttr('checked');
            wp.hooks.doAction('WPD_EDITOR.after_adding_filter_on_image');
            apply_filter(new fabric.Image.filters.Convolute({
                matrix: [1, 1, 1,
                    1, 0.7, -1,
                    -1, -1, -1]
            }), $(this).is(':checked'));
        });

        function apply_filter(filter, toApply) {

            var selected_object = wpd_editor.canvas.getActiveObject();

            var filter_index = jQuery.inArray(filter.type.toLowerCase(), wpd_editor.arr_filters);
            if ((selected_object != null) && (selected_object.type == "image"))
            {
                if (toApply)
                    selected_object.filters[filter_index] = filter;
                else
                    selected_object.filters[filter_index] = false;

                selected_object.applyFilters(wpd_editor.canvas.renderAll.bind(wpd_editor.canvas));
                wpd_editor.save_canvas();
            }

        }

        wpd_editor.is_json = function (data)
        {
            if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
                    replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
                    replace(/(?:^|:|,)(?:\s*\[)+/g, '')))
                return true;
            else
                return false;
        }

        function add_img_on_editor(url, price)
        {
            var ext = url.split('.').pop();
            if (typeof price == "undefined")
                price = 0;
            var wpd_canvas = wpd_editor.canvas;
            if (ext == "svg")
            {
                fabric.loadSVGFromURL(url, function (objects, options) {
                    var obj = fabric.util.groupSVGElements(objects, options);
                    optimize_img_width(obj);
                    wpd_editor.setCustomProperties(obj);
                    obj.set("price", price);
                    obj.set("originX", "center");
                    obj.set("originY", "center");
                    obj.set("svgSrc",url);
                    wp.hooks.doAction('WPD_EDITOR.before_adding_img_on_canvas', obj, wpd_canvas);
                    if (wpd_editor.box_center_x)
                    {
                        wpd_editor.centerObject(obj);
                        wpd_editor.canvas.add(obj).calcOffset().renderAll();
                    } else
                    {
                        wpd_editor.canvas.add(obj);
                        wpd_editor.centerObject(obj);
                        wpd_editor.canvas.calcOffset().renderAll();
                    }
                    wp.hooks.doAction('WPD_EDITOR.after_adding_img_on_canvas', obj, wpd_canvas);
                    obj.setCoords();
                    wpd_editor.save_canvas();
                });
            } else
            {
                fabric.Image.fromURL(url, function (img)
                {
                    optimize_img_width(img);
                    wpd_editor.setCustomProperties(img);
                    img.set("price", price);
                    img.set("originX", "center");
                    img.set("originY", "center");
                    wp.hooks.doAction('WPD_EDITOR.before_adding_img_on_canvas', img, wpd_canvas);
                    if (wpd_editor.box_center_x)
                    {
                        wpd_editor.canvas.add(img.set(
                                {
                                    angle: 0
                                })
                                ).renderAll();
                        wpd_editor.centerObject(img);
                        wpd_editor.canvas.calcOffset().renderAll();
                    } else
                    {
                        wpd_editor.canvas.add(img.set(
                                {
                                    angle: 0
                                })
                                );
                        wpd_editor.centerObject(img);
                        wpd_editor.canvas.calcOffset().renderAll();
                    }
                    wp.hooks.doAction('WPD_EDITOR.after_adding_img_on_canvas', img, wpd_canvas);

                    img.setCoords();
                    wpd_editor.save_canvas();
                }, {crossOrigin: 'anonymous'});
            }
        }

        function optimize_img_width(obj)
        {
            var displayable_area_width = wpd_editor.canvas.getWidth();
            var displayable_area_height = wpd_editor.canvas.getHeight();
            if (wpd.clip_w && wpd.clip_h && wpd.clip_w > 0 && wpd.clip_h > 0 && wpd.clip_type == "rect")
            {
                displayable_area_width = wpd.clip_w;
                displayable_area_height = wpd.clip_h;
            } else if (wpd.clip_r && wpd.clip_r > 0 && wpd.clip_type == "arc")
            {
                displayable_area_width = wpd.clip_r;
                displayable_area_height = wpd.clip_r;
            }
            var dimensions = wpd_editor.get_img_best_fit_dimensions(obj, displayable_area_width, displayable_area_height);
            var scaleW = displayable_area_width / dimensions[0];
            var scaleH = displayable_area_height / dimensions[1];
            if (scaleW > scaleH)
                obj.scaleToWidth(dimensions[0]);
            else
                obj.scaleToHeight(dimensions[1]);
            return dimensions;
        }

        function upload_image_callback(responseText, statusText, xhr, form)
        {
            if (wpd_editor.is_json(responseText))
            {
                var response = $.parseJSON(responseText);

                if (response.success)
                {
                    if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo'){
                        $("#acd-uploaded-img").find("div.mCustomScrollBox ").find("div.mCSB_container").append(response.message);

                    }
                    else if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
                        $("#acd-uploaded-img").append(response.message);
                    }
                    else{
                        $("#acd-uploaded-img").append(response.message);
                    }
                    
                    if (response.img_url)
                        add_img_on_editor(response.img_url, 0);
                        wp.hooks.applyFilters('wpd.after_upload_image');
                } else
                    alert(response.message);
            } else
                $("#debug").html(responseText);
            $("#userfile").val("");
        }
        
        // Helper function that formats the file sizes
        function formatFileSize(bytes) {
            if (typeof bytes !== 'number') {
                return '';
            }

            if (bytes >= 1000000000) {
                return (bytes / 1000000000).toFixed(2) + ' GB';
            }

            if (bytes >= 1000000) {
                return (bytes / 1000000).toFixed(2) + ' MB';
            }

            return (bytes / 1000).toFixed(2) + ' KB';
        }
    });



    return wpd_editor;
}(jQuery, (WPD_EDITOR || {})))