<?php

gdcet_load_units();

$units = d4p_units();
$length = $units->get_unit_type_values('length');

?>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Type", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_type(), array('selected' => $this->settings['type'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][type]', 'class' => 'widefat gdcet-field-property-settings-type'));

                ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Width", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-x-value" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][x][value]" type="number" value="<?php echo esc_attr($this->settings['x']['value']); ?>" />
                <?php d4p_render_select($length, array('selected' => $this->settings['x']['unit'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][x][unit]', 'class' => 'widefat gdcet-select-short gdcet-field-property-settings-x-unit')); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Height", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-y-value" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][y][value]" type="number" value="<?php echo esc_attr($this->settings['y']['value']); ?>" />
                <?php d4p_render_select($length, array('selected' => $this->settings['y']['unit'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][y][unit]', 'class' => 'widefat gdcet-select-short gdcet-field-property-settings-y-unit')); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Depth", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-z-value" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][z][value]" type="number" value="<?php echo esc_attr($this->settings['z']['value']); ?>" />
                <?php d4p_render_select($length, array('selected' => $this->settings['z']['unit'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][z][unit]', 'class' => 'widefat gdcet-select-short gdcet-field-property-settings-z-unit')); ?>
            </td>
        </tr>
    </tbody>
</table>