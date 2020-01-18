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
            <th scope="row"><?php _e("Editor Height", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-editor_height" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][editor_height]" type="number" min="0" step="1" value="<?php echo esc_attr($this->settings['editor_height']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Textarea Rows", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-textarea_rows" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][textarea_rows]" type="number" min="0" step="1" value="<?php echo esc_attr($this->settings['textarea_rows']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Minimal Editor", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-teeny" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][teeny]" type="checkbox"<?php echo $this->settings['teeny'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("Show minimal set of buttons.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Apply WPAutoP", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-wpautop" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][wpautop]" type="checkbox"<?php echo $this->settings['wpautop'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("Apply WPAutoP filter on content.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Media Buttons", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-media_buttons" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][media_buttons]" type="checkbox"<?php echo $this->settings['media_buttons'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("Show media add/upload buttons.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>