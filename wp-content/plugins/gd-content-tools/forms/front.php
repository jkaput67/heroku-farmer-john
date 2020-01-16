<?php

if (!defined('ABSPATH')) exit;

$panels = array();

include(GDCET_PATH.'forms/shared/top.php');

$pages = gdcet_admin()->menu_items;

?>

<div class="d4p-front-left">
    <div class="d4p-front-title" style="height: auto;">
        <h1 style="font-size: 90px; line-height: 0.95; letter-spacing: -6px; text-align: right;">
            <span>GD CONTENT</span><span>TOOLS</span>
            <span style="font-size: 48px; letter-spacing: 1px">
                PRO 
                <em style="font-weight: 100; font-style: normal;"><?php _e("Edition", "gd-content-tools"); ?></em>
            </span>
        </h1>
        <h5><?php 

            _e("Version", "gd-content-tools");
            echo': '.gdcet_settings()->info->version.' - '.  gdcet_settings()->info->codename;

            if (gdcet_settings()->info->status != 'stable') {
                echo ' - <span style="color: red; font-weight: bold;">'.strtoupper(gdcet_settings()->info->status).'</span>';
            }
            
            ?></h5>
    </div>
    <div class="d4p-front-title" style="height: auto; margin-top: 15px; text-align: center; font-size: 18px; font-weight: bold;">
        <?php _e("Knowledge Base and Support Forums", "gd-content-tools"); ?>
        <p style="font-size: 15px; font-weight: normal; margin: 10px 0 0;">
            <?php echo sprintf(__("To learn more about the plugin, check out plugin %s articles and FAQ. To get additional help, you can use %s.", "gd-content-tools"),
                '<a target="_blank" href="https://support.dev4press.com/kb/product/gd-content-tools/">'.__("knowledge base", "gd-content-tools").'</a>',
                '<a target="_blank" href="https://support.dev4press.com/forums/forum/plugins/gd-content-tools/">'.__("support forum", "gd-content-tools").'</a>'); ?>
        </p>
    </div>
    <div class="d4p-front-dev4press">
        &copy; 2008 - 2016. Dev4Press - <a target="_blank" href="https://www.dev4press.com/">www.dev4press.com</a> | 
                                        <a target="_blank" href="https://plugins.dev4press.com/gd-content-tools/">plugins.dev4press.com/gd-content-tools</a>
    </div>
</div>
<div class="d4p-front-right">
    <?php

    foreach ($pages as $page => $obj) {
        if ($page == 'front') continue;

        $url = 'admin.php?page=gd-content-tools-'.$page;

        ?>

            <div class="d4p-options-panel">

                <i class="<?php echo d4p_get_icon_class($obj['icon']); ?>"></i>
                <h5><?php echo $obj['title']; ?></h5>
                <div>
                    <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Open", "gd-content-tools"); ?></a>
                </div>
            </div>

        <?php
    }

    ?>
</div>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
