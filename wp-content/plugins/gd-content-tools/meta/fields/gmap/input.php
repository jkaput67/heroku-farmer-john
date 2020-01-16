<div class="gdcet-gmap-wrapper">
    <?php

    $_class = 'gdcet-control';

    $_settings = $this->get_edit_value($index);
    $_settings['id'] = '#'.$id_base;

    $_input_properties_latitude = array(
        'id="'.$id_base.'-latitude"',
        'name="'.$name_base.'[latitude]"',
        'value="'.$_settings['latitude'].'"',
        'class="'.$_class.' gdcet-gmap-settings-latitude"', 'step="any"',
        'style="width: 100%; margin-bottom: 5px;"'
    );

    $_input_properties_longitude = array(
        'id="'.$id_base.'-longitude"',
        'name="'.$name_base.'[longitude]"',
        'value="'.$_settings['longitude'].'"',
        'class="'.$_class.' gdcet-gmap-settings-longitude"', 'step="any"',
        'style="width: 100%; margin-bottom: 5px;"'
    );

    $_input_properties_zoom = array(
        'id="'.$id_base.'-zoom"',
        'name="'.$name_base.'[zoom]"',
        'value="'.$_settings['zoom'].'"',
        'class="'.$_class.' gdcet-gmap-settings-zoom"', 'step="1"',
        'min="0"', 'max="25"', 'style="width: 100%; margin-bottom: 5px;"'
    );

    $_input_properties_height = array(
        'id="'.$id_base.'-height"',
        'name="'.$name_base.'[height]"',
        'value="'.$_settings['height'].'"',
        'class="'.$_class.' gdcet-gmap-settings-height"', 'step="1"',
        'min="0"', 'max="1024"', 'style="width: 100%; margin-bottom: 5px;"'
    );

    $_input_properties_note = array(
        'id="'.$id_base.'-note"',
        'name="'.$name_base.'[note]"',
        'class="'.$_class.' gdcet-gmap-settings-note"'
    );

    ?>

    <div class="gdcet-gmap-container" id="<?php echo esc_attr($id_base); ?>"></div>
    <script class="gdcet-gmap-settings" type="application/json">
        <?php echo json_encode($_settings); ?>
    </script>

    <div class="gdcet-multi-input-half">
        <span><?php _e("Latitude", "gd-content-tools"); ?>:</span>
        <input <?php echo join(' ', $_input_properties_latitude); ?> type="number" />
    </div><div class="gdcet-multi-input-half">
        <span><?php _e("Longitude", "gd-content-tools"); ?>:</span>
        <input <?php echo join(' ', $_input_properties_longitude); ?> type="number" />
    </div>

    <div class="gdcet-multi-input-half">
        <span><?php _e("Zoom Level", "gd-content-tools"); ?>:</span>
        <input <?php echo join(' ', $_input_properties_zoom); ?> type="number" />
    </div><div class="gdcet-multi-input-half">
        <span><?php _e("Height", "gd-content-tools"); ?>:</span>
        <input <?php echo join(' ', $_input_properties_height); ?> type="number" />
    </div>

    <span><?php _e("Marker Baloon Content", "gd-content-tools"); ?>:</span>
    <textarea <?php echo join(' ', $_input_properties_note); ?>><?php echo esc_textarea($_settings['note']); ?></textarea>
</div>