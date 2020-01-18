<?php

/*
Plugin Name: GD Content Tools Pro
Plugin URI: https://plugins.dev4press.com/gd-content-tools/
Description: Register and control custom post types and taxonomies. Powerful meta fields and meta boxes management. Extra widgets, custom rewrite rules, enhanced features...
Version: 5.7.4
Codename: Chiana
Author: Milan Petrovic
Author URI: https://www.dev4press.com/
Private: true

== Copyright ==
Copyright 2008 - 2019 Milan Petrovic (email: milan@gdragon.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$gdcet_dirname_basic = dirname(__FILE__).'/';
$gdcet_urlname_basic = plugins_url('/gd-content-tools/');

define('GDCET_PATH', $gdcet_dirname_basic);
define('GDCET_URL', $gdcet_urlname_basic);
define('GDCET_D4PLIB', $gdcet_dirname_basic.'d4plib/');

/* D4PLIB */
if (!defined('D4PLIB_PATH')) {
    define('D4PLIB_PATH', GDCET_PATH.'d4plib/');
}

if (!defined('D4PLIB_URL')) {
    define('D4PLIB_URL', GDCET_URL.'d4plib/');
}

require_once(GDCET_D4PLIB.'d4p.core.php');
/* D4PLIB */

d4p_includes(array(
    array('name' => 'cache-wordpress', 'directory' => 'functions'), 
    array('name' => 'plugin', 'directory' => 'plugin'), 
    array('name' => 'errors', 'directory' => 'plugin'), 
    array('name' => 'wpdb', 'directory' => 'core'), 
    array('name' => 'widget', 'directory' => 'plugin'), 
    array('name' => 'settings', 'directory' => 'plugin'), 
    array('name' => 'shortcodes', 'directory' => 'plugin'), 
    array('name' => 'ip', 'directory' => 'classes'), 
    'functions', 
    'sanitize', 
    'access', 
    'wp'
), GDCET_D4PLIB);

require_once(GDCET_PATH.'core/version.php');

require_once(GDCET_PATH.'core/objects/core.db.php');
require_once(GDCET_PATH.'core/objects/base.classes.php');
require_once(GDCET_PATH.'core/objects/base.cpt.php');
require_once(GDCET_PATH.'core/objects/base.tax.php');

require_once(GDCET_PATH.'core/functions/shared.php');
require_once(GDCET_PATH.'core/functions/cpt.php');
require_once(GDCET_PATH.'core/functions/tax.php');
require_once(GDCET_PATH.'core/functions/terms.php');
require_once(GDCET_PATH.'core/functions/render.php');
require_once(GDCET_PATH.'core/functions/links.php');

require_once(GDCET_PATH.'core/functions/deprecated.php');

require_once(GDCET_PATH.'core/settings.php');
require_once(GDCET_PATH.'core/plugin.php');

require_once(GDCET_PATH.'core/loader.php');
require_once(GDCET_PATH.'meta/loader.php');

require_once(GDCET_PATH.'addons/wp-toolbar/init.php');
require_once(GDCET_PATH.'addons/tagger/init.php');
require_once(GDCET_PATH.'addons/bbpress/init.php');

global $_gdcet_db, $_gdcet_core, $_gdcet_settings, $_gdcet_loader, $_gdcet_meta;

global $_gdcet_field, $_gdcet_sub_field;

$_gdcet_db = new gdcet_core_db();
$_gdcet_core = new gdcet_core_plugin();
$_gdcet_loader = new gdcet_core_loader();
$_gdcet_meta = new gdcet_core_meta();
$_gdcet_settings = new gdcet_settings();

function gdcet_db() {
    global $_gdcet_db;
    return $_gdcet_db;
}

function gdcet() {
    global $_gdcet_core;
    return $_gdcet_core;
}

function gdcet_ctrl() {
    global $_gdcet_loader;
    return $_gdcet_loader;
}

function gdcet_meta() {
    global $_gdcet_meta;
    return $_gdcet_meta;
}

function gdcet_settings() {
    global $_gdcet_settings;
    return $_gdcet_settings;
}

if (D4P_ADMIN) {
    d4p_includes(array(
        array('name' => 'admin', 'directory' => 'plugin'),
        array('name' => 'functions', 'directory' => 'admin')
    ), GDCET_D4PLIB);

    require_once(GDCET_PATH.'core/admin/shared.php');
    require_once(GDCET_PATH.'core/admin/functions.php');
    require_once(GDCET_PATH.'core/admin/metabox.php');

    require_once(GDCET_PATH.'core/admin.php');
}

if (D4P_AJAX) {
    require_once(GDCET_PATH.'core/admin/ajax.php');
}
