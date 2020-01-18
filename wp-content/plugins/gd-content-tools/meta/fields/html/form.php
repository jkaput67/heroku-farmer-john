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
            <th scope="row"><?php _e("Placeholder", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-placeholder" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][placeholder]" type="text" value="<?php echo esc_attr($this->settings['placeholder']); ?>" />
                <p class="description">
                    <?php _e("This will be displayed inside the field as a hint, if the field is empty.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Length Limit", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-limit" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][limit]" type="number" min="0" step="1" value="<?php echo esc_attr($this->settings['limit']); ?>" />
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
            <th scope="row"><?php _e("Allow restricted HTML tags", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-allow_html_restricted" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][allow_html_restricted]" type="checkbox"<?php echo $this->settings['allow_html_restricted'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php echo sprintf(__("If enabled and if Allow HTML is enabled, plugin will allow the use of restricted HTML tags: %s.", "gd-content-tools"), "'SCRIPT', 'IFRAME'"); ?>
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