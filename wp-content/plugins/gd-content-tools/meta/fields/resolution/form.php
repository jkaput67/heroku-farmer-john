<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Width", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-x" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][x]" type="number" value="<?php echo esc_attr($this->settings['x']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Height", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-y" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][y]" type="number" value="<?php echo esc_attr($this->settings['y']); ?>" />
            </td>
        </tr>
    </tbody>
</table>