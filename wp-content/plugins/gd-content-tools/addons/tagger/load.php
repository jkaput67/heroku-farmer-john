<?php

if (!defined('ABSPATH')) exit;

class gdcet_addon_tagger extends gdcet_addon_load {
    public $prefix = 'tagger';

    public function _load_admin() {
        require_once(GDCET_PATH.'addons/tagger/admin.php');
    }
}

global $_gdcet_addon_tagger;
$_gdcet_addon_tagger = new gdcet_addon_tagger();

function gdcet_tagger() {
    global $_gdcet_addon_tagger;
    return $_gdcet_addon_tagger;
}
