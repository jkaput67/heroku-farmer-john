<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Custom default value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-switch-property gdcet-field-property-settings-custom" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][custom]" type="checkbox"<?php echo $this->settings['custom'] ? ' checked="checked"' : ''; ?> />
                <p class="description">
                    <?php _e("If this is disabled, plugin will set current date and time as default value. Enable it to set custom date and time.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr style="<?php echo $this->settings['custom'] ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Default Value", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-half-field gdcet-datetime-date gdcet-field-property-settings-default" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][default]" type="text" value="<?php echo esc_attr($this->settings['default']); ?>" />
                <p class="description">
                    <?php _e("When this field is displayed for the first time, this will be used as prepopulated value.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Store method", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_store_formats(), array('selected' => $this->settings['store'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][store]', 'class' => 'widefat gdcet-field-property-settings-store'));

                ?>
                <p class="description">
                    <?php _e("Value will be stored in the format selected here.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>