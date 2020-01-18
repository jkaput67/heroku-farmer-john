<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-default" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]" type="number" value="<?php echo esc_attr($this->settings['default']); ?>" />
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
        <tr>
            <th scope="row"><?php _e("Set Min value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-switch-property gdcet-field-property-settings-has_min" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][has_min]" type="checkbox"<?php echo $this->settings['has_min'] ? ' checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr style="<?php echo $this->settings['has_min'] ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Min Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-min" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][min]" type="number" value="<?php echo esc_attr($this->settings['min']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Set Max value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-switch-property gdcet-field-property-settings-has_max" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][has_max]" type="checkbox"<?php echo $this->settings['has_max'] ? ' checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr style="<?php echo $this->settings['has_max'] ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Max Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-max" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][max]" type="number" value="<?php echo esc_attr($this->settings['max']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Set Step value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-switch-property gdcet-field-property-settings-has_step" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][has_step]" type="checkbox"<?php echo $this->settings['has_step'] ? ' checked="checked"' : ''; ?> />
            </td>
        </tr>
        <tr style="<?php echo $this->settings['has_step'] ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Step Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-step" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][step]" type="number" value="<?php echo esc_attr($this->settings['step']); ?>" step="any" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Allow Decimal Values", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-allow_decimal" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][allow_decimal]" type="checkbox"<?php echo $this->settings['allow_decimal'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("If this is enabled, Step settings will be ignored due to the limitations of the Number field in HTML.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>