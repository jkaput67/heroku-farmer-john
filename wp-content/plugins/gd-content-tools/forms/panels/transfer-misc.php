<?php

$old_imtax = get_option('gd-taxonomy-tools-im-tax');

?>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Important Notice", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <strong><?php _e("Before you attempt transfer on live websites, make sure you test the process on the development server first. Make sure that everything works on the development server, before attempting live website transfer. If you find any issues during the testing, please use support forum to report them.", "gd-content-tools"); ?></strong>
    </div>
</div>

<div class="d4p-group d4p-group-transfer">
    <h3><?php _e("Terms Images", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php

        if (!is_array($old_imtax) || empty($old_imtax)) {
            _e("There are no assignments of term images stored with the old GD Custom Posts and Taxonomies Tools Pro plugin.", "gd-content-tools");
        } else {
            _e("Enable this option to transfer assignments of term images from GD Custom Posts and Taxonomies Tools Pro plugin. Select which taxonomies terms images assignments you want to transfer.", "gd-content-tools");

            $_transfer_list = array();

            foreach (array_keys($old_imtax) as $tax) {
                if (taxonomy_exists($tax)) {
                    $taxonomy = get_taxonomy($tax);
                    $_transfer_list[$tax] = $taxonomy->label.' - '.$tax;
                }
            }

            d4p_render_checkradios($_transfer_list, array('name' => 'gdcettools[transfer][imgterm]'));

            _e("Transfered images assignments will be stored in new plugin without checking if they are valid or if images used still exist.", "gd-content-tools");
        }

        ?>
    </div>
</div>