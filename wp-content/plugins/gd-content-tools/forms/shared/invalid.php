<?php

include(GDCET_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-left">
    <div class="d4p-panel-title">
        <i class="fa fa-bug"></i>
        <h3><?php _e("Invalid Request", "gd-content-tools"); ?></h3>
    </div>
</div>
<div class="d4p-content-right">
    <h3><?php _e("Error", "gd-content-tools"); ?></h3>
    <?php

        _e("Current request URL is invalid, and it can't be processed.", "gd-content-tools");

    ?>
</div>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
