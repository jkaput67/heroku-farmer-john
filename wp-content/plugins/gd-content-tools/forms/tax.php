<?php

if (!defined('ABSPATH')) exit;

include(GDCET_PATH.'forms/shared/top.php');

?>

<div class="d4p-content-right d4p-content-full">
    <a href="<?php echo self_admin_url('admin.php?page=gd-content-tools-tax&panel=edit&id=0'); ?>" class="button-primary"><i class="fa fa-plus-square fa-fw"></i> <?php _e("Create New Custom Taxonomy", "gd-content-tools"); ?></a>

    <form method="get" action="">
        <input type="hidden" name="page" value="gd-content-tools-tax" />
        <input type="hidden" name="panel" value="index" />
        <input type="hidden" value="getback" name="gdcet_handler" />

        <?php

            require_once(GDCET_PATH.'core/grids/tax.php');

            $_grid = new gdcet_tax_grid();
            $_grid->prepare_items();
            $_grid->display();

        ?>

        <a class="button-secondary gdcet-objects-default-toggler" href="#"><?php _e("Show default and third party taxonomies", "gd-content-tools"); ?></a>
        <div class="gdcet-objects-default-hide">
        <?php

            require_once(GDCET_PATH.'core/grids/tax.others.php');

            $_others_grid = new gdcet_tax_others_grid();
            $_others_grid->prepare_items();
            $_others_grid->display();

        ?>
    </form>    
</div>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
