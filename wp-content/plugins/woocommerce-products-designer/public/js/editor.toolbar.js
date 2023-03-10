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
        
        if(wpd_get_active_skin === 'WPD_Skin_Porto_Novo_Mobile'){
            
            $('#undo-btn').doubletap(function(e)
            {
                e.preventDefault();
                $this = "#"+ e.target.id;
                var current_data_id = $("#wpc-parts-bar > li:eq(" + wpd_editor.selected_part + ")").attr("data-id");
                if (! $($this).hasClass("disabled") && wpd_editor.canvasManipulationsPosition[current_data_id] > 0)
                {
                    wpd_editor.canvas.clear();
                    wpd_editor.canvasManipulationsPosition[current_data_id]--;
                    wpd_editor.canvas.loadFromJSON(wpd_editor.serialized_parts[current_data_id][wpd_editor.canvasManipulationsPosition[current_data_id]]);
                    wpd_editor.refresh_undo_redo_status();
                }
                
            });

            $('#redo-btn').doubletap(function(e)
            {
                e.preventDefault();
                var current_data_id = $("#wpc-parts-bar > li:eq(" + wpd_editor.selected_part + ")").attr("data-id");
                var next_index = wpd_editor.canvasManipulationsPosition[current_data_id] + 1;
                $this = "#"+ e.target.id;
                if (!$($this).hasClass("disabled") && typeof wpd_editor.serialized_parts[current_data_id][next_index] != "undefined")
                {
                    wpd_editor.canvas.clear();
                    wpd_editor.canvasManipulationsPosition[current_data_id] = next_index;
                    wpd_editor.canvas.loadFromJSON(wpd_editor.serialized_parts[current_data_id][next_index]);
                    wpd_editor.refresh_undo_redo_status();
                }
            });
            
            $('#grid-btn').doubletap(function(e)
            {
                $(".upper-canvas").toggleClass("wpc-canvas-grid");
            });
            
            $('#copy_paste_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_group != null)
                {
                    var new_group = new fabric.Group();
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    var objects = canvas.getObjects();
                    $.each(objects, function (key, current_item)
                    {
                        if (selected_group.contains(current_item))
                        {
                            cloneObject(current_item, false);
                        }
                    });
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_object != null)
                {
                    wpd_editor.canvas.discardActiveObject();
                    cloneObject(selected_object, true);
                    wpd_editor.save_canvas();
                }
            });
            
            
            $('#bring_to_front_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.canvas.bringForward(selected_object);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();

                } else if (selected_group != null)
                {
                    selected_group.forEachObject(function (a) {
                        wpd_editor.canvas.bringForward(a);
                    });
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }
            });

            $('#send_to_back_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.canvas.sendBackwards(selected_object);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    selected_group.forEachObject(function (a) {
                        wpd_editor.canvas.sendBackwards(a);
                    });
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();

                }
            });

            $('#flip_h_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    if (selected_object.get("flipX") == true)
                        selected_object.set("flipX", false);
                    else
                        selected_object.set("flipX", true);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    if (selected_group.get("flipX") == true)
                        selected_group.set("flipX", false);
                    else
                        selected_group.set("flipX", true);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }
            });

            $('#flip_v_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    if (selected_object.get("flipY") == true)
                        selected_object.set("flipY", false);
                    else
                        selected_object.set("flipY", true)
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    if (selected_group.get("flipY") == true)
                        selected_group.set("flipY", false);
                    else
                        selected_group.set("flipY", true)
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }

            });

            $('#align_h_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.centerObjectH(selected_object);
                    wpd_editor.canvas.renderAll();
                    selected_object.setCoords();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    wpd_editor.centerObjectH(selected_group);
                    wpd_editor.canvas.renderAll();
                    selected_group.setCoords();
                    wpd_editor.save_canvas();
                }
            });

            $('#align_v_btn').doubletap(function(e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.centerObjectV(selected_object);
                    wpd_editor.canvas.renderAll();
                    selected_object.setCoords();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    wpd_editor.centerObjectV(selected_group);
                    wpd_editor.canvas.renderAll();
                    selected_group.setCoords();
                    wpd_editor.save_canvas();
                }


            });
            
            
        
        }
        else{
            
            $(document).on("click", "#undo-btn", function (e)
            {
                e.preventDefault();
                var current_data_id = $("#wpc-parts-bar > li:eq(" + wpd_editor.selected_part + ")").attr("data-id");
                if (!$(this).hasClass("disabled") && wpd_editor.canvasManipulationsPosition[current_data_id] > 0)
                {
                    wpd_editor.canvas.clear();
                    wpd_editor.canvasManipulationsPosition[current_data_id]--;
                    wpd_editor.canvas.loadFromJSON(wpd_editor.serialized_parts[current_data_id][wpd_editor.canvasManipulationsPosition[current_data_id]]);
                    wpd_editor.refresh_undo_redo_status();
                }
            });

            $(document).on("click", "#redo-btn", function (e)
            {
                e.preventDefault();
                var current_data_id = $("#wpc-parts-bar > li:eq(" + wpd_editor.selected_part + ")").attr("data-id");
                var next_index = wpd_editor.canvasManipulationsPosition[current_data_id] + 1;
                if (!$(this).hasClass("disabled") && typeof wpd_editor.serialized_parts[current_data_id][next_index] != "undefined")
                {
                    wpd_editor.canvas.clear();
                    wpd_editor.canvasManipulationsPosition[current_data_id] = next_index;
                    wpd_editor.canvas.loadFromJSON(wpd_editor.serialized_parts[current_data_id][next_index]);
                    wpd_editor.refresh_undo_redo_status();
                }
            });
            
            $(document).on("click", "#grid-btn", function (e)
            {
                $(".upper-canvas").toggleClass("wpc-canvas-grid");
            });
            $(document).on("click", "#copy_paste_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_group != null)
                {
                    var new_group = new fabric.Group();
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    var objects = canvas.getObjects();
                    $.each(objects, function (key, current_item)
                    {
                        if (selected_group.contains(current_item))
                        {
                            cloneObject(current_item, false);
                        }
                    });
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_object != null)
                {
                    wpd_editor.canvas.discardActiveObject();
                    cloneObject(selected_object, true);
                    wpd_editor.save_canvas();
                }
            });
            
            $(document).on("click", "#bring_to_front_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.canvas.bringForward(selected_object);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();

                } else if (selected_group != null)
                {
                    selected_group.forEachObject(function (a) {
                        wpd_editor.canvas.bringForward(a);
                    });
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }
            });

            $(document).on("click", "#send_to_back_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.canvas.sendBackwards(selected_object);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    selected_group.forEachObject(function (a) {
                        wpd_editor.canvas.sendBackwards(a);
                    });
                    wpd_editor.canvas.discardActiveGroup();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();

                }
            });

            $(document).on("click", "#flip_h_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    if (selected_object.get("flipX") == true)
                        selected_object.set("flipX", false);
                    else
                        selected_object.set("flipX", true);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    if (selected_group.get("flipX") == true)
                        selected_group.set("flipX", false);
                    else
                        selected_group.set("flipX", true);
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }
            });

            $(document).on("click", "#flip_v_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    if (selected_object.get("flipY") == true)
                        selected_object.set("flipY", false);
                    else
                        selected_object.set("flipY", true)
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    if (selected_group.get("flipY") == true)
                        selected_group.set("flipY", false);
                    else
                        selected_group.set("flipY", true)
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }

            });

            $(document).on("click", "#align_h_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.centerObjectH(selected_object);
                    wpd_editor.canvas.renderAll();
                    selected_object.setCoords();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    wpd_editor.centerObjectH(selected_group);
                    wpd_editor.canvas.renderAll();
                    selected_group.setCoords();
                    wpd_editor.save_canvas();
                }
            });

            $(document).on("click", "#align_v_btn", function (e)
            {
                e.preventDefault();
                var selected_object = wpd_editor.canvas.getActiveObject();
                var selected_group = wpd_editor.canvas.getActiveGroup();
                if (selected_object != null)
                {
                    wpd_editor.centerObjectV(selected_object);
                    wpd_editor.canvas.renderAll();
                    selected_object.setCoords();
                    wpd_editor.save_canvas();
                } else if (selected_group != null)
                {
                    wpd_editor.centerObjectV(selected_group);
                    wpd_editor.canvas.renderAll();
                    selected_group.setCoords();
                    wpd_editor.save_canvas();
                }


            });
            
            
            
            
        }
        
    
    

    $(document).on("click", "#clear_all_btn", function (e)
    {
        e.preventDefault();
        var is_confirmed = confirm(wpd.translated_strings.delete_all_msg);
        if (is_confirmed)
        {
            wpd_editor.canvas.clear();
            $(".wpd-edit-object").remove();
            wpd_editor.reload_background_overlay_if_needed(wpd_editor.selected_part, wpd_editor.save_canvas);
            //console.log(wpd_editor);

        }
    });

    $(document).on(" click", "#delete_btn", function (e)
    {
        e.preventDefault();
        var selected_object = wpd_editor.canvas.getActiveObject();
        var selected_group = wpd_editor.canvas.getActiveGroup();
        var is_confirmed;
        if (selected_object != null)
        {
            if (selected_object['lockDeletion']) {
                alert(wpd.translated_strings.deletion_error_msg);
            } else
            {
                is_confirmed = confirm(wpd.translated_strings.delete_msg);
                if (is_confirmed)
                {
                    wpd_editor.canvas.remove(selected_object);
                    $(".wpd-edit-object").remove(); 
                    wpd_editor.canvas.calcOffset();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }
            }
            ;
        } else if (selected_group != null)
        {
            if (selected_group['lockDeletion']) {
                alert(wpd.translated_strings.deletion_error_msg);
            } else
            {
                is_confirmed = confirm('Do you really want to delete the selected items?');
                if (is_confirmed)
                {
                    selected_group.forEachObject(function (a) {
                        wpd_editor.canvas.remove(a);
                    });
                    wpd_editor.canvas.discardActiveGroup();
                    $(".wpd-edit-object").remove(); 
                    wpd_editor.canvas.calcOffset();
                    wpd_editor.canvas.renderAll();
                    wpd_editor.save_canvas();
                }

            }
            ;
        }
    });

    

    function cloneObject(object, render_after)
    {
        var new_object = fabric.util.object.clone(object);
        new_object.set("top", new_object.top + 5);
        new_object.set("left", new_object.left + 5);
        wpd_editor.setCustomProperties(new_object);
        wpd_editor.canvas.add(new_object);
        if (render_after)
        {
            wpd_editor.canvas.renderAll();
            wpd_editor.save_canvas();
        }

    }
    });
    return wpd_editor;
}(jQuery, (WPD_EDITOR || {})))