<?php

$_editor_settings = array(
    'gdcet_id' => $id_base,
    'textareaRows' => $this->s('textarea_rows'),
    'editorClass' => $this->s('editor_class'),
    'mediaButtons' => $this->s('media_buttons'),
    'teeny' => $this->s('teeny'),
    'tinymce' => true,
    'quicktags' => true,
    'wpautop' => $this->s('wpautop')
);

if ($this->s('editor_height') > 0) {
    $_editor_settings['editor_height'] = $this->s('editor_height');
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'class="gdcet_meta_fields_do_wpeditor wp-editor-area"'
);

?>

<textarea <?php echo join(' ', $_input_properties); ?>><?php echo esc_textarea($this->get_edit_value($index)); ?></textarea><script 
type="application/json">
<?php echo json_encode($_editor_settings); ?></script>
