<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Label", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-label" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][label]" type="text" value="<?php echo esc_attr($this->settings['label']); ?>" />
                <p class="description">
                    <?php _e("This will be displayed next to the checkbox.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>