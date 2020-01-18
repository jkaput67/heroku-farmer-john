<?php

if (!defined('ABSPATH')) exit;

$_classes = array('d4p-wrap', 'wpv-'.GDCET_WPV, 'd4p-page-update');

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-plugin">
            GD Content Tools
        </div>
    </div>
    <div class="d4p-content">
        <div class="d4p-content-left">
            <div class="d4p-panel-title">
                <i class="fa fa-magic"></i>
                <h3><?php _e("Update", "gd-content-tools"); ?></h3>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Before you continue, make sure plugin was successfully updated.", "gd-content-tools"); ?>
            </div>
        </div>
        <div class="d4p-content-right">
            <div class="d4p-update-info">
                <?php

                    gdcet_settings()->set('install', false, 'info');
                    gdcet_settings()->set('update', false, 'info', true);

                ?>

                <h3 style="margin-top: 0;"><?php _e("All Done", "gd-content-tools"); ?></h3>
                <?php _e("Update completed.", "gd-content-tools"); ?>

                <br/><br/><a class="button-primary" href="admin.php?page=gd-content-tools-about"><?php _e("Click here to continue", "gd-content-tools"); ?></a>
            </div>
            <?php echo gdcet()->recommend('update'); ?>
        </div>
    </div>
</div>