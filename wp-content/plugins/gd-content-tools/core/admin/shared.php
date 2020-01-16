<?php

if (!defined('ABSPATH')) exit;

class gdcet_admin_shared_data {
    public static function get_list_of_post_types_menu_positions() {
        return array(
            '__auto__' => __("Default / Auto", "gd-content-tools"),
            '__block__' => __("New menu items block", "gd-content-tools"),
            5 => __("Below Posts", "gd-content-tools"),
            10 => __("Below Media", "gd-content-tools"),
            15 => __("Below Links", "gd-content-tools"),
            20 => __("Below Pages", "gd-content-tools"),
            25 => __("Below Comments", "gd-content-tools"),
            60 => __("Below First separator", "gd-content-tools"),
            65 => __("Below Plugins", "gd-content-tools"),
            70 => __("Below Users", "gd-content-tools"),
            75 => __("Below Tools", "gd-content-tools"),
            80 => __("Below Settings", "gd-content-tools"),
            100 => __("Below Second separator", "gd-content-tools")
        );
    }

    public static function get_list_of_taxonomy_meta_box() {
        return array(
            'auto' => __("Automatic / Default", "gd-content-tools"),
            'hide' => __("Hidden", "gd-content-tools"),
            'limited_single' => __("Limited: Single Term", "gd-content-tools"),
            'limited_multi' => __("Limited: Multi Terms", "gd-content-tools")
        );
    }

    public static function get_list_of_taxonomy_visibility() {
        return array(
            'show_ui' => __("Show UI", "gd-content-tools"),
            'show_in_menu' => __("Show in Menu", "gd-content-tools"),
            'show_in_nav_menus' => __("Show in NavMenus", "gd-content-tools"),
            'show_admin_column' => __("Show Admin Column", "gd-content-tools"),
            'show_tagcloud' => __("Show Tagcloud", "gd-content-tools"),
            'show_in_quick_edit' => __("Show In Quick Edit", "gd-content-tools"),
            'publicly_queryable' => __("Publicly Queryable", "gd-content-tools")
        );
    }

    public static function get_list_of_post_type_visibility() {
        return array(
            'exclude_from_search' => __("Exclude from Search", "gd-content-tools"),
            'publicly_queryable' => __("Publicly Queryable", "gd-content-tools"),
            'show_ui' => __("Show UI", "gd-content-tools"),
            'show_in_nav_menus' => __("Show in NavMenus", "gd-content-tools"),
            'show_in_menu' => __("Show in Menu", "gd-content-tools"),
            'show_in_admin_bar' => __("Show in Admin Bar", "gd-content-tools")
        );
    }

    public static function get_list_of_post_types_supports() {
        return array(
            'title' => __("Title", "gd-content-tools"),
            'editor' => __("Editor", "gd-content-tools"),
            'author' => __("Author", "gd-content-tools"),
            'thumbnail' => __("Featured image", "gd-content-tools"),
            'excerpt' => __("Excerpt", "gd-content-tools"),
            'trackbacks' => __("Trackbacks", "gd-content-tools"),
            'custom-fields' => __("Custom Fields", "gd-content-tools"),
            'comments' => __("Comments", "gd-content-tools"),
            'revisions' => __("Revisions", "gd-content-tools"),
            'page-attributes' => __("Page Attributes", "gd-content-tools"),
            'post-formats'=> __("Post Formats", "gd-content-tools")
        );
    }

    public static function get_list_of_post_type_icons() {
        return array(
            'dashicon' => __("Dashicon", "gd-content-tools"),
            'sprite' => __("Sprite", "gd-content-tools"),
            'url' => __("URL", "gd-content-tools"),
            'image' => __("Select Image", "gd-content-tools"),
            'embed' => __("Embed", "gd-content-tools")
        );
    }

    public static function get_list_of_capabilities_types() {
        return array(
            'type' => __("Capability Type", "gd-content-tools"),
            'caps' => __("Custom Capabilities", "gd-content-tools")
        );
    }

