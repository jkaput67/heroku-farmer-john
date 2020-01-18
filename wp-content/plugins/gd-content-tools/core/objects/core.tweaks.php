<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_tweaks {
    public $disable_blocks_editor = array();

    public function __construct() {
        add_action('gdcet_plugin_init', array($this, 'blocks_editor'));
    }

    public function blocks_editor() {
        if (GDCET_WPV > 49) {
            if (gdcet_settings()->get('no_blocks_post', 'tweaks')) {
                $this->disable_blocks_editor[] = 'post';
            }

            if (gdcet_settings()->get('no_blocks_page', 'tweaks')) {
                $this->disable_blocks_editor[] = 'page';
            }

            if (!empty($this->disable_blocks_editor)) {
                add_filter('use_block_editor_for_post_type', array($this, 'classic_editor'), 10, 2);
            }
        }
    }

    public function classic_editor($use_block_editor, $post_type) {
        if (in_array($post_type, $this->disable_blocks_editor)) {
            $use_block_editor = false;
        }

        return $use_block_editor;
    }
}
