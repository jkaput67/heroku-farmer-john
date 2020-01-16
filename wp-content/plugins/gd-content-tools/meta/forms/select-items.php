<?php

if (!function_exists('gdcet_select_items_item')) {
    function gdcet_select_items_item($base, $name = '', $id = '%id%', $value = '', $label = '', $selected = false, $sel_type = 'radio') {
        $_name = $base.'[default]';

        if ($sel_type == 'checkbox') {
            $_name.= '[]';
        }

        ?>

    <tr class="gdcet-meta-items-list-item" data-item="<?php echo $id; ?>">
        <td class="gdcet-item-move">
            <i class="fa fa-arrows fa-fw"></i>
        </td>
        <td class="gdcet-item-default">
            <input class="gdcet-item-input--default" type="<?php echo $sel_type; ?>" value="<?php echo $id; ?>" name="<?php echo $_name; ?>"<?php echo $selected ? ' checked="checked"' : ''; ?> />
        </td>
        <td class="gdcet-item-data">
            <input class="gdcet-item-input--value" type="text" name="<?php echo $base; ?>[list][<?php echo $id; ?>][value]" value="<?php echo esc_attr($value); ?>" /><input class="gdcet-item-input--label" type="text" name="<?php echo $base; ?>[list][<?php echo $id; ?>][label]" value="<?php echo esc_attr($label); ?>" />
        </td>
        <td class="gdcet-item-ctrl">
            <i class="fa fa-minus-circle fa-fw"></i>
            <i class="fa fa-plus-circle fa-fw"></i>
        </td>
    </tr>

        <?php
    }
}

?>

<div class="gdcet-meta-items-wrapper-list">
    <table class="gdcet-meta-items-list">
        <thead>
            <tr>
                <td class="gdcet-item-move">&nbsp;</td>
                <td class="gdcet-item-default">&nbsp;</td>
                <td class="gdcet-item-data">
                    <div><?php _e("Value", "gd-content-tools"); ?></div><div><?php _e("Label", "gd-content-tools"); ?></div>
                </td>
                <td class="gdcet-item-ctrl">&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $id = 0;
            $items_list = array();
            $defaults = (array)$this->settings['default'];

            foreach ($this->settings['list'] as $value => $label) {
                $selected = $this->settings['mode'] == 'normal' ? in_array($label, $defaults) : in_array($value, $defaults);

                $items_list[] = $id;
                gdcet_select_items_item($_current_field_base, 'list', $id, $value, $label, $selected, $_current_field_select_type);

                $id++;
            }

            gdcet_select_items_item($_current_field_base, 'list', $id, '', '', false, $_current_field_select_type);

            ?>
        </tbody>
        <tfoot>
            <?php gdcet_select_items_item($_current_field_base, 'list', '%id%', '', '', false, $_current_field_select_type); ?>
        </tfoot>
    </table>
    <p class="description">
        <?php _e("Empty values and labels will be discarded on save!", "gd-content-tools"); ?>
    </p>
</div>
<div class="gdcet-meta-items-wrapper-textarea" style="display: none">
    <textarea></textarea>
    <p class="description">
        <?php _e("One element on each line. Use pipe character to split value and label for each element.", "gd-content-tools"); ?> <strong>
        <?php _e("Make sure to switch back to normal edit, or the changes will not save!", "gd-content-tools"); ?>
        </strong>
    </p>
</div>
<input type="hidden" value="<?php echo $id + 1; ?>" class="gdcet-list-items-counter" />
