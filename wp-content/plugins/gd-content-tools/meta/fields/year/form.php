<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Custom default value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-switch-property gdcet-field-property-settings-custom" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][custom]" type="checkbox"<?php echo $this->settings['custom'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("If this is disabled, field will be empty when displayed first.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr style="<?php echo $this->settings['custom'] ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Default Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-half-field gdcet-datetime-year gdcet-field-property-settings-default" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]" type="number" value="<?php echo esc_attr($this->settings['default']); ?>" step="1" />
                <p class="description">
                    <?php _e("When this field is displayed for the first time, this will be used as prepopulated value.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>