    public static function get_list_of_editors() {
        return array(
            'default' => __("Block Editor", "gd-content-tools"),
            'classic' => __("Classic Editor", "gd-content-tools")
        );
    }

    public static function get_list_of_taxonomies() {
        global $wp_taxonomies;

        $list = array();

        foreach ($wp_taxonomies as $tax => $object) {
            $list[$tax] = $object->label.' <span style="font-style: italic">['.$tax.']</span>';
        }

        return $list;
    }

    public static function get_list_of_post_types() {
        global $wp_post_types;

        $list = array();

        foreach ($wp_post_types as $cpt => $object) {
            $list[$cpt] = $object->label.' <span style="font-style: italic">['.$cpt.']</span>';
        }

        return $list;
    }

    public static function get_list_of_dashicons() {
        $icons = array('menu', 'admin-site', 'dashboard', 'admin-media', 'admin-page', 'admin-comments', 'admin-appearance', 'admin-plugins', 'admin-users', 'admin-tools', 'admin-settings', 'admin-network', 'admin-generic', 'admin-home', 'admin-collapse', 'filter', 'admin-customizer', 'admin-multisite', 'admin-links', 'format-links', 'admin-post', 'format-standard', 'format-image', 'format-gallery', 'format-audio', 'format-video', 'format-chat', 'format-status', 'format-aside', 'format-quote', 'welcome-write-blog', 'welcome-edit-page', 'welcome-add-page', 'welcome-view-site', 'welcome-widgets-menus', 'welcome-comments', 'welcome-learn-more', 'image-crop', 'image-rotate', 'image-rotate-left', 'image-rotate-right', 'image-flip-vertical', 'image-flip-horizontal', 'image-filter', 'undo', 'redo', 'editor-bold', 'editor-italic', 'editor-ul', 'editor-ol', 'editor-quote', 'editor-alignleft', 'editor-aligncenter', 'editor-alignright', 'editor-insertmore', 'editor-spellcheck', 'editor-distractionfree', 'editor-expand', 'editor-contract', 'editor-kitchensink', 'editor-underline', 'editor-justify', 'editor-textcolor', 'editor-paste-word', 'editor-paste-text', 'editor-removeformatting', 'editor-video', 'editor-customchar', 'editor-outdent', 'editor-indent', 'editor-help', 'editor-strikethrough', 'editor-unlink', 'editor-rtl', 'editor-break', 'editor-code', 'editor-paragraph', 'editor-table', 'align-left', 'align-right', 'align-center', 'align-none', 'lock', 'unlock', 'calendar', 'calendar-alt', 'visibility', 'hidden', 'post-status', 'edit', 'post-trash', 'trash', 'sticky', 'external', 'arrow-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up-alt', 'arrow-down-alt', 'arrow-left-alt', 'arrow-right-alt', 'arrow-up-alt2', 'arrow-down-alt2', 'arrow-left-alt2', 'arrow-right-alt2', 'leftright', 'sort', 'randomize', 'list-view', 'exerpt-view', 'excerpt-view', 'grid-view', 'move', 'hammer', 'art', 'migrate', 'performance', 'universal-access', 'universal-access-alt', 'tickets', 'nametag', 'clipboard', 'heart', 'megaphone', 'schedule', 'wordpress', 'wordpress-alt', 'pressthis', 'update', 'screenoptions', 'cart', 'feedback', 'cloud', 'translation', 'tag', 'category', 'archive', 'tagcloud', 'text', 'media-archive', 'media-audio', 'media-code', 'media-default', 'media-document', 'media-interactive', 'media-spreadsheet', 'media-text', 'media-video', 'playlist-audio', 'playlist-video', 'controls-play', 'controls-pause', 'controls-forward', 'controls-skipforward', 'controls-back', 'controls-skipback', 'controls-repeat', 'controls-volumeon', 'controls-volumeoff', 'yes', 'no', 'no-alt', 'plus', 'plus-alt', 'plus-alt2', 'minus', 'dismiss', 'marker', 'star-filled', 'star-half', 'star-empty', 'flag', 'info', 'warning', 'share', 'share1', 'share-alt', 'share-alt2', 'twitter', 'rss', 'email', 'email-alt', 'facebook', 'facebook-alt', 'networking', 'googleplus', 'location', 'location-alt', 'camera', 'images-alt', 'images-alt2', 'video-alt', 'video-alt2', 'video-alt3', 'vault', 'shield', 'shield-alt', 'sos', 'search', 'slides', 'analytics', 'chart-pie', 'chart-bar', 'chart-line', 'chart-area', 'groups', 'businessman', 'id', 'id-alt', 'products', 'awards', 'forms', 'testimonial', 'portfolio', 'book', 'book-alt', 'download', 'upload', 'backup', 'clock', 'lightbulb', 'microphone', 'desktop', 'laptop', 'tablet', 'smartphone', 'phone', 'smiley', 'index-card', 'carrot', 'building', 'store', 'album', 'palmtree', 'tickets-alt', 'money', 'thumbs-up', 'thumbs-down', 'layout', 'paperclip');

        $list = array();

        foreach ($icons as $icon) {
            $list[$icon] = ucwords(str_replace('-', ' ', $icon));
        }

        asort($list);

        return $list;
    }

