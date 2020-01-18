<?php

$_box_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$_box = gdcet_meta()->get_box($_box_id);

include(GDCET_PATH.'forms/meta/box-php-metabox.php');

if ($_box->is_legacy()) {
    include(GDCET_PATH.'forms/meta/box-php-legacy-loop.php');
    include(GDCET_PATH.'forms/meta/box-php-legacy-name.php');
} else {
    include(GDCET_PATH.'forms/meta/box-php-meta-loop.php');
    include(GDCET_PATH.'forms/meta/box-php-meta-name.php');
}
