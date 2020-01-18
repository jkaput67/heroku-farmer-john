/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_plugin_core, gdcet_data */
var gdcet_bbpress;

;(function($, window, document, undefined) {
    gdcet_bbpress = {
        bbpress: {
            init: function() {
                $(".gdcet-bbpress-forums-scope select").change(function(){
                    if ($(this).val() === "forums") {
                        $(".gdcet-bbpress-forums-list").removeClass("gdcet-hide");
                    } else {
                        $(".gdcet-bbpress-forums-list").addClass("gdcet-hide");
                    }
                });

                $(".gdcet-action-delete-bbpress").click(function(e){
                    e.preventDefault();

                    gdcet_plugin_core.temp.url = $(this).attr("href");

                    $("#gdcet-dialog-delete-bbpress-confirm").wpdialog("open");
                });
            },
            dialogs: function() {
                var dlg_delete_confirm = $.extend({}, gdcet_plugin_core.dialogs.defaults(), {
                    width: 640,
                    dialogClass: gdcet_plugin_core.dialogs.classes("gdcet-dialog-hidex"),
                    buttons: [
                        {
                            id: "gdcet-delete-bbpress-delete",
                            class: "gdcet-dialog-button-delete",
                            text: gdcet_data.dialog_button_delete,
                            data: { icon: "delete" },
                            click: function() {
                                $("#gdcet-dialog-delete-bbpress-confirm").wpdialog("close");

                                window.location = gdcet_plugin_core.temp.url;
                            }
                        },
                        {
                            id: "gdcet-delete-bbpress-cancel",
                            class: "gdcet-dialog-button-cancel gdcet-button-focus",
                            text: gdcet_data.dialog_button_cancel,
                            data: { icon: "cancel" },
                            click: function() {
                                $("#gdcet-dialog-delete-bbpress-confirm").wpdialog("close");
                            }
                        }
                    ]
                });

                $("#gdcet-dialog-delete-bbpress-confirm").wpdialog(dlg_delete_confirm);

                gdcet_plugin_core.dialogs.icons("#gdcet-dialog-delete-bbpress-confirm");
            }
        }
    };

    gdcet_bbpress.bbpress.dialogs();
    gdcet_bbpress.bbpress.init();
})(jQuery, window, document);
