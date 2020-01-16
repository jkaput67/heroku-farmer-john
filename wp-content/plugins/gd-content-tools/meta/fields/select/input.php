<?php

$_selected = (array)$this->get_edit_value($index);

$_select_items = $this->s('hide_empty', false) === true ? array() : array('' => __("Nothing Selected", "gd-content-tools"));
$_select_items+= $this->get_list($_selected);

$_associative = $this->settings['mode'] != 'normal';

$_class = 'gdcet-control gdcet-control-select';

$_properties = array(
    'id' => $id_base,
    'name' => $name_base
);

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

if ($this->settings['display'] == 'select2') {
    $_class.= ' gdcet-control-select-enhanced gdcet-enhanced-select2';

    if ($this->settings['source'] == 'remote') {
        $_class.= ' gdcet-control-get-remote';
        $_properties['data-remote'] = $this->settings['remote'];
    }
}

$_properties['class'] = $_class;

$_render = array();

foreach ($_properties as $key => $value) {
    $_render[] = $key.'="'.esc_attr($value).'"';
}

?>
<select <?php echo join(' ', $_render); ?>>
    <?php

    foreach ($_select_items as $key => $value) {
        $_sel = $_associative ? in_array($key, $_selected) : in_array($value, $_selected);
        $_val = $_associative ? $key : $value;

?>
    <option value="<?php echo esc_attr($_val); ?>"<?php echo $_sel ? ' selected="selected"' : ''; ?>><?php echo esc_attr($value); ?></option>
<?php

    }

    ?>
</select>
