<?php

include(GDCET_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-left">
    <div class="d4p-panel-scroller d4p-scroll-active">
        <div class="d4p-panel-title">
            <i class="d4p-icon d4p-logo-bbpress"></i>
            <h3><?php _e("Meta bbPress", "gd-content-tools"); ?></h3>
        </div>
        <div class="d4p-panel-info">
            <?php _e("Manage assignments of meta boxes to bbPress topic and reply forms.", "gd-content-tools"); ?>
        </div>
        <div class="d4p-panel-buttons">
            <a class="button-primary" href="<?php echo admin_url("admin.php?page=gd-content-tools-meta-bbpress&rule=0"); ?>"><?php _e("Add new Rule", "gd-content-tools"); ?></a>
        </div>
    </div>
</div>
<div class="d4p-content-right">

    <form method="get" action="">
        <input type="hidden" name="page" value="gd-gd-content-tools-cpt" />
        <input type="hidden" name="panel" value="index" />
        <input type="hidden" value="getback" name="gdcet_handler" />

        <?php

            require_once(GDCET_PATH.'addons/bbpress/code/rules.php');

            $_grid = new gdcet_rule_grid();
            $_grid->prepare_items();
            $_grid->display();

        ?>
    </form>

</div>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
