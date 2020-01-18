/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_tagger_data, tagBox */
var gdcet_tagger;

;(function($, window, document, undefined) {
    gdcet_tagger = {
        tmp: {
            tagger: {
                done: {},
                list: {},
                apis: {}
            }
        },
        tagger: {
            init: function() {
                $(".tagsdiv").each(function() {
                    var id = $(this).attr("id"), $tts = $(this).parent(), suggests = [],
                        cls = "hide-if-no-js", cls_results = "gdcet-terms-block";

                    if ($.inArray(id, gdcet_tagger_data.taxonomies) > -1) {
                        cls+= " gdcet-with-dashicons";
                        cls_results+= " gdcet-with-dashicons";

                        $(this).next(".hide-if-no-js")
                               .after("<div id='gdcet-tagger-block' class='" + cls + "'></div>");

                        gdcet_tagger.tmp.tagger.done[id] = false;
                        gdcet_tagger.tmp.tagger.list[id] = [];
                        gdcet_tagger.tmp.tagger.apis[id] = [];

                        if (gdcet_tagger_data.clear_tags === "1") {
                            $("#gdcet-tagger-block", $tts).append('<div class="gdcet-tagger-wrap"><label class="gdcet-clear-label">' + gdcet_tagger_data.text_assigned_tags + ':</label> <a class="gdcet-tagger-clear-tags" data-taggerid="' + id + '" href="#">' + gdcet_tagger_data.text_clear_all + '</a></div>');
                        }

                        var suggest_append = '<div class="gdcet-tagger-wrap"><label class="gdcet-extract-label">' + gdcet_tagger_data.text_suggest + ':</label><div class="gdcet-tagger-engines">';

                        if (gdcet_tagger_data.suggest_internal === "1") {
                            suggests.push('<a class="gdcet-tagger-engine" data-taggerid="' + id + '" data-taggerengine="internal" href="#">' + gdcet_tagger_data.text_internal + '</a>');
                        }

                        if (gdcet_tagger_data.suggest_dandelion === "1") {
                            suggests.push('<a class="gdcet-tagger-engine" data-taggerid="' + id + '" data-taggerengine="dandelion" href="#">Dandelion</a>');
                        }

                        if (gdcet_tagger_data.suggest_opencalais === "1") {
                            suggests.push('<a class="gdcet-tagger-engine" data-taggerid="' + id + '" data-taggerengine="opencalais" href="#">OpenCalais</a>');
                        }

                        $("#gdcet-tagger-block", $tts).append(suggest_append + suggests.join("") + "</div>");

                        $("#gdcet-tagger-block", $tts).after('<div class="' + cls_results + '" id="gdcet-results-' + id + '"></div>');
                    }
                });

                gdcet_tagger.tagger.events();
            },
            events: function() {
                $(document).on("click", ".gdcet-tagger-clear-tags", function(e){
                    e.preventDefault();

                    var id = $(this).data("taggerid"), ids = [], i;

                    $("#" + id + " .tagchecklist .ntdelbutton").each(function() {
                        ids[ids.length] = $(this).attr("id");
                    });

                    for (i = 0; i < ids.length; i++) {
                        $("#" + ids[ids.length - i - 1]).click();
                    }
                });

                $(document).on("click", ".gdcet-tagger-close", function(e){
                    e.preventDefault();

                    var id = $(this).data("taggerid");

                    $("#gdcet-results-" + id).slideUp();
                });

                $(document).on("click", ".gdcet-tagger-load", function(e){
                    e.preventDefault();

                    var id = $(this).data("taggerid");

                    gdcet_tagger.tagger.load(id);
                });

                $(document).on("click", ".gdcet-tagger-addall", function(e){
                    e.preventDefault();

                    var id = $(this).data("taggerid"),
                        tagsid = "textarea#tax-input-" + id + ".the-tags",
                        tags = $(tagsid).val(), i;

                    for (i = 0; i < gdcet_tagger.tmp.tagger.list[id].length; i++) {
                        tags+= "," + gdcet_tagger.tmp.tagger.list[id][i];
                    }

                    $(tagsid).val(tags);
                    var taxbox = $("#tagsdiv-" + id + " .tagsdiv");

                    tagBox.quickClicks(taxbox);
                });

                $(document).on("click", ".gdcet-tagger-engine", function(e){
                    e.preventDefault();

                    $(this).parent().find(".gdcet-tagger-engine").removeClass("gdcet-activated");
                    $(this).addClass("gdcet-activated");

                    var id = $(this).data("taggerid"),
                        api = $(this).data("taggerengine"),
                        divid = "gdcet-results-" + id,
                        run = gdcet_tagger.tmp.tagger.apis[id] !== api;

                    gdcet_tagger.tmp.tagger.apis[id] = api;

                    if (run) {
                        gdcet_tagger.tmp.tagger.done[id] = false;
                        gdcet_tagger.tmp.tagger.list[id] = [];
                        $("#" + divid).html("");
                    }

                    if (!gdcet_tagger.tmp.tagger.done[id]) {
                        $("#" + divid).append('<div class="gdcet-terms-loader"><span class="spinner is-active"></span>' + gdcet_tagger_data.text_getting_tags + '</div>');
                        $("#" + divid).append('<div class="gdcet-terms-tags"></div>');
                        $("#" + divid).append('<div class="gdcet-terms-tasks"></div>');
                        $("#" + divid + ' .gdcet-terms-tasks').append('<a data-taggerid="' + id + '" class="gdcet-tagger-close" href="#">' + gdcet_tagger_data.text_close + '</a>');
                        $("#" + divid + ' .gdcet-terms-tasks').append('<a data-taggerid="' + id + '" class="gdcet-tagger-load" href="#">' + gdcet_tagger_data.text_refresh + '</a>');
                        $("#" + divid + ' .gdcet-terms-tasks').append('<a data-taggerid="' + id + '" class="gdcet-tagger-addall" href="#">' + gdcet_tagger_data.text_add_all + '</a>');
                        gdcet_tagger.tmp.tagger.done[id] = true;
                    }

                    $("#" + divid).show();

                    if (gdcet_tagger.tmp.tagger.list[id].length === 0) {
                        gdcet_tagger.tagger.load(id);
                    }
                });
            },
            click: function(id, tag) {
                var tagsid = "textarea#tax-input-" + id + ".the-tags",
                    taxbox = $("#tagsdiv-" + id + " .tagsdiv"),
                    tags = $(tagsid).val();

                tags+= "," + tag;
                $(tagsid).val(tags);

                tagBox.quickClicks(taxbox);
            },
            load: function(id) {
                var divid = "gdcet-results-" + id;

                $.ajax({type: "post", dataType: "json",
                    url: "admin-ajax.php?action=gdcet_tagger_search_tags&_ajax_nonce=" + gdcet_tagger_data.nonce,
                    data: {
                        content: $("#content").val(), 
                        title: $("#title").val(), 
                        url: gdcet_tagger_data.url,
                        taxonomy: id,
                        api: gdcet_tagger.tmp.tagger.apis[id]
                    },
                    beforeSend: function() {
                        $("#" + divid + " .gdcet-terms-loader").show();
                        $("#" + divid + " .gdcet-terms-tags").hide();
                        $("#" + divid + " .gdcet-terms-tasks").hide();
                    },
                    success: function(json) {
                        if (json.tags) {
                            gdcet_tagger.tmp.tagger.list[id] = json.tags;
                        }

                        $("#" + divid + " .gdcet-terms-tags").html('');

                        if (gdcet_tagger.tmp.tagger.list[id].length === 0) {
                            $("#" + divid + " .gdcet-terms-tags").html(gdcet_tagger_data.text_no_tags_found);
                        } else {
                            var i;

                            for (i = 0; i < gdcet_tagger.tmp.tagger.list[id].length; i++) {
                                var tag = '<a class="gdcet-tag-button" href="#">' + gdcet_tagger.tmp.tagger.list[id][i] + '</a> ';
                                $("#" + divid + " .gdcet-terms-tags").append(tag);
                            }
                        }

                        $("#" + divid + " .gdcet-terms-loader").hide();
                        $("#" + divid + " .gdcet-terms-tags").show();
                        $("#" + divid + " .gdcet-terms-tasks").show();

                        $("#" + divid + " .gdcet-terms-tags a").click(function() {
                            var clicked = $(this).html();
                            gdcet_tagger.tagger.click(id, clicked);
                            return false;
                        });
                    }
                });
            }
        }
    };

    gdcet_tagger.tagger.init();
})(jQuery, window, document);
