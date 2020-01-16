<?php

$_class = 'gdcet-control gdcet-control-text';
$_mask = '';
$_regex = '';
$_restrict = $this->s('restriction');

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

if ($_restrict != '__none__') {
    if ($_restrict == '__mask__') {
        $_mask = $this->s('mask');
    } else if ($_restrict == '__regex__') {
        $_mask = $this->s('regex');
    } else {
        $split = explode('|', $_restrict);

        if ($split[0] == 'mask') {
            $_mask = call_user_func($split[1]);
        } else if ($split[0] == 'regex') {
            $_regex = call_user_func($split[1]);
        }
    }

    if (!empty($_mask)) {
        $_class.= ' gdcet-input-masked';
    } else if (!empty($_regex) && !gdcet_settings()->get('meta_text_pattern')) {
        $_class.= ' gdcet-input-regexed';
    }
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="'.$_class.'"',
    'placeholder="'.esc_attr($this->get_placeholder()).'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

if ($this->s('limit') > 0) {
    $_input_properties[] = 'maxlength="'.esc_attr($this->s('limit')).'"';
}

if ($_mask != '') {
    $_input_properties[] = 'data-gdcet-mask="'.esc_attr($_mask).'"';
}

if ($_regex != '') {
    if (gdcet_settings()->get('meta_text_pattern')) {
        $_input_properties[] = 'pattern="'.esc_attr($_regex).'"';
        $_input_properties[] = 'title="'.esc_attr(apply_filters('gdcet_meta_text_restriction_methods_regex_title', '', $_regex)).'"';
    } else {
        $_input_properties[] = 'data-gdcet-regex="/'.esc_attr($_regex).'/"';
    }
}

?>
<input <?php echo join(' ', $_input_properties); ?> type="text" />