    public static function get_list_of_sprites() {
        $icons = array('address-book-blue', 'address-book', 'alarm-clock', 'android', 'application-monitor', 'asterisk', 'auction-hammer', 'balance', 'bank', 'battery-charge', 'bauble', 'bean', 'bell', 'binocular', 'block', 'blog-blue', 'blog-posterous', 'blog', 'blogs', 'book-open-text-image', 'book', 'bookmark', 'books-brown', 'books', 'box', 'brain', 'briefcase', 'broom', 'bug', 'burn', 'calculator', 'calendar-blue', 'cards-bind-address', 'chain', 'chart-pie', 'chart', 'clapperboard', 'clipboard-task', 'database', 'disc-blue', 'envelope', 'film', 'flag-black', 'flag-blue', 'flag-green', 'flag-pink', 'flag-purple', 'flag-white', 'flag-yellow', 'flag', 'gear', 'globe', 'guitar', 'hammer-left', 'headphone', 'heart', 'home', 'hourglass', 'ice', 'image-select', 'images-flickr', 'jar', 'key', 'keyboard', 'leaf', 'lifebuoy', 'luggage', 'mail-open-table', 'mail-open', 'map', 'marker', 'music-beam-16', 'newspaper', 'palette', 'paper-clip', 'pencil', 'photo-album-blue', 'photo-album', 'piano', 'piggy-bank', 'pill', 'pin', 'pipette', 'playing-card', 'plug-disconnect', 'plug', 'present', 'price-tag-label', 'puzzle', 'spray', 'stamp', 'star', 'store', 'target', 'umbrella', 'users', 'wand', 'weather-cloudy', 'wooden-box', 'wrench');

        $list = array();

        foreach ($icons as $icon) {
            $list[$icon] = ucwords(str_replace('-', ' ', $icon));
        }

        asort($list);

        return $list;
    }

    public static function restricted_keywords($exclude = array()) {
        global $wp_post_types, $wp_taxonomies;

        $standard = array('attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category', 'category__and', 'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup', 'custom', 'customize_messenger_channel', 'customized', 'cpage', 'day', 'debug', 'embed', 'error', 'exact', 'feed', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nonce', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'terms', 'theme', 'title', 'type', 'w', 'withcomments', 'withoutcomments', 'year');
        $expanded = array_merge(array_keys($wp_post_types), array_keys($wp_taxonomies), gdcet_ctrl()->keywords);

        $keywords = array_merge($standard, $expanded);
        $keywords = array_unique($keywords);
        $keywords = array_diff($keywords, $exclude);

        return $keywords;
    }
}
