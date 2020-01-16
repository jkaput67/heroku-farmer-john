/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
var gdcet_widgets;

;(function($, window, document, undefined) {
    gdcet_widgets = {
        sortable: function() {
            $(document).on("click", "a.gdcet-tab-post-types-list", function() {
                gdcet_widgets.run($(this).closest(".d4plib-widget").find(".gdcet-post-types-list"), 'type');
            });
        },
        run: function(el, key) {
            if (!el.hasClass("gdcet-active")) {
                $(".gdcet-" + key + "s-ul", el).sortable({
                    stop: function(event, ui) {
                        ui.item.closest("form").find(".widget-control-actions input.button").click();
                    }
                });

                $(el).addClass("gdcet-active");
            }
        }
    };

    gdcet_widgets.sortable();
})(jQuery, window, document);
