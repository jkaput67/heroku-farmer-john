/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_plugin_core, gdcet_data, gdcet_meta */
var gdcet_meta_bbpress;

;(function($, window, document, undefined) {
    gdcet_meta_bbpress = {
        init: function() {
            gdcet_meta_bbpress.validation();
        },
        validation: function() {
            if ($(".gdcet-render-metabox-wrapper").length > 0) {
                $("#new-post").submit(gdcet_meta.validator.handler);
            }
        }
    };

    gdcet_meta_bbpress.init();
})(jQuery, window, document);
