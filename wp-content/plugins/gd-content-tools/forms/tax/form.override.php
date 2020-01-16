<?php

global $_name;

$_object = null;
$_name = isset($_GET['name']) ? sanitize_text_field($_GET['name']) : '';

if (taxonomy_exists($_name)) {
    $_object = gdcet_ctrl()->get_tax_override($_name);
}

if ($_object === false) {
    include(GDCET_PATH.'forms/shared/invalid.php');
} else {
    $_subitle = '<h5>'.__("Editing Taxonomy", "gd-content-tools").'</h5>';
    $_subitle.= '<h4>'.$_object['taxonomy'].'</h4>';

    include(GDCET_PATH.'forms/shared/top.php');

    $panels_list = array(
        'features' => array(
            'title' => __("Features Edit", "gd-content-tools"),
            'icon' => 'edit', 'submit' => true,
            'description' => __("Edit various post type features.", "gd-content-tools")
        ),
        'post_types' => array(
            'title' => __("Post Types Edit", "gd-content-tools"),
            'icon' => 'edit', 'submit' => true,
            'description' => __("Change assigned post types for this taxonomy.", "gd-content-tools")
        )
    );

    ?>

    <form method="post" action="" enctype="multipart/form-data">
        <?php settings_fields('gd-content-tools-tax'); ?>

        <input type="hidden" value="named" name="gdcettax[mode]" />
        <input type="hidden" value="<?php echo $_name; ?>" name="gdcettax[name]" />

        <input type="hidden" value="<?php echo $_panel; ?>" name="gdcettax[panel]" />
        <input type="hidden" value="postback" name="gdcet_handler" />

        <div class="d4p-content-left">
            <div class="d4p-panel-scroller d4p-scroll-active">
                <div class="d4p-panel-title">
                    <i class="fa fa-file-text-o"></i>
                    <h3><?php _e("Taxonomy", "gd-content-tools"); ?></h3>
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
            <?php

            d4p_includes(array(
                array('name' => 'walkers', 'directory' => 'admin'),
                array('name' => 'settings', 'directory' => 'admin')
            ), GDCET_D4PLIB);

            require_once(GDCET_PATH.'core/admin/objects.php');

            $options = new gdcet_admin_data_objects();
            $options->data = $_object;
            $options->tax_override();

            $groups = $options->get($_panel);

            $render = new d4pSettingsRender($_panel, $groups);
            $render->base = 'gdcettax';
            $render->render();

            ?>
        </div>
    </form>

    <?php

    include(GDCET_PATH.'forms/shared/bottom.php');
}