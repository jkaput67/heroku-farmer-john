<table class="form-table">
    <tbody>
        <tr>
            <th scope="row"><?php _e("Default Years", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-year" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][year]" type="number" value="<?php echo esc_attr($this->settings['year']); ?>" min="0" step="1" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Months", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-month" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][month]" type="number" value="<?php echo esc_attr($this->settings['month']); ?>" min="0" step="1" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Days", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-day" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][day]" type="number" value="<?php echo esc_attr($this->settings['day']); ?>" min="0" step="1" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Hours", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-hour" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][hour]" type="number" value="<?php echo esc_attr($this->settings['hour']); ?>" min="0" step="1" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Minutes", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-minute" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][minute]" type="number" value="<?php echo esc_attr($this->settings['minute']); ?>" min="0" step="1" />
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e("Default Seconds", "gd-content-tools"); ?></th>
            <td>
                <input class="widefat gdcet-field-property-settings-second" name="gdcet[field][fields][<?php echo $field_id; ?>][settings][second]" type="number" value="<?php echo esc_attr($this->settings['second']); ?>" min="0" step="1" />
            </td>
        </tr>
    </tbody>
</table>