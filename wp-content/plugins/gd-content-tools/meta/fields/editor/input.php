<?php

$_editor_settings = array(
    'textarea_name' => $name_base,
    'textarea_rows' => $this->s('textarea_rows'),
    'editor_class' => $this->s('editor_class'),
    'media_buttons' => $this->s('media_buttons'),
    'teeny' => $this->s('teeny'),
    'tinymce' => true,
    'quicktags' => true,
    'wpautop' => $this->s('wpautop')
);

if ($this->s('editor_height') > 0) {
    $_editor_settings['editor_height'] = $this->s('editor_height');
}

wp_editor($this->get_edit_value($index), $id_base, $_editor_settings);

wp_enqueue_editor();
