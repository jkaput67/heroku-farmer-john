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
        <tr>
            <th scope="row"><?php _e("Length Limit", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-limit" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][limit]" type="number" min="0" step="1" value="<?php echo esc_attr($this->settings['limit']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Restriction Method", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_grouped_select($this->get_restriction_methods(), array('selected' => $this->settings['restriction'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][restriction]', 'class' => 'widefat gdcet-field-property-settings-restriction'));

                ?>
                <p class="description">
                    <?php _e("If you need to restrict scope of entered data, you can use mask or regular expression. Select one of predefined masks or expressions, or insert your own.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Custom Mask", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-mask" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][mask]" type="text" value="<?php echo esc_attr($this->settings['mask']); ?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Custom Regular Expression", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-regex" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][regex]" type="text" value="<?php echo esc_attr($this->settings['regex']); ?>" />
            </td>
        </tr>
    </tbody>
</table>