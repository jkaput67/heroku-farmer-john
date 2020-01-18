<?php

$_sel_render = array(
    'list' => __("List", "gd-content-tools"),
    'drop' => __("Dropdown", "gd-content-tools")
);

?>
<h4><?php _e("Extra Options", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('render'); ?>"><?php _e("Render Method", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select($_sel_render, array('id' => $this->get_field_id('render'), 'class' => 'widefat', 'name' => $this->get_field_name('render'), 'selected' => $instance['render'])); ?>
            </td>
            <td class="cell-right">
                <label><?php _e("And more", "gd-content-tools"); ?>:</label>
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('hierarchical'); ?>">
                        <input class="widefat" <?php echo $instance['hierarchical'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>" />
                        <?php _e("Render hierarchy", "gd-content-tools"); ?></label>

                    <label for="<?php echo $this->get_field_id('show_count'); ?>">
                        <input class="widefat" <?php echo $instance['show_count'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" />
                        <?php _e("Display post count", "gd-content-tools"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>