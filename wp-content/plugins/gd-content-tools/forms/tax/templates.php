<?php

global $_id;

$tax = gdcet_ctrl()->get_tax($_id, 'object');

?>
<div class="d4p-group gdcet-group-info d4p-group-changelog">
    <h3><?php _e("Archive Templates", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <p><?php _e("These are the base templates that WordPress supports by default.", "gd-content-tools"); ?></p>
        <ul>
            <li>taxonomy-<?php echo $tax->taxonomy; ?>-{term-slug}.php</li>
            <li>taxonomy-<?php echo $tax->taxonomy; ?>.php</li>
            <li>taxonomy.php</li>
            <li>archive.php</li>
            <li>index.php</li>
        </ul>
    </div>
</div>
