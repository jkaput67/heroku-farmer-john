<?php

if (!defined('ABSPATH')) exit;

$_panel = gdcet_admin()->panel === false ? 'whatsnew' : gdcet_admin()->panel;

if (!in_array($_panel, array('changelog', 'whatsnew', 'info', 'dev4press'))) {
    $_panel = 'whatsnew';
}

include(GDCET_PATH.'forms/about/header.php');

include(GDCET_PATH.'forms/about/'.$_panel.'.php');

include(GDCET_PATH.'forms/about/footer.php');
