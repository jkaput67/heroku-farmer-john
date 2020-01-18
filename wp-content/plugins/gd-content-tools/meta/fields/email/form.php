<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-default" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]" type="text" value="<?php echo esc_attr($this->settings['default']); ?>" />
                <p class="description">
                    <?php _e("When this field is displayed for the first time, this will be used as prepopulated value.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Placeholder", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-placeholder" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][placeholder]" type="text" value="<?php echo esc_attr($this->settings['placeholder']); ?>" />
                <p class="description">
                    <?php _e("This will be displayed inside the field as a hint, if the field is empty.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>