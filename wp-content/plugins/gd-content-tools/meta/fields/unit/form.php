<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Type", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_unit_types(), array('selected' => $this->settings['type'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][type]', 'class' => 'widefat gdcet-field-property-settings-type'));

                ?>
            </td>
        </tr>
    </tbody>
</table>