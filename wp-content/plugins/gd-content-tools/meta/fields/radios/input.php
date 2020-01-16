<?php

$_select_items = $this->get_list();
$_selected = (array)$this->get_edit_value($index);
$_associative = $this->settings['mode'] != 'normal';

?>
<div class="gdcet-block-checkradios">
    <?php

    foreach ($_select_items as $key => $value) {
        $_sel = $_associative ? in_array($key, $_selected) : in_array($value, $_selected);
        $_val = $_associative ? $key : $value;

    ?>
    <label><input<?php echo $_sel ? ' checked="checked"' : ''; ?> value="<?php echo esc_attr($_val); ?>" type="radio" id="<?php echo esc_attr($id_base); ?>" name="<?php echo esc_attr($name_base); ?>" class="gdcet-control" /><?php echo esc_attr($value); ?></label>
    <?php

    }

    ?>
</div>