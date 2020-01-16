<?php

$_input_properties = array(
    'id="'.$id_base.'"',
    'name="'.$name_base.'"',
    'class="gdcet-control"'
);

if ($this->get_edit_value($index)) {
    $_input_properties[] = 'checked="checked"';
}

?>
<label>
    <input <?php echo join(' ', $_input_properties); ?> type="checkbox" />
    <span><?php echo $this->s('label'); ?></span>
</label>
