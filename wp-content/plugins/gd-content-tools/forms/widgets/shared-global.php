<h4><?php _e("Basic", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title", "gd-content-tools"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
