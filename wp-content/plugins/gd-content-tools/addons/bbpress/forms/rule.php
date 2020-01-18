<?php

include(GDCET_PATH.'forms/shared/top.php');

$rule_id = isset($_GET['rule']) ? absint($_GET['rule']) : 0;
$rule = gdcet_bbpress()->get_rule($rule_id);

?>

<form method="post" action="" id="gdcet-tools-form">
    <?php settings_fields('gd-content-tools-bbpress'); ?>

    <input type="hidden" value="bbpress-rule" name="gdcetbbpmeta[panel]" />
    <input type="hidden" value="postback" name="gdcet_handler" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="d4p-icon d4p-logo-bbpress"></i>
                <h3><?php _e("Meta bbPress", "gd-content-tools"); ?></h3>
                <h4><i class="fa fa-file"></i> <?php _e("Rule Editor", "gd-content-tools"); ?></h4>
            </div>
            <div class="d4p-panel-info">
                <?php _e("Assign meta box to one or more forums and topic or reply forms.", "gd-content-tools"); ?>
            </div>
            <div class="d4p-panel-buttons">
                <input id="gdcet-tool-<?php echo $_panel; ?>" class="button-primary" type="submit" value="<?php _e("Save Rule", "gd-content-tools"); ?>" />
            </div>
        </div>
    </div>
    <div class="d4p-content-right">

        <?php

        d4p_includes(array(
            array('name' => 'walkers', 'directory' => 'admin'),
            array('name' => 'settings', 'directory' => 'admin')
        ), GDCET_D4PLIB);

        include(GDCET_PATH.'addons/bbpress/code/options.php');

        $options = new gdcet_bbpress_data_options($rule);

        $groups = $options->get('rule');

        $render = new d4pSettingsRender('rule', $groups);
        $render->base = 'gdcetbbpmeta';
        $render->render();

        ?>

    </div>
</form>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
