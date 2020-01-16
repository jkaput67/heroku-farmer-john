/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
var gdcet_front_gmap;

;(function($, window, document, undefined) {
    gdcet_front_gmap = {
        init: function() {
            $(".gdcet-gmap-wrapper").each(function(){
                var wrap = $(this), 
                    container = $(".gdcet-gmap-container", wrap),
                    settings = JSON.parse($(".gdcet-gmap-settings", wrap).html()),
                    latlng = [settings.latitude, settings.longitude];

                var map = container
                    .gmap3({
                        center: latlng,
                        zoom: settings.zoom,
                        streetViewControl: false
                    })
                    .marker({
                        position: latlng,
                        draggable: true
                    })
                    .infowindow({
                        position: latlng,
                        content: settings.note
                    })
                    .then(function(infowindow) {
                        infowindow.open(this.get(0), this.get(1));
                    });
            });
        }
    };

    gdcet_front_gmap.init();
})(jQuery, window, document);
