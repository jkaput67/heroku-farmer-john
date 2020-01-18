<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Value", "gd-content-tools"); ?></th>
            <td>
                <textarea class="widefat gdcet-field-property-settings-default" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]"><?php echo esc_textarea($this->settings['default']); ?></textarea>
                <p class="description">
                    <?php _e("When this field is displayed for the first time, this will be used as prepopulated value.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Allow HTML", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-allow_html" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][allow_html]" type="checkbox"<?php echo $this->settings['allow_html'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("If disabled, plugin will strip HTML before saving.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Allow Shortcodes", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-allow_shortcodes" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][allow_shortcodes]" type="checkbox"<?php echo $this->settings['allow_shortcodes'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("If disabled, plugin will strip shortcodes before saving.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>