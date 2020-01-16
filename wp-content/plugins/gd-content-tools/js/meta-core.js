/*jslint regexp: true, nomen: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */
/*global gdcet_metadata, wp, google */
var gdcet_meta, gdcet_gmap, gdcet_meta_file;

;(function($, window, document, undefined) {
    gdcet_meta_file = {
        handler: null,
        init: function() {
            if (wp && wp.media) {
                if (typeof wp.media.frames.gdcet_meta_image_frame === "undefined") {
                    wp.media.frames.gdcet_meta_image_frame = new wp.media.view.MediaFrame.Select({
                        title: gdcet_metadata.string_image_title,
                        className: "media-frame gdcet-imagefile-image-frame",
                        multiple: false,
                        library: {
                            type: "image"
                        },
                        button: {
                            text: gdcet_metadata.string_image_button
                        }
                    });

                    wp.media.frames.gdcet_meta_image_frame.on("select", function() {
                        var image = wp.media.frames.gdcet_meta_image_frame.state().get("selection").first().toJSON();

                        if (gdcet_meta_file.handler) {
                            gdcet_meta_file.handler(image);
                        }
                    });
                }

                if (typeof wp.media.frames.gdcet_meta_file_frame === "undefined") {
                    wp.media.frames.gdcet_meta_file_frame = new wp.media.view.MediaFrame.Select({
                        title: gdcet_metadata.string_file_title,
                        className: "media-frame gdcet-imagefile-file-frame",
                        multiple: false,
                        button: {
                            text: gdcet_metadata.string_file_button
                        }
                    });

                    wp.media.frames.gdcet_meta_file_frame.on("select", function() {
                        var file = wp.media.frames.gdcet_meta_file_frame.state().get("selection").first().toJSON();

                        if (gdcet_meta_file.handler) {
                            gdcet_meta_file.handler(file);
                        }
                    });
                }
            }
        },
        open_image: function(handler) {
            gdcet_meta_file.handler = handler;

            wp.media.frames.gdcet_meta_image_frame.open();
        },
        open_file: function(handler) {
            gdcet_meta_file.handler = handler;

            wp.media.frames.gdcet_meta_file_frame.open();
        }
    };

    gdcet_meta = {
        active_element: null,
        datetime: ".gdcet-control-datetime, .gdcet-control-date, .gdcet-control-time, .gdcet-control-month",
        init: function() {
            gdcet_meta_file.init();

            gdcet_meta.tabs();
            gdcet_meta.live();

            gdcet_meta.validator.init();
            gdcet_meta.repeater.live();

            $(".gdcet-field-inner-field, .gdcet-field-type-simple").each(function(){
                gdcet_meta.fields.prepare($(this));
            });
        },
        live: function() {
            $(document).on("click", ".gdcet-control-multiple:not(.gdcet-control-select-enhanced) option", function(){
                var select = $(this).closest(".gdcet-control-multiple"), 
                    limit = select.data("maximum-selection-length");

                if (limit > 0) {
                    if ($("option:selected", select).length > limit) {
                        $(this).removeAttr("selected");
                    }
                }
            });

            $(document).on("click", ".gdcet-block-check-uncheck a", function(e){
                e.preventDefault();

                var checkall = $(this).attr("href").substr(1) === "checkall";

                $(this).parent().parent().find("input[type=checkbox]").prop("checked", checkall);
            });

            $(document).on("click", ".gdcet-button.gdcet-imagefile-preview", function(e){
                e.preventDefault();

                $(this).closest(".gdcet-imagefile-wrapper").find("img").slideToggle(function(){
                    if ($(this).is(":visible")) {
                        $(this).css("display", "block");
                    }
                });
            });

            $(document).on("click", ".gdcet-button.gdcet-imagefile-add", function(e){
                e.preventDefault();

                gdcet_meta.active_element = $(this).closest(".gdcet-imagefile-wrapper");
                gdcet_meta_file.open_image(gdcet_meta.files.image);
            });

            $(document).on("click", ".gdcet-button.gdcet-imagefile-add-file", function(e){
                e.preventDefault();

                gdcet_meta.active_element = $(this).closest(".gdcet-imagefile-wrapper");
                gdcet_meta_file.open_file(gdcet_meta.files.file);
            });

            $(document).on("click", ".gdcet-button.gdcet-imagefile-clear", function(e){
                e.preventDefault();

                if (confirm(gdcet_metadata.string_are_you_sure)) {
                    var wrapper = $(this).closest(".gdcet-imagefile-wrapper");

                    wrapper.find("input").val("0");
                    wrapper.find("img").attr("src", "").hide();
                    wrapper.find(".gdcet-imagefile-title").html(gdcet_metadata.string_image_not_selected);
                    wrapper.find(".gdcet-imagefile-preview, .gdcet-imagefile-clear").hide();
                }
            });
        },
        files: {
            image: function(obj) {
                gdcet_meta.files.file(obj);

                var wrapper = gdcet_meta.active_element;

                $("img", wrapper).attr("src", obj.url).hide();
            },
            file: function(obj) {
                var wrapper = gdcet_meta.active_element;

                $("input", wrapper).val(obj.id);
                $(".gdcet-imagefile-title", wrapper).html("(" + obj.id + ") " + obj.name);

                $(".gdcet-imagefile-preview, .gdcet-imagefile-clear", wrapper).show();
            }
        },
        tabs: function() {
            $(".gdcet-render-metabox-tabs-wrapper .wp-tab-bar a").click(function(e){
                e.preventDefault();

                var tab = $(this).attr("href").substr(1);

                $(this).closest("ul").find("li").removeClass("wp-tab-active");
                $(this).parent().addClass("wp-tab-active");

                $(this).closest(".gdcet-render-metabox-tabs-wrapper").find(".wp-tab-panel")
                                                          .removeClass("tabs-panel-active")
                                                          .addClass("tabs-panel-inactive");
                $(this).closest(".gdcet-render-metabox-tabs-wrapper").find("#" + tab)
                                                          .removeClass("tabs-panel-inactive")
                                                          .addClass("tabs-panel-active");
            });
        },
        fields: {
            prepare: function(el) {
                $(".gdcet-control-color", el).wpColorPicker();

                $(".gdcet-control-slug", el).limitkeypress({ rexp: /^[a-z0-9]*[a-z0-9\-\_]*[a-z0-9]*$/ });

                $(".gdcet-control-text.gdcet-input-regexed", el).each(function(){
                    var ctrl = $(this),
                        regex = ctrl.data("gdcet-regex");

                    ctrl.limitkeypress({ rexp: gdcet_help.regexp_from_string(regex) });
                });

                $(".gdcet-control-text.gdcet-input-masked", el).each(function(){
                    var ctrl = $(this),
                        mask = ctrl.data("gdcet-mask");

                    ctrl.mask(mask);
                });

                if ($(".gdcet-fontawesome-selector", el).length > 0) {
                    $(".gdcet-fontawesome-selector", el).each(function(){
                        var item = $(this);

                        gdcet_meta.fields.fontawesome(item);
                    });
                }

                if ($(gdcet_meta.datetime, el).length > 0) {
                    gdcet_meta.fields.datetime(el);
                }

                if ($(".gdcet-gmap-wrapper", el).length > 0) {
                    gdcet_gmap.load(el);
                }

                if ($(".gdcet-content-select-wrapper", el).length > 0) {
                    $(".gdcet-content-select-wrapper", el).each(function(){
                        var item = $(this);

                        gdcet_wp.load(item);
                        gdcet_wp.call(item);
                    });
                }

                if ($(".gdcet-control-wpsource-enhanced.gdcet-enhanced-select2", el).length > 0) {
                    gdcet_meta.fields.wp(el);
                }

                if ($(".gdcet-control-select-enhanced.gdcet-enhanced-select2", el).length > 0) {
                    gdcet_meta.fields.select(el);
                }
            },
            datetime: function(el) {
                var argsDate = {},
                    argsDateTime = {enableTime: true, enableSeconds: true, dateFormat: "Y-m-d H:i:S"},
                    argsTime = {enableTime: true, enableSeconds: true, noCalendar: true, dateFormat: "H:i:S"},
                    argsMonth = {plugins: [
                        new monthSelectPlugin({
                            shorthand: true,
                            dateFormat: "Y-m"
                        })
                    ]};

                if (gdcet_metadata.flatpickr_locale !== "") {
                    argsDate.locale = gdcet_metadata.flatpickr_locale;
                    argsDateTime.locale = gdcet_metadata.flatpickr_locale;
                    argsTime.locale = gdcet_metadata.flatpickr_locale;
                    argsMonth.locale = gdcet_metadata.flatpickr_locale;
                }

                $(".gdcet-control-date", el).flatpickr(argsDate);
                $(".gdcet-control-datetime", el).flatpickr(argsDateTime);
                $(".gdcet-control-time", el).flatpickr(argsTime);
                $(".gdcet-control-month", el).flatpickr(argsMonth);
            },
            fontawesome: function(wrapper) {
                var icon = wrapper.find(".d4p-fa-selected");

                wrapper.find(".d4p-fa-icon").first().before(icon);

                $(".d4p-fa-icon", wrapper).click(function(){
                    var icon = $("i", this).data("icon");

                    $(".d4p-fa-selected", wrapper).removeClass("d4p-fa-selected");

                    $(this).addClass("d4p-fa-selected");

                    wrapper.prev().val(icon);
                });
            },
            select: function(el) {
                var args = {
                    width: '100%',
                    closeOnSelect: false
                };

                if (gdcet_metadata.select2_locale !== "") {
                    args.language = gdcet_metadata.select2_locale;
                }

                $(".gdcet-control-select-enhanced.gdcet-enhanced-select2:not(.gdcet-control-get-remote)", el).select2(args);

                $(".gdcet-control-select-enhanced.gdcet-enhanced-select2.gdcet-control-get-remote", el).each(function(){
                    var remote = $(this).data("remote"),
                        metabox = $(this).closest(".gdcet-render-metabox-wrapper"),
                        argsRemote = {
                            width: '100%',
                            closeOnSelect: false,
                            ajax: {
                                url: gdcet_metadata.ajax + "?action=gdcet-metabox-select-remote",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        metabox: metabox.data("metabox"),
                                        nonce: metabox.data("nonce"),
                                        type: metabox.data("type"),
                                        name: metabox.data("name"),
                                        id: metabox.data("id"),
                                        q: params.term,
                                        call: remote,
                                        page: params.page || 1,
                                        pager: 50
                                    };
                                },
                                processResults: function (data, params) {
                                    params.page = params.page || 1;

                                    return {
                                        results: data.items,
                                        pagination: {
                                            more: (params.page * 25) < data.total_count
                                        }
                                    };
                                },
                                minimumInputLength: 1,
                                cache: true
                            }
                        };

                    if (gdcet_metadata.select2_locale !== "") {
                        argsRemote.language = gdcet_metadata.select2_locale;
                    }

                    $(this).select2(argsRemote);
                });
            },
            wp: function(el) {
                $(".gdcet-control-wpsource-enhanced.gdcet-enhanced-select2", el).each(function(){
                    var select = $(this),
                        metabox = $(this).closest(".gdcet-render-metabox-wrapper"),
                        args = {
                            width: '100%',
                            closeOnSelect: false,
                            ajax: {
                                url: gdcet_metadata.ajax + "?action=gdcet-metabox-wp-search-enhanced",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        metabox: metabox.data("metabox"),
                                        nonce: metabox.data("nonce"),
                                        type: metabox.data("type"),
                                        name: metabox.data("name"),
                                        id: metabox.data("id"),
                                        keyword: params.term,
                                        method: select.data("wp"),
                                        filter: select.data("filter"),
                                        attr: select.data("attr"),
                                        page: params.page || 1,
                                        pager: 50
                                    };
                                },
                                processResults: function (data, params) {
                                    params.page = params.page || 1;

                                    return {
                                        results: data.items,
                                        pagination: {
                                            more: (params.page * 25) < data.total_count
                                        }
                                    };
                                },
                                minimumInputLength: 1,
                                cache: true
                            }
                        };

                    if (gdcet_metadata.select2_locale !== "") {
                        args.language = gdcet_metadata.select2_locale;
                    }

                    $(this).select2(args);
                });
            }
        },
        repeater: {
            live: function() {
                $(document).on("click", "i." + gdcet_metadata.toggler_open + ", i." + gdcet_metadata.toggler_close, function(){
                    if ($(this).hasClass(gdcet_metadata.toggler_open)) {
                        $(this).removeClass(gdcet_metadata.toggler_open)
                               .addClass(gdcet_metadata.toggler_close)
                               .closest(".gdcet-field-repeater")
                               .removeClass("gdcet-field-repeater-open");
                    } else {
                        $(this).removeClass(gdcet_metadata.toggler_close)
                               .addClass(gdcet_metadata.toggler_open)
                               .closest(".gdcet-field-repeater")
                               .addClass("gdcet-field-repeater-open");
                    }
                });

                $(document).on("click", "i." + gdcet_metadata.repeater_minus, function(){
                    var current = $(this),
                        repeater = current.closest(".gdcet-field-repeater"),
                        wrapper = current.closest(".gdcet-field-input-wrapper");

                    repeater.remove();
                    wrapper.removeClass("gdcet-field-repeater-closed");
                });

                $(document).on("click", "i." + gdcet_metadata.repeater_up, function(){
                    var repeater = $(this).closest(".gdcet-field-repeater"),
                        prev = repeater.prev();

                    repeater.insertBefore(prev);
                });

                $(document).on("click", "i." + gdcet_metadata.repeater_down, function(){
                    var repeater = $(this).closest(".gdcet-field-repeater"),
                        next = repeater.next();

                    repeater.insertAfter(next);
                });

                $(document).on("click", "i." + gdcet_metadata.repeater_plus, function(){
                    var current = $(this),
                        wrapper = current.closest(".gdcet-field-input-wrapper"),
                        metabox = current.closest(".gdcet-render-metabox-wrapper"),
                        repeater = current.closest(".gdcet-field-repeater"),
                        repeat = {
                            metabox: metabox.data("metabox"),
                            nonce: metabox.data("nonce"),
                            type: metabox.data("type"),
                            name: metabox.data("name"),
                            id: metabox.data("id"),

                            field: wrapper.data("field"),
                            index: wrapper.data("next-index"),

                            inner: "",
                            parent: 0
                        };

                    if (wrapper.hasClass("gdcet-field-inner-field")) {
                        repeat.inner = wrapper.data("inner");
                        repeat.parent = wrapper.data("parent");
                    }

                    $.ajax({
                        dataType: "json", data: repeat, type: "POST", 
                        url: gdcet_metadata.ajax + "?action=gdcet-metabox-repeater-field",
                        success: function(json) {
                            repeater.find(".dashicons-arrow-up").click();
                            repeater.after(json.html);

                            if ($(json.html).find(".gdcet_meta_fields_do_wpeditor").length > 0) {
                                var data = JSON.parse($(json.html).find("script").html());

                                wp.editor.initialize(data.gdcet_id, data);
                            }

                            wrapper.data("next-index", json.index);

                            var item = repeater.next();

                            gdcet_meta.fields.prepare(item);

                            if ($(".gdcet-field-repeater", wrapper).length === wrapper.data("limit")) {
                                wrapper.addClass("gdcet-field-repeater-closed");
                            }
                        }
                    });
                });
            }
        },
        validator: {
            init: function() {
                if ($(".gdcet-render-metabox-wrapper").length > 0) {
                    if (gdcet_metadata.is_post_edit === "yes") {
                        $("#post").submit(gdcet_meta.validator.handler);
                    }

                    if (gdcet_metadata.is_term_edit === "yes") {
                        $("#edittag").submit(gdcet_meta.validator.handler);
                    }

                    if (gdcet_metadata.is_user_edit === "yes") {
                        $("#your-profile").submit(gdcet_meta.validator.handler);
                    }
                }
            },
            handler: function() {
                var submit = true, move = false;

                $(".gdcet-render-metabox-wrapper").each(function(){
                    var el = $(this);

                    $(".gdcet-render-metabox-field-required", el).each(function(){
                        var ef = $(this);

                        ef.removeClass("gdcet-required-failed");

                        if ($(".gdcet-control-required", ef).length > 0) {
                            var item_ok = false;

                            $(".gdcet-control-required.gdcet-required-textual", ef).each(function(){
                                if ($(this).val() !== "") {
                                    item_ok = true;
                                }
                            });

                            $(".gdcet-control-required.gdcet-required-numerical", ef).each(function(){
                                if ($(this).val() !== "") {
                                    item_ok = true;
                                }
                            });

                            $(".gdcet-control-required.gdcet-required-id", ef).each(function(){
                                if ($(this).val() !== "" && parseInt($(this).val()) > 0) {
                                    item_ok = true;
                                }
                            });

                            if (item_ok === false) {
                                if (move === false) {
                                    move = ef;
                                }

                                ef.addClass("gdcet-required-failed");
                                submit = false;
                            }
                        }
                    });
                });

                if (move !== false) {
                    var bar = 0;

                    if ($("#wpadminbar").length === 1) {
                        bar = $("#wpadminbar").height();
                    }

                    $("html, body").animate({
                        scrollTop: move.offset().top - bar
                    }, 1000);
                }

                return submit;
            }
        }
    };

    gdcet_gmap = {
        load: function(el) {
            $(".gdcet-gmap-wrapper", el).each(function(){
                var wrap = $(this), 
                    settings = JSON.parse($(".gdcet-gmap-settings", wrap).html()),
                    latlng = [settings.latitude, settings.longitude];

                var map = $(settings.id)
                    .gmap3({
                        center: latlng,
                        zoom: settings.zoom,
                        streetViewControl: false
                    })
                    .on({
                        click: function(map, event) {
                            this.get(1).setPosition(event.latLng);
                            this.get(2).setPosition(event.latLng);

                            $(".gdcet-gmap-settings-latitude", wrap).val(event.latLng.lat());
                            $(".gdcet-gmap-settings-longitude", wrap).val(event.latLng.lng());
                        }
                    })
                    .marker({
                        position: latlng,
                        draggable: true
                    })
                    .on({
                        dragend: function(marker, event) {
                            $(".gdcet-gmap-settings-latitude", wrap).val(marker.position.lat());
                            $(".gdcet-gmap-settings-longitude", wrap).val(marker.position.lng());
                        }
                    })
                    .infowindow({
                        position: latlng,
                        content: settings.note
                    })
                    .then(function(infowindow) {
                        infowindow.open(this.get(0), this.get(1));
                    });

                $(".gdcet-gmap-settings-latitude, .gdcet-gmap-settings-longitude", wrap).keyup(function(){
                    var loc = parseFloat($(this).val()), newPos,
                        _map = map.get(0), _marker = map.get(1), _info = map.get(2),
                        latLng = _marker.getPosition();

                    if ($(this).hasClass("gdcet-gmap-settings-latitude")) {
                        newPos = new google.maps.LatLng({lat: loc, lng: latLng.lng()});
                    } else {
                        newPos = new google.maps.LatLng({lat: latLng.lat(), lng: loc});
                    }

                    _map.setCenter(newPos);
                    _marker.setPosition(newPos);
                    _info.setPosition(newPos);
                });

                $(".gdcet-gmap-settings-note", wrap).keyup(function(){
                    var note = $(this).val(), _info = map.get(2);

                    _info.setContent(note);
                });
            });
        }
    };

    gdcet_wp = {
        load: function(el) {
            $(".gdcet-search", el).keyup(function(){
                gdcet_wp.call(el);
            });
        },
        call: function(el) {
            var metabox = el.closest(".gdcet-render-metabox-wrapper"),
                search = {
                    metabox: metabox.data("metabox"),
                    nonce: metabox.data("nonce"),
                    type: metabox.data("type"),
                    name: metabox.data("name"),
                    id: metabox.data("id"),

                    method: el.data("wp"),
                    keyword: el.find(".gdcet-search").val(),
                    filter: el.data("filter"),
                    attr: el.data("attr")
                };

            $.ajax({
                dataType: "json",  type: "POST", data: search, 
                url: gdcet_metadata.ajax + "?action=gdcet-metabox-wp-search",
                success: function(json) {
                    var render = "<ul>" + json.items.join("") + "</ul>";

                    el.find(".gdcet-content-results ul").remove();
                    el.find(".gdcet-content-results").append(render);

                    gdcet_wp.prepare(el);
                }
            });
        },
        prepare: function(el) {
            $(".gdcet-content-results ul li", el).click(function(){
                var html = $(this)[0].outerHTML,
                    item = $(this).data("item") + "",
                    items = $(".gdcet-selected-items", el).val().split(",");

                if ($.inArray(item, items) === -1) {
                    items.push(item);

                    $(".gdcet-selected-items", el).val(items.join(","));
                    $(".gdcet-content-selected ul", el).append(html);
                }
            });

            $(document).on("click", ".gdcet-content-selected li span", function(){
                var item = $(this).closest("li").data("item") + "",
                    items = $(".gdcet-selected-items", el).val().split(",");

                items = gdcet_help.remove_from_array(items, item);
                $(".gdcet-selected-items", el).val(items.join(","));

                $(this).closest("li").remove();
            });
        }
    };

    gdcet_help = {
        regexp_from_string: function(input) {
            var flags = input.replace(/.*\/([gimy]*)$/, '$1');
            var pattern = input.replace(new RegExp('^/(.*?)/' + flags + '$'), '$1');

            return new RegExp(pattern, flags);
        },
        remove_from_array: function(arr, val) {
            var idx = arr.indexOf(val);

            if (idx > -1) {
                arr.splice(idx, 1);
            }

            return arr;
        }
    };

    gdcet_meta.init();
})(jQuery, window, document);
