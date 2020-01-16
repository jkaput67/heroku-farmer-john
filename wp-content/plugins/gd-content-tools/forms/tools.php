<?php

if (!defined('ABSPATH')) exit;

$panels = array(
    'index' => array(
        'title' => __("Tools Index", "gd-content-tools"), 'icon' => 'wrench', 
        'info' => __("All plugin tools are split into several panels, and you access each starting from the right.", "gd-content-tools")),
    'export' => array(
        'title' => __("Export Settings", "gd-content-tools"), 'icon' => 'download', 
        'button' => 'button', 'button_text' => __("Export", "gd-content-tools"),
        'info' => __("Export all plugin settings into file.", "gd-content-tools")),
    'import' => array(
        'title' => __("Import Settings", "gd-content-tools"), 'icon' => 'upload', 
        'button' => 'submit', 'button_text' => __("Import", "gd-content-tools"),
        'info' => __("Import all plugin settings from export file.", "gd-content-tools")),
    'remove' => array(
        'title' => __("Reset / Remove", "gd-content-tools"), 'icon' => 'remove', 
        'button' => 'submit', 'button_text' => __("Remove", "gd-content-tools"),
        'info' => __("Remove selected plugin settings and optionally disable plugin.", "gd-content-tools")),
    'transfer-objects' => array(
        'title' => __("v4 Transfer: Objects", "gd-content-tools"), 'icon' => 'exchange', 
        'button' => 'submit', 'button_text' => __("Transfer", "gd-content-tools"),
        'info' => __("Transfer definitions for post types and taxonomies objects from plugin v4 version.", "gd-content-tools")),
    'transfer-meta' => array(
        'title' => __("v4 Transfer: Meta", "gd-content-tools"), 'icon' => 'exchange', 
        'button' => 'submit', 'button_text' => __("Transfer", "gd-content-tools"),
        'info' => __("Transfer definitions for meta fields and boxes from plugin v4 version.", "gd-content-tools")),
    'transfer-misc' => array(
        'title' => __("v4 Transfer: Misc", "gd-content-tools"), 'icon' => 'exchange', 
        'button' => 'submit', 'button_text' => __("Transfer", "gd-content-tools"),
        'info' => __("Transfer other data from plugin v4 version.", "gd-content-tools"))
);

include(GDCET_PATH.'forms/shared/top.php');

?>

<form method="post" action="" enctype="multipart/form-data" id="gdcet-tools-form">
    <?php settings_fields('gd-content-tools-tools'); ?>
    <input type="hidden" value="<?php echo $_panel; ?>" name="gdcettools[panel]" />
    <input type="hidden" value="postback" name="gdcet_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-wrench"></i>
                <h3><?php _e("Tools", "gd-content-tools"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index' && $panels[$_panel]['button'] != 'none') { ?>
                <div class="d4p-panel-buttons">
                    <input id="gdcet-tool-<?php echo $_panel; ?>" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            foreach ($panels as $panel => $obj) {
                if ($panel == 'index') continue;

                $url = 'admin.php?page=gd-content-tools-'.$_page.'&panel='.$panel;

                ?>

                <div class="d4p-options-panel">
                    <i class="fa fa-<?php echo $obj['icon']; ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Tools Panel", "gd-content-tools"); ?></a>
                    </div>
                </div>

                <?php
            }
        } else {
            include(GDCET_PATH.'forms/panels/'.$_panel.'.php');
        }

        ?>
    </div>
</form>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
