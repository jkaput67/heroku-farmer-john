<?php

if (!defined('ABSPATH')) exit;

include(GDCET_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-right d4p-content-full">
    <a href="<?php echo self_admin_url('admin.php?page=gd-content-tools-cpt&panel=edit&id=0'); ?>" class="button-primary"><i class="fa fa-plus-square fa-fw"></i> <?php _e("Create New Custom Post Type", "gd-content-tools"); ?></a>

    <form method="get" action="">
        <input type="hidden" name="page" value="ggd-content-tools-cpt" />
        <input type="hidden" name="panel" value="index" />
        <input type="hidden" value="getback" name="gdcet_handler" />

        <?php

            require_once(GDCET_PATH.'core/grids/cpt.php');

            $_grid = new gdcet_cpt_grid();
            $_grid->prepare_items();
            $_grid->display();

        ?>

        <a class="button-secondary gdcet-objects-default-toggler" href="#"><?php _e("Show default and third party post types", "gd-content-tools"); ?></a>
        <div class="gdcet-objects-default-hide">
        <?php

            require_once(GDCET_PATH.'core/grids/cpt.others.php');

            $_others_grid = new gdcet_cpt_others_grid();
            $_others_grid->prepare_items();
            $_others_grid->display();

        ?>
        </div>
    </form>
</div>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
