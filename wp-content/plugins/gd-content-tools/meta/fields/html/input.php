<?php

$_class = 'gdcet-control';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'class="'.$_class.'"',
    'placeholder="'.esc_attr($this->get_placeholder()).'"'
);

if ($this->s('limit') > 0) {
    $_input_properties[] = 'maxlength="'.esc_attr($this->s('limit')).'"';
}

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

?>
<textarea <?php echo join(' ', $_input_properties); ?>><?php echo esc_textarea($this->get_edit_value($index)); ?></textarea>