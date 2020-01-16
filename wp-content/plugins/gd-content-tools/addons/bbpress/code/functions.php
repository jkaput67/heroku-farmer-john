<?php

if (!defined('ABSPATH')) exit;

function gdcet_bbpress_forums_list() {
    $_base_forums = get_posts(array(
        'post_type' => bbp_get_forum_post_type(),
        'numberposts' => -1,
    ));

    $forums = array();

    foreach ($_base_forums as $forum) {
        $forums[$forum->ID] = (object)array(
            'id' => $forum->ID,
            'url' => get_permalink($forum->ID),
            'parent' => $forum->post_parent,
            'title' => $forum->post_title
        );
    }

    return $forums;
}
