<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Display", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_display(), array('selected' => $this->settings['display'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][display]', 'class' => 'widefat gdcet-field-property-settings-display'));

                ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Post Type", "gd-content-tools"); ?></th>
            <td>
                <?php

                    d4p_render_select($this->get_post_types(), array('selected' => $this->settings['post_type'], 'name' => 'gdcet[field][fields]['.$field_id.'][settings][post_type]', 'class' => 'widefat gdcet-field-property-settings-post_type'));

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