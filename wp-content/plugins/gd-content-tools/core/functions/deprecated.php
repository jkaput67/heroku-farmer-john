<?php

if (!defined('ABSPATH')) { exit; }

function gdtt_get_date_archive_link($post_type, $year = 0, $month = 0, $day = 0) {
    _deprecated_function(__FUNCTION__, '5.3.5', 'gdcet_get_date_archive_link()');

    return gdcet_get_date_archive_link($post_type, $year, $month, $day);
}
