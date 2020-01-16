<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_info {
    public $code = 'gd-content-tools';

    public $version = '5.7.4';
    public $codename = 'Chiana';
    public $build = 370;
    public $edition = 'pro';
    public $status = 'stable';
    public $updated = '2020.01.07';
    public $url = 'https://plugins.dev4press.com/gd-content-tools/';
    public $author_name = 'Milan Petrovic';
    public $author_url = 'https://www.dev4press.com/';
    public $released = '2016.09.20';

    public $php = '5.6';
    public $mysql = '5.1';
    public $wordpress = '4.7';

    public $install = false;
    public $update = false;
    public $previous = 0;

    function __construct() { }

    public function to_array() {
        return (array)$this;
    }
}
