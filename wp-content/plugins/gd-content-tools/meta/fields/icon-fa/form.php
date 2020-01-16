<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Icon", "gd-content-tools"); ?></th>
            <td>
                <input type="hidden" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]" value="<?php echo esc_attr($this->settings['default']); ?>" />

                <?php

                $_current_icon_selected = $this->settings['default'];

                include(GDCET_PATH.'meta/forms/select-fontawesome.php');

                ?>
            </td>
        </tr>
    </tbody>
</table>