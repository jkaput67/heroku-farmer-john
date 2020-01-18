/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_data_meta, gdcet_plugin_core, gdcet_data, ajaxurl, d4plib_shared, d4plib_media_image, gdcet_meta_errors_keys*/
var gdcet_plugin_meta;

;(function($, window, document, undefined) {
    gdcet_plugin_meta = {
        store: {
            type: "",
            el: null,
            next: 0
        },
        dialogs: {
            grid: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-field-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-field-confirm").wpdialog("close");

                                window.location = gdcet_plugin_core.temp.url;
                            }
                        },
                        {
                            id: "gdcet-delete-field-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-field-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-field-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-field-confirm");
            },
            box: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-field-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-element-confirm").wpdialog("close");

                                gdcet_plugin_meta.store.el.fadeOut("slow", function(){
                                    $(this).remove();

                                    gdcet_plugin_meta.boxes.update();
                                });
                            }
                        },
                        {
                            id: "gdcet-delete-field-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-element-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-element-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-element-confirm");
            },
            field: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-field-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-element-confirm").wpdialog("close");

                                gdcet_plugin_meta.store.el.fadeOut("slow", function(){
                                    $(this).remove();

                                    gdcet_plugin_meta.helpers.save_order();
                                });
                            }
                        },
                        {
                            id: "gdcet-delete-field-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-element-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-element-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-element-confirm");
            }
        },
        init: function() {
            if (gdcet_data.page === "meta-boxes") {
                gdcet_plugin_meta.store.type = $("#gdcet-meta-box-editor-type").val();

                if (gdcet_plugin_meta.store.type === "") {
                    gdcet_plugin_meta.dialogs.grid();
                    gdcet_plugin_meta.boxes.grid();
                } else {
                    gdcet_plugin_meta.dialogs.box();
                    gdcet_plugin_meta.boxes.live();
                    gdcet_plugin_meta.boxes.box();
                    
                    $(".gdcet-group-meta-field").each(function(){
                        gdcet_plugin_meta.boxes.hook($(this));
                    });
                }
            } else if (gdcet_data.page === "meta-fields") {
                gdcet_plugin_meta.store.type = $("#gdcet-meta-field-editor-type").val();

                if (gdcet_plugin_meta.store.type === "") {
                    gdcet_plugin_meta.dialogs.grid();
                    gdcet_plugin_meta.fields.grid();
                } else {
                    gdcet_plugin_meta.fields.live();

                    switch (gdcet_plugin_meta.store.type) {
                        case "simple":
                            gdcet_plugin_meta.fields.simple();
                            break;
                        case "custom":
                            gdcet_plugin_meta.dialogs.field();
                            gdcet_plugin_meta.fields.custom();
                            break;
                    }

                    $(".gdcet-group-meta-field").each(function(){
                        gdcet_plugin_meta.fields.hook($(this));
                    });
                }
            }
        },
        boxes: {
            grid: function() {
                
            },
            live: function() {
                gdcet_plugin_meta.shared.live();

                $(document).on("keyup", ".gdcet-box-property-label", function(){
                    var label = $(this).val();

                    $(this).closest(".gdcet-group-meta-field")
                           .find("h3 .gdcet-field-name")
                           .html(label);
                });
            },
            hook: function(el) {
                gdcet_plugin_meta.elements.hook_box(el);
            },
            box: function() {
                gdcet_plugin_meta.store.next = $("#gdcet-meta-box-fields-count").val();

                $("#gdcet-tool-legacy").click(function(e){
                    var has_label = $(".gdcet-field-property-basic-label").val() !== "",
                        has_slug = $(".gdcet-field-property-basic-slug").val() !== "";

                    if (!has_label || !has_slug) {
                        e.preventDefault();

                        alert(gdcet_data_meta.validation_label_slug);
                    }

                    if ($(".gdcet-meta-fields-list-wrapper > div").length === 0) {
                        e.preventDefault();

                        alert(gdcet_data_meta.validation_meta_fields);
                    }
                });

                $(".gdcet-meta-fields-control a").click(function(e){
                    e.preventDefault();

                    var item = $("#gdcet-box-meta-fields-holder .gdcet-meta-box-single-field").clone().fadeIn();

                    gdcet_plugin_meta.store.next++;

                    item.data("field", gdcet_plugin_meta.store.next);

                    $(item).find("input, select").each(function(){
                        $(this).attr("name", $(this).attr("name").replace("%id%", gdcet_plugin_meta.store.next));
                    });

                    $(".gdcet-meta-fields-list-wrapper").append(item);

                    gdcet_plugin_meta.elements.hook_box(item);

                    gdcet_plugin_meta.boxes.update();
                });

                $(".gdcet-meta-fields-list-wrapper").sortable({
                    items: ".gdcet-group-meta-field" ,
                    cursor: "move",
                    containment: ".gdcet-meta-fields-list",
                    handle: "h3.gdcet-group-sort-handler",
                    placeholder: "gdcet-field-placeholder",
                    scrollSensitivity: 32,
                    forceHelperSize: true,
                    start: function(e, ui) {
                        ui.item.addClass("gdcet-field-dragged");
                        ui.placeholder.height(ui.item.height() + 2)
                                      .width(ui.item.width());
                    },
                    stop: function(e, ui) {
                        ui.item.removeClass("gdcet-field-dragged");
                    }
                });
            },
            update: function() {
                if ($(".gdcet-meta-fields-list-wrapper > div").length > 0) {
                    $(".gdcet-meta-fields-empty").hide();
                    $(".gdcet-meta-fields-list-wrapper").show();
                } else {
                    $(".gdcet-meta-fields-empty").show();
                    $(".gdcet-meta-fields-list-wrapper").hide();
                }
            }
        },
        fields: {
            grid: function() {
                $(".gdcet-action-delete-field").click(function(e){
                    e.preventDefault();

                    gdcet_plugin_core.temp.url = $(this).attr("href");

                    $("#gdcet-dialog-delete-field-confirm").wpdialog("open");
                });
            },
            live: function() {
                $(document).on("change", ".gdcet-field-property-basic-type", function(){
                    var change_to_type = $(this).val(),
                        option = $(this).find("option:selected"),
                        icon = option.data("icon"),
                        label = option.html(),
                        wrapper = $(this).closest(".gdcet-group-meta-field"),
                        field_id = wrapper.data("field"),
                        settings = $(this).closest(".d4p-group-inner").find(".gdcet-field-block-settings"),
                        please_wait = $(this).closest(".gdcet-field-block-type").next();

                    please_wait.show();
                    settings.hide();

                    $.ajax({
                        dataType: "html", data: { id: field_id, type: change_to_type },
                        type: "POST", url: ajaxurl + "?action=gdcet-meta-change-field-type&_ajax_nonce=" + gdcet_data.nonce,
                        success: function(html) {
                            wrapper.find(".gdcet-field-icon i")
                                   .attr("class", "fa fa-" + icon)
                                   .attr("title", label);

                            please_wait.hide();
                            settings.html(html)
                                    .show();

                            gdcet_plugin_meta.elements.hook_field(settings);

                            $("html").animate({
                                scrollTop: settings.offset().top - 64
                            }, 700);
                        }
                    });
                });

                $(document).on("keyup", ".gdcet-field-property-basic-label", function(){
                    var label = $(this).val();

                    $(this).closest(".gdcet-group-meta-field")
                           .find("h3 .gdcet-field-name")
                           .html(label);
                });

                $(document).on("click", ".gdcet-list-switch-normal-edit", function(e){
                    e.preventDefault();

                    var tr = $(this).closest("tr"),
                        td = tr.find("td"),
                        th = $(this).closest("th"),
                        plain = tr.hasClass("gdcet-select-mode-plain");

                    gdcet_plugin_meta.helpers.textarea_to_items(tr, plain);

                    $(this).hide();
                    $(".gdcet-list-switch-mass-edit", th).show();
                    $(".gdcet-meta-items-wrapper-list", td).show();
                    $(".gdcet-meta-items-wrapper-textarea", td).hide();
                });

                $(document).on("click", ".gdcet-list-switch-mass-edit", function(e){
                    e.preventDefault();

                    var tr = $(this).closest("tr"),
                        td = tr.find("td"),
                        th = $(this).closest("th"),
                        plain = tr.hasClass("gdcet-select-mode-plain");

                    gdcet_plugin_meta.helpers.items_to_textarea(tr, plain);

                    $(this).hide();
                    $(".gdcet-list-switch-normal-edit", th).show();
                    $(".gdcet-meta-items-wrapper-list", td).hide();
                    $(".gdcet-meta-items-wrapper-textarea", td).show();
                });

                $(document).on("click", ".gdcet-meta-items-list .gdcet-item-ctrl .fa-plus-circle", function(){
                    var row = $(this).closest("table").find("tfoot tr").clone().fadeIn("slow"),
                        wrapper = $(this).closest("table").parent().parent(),
                        id = wrapper.find(".gdcet-list-items-counter").val();

                    id++;

                    wrapper.find(".gdcet-list-items-counter").val(id);

                    $(row).data("item", id);
                    $(row).find(".gdcet-item-default input").val(id);

                    $(row).find(".gdcet-item-data input").each(function(){
                        $(this).attr("name", $(this).attr("name").replace("%id%", id));
                    });

                    $(this).closest("tr").after(row);
                });

                $(document).on("click", ".gdcet-meta-items-list .gdcet-item-ctrl .fa-minus-circle", function(){
                    $(this).closest("tr").fadeOut(function(){
                        $(this).remove();
                    });
                });

                gdcet_plugin_meta.shared.live();
            },
            hook: function(el) {
                gdcet_plugin_meta.shared.hook(el);
                gdcet_plugin_meta.elements.hook_field(el);
            },
            simple: function() {
                $("#gdcet-tool-simple").click(function(e){
                    var has_label = $(".gdcet-field-property-basic-label").val() !== "",
                        has_slug = $(".gdcet-field-property-basic-slug").val() !== "";

                    if (!has_label || !has_slug) {
                        e.preventDefault();

                        alert(gdcet_data_meta.validation_label_slug);
                    }
                });

                if (typeof gdcet_meta_errors_keys !== "undefined") {
                    var i;

                    for (i = 0; i < gdcet_meta_errors_keys.length; i++) {
                        var name = gdcet_meta_errors_keys[i];

                        if (name !== "") {
                            $(".gdcet-field-property-" + name).closest("tr")
                                                              .addClass("d4p-settings-item-error");
                        }
                    }
                }
            },
            custom: function() {
                gdcet_plugin_meta.store.next = $("#gdcet-meta-field-fields-count").val();

                if (typeof gdcet_meta_errors_keys !== "undefined") {
                    var i;

                    for (i = 0; i < gdcet_meta_errors_keys.field.length; i++) {
                        var name = gdcet_meta_errors_keys.field[i];

                        if (name !== "") {
                            $(".gdcet-group-field-main .gdcet-field-property-" + name).closest("tr")
                                                                                      .addClass("d4p-settings-item-error");
                        }
                    }

                    $.each(gdcet_meta_errors_keys.items, function(idx, items) {
                        for (i = 0; i < items.length; i++) {
                            var name = items[i];

                            if (name !== "") {
                                $("#gdcet-field-element-" + idx + " .gdcet-field-property-" + name).closest("tr")
                                                                                                   .addClass("d4p-settings-item-error");

                                if ($("#gdcet-field-element-" + idx).hasClass("gdcet-meta-closed")) {
                                    gdcet_plugin_meta.helpers.toggle_field($("#gdcet-field-element-" + idx).find(".gdcet-field-toggler i"));
                                }
                            }
                        }
                    });
                }

                $(".gdcet-meta-fields-list-wrapper").sortable({
                    items: ".gdcet-group-meta-field" ,
                    cursor: "move",
                    containment: ".gdcet-meta-fields-list",
                    handle: "h3.gdcet-group-sort-handler",
                    placeholder: "gdcet-field-placeholder",
                    scrollSensitivity: 32,
                    forceHelperSize: true,
                    start: function(e, ui) {
                        ui.item.addClass("gdcet-field-dragged");
                        ui.placeholder.height(ui.item.height() + 2)
                                      .width(ui.item.width());
                    },
                    stop: function(e, ui) {
                        ui.item.removeClass("gdcet-field-dragged");
                    },
                    update: function(e, ui) {
                        gdcet_plugin_meta.helpers.save_order();
                    }
                });

                $(".gdcet-meta-fields-control a").click(function(e){
                    e.preventDefault();

                    gdcet_plugin_meta.store.next++;

                    $.ajax({
                        dataType: "html", data: { id: gdcet_plugin_meta.store.next },
                        type: "POST", url: ajaxurl + "?action=gdcet-meta-add-basic-field&_ajax_nonce=" + gdcet_data.nonce,
                        success: function(html) {
                            $(".gdcet-meta-fields-list-wrapper").append(html);

                            var field = $(".gdcet-group-meta-field").last();

                            gdcet_plugin_meta.fields.hook(field);

                            $("html").animate({
                                scrollTop: field.offset().top - 64
                            }, 700);
                        }
                    });
                });
            }
        },
        elements: {
            hook_box: function(el) {
                $(".gdcet-metabox-field-field-id", el).change(function(){
                    var label = $(this).find("option:selected").html();

                    $(this).closest(".gdcet-group-meta-field").find(".gdcet-field-name").html(label);
                });

                $(".gdcet-metabox-field-field-id", el).change();

                gdcet_plugin_meta.shared.hook(el);
            },
            hook_field: function(el) {
                var argsDate = {},
                    argsDateTime = {enableTime: true, enableSeconds: true, dateFormat: "Y-m-d H:i:S"},
                    argsTime = {enableTime: true, enableSeconds: true, noCalendar: true, dateFormat: "H:i:S"},
                    argsMonth = {plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: "Y-m"
                        })
                    ]};

                if (gdcet_data_meta.flatpickr_locale !== "") {
                    argsDate.locale = gdcet_data_meta.flatpickr_locale;
                    argsDateTime.locale = gdcet_data_meta.flatpickr_locale;
                    argsTime.locale = gdcet_data_meta.flatpickr_locale;
                    argsMonth.locale = gdcet_data_meta.flatpickr_locale;
                }

                $(".gdcet-datetime-date", el).flatpickr(argsDate);
                $(".gdcet-datetime-datetime", el).flatpickr(argsDateTime);
                $(".gdcet-datetime-time", el).flatpickr(argsTime);
                $(".gdcet-datetime-month", el).flatpickr(argsMonth);

                $(".gdcet-field-color", el).wpColorPicker();

                $(".gdcet-field-slug", el).limitkeypress({ rexp: /^[a-z0-9]*[a-z0-9\-\_]*[a-z0-9]*$/ });

                $(".gdcet-select-with-options", el).change(function(){
                    var wrapper = $(this).closest(".form-table"),
                        select = $(this).val(),
                        item = $(this).data("select");

                    $(".gdcet-select-" + item, wrapper).hide();
                    $(".gdcet-select-" + item + "-" + select, wrapper).show();
                });

                $(".gdcet-meta-items-list tbody", el).sortable({
                    items: ".gdcet-meta-items-list-item" ,
                    cursor: "move",
                    handle: ".gdcet-item-move",
                    placeholder: "gdcet-field-placeholder",
                    scrollSensitivity: 32,
                    forceHelperSize: true,
                    start: function(e, ui) {
                        ui.item.addClass("gdcet-field-dragged");
                        ui.placeholder.height(ui.item.height() + 2)
                                      .width(ui.item.width());
                    },
                    stop: function(e, ui) {
                        ui.item.removeClass("gdcet-field-dragged");
                    }
                });

                $(".gdcet-field-property-settings-mode", el).change(function(){
                    var item = $(this).closest(".form-table").find(".gdcet-select-source-list");

                    if ($(this).val() === "normal") {
                        item.addClass("gdcet-select-mode-plain");
                    } else {
                        item.removeClass("gdcet-select-mode-plain");
                    }
                });

                if ($(".gdcet-fontawesome-selector", el).length > 0) {
                    var wrapper = $(".gdcet-fontawesome-selector", el),
                        icon = wrapper.find(".d4p-fa-selected");

                    wrapper.find(".d4p-fa-icon").first().before(icon);

                    $(".d4p-fa-icon", wrapper).click(function(){
                        var icon = $("i", this).data("icon");

                        $(".d4p-fa-selected", wrapper).removeClass("d4p-fa-selected");

                        $(this).addClass("d4p-fa-selected");

                        wrapper.prev().val(icon);
                    });
                }
            }
        },
        shared: {
            live: function() {
                $(document).on("change", ".gdcet-field-switch-property", function(){
                    var limit = $(this).closest("tr").next();

                    if ($(this).is(":checked")) {
                        limit.show();
                    } else {
                        limit.hide();
                    }
                });

                $(document).on("click", ".gdcet-field-block-control input", function(e){
                    e.preventDefault();

                    gdcet_plugin_meta.store.el = $(this).closest(".gdcet-group-meta-field");

                    $("#gdcet-dialog-delete-element-confirm").wpdialog("open");
                });
            },
            hook: function(el) {
                $(".gdcet-field-property-basic-slug", el).limitkeypress({ rexp: /^[a-z0-9]*[a-z0-9\-\_]*[a-z0-9]*$/ });

                $(".gdcet-field-toggler i", el).click(function() {
                    gdcet_plugin_meta.helpers.toggle_field($(this));
                });

                $(".gdcet-field-move-up", el).click(function(e) {
                    e.preventDefault();

                    var field = $(this).closest(".gdcet-group-meta-field"),
                        prev = field.prev();

                    field.insertBefore(prev);
                });

                $(".gdcet-field-move-down", el).click(function(e) {
                    e.preventDefault();

                    var field = $(this).closest(".gdcet-group-meta-field"),
                        next = field.next();

                    field.insertAfter(next);
                });
            }
        },
        helpers: {
            items_to_textarea: function(tr, plain) {
                var text = $(".gdcet-meta-items-wrapper-textarea textarea", tr),
                    items = $(".gdcet-meta-items-wrapper-list table tbody tr", tr),
                    lines = "";

                items.each(function(idx, line){
                    var inputs = $("input", line),
                        value = plain ? "" : inputs[1].value,
                        label = inputs[2].value;

                    var line = (value !== "" ? value + "|" : "") + label;

                    lines+= line + "\n";
                });

                text.val(lines.trim());
            },
            textarea_to_items: function(tr, plain) {
                var text = $(".gdcet-meta-items-wrapper-textarea textarea", tr),
                    list = text[0].value.replace(/\r\n/g,"\n").split("\n"),
                    body = $(".gdcet-meta-items-wrapper-list table tbody", tr),
                    item = $(".gdcet-meta-items-wrapper-list table tfoot tr", tr), id = 0;

                body.html("");

                $.each(list, function(idx, value) {
                    value = value.trim();

                    if (value !== "") {
                        var parts = value.split("|"),
                            value = parts.length == 2 ? parts[0] : '',
                            label = parts.length == 2 ? parts[1] : parts[0],
                            row = item.clone().fadeIn("fast");

                        $(row).data("item", id);
                        $(row).find(".gdcet-item-input--value").val(value);
                        $(row).find(".gdcet-item-input--label").val(label);

                        $(row).find(".gdcet-item-default input").val(id);

                        $(row).find(".gdcet-item-data input").each(function () {
                            $(this).attr("name", $(this).attr("name").replace("%id%", id));
                        });

                        body.append(row);

                        id++;
                    }
                });

                $(".gdcet-list-items-counter", tr).val(id);
            },
            save_order: function() {
                var order = [];

                $(".gdcet-meta-fields-list-wrapper .gdcet-group-meta-field").each(function() {
                    order.push($(this).data("field"));
                });

                $("#gdcet-meta-field-fields-order").val(order.join(","));
            },
            toggle_field: function(el) {
                if ($(el).hasClass(gdcet_data_meta.toggler_open)) {
                    $(el).removeClass(gdcet_data_meta.toggler_open)
                         .addClass(gdcet_data_meta.toggler_close)
                         .closest("h3")
                         .removeClass("gdcet-group-sort-handler")
                         .closest(".gdcet-group-meta-field")
                         .removeClass("gdcet-meta-closed")
                         .addClass("gdcet-meta-opened");
                } else {
                    $(el).removeClass(gdcet_data_meta.toggler_close)
                         .addClass(gdcet_data_meta.toggler_open)
                         .closest("h3")
                         .addClass("gdcet-group-sort-handler")
                         .closest(".gdcet-group-meta-field")
                         .removeClass("gdcet-meta-opened")
                         .addClass("gdcet-meta-closed");
                }
            }
        }
    };

    gdcet_plugin_meta.init();
})(jQuery, window, document);
