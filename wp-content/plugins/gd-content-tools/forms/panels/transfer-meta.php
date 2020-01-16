<?php

$old_meta = get_option('gd-taxonomy-tools-meta');

$meta_fields = $old_meta['fields'];
$meta_boxes = $old_meta['boxes'];

?>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Important Notice", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <strong><?php _e("Before you attempt transfer on live websites, make sure you test the process on the development server first. Make sure that everything works on the development server, before attempting live website transfer. If you find any issues during the testing, please use support forum to report them.", "gd-content-tools"); ?></strong>
    </div>
</div>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Custom Fields", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php

        if (!is_array($old_meta) || empty($meta_fields)) {
            _e("There are no custom fields found from old GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");
        } else {
            _e("Select custom fields you want to import from GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");

            echo '<br/><br/><strong>';

            _e("Metadata stored in the wp_postmeta table is not affected by this transfer.", "gd-content-tools");

            echo '</strong>';
            
            $_transfer_list = array();

            foreach ($meta_fields as $field) {
                $_transfer_list[$field['code']] = $field['name'].' - '.$field['code'].' ('.__("Type", "gd-content-tools").': '.$field['type'].')';
            }

            d4p_render_checkradios($_transfer_list, array('name' => 'gdcettools[transfer][fields]'));

            _e("Make sure to import all fields that are in the meta boxes listed below and you plan to import.", "gd-content-tools");
        }

        ?>
    </div>
</div>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Meta Boxes", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php

        if (!is_array($old_meta) || empty($meta_boxes)) {
            _e("There are no meta boxes found from old GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");
        } else {
            _e("Select meta boxes you want to import from GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");

            echo '<br/><br/><strong>';

            _e("Metadata stored in the wp_postmeta table is not affected by this transfer.", "gd-content-tools");

            echo '</strong>';

            $_transfer_list = array();

            foreach ($meta_boxes as $meta) {
                $_transfer_list[$meta['code']] = $meta['name'].' - '.$meta['code'];
            }

            d4p_render_checkradios($_transfer_list, array('name' => 'gdcettools[transfer][boxes]'));

            _e("Make sure to import all custom fields that are in the meta boxes you want to import.", "gd-content-tools");
        }

        ?>
    </div>
</div>
