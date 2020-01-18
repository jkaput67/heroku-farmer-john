<?php

if (!defined('ABSPATH')) exit;

$_classes = array(
    'd4p-wrap', 
    'wpv-'.GDCET_WPV, 
    'd4p-page-'.gdcet_admin()->page,
    'd4p-panel',
    'd4p-panel-'.$_panel);

$_tabs = array(
    'whatsnew' => __("What&#8217;s New", "gd-content-tools"),
    'info' => __("Info", "gd-content-tools"),
    'changelog' => __("Changelog", "gd-content-tools"),
    'dev4press' => __("Dev4Press", "gd-content-tools")
);

?>

<div class="<?php echo join(' ', $_classes); ?>">
    <h1><?php printf(__("Welcome to GD Content Tools Pro %s", "gd-content-tools"), gdcet_settings()->info_version); ?></h1>
    <p class="d4p-about-text">
        Register and control custom post types and taxonomies. Powerful meta fields and meta boxes management. Extra widgets, custom rewrite rules, enhanced features...
    </p>
    <div class="d4p-about-badge" style="background-color: #AD0067;">
        <i class="d4p-icon d4p-plugin-icon-gd-content-tools"></i>
        <?php printf(__("Version %s", "gd-content-tools"), gdcet_settings()->info_version); ?>
    </div>

    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php

        foreach ($_tabs as $_tab => $_label) {
            echo '<a href="admin.php?page=gd-content-tools-about&panel='.$_tab.'" class="nav-tab'.($_tab == $_panel ? ' nav-tab-active' : '').'">'.$_label.'</a>';
        }

        ?>
    </h2>

    <div class="d4p-about-inner">