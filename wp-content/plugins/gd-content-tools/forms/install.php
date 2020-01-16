<?php

if (!defined('ABSPATH')) exit;

$_classes = array('d4p-wrap', 'wpv-'.GDCET_WPV, 'd4p-page-install');

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
                <h3><?php _e("Installation", "gd-content-tools"); ?></h3>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Before you continue, make sure plugin installation was successful.", "gd-content-tools"); ?>
            </div>
        </div>
        <div class="d4p-content-right">
            <div class="d4p-update-info">
                <?php

                gdcet_settings()->set('install', false, 'info');
                gdcet_settings()->set('update', false, 'info', true);

                ?>

                <h3 style="margin-top: 0;"><?php _e("All Done", "gd-content-tools"); ?></h3>
                <?php _e("Installation completed.", "gd-content-tools"); ?>

                <br/><br/><a class="button-primary" href="admin.php?page=gd-content-tools-about"><?php _e("Click here to continue", "gd-content-tools"); ?></a>

                <?php

                $gdcptt = get_option('gd-taxonomy-tools');

                if (is_array($gdcptt)) {
                    
                ?>

                <div style="margin: 2em 0; padding: 2em 0; border-top: 1px solid #777777;">
                <h3><?php _e("GD Custom Posts and Taxonomies Tools", "gd-content-tools"); ?></h3>
                <?php _e("Settings from old plugin found. If you want, you can transfer data from it. Transfer tools are located on the Tools panel.", "gd-content-tools"); ?>

                <br/><br/><a class="button-primary" href="<?php echo admin_url('admin.php?page=gd-content-tools-tools'); ?>"><?php _e("Open tools panel", "gd-content-tools"); ?></a>

                <?php

                }

                ?>
            </div>
            <?php echo gdcet()->recommend('install'); ?>
        </div>
    </div>
</div>