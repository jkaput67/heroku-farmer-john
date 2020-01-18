<h4><?php _e("Term display sizes", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('smallest'); ?>"><?php _e("Smallest term size", "gd-content-tools"); ?>:</label>
                <input class="widefat d4p-setting-integer" id="<?php echo $this->get_field_id('smallest'); ?>" name="<?php echo $this->get_field_name('smallest'); ?>" type="text" value="<?php echo $instance['smallest']; ?>" />

                <label for="<?php echo $this->get_field_id('largest'); ?>"><?php _e("Largest term size", "gd-content-tools"); ?>:</label>
                <input class="widefat d4p-setting-integer" id="<?php echo $this->get_field_id('largest'); ?>" name="<?php echo $this->get_field_name('largest'); ?>" type="text" value="<?php echo $instance['largest']; ?>" />
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('unit'); ?>"><?php _e("Size Unit", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select(d4p_css_size_units(), array('id' => $this->get_field_id('unit'), 'class' => 'widefat', 'name' => $this->get_field_name('unit'), 'selected' => $instance['unit'])); ?>
            </td>
        </tr>
    </tbody>
</table>
