<?php

if (!defined('ABSPATH')) exit;

$panels = array(
    'index' => array(
        'title' => __("Settings Index", "gd-content-tools"), 'icon' => 'cogs', 
        'info' => __("All plugin settings are split into panels, and you access each starting from the right.", "gd-content-tools")),
    'addons' => array(
        'title' => __("Addons", "gd-content-tools"), 'icon' => 'puzzle-piece', 
        'break' => __("Basic Settings", "gd-content-tools"), 
        'info' => __("From this panel you can disable and enable individual plugin addons and rating methods.", "gd-content-tools")),
    'global' => array(
        'title' => __("Global", "gd-content-tools"), 'icon' => 'cog', 
        'info' => __("From this panel you control general plugin settings.", "gd-content-tools")),
    'templates' => array(
        'title' => __("Templates", "gd-content-tools"), 'icon' => 'files-o', 
        'info' => __("From this panel you control additional theme templates.", "gd-content-tools")),
    'meta' => array(
        'title' => __("Meta", "gd-content-tools"), 'icon' => 'ticket', 
        'info' => __("From this panel you control meta boxes and meta fields controls.", "gd-content-tools")),
    'widgets' => array(
        'title' => __("Widgets", "gd-content-tools"), 'icon' => 'sticky-note-o', 
        'info' => __("From this panel you control plugin widgets.", "gd-content-tools")),
    'tweaks' => array(
        'title' => __("Tweaks", "gd-content-tools"), 'icon' => 'magic', 
        'info' => __("From this panel you control some content related tweaks.", "gd-content-tools"))
);

$panels = apply_filters('gdcet_admin_settings_panels', $panels);

$_addons = false;

foreach ($panels as $code => &$_obj) {
    if (!$_addons && isset($_obj['type']) && $_obj['type'] == 'addon') {
        $_obj['break'] = __("Addons", "gd-content-tools");
        $_addons = true;
    }
}

include(GDCET_PATH.'forms/shared/top.php');

?>

<form method="post" action="">
    <?php settings_fields('gd-content-tools-settings'); ?>
    <input type="hidden" value="postback" name="gdcet_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-cogs"></i>
                <h3><?php _e("Settings", "gd-content-tools"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input type="submit" value="<?php _e("Save Settings", "gd-content-tools"); ?>" class="button-primary">
                </div>
                <div class="d4p-return-to-top">
                    <a href="#wpwrap"><?php _e("Return to top", "gd-content-tools"); ?></a>
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

                if (isset($obj['break'])) { ?>

                    <div style="clear: both"></div>
                    <div class="d4p-panel-break d4p-clearfix">
                        <h4><?php echo $obj['break']; ?></h4>
                    </div>
                    <div style="clear: both"></div>

                <?php } ?>

                <div class="d4p-options-panel">
                    <i class="<?php echo d4p_get_icon_class($obj['icon']); ?>"></i>
                    <h5><?php echo $obj['title']; ?></h5>
                    <div>
                        <?php if (isset($obj['type'])) { ?>
                        <span><?php echo $obj['type']; ?></span>
                        <?php } ?>
                        <a class="button-primary" href="<?php echo $url; ?>"><?php _e("Settings Panel", "gd-content-tools"); ?></a>
                    </div>
                </div>
        
                <?php
            }
        } else {
            d4p_includes(array(
                array('name' => 'walkers', 'directory' => 'admin'),
                array('name' => 'settings', 'directory' => 'admin')
            ), GDCET_D4PLIB);

            include(GDCET_PATH.'core/admin/options.php');

            $options = new gdcet_admin_data_options();

            $panel = gdcet_admin()->panel;
            $groups = $options->get($panel);

            $render = new d4pSettingsRender($panel, $groups);
            $render->base = 'gdcetvalue';
            $render->render();
        }

        ?>
    </div>
</form>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
