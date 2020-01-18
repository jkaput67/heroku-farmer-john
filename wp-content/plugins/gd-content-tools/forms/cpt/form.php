<?php

global $_id;

include(GDCET_PATH.'forms/cpt/hooks.php');

$_object = null;
$_errors = null;

$_subitle = '<h5>'.__("New Post Type", "gd-content-tools").'</h5>';
$_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$_copy_id = isset($_GET['copy']) ? intval($_GET['copy']) : 0;

$_feedback = gdcet_admin()->feedback !== false;

if ($_feedback) {
    $_errors = gdcet_admin()->feedback['errors'];
    $_object = gdcet_admin()->feedback['object'];

    $_id = $_object['_id'];
} else {
    if ($_copy_id > 0) {
        $_id = 0;

        $_object = gdcet_ctrl()->get_cpt($_copy_id);
    } else {
        $_object = gdcet_ctrl()->get_cpt($_id);
    }
}

if ($_id > 0) {
    $_subitle = '<h5>'.__("Editing Post Type", "gd-content-tools").'</h5>';
    $_subitle.= '<h4>'.$_object['post_type'].'</h4>';
}

$_js_errors = array();

$panels_list = array(
    'function' => array(
        'title' => __("Function", "gd-content-tools"),
        'icon' => 'code', 'submit' => false,
        'description' => __("Registration function used to register the post type based on settings.", "gd-content-tools")
    ),
    'templates' => array(
        'title' => __("Templates", "gd-content-tools"),
        'icon' => 'file-text-o', 'submit' => false,
        'description' => __("List of theme templates you can use to target this post type. It also includes fallback files full hierarchy.", "gd-content-tools")
    ),
    'edit' => array(
        'title' => __("Basic Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Edit basic post type settings.", "gd-content-tools")
    ),
    'labels' => array(
        'title' => __("Labels Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Edit extended post type labels.", "gd-content-tools")
    ),
    'features' => array(
        'title' => __("Features Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Edit various post type features.", "gd-content-tools")
    ),
    'visibility' => array(
        'title' => __("Visibility Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Edit visibility related settings.", "gd-content-tools")
    ),
    'rewrite' => array(
        'title' => __("Rewrite Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Edit rewrite, permalinks and query settings.", "gd-content-tools")
    ),
    'permalinks' => array(
        'title' => __("Permalinks Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Advanced permalinks settings.", "gd-content-tools")
    ),
    'taxonomies' => array(
        'title' => __("Taxonomies Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Change assigned taxonomies.", "gd-content-tools")
    ),
    'capabilities' => array(
        'title' => __("Capabilities Edit", "gd-content-tools"),
        'icon' => 'edit', 'submit' => true,
        'description' => __("Change user capabilities for this post type.", "gd-content-tools")
    )
);

if ($_id == 0 && gdcet_admin()->panel != 'edit') {
    include(GDCET_PATH.'forms/shared/invalid.php');
} else {
    include(GDCET_PATH.'forms/shared/top.php');

    ?>

    <form method="post" action="" enctype="multipart/form-data">
        <?php settings_fields('gd-content-tools-cpt'); ?>

        <input type="hidden" value="internal" name="gdcetcpt[mode]" />
        <input type="hidden" value="<?php echo $_id; ?>" name="gdcetcpt[id]" />

        <input type="hidden" value="<?php echo $_panel; ?>" name="gdcetcpt[panel]" />
        <input type="hidden" value="postback" name="gdcet_handler" />

        <div class="d4p-content-left">
            <div class="d4p-panel-scroller d4p-scroll-active">
                <div class="d4p-panel-title">
                    <i class="fa fa-file-text-o"></i>
                    <h3><?php _e("Post Type", "gd-content-tools"); ?></h3>
                    <h4><i class="fa fa-<?php echo $panels_list[$_panel]['icon']; ?>"></i> <?php echo $panels_list[$_panel]['title']; ?></h4>
                </div>

                <div class="d4p-panel-title">
                   <?php echo $_subitle; ?>
                </div>

                <div class="d4p-panel-info">
                    <?php echo $panels_list[$_panel]['description']; ?>
                </div>
                <?php if ($panels_list[$_panel]['submit']) { ?>
                <div class="d4p-panel-buttons">
                    <input class="button-primary" type="submit" value="<?php _e("Save", "gd-content-tools"); ?>" />
                </div>
                <?php } ?>
                <div class="d4p-return-to-top">
                    <a href="#wpwrap"><?php _e("Return to top", "gd-content-tools"); ?></a>
                </div>
            </div>
        </div>
        <div class="d4p-content-right">
            <?php if (!is_null($_errors)) { ?>
            <div class="d4p-group d4p-group-error">
                <h3><?php _e("Errors", "gd-content-tools"); ?></h3>
                <div class="d4p-group-inner">
                    <p><?php _e("Please, fix these errors before post type can be saved.", "gd-content-tools"); ?></p>
                    <ul>
                        <?php foreach ($_errors->errors as $code => $r) { $_js_errors[] = $code; ?>
                        <li><?php echo join('</li><li>', $r); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>

            <?php

            if ($_panel == 'function') {
                include(GDCET_PATH.'forms/cpt/function.php');
            } else if ($_panel == 'templates') {
                include(GDCET_PATH.'forms/cpt/templates.php');
            } else {
                d4p_includes(array(
                    array('name' => 'walkers', 'directory' => 'admin'),
                    array('name' => 'settings', 'directory' => 'admin')
                ), GDCET_D4PLIB);

                require_once(GDCET_PATH.'core/admin/objects.php');

                $options = new gdcet_admin_data_objects();
                $options->data = $_object;
                $options->cpt();

                $groups = $options->get($_panel);

                $render = new d4pSettingsRender($_panel, $groups);
                $render->base = 'gdcetcpt';
                $render->render();
            }

            ?>
        </div>
    </form>

    <script type="text/javascript">
        var gdcet_global_errors_keys = ['<?php echo join("', '", $_js_errors) ?>'];
    </script>
    <?php

    include(GDCET_PATH.'forms/shared/bottom.php');
}
