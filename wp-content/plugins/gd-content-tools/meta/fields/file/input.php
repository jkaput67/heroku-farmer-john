<div class="gdcet-imagefile-wrapper">
    <?php

    $image_id = absint($this->get_edit_value($index));

    $_class = '';

    if ($this->is_required()) {
        $_class.= ' gdcet-control-required gdcet-required-id';
    }

    $_input_properties = array(
        'id="'.$id_base.'"',
        'name="'.$name_base.'"',
        'value="'.esc_attr($image_id).'"',
        'class="'.$_class.'"'
    );

    ?>
    <input <?php echo join(' ', $_input_properties); ?> type="hidden" />

    <div class="gdcet-imagefile-buttons">
        <a href="#" class="gdcet-button gdcet-imagefile-add-file"><i class="dashicons dashicons-media-default"></i> <?php _e("Select", "gd-content-tools"); ?></a>
        <a style="display: <?php echo $image_id > 0 ? "inline-block" : "none"; ?>" href="#" class="gdcet-button gdcet-imagefile-clear"><i class="dashicons dashicons-no"></i> <?php _e("Clear", "gd-content-tools"); ?></a>
    </div>
    <div class="gdcet-imagefile-preview-area">
        <?php

        $url = '';
        $title = __("File not selected.", "gd-content-tools");

        if ($image_id > 0) {
            $image = get_post($image_id);
            $title = '('.$image->ID.') '.$image->post_title;
            $media = wp_get_attachment_image_src($image_id, 'full');
            $url = $media[0];
        }

        ?>
        <span class="gdcet-imagefile-title"><?php echo $title; ?></span>
    </div>
</div>