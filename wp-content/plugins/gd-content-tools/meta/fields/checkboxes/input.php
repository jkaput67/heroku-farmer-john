<?php

$_select_items = $this->get_list();
$_selected = (array)$this->get_edit_value($index);
$_associative = $this->settings['mode'] != 'normal';

?>
<div class="gdcet-block-checkradios"<?php echo $this->settings['limit'] > 0 ? ' data-selection-limit="'.esc_attr($this->settings['limit']).'"' : ''; ?>>
    <div class="gdcet-block-check-uncheck">
        <a href="#checkall"><?php _e("Check All", "gd-content-tools"); ?></a> | <a href="#uncheckall"><?php _e("Uncheck All", "gd-content-tools"); ?></a>
    </div>

    <?php

    foreach ($_select_items as $key => $value) {
        $_sel = $_associative ? in_array($key, $_selected) : in_array($value, $_selected);
        $_val = $_associative ? $key : $value;

    ?>
    <label><input<?php echo $_sel ? ' checked="checked"' : ''; ?> value="<?php echo esc_attr($_val); ?>" type="checkbox" id="<?php echo esc_attr($id_base); ?>" name="<?php echo esc_attr($name_base); ?>[]" class="gdcet-control" /><?php echo esc_attr($value); ?></label>
    <?php

    }

    ?>
</div>