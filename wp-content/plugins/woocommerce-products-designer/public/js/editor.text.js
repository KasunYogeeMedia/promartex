var WPD_EDITOR = (function ($, wpd_editor) {
    'use strict';
   

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
        
        $(document).on('click', '#wpc-add-text', function (event) {
            event.preventDefault();
            var new_text = $("#new-text").val();
            var is_curved = $("#cb-curved").is(":checked");
            if (new_text.length == 0)
                alert(wpd.translated_strings.empty_txt_area_msg);
            else if (!is_curved)
                add_text(new_text, false, false);
            else
            {
                add_curved_text(new_text);
            }
            if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
                //$('.wpc-porto-skin .wpc-tools-head').removeClass('is-active');
                $('#text-panel').css('transform','');
                $('.wpc-porto-skin .wpc-tools-content').removeClass('is-active');
            }
        });

        function add_text(txt, left, top) {
            var text = create_text_elmt(txt);
            wpd_editor.canvas.add(text);
            if (left)
            {
                text.set("left", left);
                text.set("top", top);
            } else
            {
                wpd_editor.centerObjectH(text);
                wpd_editor.centerObjectV(text);
            }
            var wpd_canvas = wpd_editor.canvas;
            wp.hooks.doAction('WPD_EDITOR.after_adding_text_on_canvas', text, wpd_canvas);
            wpd_editor.canvas.renderAll();
            text.setCoords();

            $("#new-text").val("");
            wpd_editor.save_canvas();
        }

        $("#font-family-selector").trigger('change');

        $("#font-family-selector").css('font-family', $("#font-family-selector").val());
        $("#font-family-selector").change(function()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var font_size = parseInt($("#font-size-selector").val());
            var font_family = $(this).attr("value");
            $(this).css('font-family', font_family);
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                selected_object.set('fontFamily', font_family);
                if (font_size)
                    selected_object.setFontSize(parseInt(font_size));
                wpd_editor.canvas.renderAll();
                wpd_editor.save_canvas();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                selected_object.forEachObject(function (a) {
                    a.set('fontFamily', font_family);
                    if (font_size)
                        a.setFontSize(parseInt(font_size));
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                });
            }
        });


        $("#font-size-selector").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var font_size = parseInt($("#font-size-selector").val());
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                selected_object.setFontSize(parseInt(font_size));
                wpd_editor.canvas.renderAll();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                recreate_group(selected_object);
            }
        });

        $(".txt-align").change(function ()
        {
            var align = $(this).val();
            var selected_object = wpd_editor.canvas.getActiveObject();
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                selected_object.set("textAlign", align);
                wpd_editor.canvas.renderAll();
                wpd_editor.save_canvas();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                selected_object.forEachObject(function (a) {
                    a.set("textAlign", align);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                });
            }

        });

        //Bold styles
        $("#bold-cb").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var is_bold = $("#bold-cb").is(":checked");
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                if (is_bold)
                    selected_object.set("fontWeight", "bold");
                else
                    selected_object.set("fontWeight", "normal");
                wpd_editor.canvas.renderAll();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                selected_object.forEachObject(function (a) {
                    if (is_bold)
                        a.set("fontWeight", "bold");
                    else
                        a.set("fontWeight", "normal");
                    wpd_editor.canvas.renderAll();
                });
            }
        });

        $("#italic-cb").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var is_italic = $("#italic-cb").is(":checked");
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                if (is_italic)
                    selected_object.set("fontStyle", "italic");
                else
                    selected_object.set("fontStyle", "normal");
                wpd_editor.canvas.renderAll();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                selected_object.forEachObject(function (a) {
                    if (is_italic)
                        a.set("fontStyle", "italic");
                    else
                        a.set("fontStyle", "normal");
                    wpd_editor.canvas.renderAll();
                });
            }
        });

        $("#o-thickness-slider").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                if ($(this).val() > 0)
                {
                    var stroke = $("#txt-outline-color-selector").css('background-color');
                    selected_object.set("strokeWidth", parseInt($(this).val()));
                    selected_object.set("stroke", stroke);
                } else
                    selected_object.set("stroke", false);
                wpd_editor.canvas.renderAll();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                recreate_group(selected_object);
            }
        });

        //Is curved checkbox
        function wpd_get_curved_state(){
   
            if ($('.wpc-text-curved-wrap #cb-curved').is(':checked')){
                
                $('.wpc-text-curved-wrap #cb-curved').parents('.wpc-text-curved-wrap').find('.wpc-text-curved-content').addClass('is-active');
            }
            else{
                
                 $('.wpc-text-curved-wrap #cb-curved').parents('.wpc-text-curved-wrap').find('.wpc-text-curved-content').removeClass('is-active');
            }
        }
        $("#cb-curved").change(function ()
        {
             wpd_get_curved_state();
            var is_curved = $("#cb-curved").is(":checked");
            var selected_object = wpd_editor.canvas.getActiveObject();
            if (is_curved)
            {
                if (selected_object != null)
                {
                    var left = selected_object.get("left");
                    var top = selected_object.get("top");
                    if (selected_object.type == "i-text")
                    {
                        var text = selected_object.get("text");
                        wpd_editor.canvas.remove(selected_object);
                        add_curved_text(text, top, left);
                        wpd_editor.save_canvas();
                        wpd_editor.canvas.renderAll();
                        $("#cb-curved").attr('checked', 'checked');
                        if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo' || wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
                           $('.wpd-font-view').html(text); 
                        }
                    }
                }
            } else
            {
                if (selected_object != null)
                {
                    var left = selected_object.get("left");
                    var top = selected_object.get("top");
                    if (selected_object.type == "group")
                    {
                        var text = selected_object.get("originalText");
                        wpd_editor.canvas.remove(selected_object);
                        add_text(text, top, left);
                        wpd_editor.save_canvas();
                        wpd_editor.canvas.renderAll();
                    }
                }
            }
        });

        $("#curved-txt-radius-slider, #curved-txt-spacing-slider").change(function () {
            var selected_object = wpd_editor.canvas.getActiveObject();
            if ((selected_object != null) && (selected_object.type == "group"))
                recreate_group(selected_object);
        });

        $("[id$='opacity-slider']").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            if (selected_object != null)
            {
                selected_object.set("opacity", $(this).val());
                wpd_editor.canvas.renderAll();
                wpd_editor.save_canvas();
            }
        });

        $(".txt-decoration").change(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var decoration = $(this).val();

            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                selected_object.set("textDecoration", decoration);
                wpd_editor.canvas.renderAll();
            }
        });



        function add_curved_text(str, custom_top, custom_left)
        {
            var len = str.length;
            var s;
            var radius = $("#curved-txt-radius-slider").val();
            var spacing = $("#curved-txt-spacing-slider").val();
           if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo' || wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
               var font_color = $("#txt-color-selector .wpd-color-view").css('background-color');
           }
           else{
               var font_color = $("#txt-color-selector").css('background-color');
           }
            
            if (!radius)
                radius = 150;
            if (!spacing)
                spacing = 10;
            var curAngle = 0;
            var angleRadians = 0;
            var align = 0;
            var centerX = wpd_editor.canvas.getWidth() / 2;
            var centerY = wpd_editor.canvas.getHeight() - 30;
            align = (spacing / 2) * (len - 1);
            var reverse = false;
            var coef = 1;
            if (reverse)
                coef = -1;
            var items = [];
            for (var n = 0; n < len; n++) {
                s = str[n];

                var text = create_text_elmt(s);
                curAngle = (n * parseInt(spacing, 10)) - align;
                angleRadians = curAngle * (Math.PI / 180);
                if (reverse)
                {
                    curAngle = (-n * parseInt(spacing, 10)) + align;
                    angleRadians = curAngle * (Math.PI / 180);
                }

                var top = (centerX + (-Math.cos(angleRadians) * radius)) * coef;
                var left = (centerY + (Math.sin(angleRadians) * radius)) * coef;
                text.set('top', top);
                text.set('left', left);
                text.setAngle(curAngle);
                items.push(text);
            }
            var group = new fabric.Group(items, {
                left: 150,
                top: 100,
                fill: font_color,
            });

            if (custom_top != null)
                wpd_editor.canvas.setActiveObject(group);
            wpd_editor.setCustomProperties(group);
            group["originalText"] = str;
            group["radius"] = radius;
            group["spacing"] = spacing;
            wpd_editor.canvas.add(group);

            if (custom_top == null)
                group.center();
            else
            {
                group.set("left", custom_left);
                group.set("top", custom_top);
            }

            wpd_editor.save_canvas();
            wpd_editor.canvas.renderAll();
            group.setCoords();
        }

        function create_text_elmt(txt)
        {
            var strokeWidth = $("#o-thickness-slider").val();
            var fontWeight = "normal";
            var textDecoration = "";
            var fontStyle = "";
            
            if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo' ||
                    wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
                var font_color = $("#txt-color-selector .wpd-color-view").css('background-color');
            }
            else{
                var font_color = $("#txt-color-selector").css('background-color');
            }
            var fontFamily = $("#font-family-selector").val();
            var font_size = parseInt($("#font-size-selector").val());
            var opacity = $("#opacity-slider").val();
            var strokeColor = $("#txt-outline-color-selector").css('background-color');
            var is_bold = $("#bold-cb").is(":checked");
            var is_underlined = $("#underline-cb").is(":checked");
            var is_italic = $("#italic-cb").is(":checked");

            if (is_bold)
                fontWeight = "bold";
            if (is_underlined)
                textDecoration = "underline";
            if (is_italic)
                fontStyle = "italic";
            if (!fontFamily)
                fontFamily = 'Arial';
            if (!font_size)
                font_size = 30;
            if (!fontWeight)
                fontWeight = "normal";
            if (!font_color)
                font_color = "rgb(198, 196, 196)";

            if (!opacity)
                opacity = 1;
            var text = new fabric.IText(txt, {
                left: 30,
                top: 70,
                fontFamily: fontFamily,
                fontSize: font_size,
                fontWeight: fontWeight,
                fontStyle: fontStyle,
                textDecoration: textDecoration,
                selectable: true,
                fill: font_color,
                opacity: opacity,

            });
            text.set("originX", wpd.originX);
            text.set("originY", "center");
            

            if (strokeWidth > 0)
            {
                text.set("stroke", strokeColor);
                text.set("strokeWidth", parseInt(strokeWidth));
            }
            wpd_editor.setCustomProperties(text);

            return text;
        }

        function recreate_group(group)
        {
            var left = group.get("left");
            var top = group.get("top");
            wpd_editor.canvas.remove(group);
            add_curved_text(group.originalText, top, left);
        }

        $('#new-text').keyup(function ()
        {
            var selected_object = wpd_editor.canvas.getActiveObject();
            var new_text = $('#new-text').val();
            if ((selected_object != null) && (selected_object.type == "i-text"))
            {
                selected_object.set("text", new_text);
                wpd_editor.save_canvas();
                wpd_editor.canvas.renderAll();
            } else if ((selected_object != null) && (selected_object.type == "group"))
            {
                var left = selected_object.get("left");
                var top = selected_object.get("top");
                wpd_editor.canvas.remove(selected_object);
                add_curved_text(new_text, top, left);
            }
        });


        $('[id$="color-selector"]').each(function ()
        {
            var id = $(this).attr("id");
            
            
            
            var initial_color = $(this).css("background-color");
            if (!initial_color)
                initial_color = "#0000ff";
            //console.log(wpd.palette_tpl);
            if (wpd.palette_type == "custom")
            {
                $('#' + id).spectrum({
                    containerClassName: 'wpc-custom-colors-container wpc-custom-color-'+ id ,
                    hideAfterPaletteSelect:true,
                    showPaletteOnly: true,
                    preferredFormat: "hex",
                    togglePaletteOnly: false,
                    togglePaletteMoreText: 'more',
                    togglePaletteLessText: 'less',
                    color: initial_color,
                    palette: wpd.palette_tpl,
                    change: function(color) {
                        var color = color.toHexString();
                        var hex = color.replace("#", "");
                        var id = $(this).attr('id');
                        wpd_editor.change_item_color(id, hex);
                    }
                });
//                $('#' + id).qtip({
//                    content: "<div class='wpc-custom-colors-container' data-id='" + id + "'>" + wpd.palette_tpl + "</div>",
//                    position: {
//                        corner: {
//                            target: 'middleRight',
//                            tooltip: 'leftTop'
//                        }
//                    },
//                    style: {
//                        width: 200,
//                        padding: 5,
//                        background: 'white',
//                        color: 'black',
//                        border: {
//                            width: 1,
//                            radius: 1,
//                            color: '#08AED6'
//                        }
//                    },
//                    tip: 'bottomLeft',
//                    show: 'click',
//                    hide: {when: {event: 'unfocus'}}
//                });
            } else
            {
                $('#' + id).spectrum({
                    flat: true,
                    color:initial_color,
                    showPalette: false,
                    showButtons: false,
                    showInput: true,
                    showAlpha: false,
                    allowAlpha: true,
                    clickoutFiresChange: true,
                    preferredFormat: "hex",
                    show: function(color) {
			return false;
                    },
                    hide: function(color) {
			var selected_object = wpd_editor.canvas.getActiveObject();
			if ((selected_object != null))
			{
			    wpd_editor.save_canvas();
			}
			return false;
                    },
                    move: function(color) {
                        //console.log();
                        var color = color.toHexString();
                        var hex = color.replace("#", "");
                        var id = $(this).attr('id');
                        wpd_editor.change_item_color(id, hex);
                    }
                });
//                $('#' + id).ColorPicker({
//                    color: initial_color,
//                    onShow: function (colpkr) {
//                        $(colpkr).fadeIn(500);
//                        return false;
//                    },
//                    onHide: function (colpkr) {
//                        $(colpkr).fadeOut(500);
//                        var selected_object = wpd_editor.canvas.getActiveObject();
//                        if ((selected_object != null))
//                        {
//                            wpd_editor.save_canvas();
//                        }
//                        return false;
//                    },
//                    onChange: function (hsb, hex, rgb) {
//                        wpd_editor.change_item_color(id, hex);
//                    }
//                });
            }

        });
    })
    return wpd_editor;
}(jQuery, (WPD_EDITOR || {})))