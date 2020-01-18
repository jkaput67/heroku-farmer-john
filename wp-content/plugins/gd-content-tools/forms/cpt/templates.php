<?php

global $_id, $_name;

if (isset($_id) && $_id > 0) {
    $cpt = gdcet_ctrl()->get_cpt($_id, 'object');
    $post_type_name = $cpt->post_type;
} else {
    $cpt = get_post_type_object($_name);
    $post_type_name = $cpt->name;
}

?>
<div class="d4p-group gdcet-group-info d4p-group-changelog">
    <h3><?php _e("Single Post Templates", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <p><?php _e("These are the base templates that WordPress supports by default.", "gd-content-tools"); ?></p>
        <ul>
            <li>single-<?php echo $post_type_name; ?>-{slug}.php</li>
            <li>single-<?php echo $post_type_name; ?>.php</li>
            <li>single.php</li>
            <li>singular.php</li>
            <li>index.php</li>
        </ul>
    </div>
</div>

<div class="d4p-group gdcet-group-info d4p-group-changelog">
    <h3><?php _e("Archive Templates", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <p><?php _e("These are the base templates that WordPress supports by default.", "gd-content-tools"); ?></p>
        <ul>
            <li>archive-<?php echo $post_type_name; ?>.php</li>
            <li>archive.php</li>
            <li>index.php</li>
        </ul>
    </div>
</div>
