<?php

$old_cpt = get_option('gd-taxonomy-tools-cpt');
$old_tax = get_option('gd-taxonomy-tools-tax');

?>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Important Notice", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <strong><?php _e("Before you attempt transfer on live websites, make sure you test the process on the development server first. Make sure that everything works on the development server, before attempting live website transfer. If you find any issues during the testing, please use support forum to report them.", "gd-content-tools"); ?></strong>
    </div>
</div>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Custom Post Types", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php

        if (!is_array($old_cpt) || empty($old_cpt)) {
            _e("There are no custom post types found from old GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");
        } else {
            _e("Select custom post types you want to import from GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");

            $_transfer_list = array();

            foreach ($old_cpt as $cpt) {
                $_transfer_list[$cpt['id']] = $cpt['labels']['name'].' - '.$cpt['name'];
            }

            d4p_render_checkradios($_transfer_list, array('name' => 'gdcettools[transfer][cpt]'));

            _e("Transfered custom post types will be set as inactive.", "gd-content-tools");
        }

        ?>
    </div>
</div>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Custom Taxonomies", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php

        if (!is_array($old_tax) || empty($old_tax)) {
            _e("There are no custom taxonomies found from old GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");
        } else {
            _e("Select custom taxonomies you want to import from GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");

            $_transfer_list = array();

            foreach ($old_tax as $tax) {
                $_transfer_list[$tax['id']] = $tax['labels']['name'].' - '.$tax['name'];
            }

            d4p_render_checkradios($_transfer_list, array('name' => 'gdcettools[transfer][tax]'));

            _e("Transfered custom taxonomies will be set as inactive.", "gd-content-tools");
        }

        ?>
    </div>
</div>
