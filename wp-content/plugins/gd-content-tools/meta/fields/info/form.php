<div class="gdcet-field-no-repeat">
    <?php _e("This is backend only field to show custom information inside the meta box.", "gd-content-tools"); ?><br/>
    <span style="font-weight: normal"><?php _e("This field doesn't save any data for the meta box and it will not be available on the frontend.", "gd-content-tools"); ?></span>
</div>
<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Information to show", "gd-content-tools"); ?></th>
            <td>
                <textarea class="widefat gdcet-field-property-settings-information" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][information]"><?php echo esc_textarea($this->settings['information']); ?></textarea>
                <p class="description">
                    <?php _e("This will be displayed as the metabox value. Only basic HTML is allowed.", "gd-content-tools"); ?>
                </p>
            </td>
        </tr>
    </tbody>
</table>
