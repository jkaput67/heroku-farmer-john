<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Mode", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_modes(), array('selected' => $this->settings['mode'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][mode]', 'class' => 'widefat gdcet-field-property-settings-mode'));

                ?>
                <p class="description">
                    <?php _e("Data can be plain list (each item has only label) or associated list (each item will have value and label).", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Source", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_sources(), array('selected' => $this->settings['source'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][source]', 'class' => 'widefat gdcet-select-with-options gdcet-field-property-settings-source'), array('data-select' => 'source'));

                ?>
                <p class="description">
                    <?php _e("Data for this field can be a list or result of the special function. If you use the function, you can't specify default value.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
        <tr class="gdcet-select-source gdcet-select-source-list <?php echo $this->settings['mode'] == 'normal' ? 'gdcet-select-mode-plain' : ''; ?>" style="<?php echo $this->settings['source'] == 'list' ? '' : 'display: none;'; ?>">
            <th scope="row">
                <?php _e("Items List", "gd-content-tools"); ?><br/>
                <a href="#" class="gdcet-list-switch-mass-edit"><?php _e("mass edit", "gd-content-tools"); ?></a>
                <a href="#" class="gdcet-list-switch-normal-edit" style="display: none"><?php _e("normal edit", "gd-content-tools"); ?></a>
            </th>
            <td>
                <?php

                $_current_field_base = 'gdcet[field][fields]['.$field_id.'][settings]';
                $_current_field_select_type = 'checkbox';

                include(GDCET_PATH.'meta/forms/select-items.php');

                ?>
            </td>
        </tr>
        <tr class="gdcet-select-source gdcet-select-source-function" style="<?php echo $this->settings['source'] == 'function' ? '' : 'display: none;'; ?>">
            <th scope="row"><?php _e("Function", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_functions(), array('selected' => $this->settings['function'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][function]', 'class' => 'widefat gdcet-field-property-settings-function'));

                ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Limit number of selected values", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-limit" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][limit]" type="number" value="<?php echo esc_attr($this->settings['limit']); ?>" step="1" min="0" />
            </td>
        </tr>
    </tbody>
</table>
