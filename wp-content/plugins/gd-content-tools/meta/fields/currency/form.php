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
            <th scope="row"><?php _e("Default currency", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_currencies(), array('selected' => $this->settings['currency'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][currency]', 'class' => 'widefat gdcet-field-property-settings-currency'));

                ?>
            </td>
        </tr>
    </tbody>
</table>