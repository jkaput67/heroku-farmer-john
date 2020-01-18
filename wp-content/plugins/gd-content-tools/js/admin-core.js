/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_data, ajaxurl, d4plib_shared, d4plib_media_image, gdcet_global_errors_keys*/
var gdcet_plugin_core;

;(function($, window, document, undefined) {
    gdcet_plugin_core = {
        temp: {
            url: ""
        },
        init: function() {
            if (gdcet_data.page === "tools") {
                gdcet_plugin_core.tools.init();
            }

            if (gdcet_data.page === "cpt") {
                gdcet_plugin_core.dialogs.cpt();

                gdcet_plugin_core.cpt.init();
                gdcet_plugin_core.cpt.edit();
            }

            if (gdcet_data.page === "tax") {
                gdcet_plugin_core.dialogs.tax();

                gdcet_plugin_core.tax.init();
            }
        },
        shared: {
            errors: function() {
                if (typeof gdcet_global_errors_keys !== "undefined") {
                    var i;

                    for (i = 0; i < gdcet_global_errors_keys.length; i++) {
                        var name = gdcet_global_errors_keys[i];

                        if (name !== "") {
                            $("tr.d4p-settings-item-row-" + name).addClass("d4p-settings-item-error");
                        }
                    }
                }
            },
            reorder: function(id, item, for_type) {
                if ($(id + " tbody tr." + item).length < 2) {
                    return;
                }

                $(id + " tbody").sortable({
                    items: "tr." + item,
                    cursor: "move",
                    axis: "y",
                    containment: id,
                    handle: "td.column-icon",
                    placeholder: "gdcet-row-placeholder",
                    scrollSensitivity: 32,
                    forceHelperSize: true,
                    start: function(e, ui) {
                        ui.item.addClass("gdcet-row-dragged");
                        ui.placeholder.height(ui.item.height())
                                      .width(ui.item.width());
                    },
                    stop: function(e, ui) {
                        ui.item.removeClass("gdcet-row-dragged");
                    },
                    update: function(e, ui) {
                        var order = [];

                        $(id + " tr." + item).each(function() {
                            order.push($(this).data(for_type));
                        });

                        $.ajax({
                            dataType: "html", data: { list: order, type: for_type },
                            type: "POST", url: ajaxurl + "?action=gdcet-change-objects-order&_ajax_nonce=" + gdcet_data.nonce
                        });
                    }
                });
            },
            clear_labels: function() {
                $(".gdcet-ctrl-clear-all-labels").click(function(e){
                    e.preventDefault();

                    $(".gdcet-input-text-label input").val("");
                });
            },
            show_default: function() {
                $(".gdcet-objects-default-toggler").click(function(e){
                    e.preventDefault();

                    $(this).hide().next().slideDown(300);
                });
            }
        },
        dialogs: {
            classes: function(extra) {
                var cls = "wp-dialog d4p-dialog gdcet-modal-dialog";

                if (extra !== "") {
                    cls+= " " + extra;
                }

                return cls;
            },
            defaults: function() {
                return {
                    width: 480,
                    height: "auto",
                    minHeight: 24,
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    closeOnEscape: false,
                    zIndex: 300000,
                    open: function() {
                        $(".gdcet-button-focus").focus();
                    }
                };
            },
            icons: function(id) {
                $(id).next().find(".ui-dialog-buttonset button").each(function(){
                    var icon = $(this).data("icon");

                    if (icon !== "") {
                        $(this).find("span.ui-button-text").prepend(gdcet_data["button_icon_" + icon]);
                    }
                });
            },
            cpt: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-cpt-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-cpt-confirm").wpdialog("close");

                                window.location = gdcet_plugin_core.temp.url;
                            }
                        },
                        {
                            id: "gdcet-delete-cpt-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-cpt-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-cpt-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-cpt-confirm");
            },
            tax: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-tax-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-tax-confirm").wpdialog("close");

                                window.location = gdcet_plugin_core.temp.url;
                            }
                        },
                        {
                            id: "gdcet-delete-tax-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-tax-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-tax-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-tax-confirm");
            }
        },
        tax: {
            init: function() {
                gdcet_plugin_core.shared.errors();
                gdcet_plugin_core.shared.clear_labels();
                gdcet_plugin_core.shared.show_default();
                gdcet_plugin_core.shared.reorder(".gdcet-grid-tax", "gdcet-row-custom-taxonomy", "tax");

                $(".gdcet-action-delete-tax").click(function(e){
                    e.preventDefault();

                    gdcet_plugin_core.temp.url = $(this).attr("href");

                    $("#gdcet-dialog-delete-tax-confirm").wpdialog("open");
                });
            }
        },
        cpt: {
            init: function() {
                gdcet_plugin_core.shared.errors();
                gdcet_plugin_core.shared.clear_labels();
                gdcet_plugin_core.shared.show_default();
                gdcet_plugin_core.shared.reorder(".gdcet-grid-cpt", "gdcet-row-custom-post-type", "cpt");

                $(".gdcet-action-delete-cpt").click(function(e){
                    e.preventDefault();

                    gdcet_plugin_core.temp.url = $(this).attr("href");

                    $("#gdcet-dialog-delete-cpt-confirm").wpdialog("open");
                });
            },
            edit: function() {
                $(".gdcet-cpt-icon-type select").change(function(){
                    var type = $(this).val();

                    $(".gdcet-cpt-icon").addClass("gdcet-wrap-icon-hide");
                    $(".gdcet-cpt-icon-" + type).removeClass("gdcet-wrap-icon-hide");
                });

                $(".gdcet-permalink-example").change(function(){
                    var rule = $(this).val();

                    $("#gdcetcpt_settings__permalinks_single_structure").val(rule);
                });
            }
        },
        tools: {
            init: function() {
                if (gdcet_data.panel === "export") {
                    gdcet_plugin_core.tools.export();
                }
            },
            export: function() {
                $("#gdcet-tool-export").click(function(e){
                    e.preventDefault();

                    window.location = $("#gdcet-export-url").val();
                });
            }
        }
    };

    gdcet_plugin_core.init();
})(jQuery, window, document);
