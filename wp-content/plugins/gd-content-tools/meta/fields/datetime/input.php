<?php

$_class = 'gdcet-control gdcet-control-datetime';

if ($this->is_required()) {
    $_class.= ' gdcet-control-required gdcet-required-textual';
}

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'value="'.esc_attr($this->get_edit_value($index)).'"',
    'class="'.$_class.'"',
    'data-enable-seconds="'.(isset($this->settings['time_seconds']) && $this->settings['time_seconds'] === true ? 'true' : 'false').'"',
    'data-time_24hr="'.(isset($this->settings['time_mode']) && $this->settings['time_mode'] == '24h' ? 'true' : 'false').'"'
);

if ($this->is_required()) {
    $_input_properties[] = 'required';
}

?>
<input <?php echo join(' ', $_input_properties); ?> type="text" />