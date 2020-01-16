/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_wp_data, ajaxurl, d4plib_shared, d4plib_media_image*/
var gdcet_plugin_wp;

;(function($, window, document, undefined) {
    gdcet_plugin_wp = {
        init: function() {
            gdcet_plugin_wp.basic.limited();

            if (gdcet_wp_data.hook === "nav-menus.php") {
                gdcet_plugin_wp.nav.init();
            }

            if (gdcet_wp_data.hook === "edit-tags.php") {
                gdcet_plugin_wp.tax.images.init();
            }
        },
        basic: {
            limited: function() {
                $(".gdcet-term-limited").change(function() {
                    var holder = $(this).closest(".categorydiv"), terms = [];

                    $(".gdcet-term-limited:checked", holder).each(function() {
                        terms[terms.length] = $(this).val();
                    });

                    jQuery(".gdcet_tax_input", holder).val(terms.join(", "));
                });
            }
        },
        nav: {
            init: function() {
                $("#gdtt-cpt-archives-box-submit").click(function(e) {  
                    e.preventDefault();

                    var post_types = [], 
                        spinner = $(this).parent().find(".spinner");

                    $("#gdtt-cpt-archives-list li input:checked").each(function() {
                        post_types.push(jQuery(this).val());
                    });

                    if (post_types.length > 0) {
                        spinner.css("visibility", "visible");
                        $.post(ajaxurl + "?action=gdcet-navmenus-post-type-archives&_ajax_nonce=" + gdcet_wp_data.nonce, {
                                list: post_types
                            }, function(html) {
                                $("#menu-to-edit").append(html);
                                spinner.css("visibility", "hidden");
                            }
                        );
                    }
                });
            }
        },
        tax: {
            images: {
                init: function() {
                    d4plib_media_image.init();

                    $(".gdcet-assign-term button").click(function(e){
                        e.preventDefault();

                        $(this).parent().parent().prev().click();
                    });

                    $(".gdcet-delete-term button").click(function(e){
                        e.preventDefault();

                        var img = $(this).parent().parent().prev();

                        $(this).parent().hide();

                        img.removeClass("gdcet-has-image")
                           .find("img").remove();

                        gdcet_plugin_wp.tax.images.send(img.data("taxonomy"), img.data("term"), 0);
                    });

                    $(".gdcet-term-image").click(function(){
                        d4plib_shared.active_element = $(this);
                        d4plib_media_image.open(gdcet_plugin_wp.tax.images.handler, true);
                    });
                },
                handler: function(obj) {
                    var $this = d4plib_shared.active_element;

                    $this.find("img").remove();
                    $this.next().find(".gdcet-delete-term").show();

                    $this.addClass("gdcet-has-image")
                         .prepend($("<img>", {"src": obj.url, "alt": obj.name}));

                    gdcet_plugin_wp.tax.images.send($this.data("taxonomy"), $this.data("term"), obj.id);
                },
                send: function(taxonomy, term, image) {
                    $.ajax({
                        dataType: "json", data: { taxonomy: taxonomy, term: term, image: image },
                        type: "POST", url: ajaxurl + "?action=gdcet-update-term-image&_ajax_nonce=" + gdcet_wp_data.nonce
                    });
                }
            }
        }
    };

    gdcet_plugin_wp.init();
})(jQuery, window, document);
