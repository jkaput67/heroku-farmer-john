<div class="d4p-group gdcet-group-info">
    <h3><?php _e("Registration Function", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <pre><?php

        global $_id;

        $tax = gdcet_ctrl()->get_tax($_id, 'object');
        $reg = $tax->build_registration();
        $arr = gdcet_array_to_string($reg);
        $cpt = empty($tax->_post_types) ? '' : "'".join("', '", $tax->_post_types)."'";

        echo sprintf("register_taxonomy('%s', array(%s), %s);", $tax->taxonomy, $cpt, $arr);

        ?></pre>
    </div>
</div>
