<?php

if (!defined('ABSPATH')) exit;

$_box_id = 0;
$_box_blank = '';
$_box_type = '';
$_box = null;
$_errors = null;

$_js_errors = array();

include(GDCET_PATH.'forms/shared/top.php');

$panels = array(
    'index' => array(
        'title' => __("Meta Boxes", "gd-content-tools"), 'icon' => 'th-large', 
        'info' => __("Manage meta boxes from this panel.", "gd-content-tools")),
    'legacy' => array(
        'title' => __("Legacy Box", "gd-content-tools"), 'icon' => 'square-o', 
        'button' => 'submit', 'button_text' => __("Save", "gd-content-tools"),
        'info' => __("Meta box that is compatible with old plugin version with simple meta fields support only.", "gd-content-tools")),
    'meta' => array(
        'title' => __("Meta Box", "gd-content-tools"), 'icon' => 'square', 
        'button' => 'submit', 'button_text' => __("Save", "gd-content-tools"),
        'info' => __("Meta box supporting both simple and custom meta fields.", "gd-content-tools")),
    'php' => array(
        'title' => __("Metabox Code", "gd-content-tools"), 'icon' => 'square', 
        'button' => 'none', 'button_text' => '',
        'info' => __("Example code to quickly start with the meta box implementation.", "gd-content-tools"))
);

if ($_panel == '') {
    $_panel = 'index';
} else if ($_panel == 'php') {
    
} else {
    $_feedback = gdcet_admin()->feedback !== false;

    if ($_feedback) {
        $_errors = gdcet_admin()->feedback['errors'];
        $_object = gdcet_admin()->feedback['object'];

        $_box_id = $_object['id'];
        $_box_type = $_object['type'];

        switch ($_box_type) {
            case 'legacy':
                $_box = new gdcet_meta_legacy_box($_object);
            case 'meta':
                $_box = new gdcet_meta_meta_box($_object);
        }
    } else {
        $_copy_id = isset($_GET['copy']) ? intval($_GET['copy']) : 0;

        $_box_blank = $_panel == 'legacy' ? 'legacy' : 'meta';

        if ($_copy_id > 0) {
            $_box = gdcet_meta()->get_box($_copy_id, $_box_blank);
            $_box->id = 0;
        } else {
            $_box_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $_box = gdcet_meta()->get_box($_box_id, $_box_blank);
        }
    }

    $_panel = $_box->type;
    $_box_type = $_box->type;
}

?>

<form method="post" action="" enctype="multipart/form-data" id="gdcet-tools-form">
    <?php settings_fields('gd-content-tools-meta-boxes'); ?>

    <input type="hidden" value="<?php echo $_panel; ?>" name="gdcettools[panel]" />
    <input type="hidden" value="postback" name="gdcet_handler" />

    <input type="hidden" value="<?php echo $_box_id; ?>" name="gdcet[box][id]" />
    <input type="hidden" value="<?php echo $_box_type; ?>" name="gdcet[box][type]" id="gdcet-meta-box-editor-type" />
    <input type="hidden" value="<?php echo isset($_box->fields) ? join(',', array_keys($_box->fields)) : ''; ?>" name="gdcet[box-order]" id="gdcet-meta-box-fields-order" />
    <input type="hidden" value="<?php echo isset($_box->fields) ? count($_box->fields) - 1 : 0; ?>" id="gdcet-meta-box-fields-count" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-th-large"></i>
                <h3><?php _e("Meta Boxes", "gd-content-tools"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel == 'legacy' || $_panel == 'meta') { ?>
                <div class="d4p-panel-buttons">
                    <input id="gdcet-tool-<?php echo $_panel; ?>" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                </div>
            <?php } else if ($_panel == 'index') { ?>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <?php _e("If you use only Simple meta fields, use the Legacy box.", "gd-content-tools"); ?>
                    <a style="margin-top: 10px; text-align: center;" class="button-secondary" href="<?php echo admin_url('admin.php?page=gd-content-tools-meta-boxes&panel=legacy') ?>"><?php _e("New Legacy Box", "gd-content-tools"); ?></a>
                </div>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <?php _e("If you need to use Custom meta fields (and/or Simple meta fields), use the Meta Box.", "gd-content-tools"); ?>
                    <a style="margin-top: 10px; text-align: center;" class="button-secondary" href="<?php echo admin_url('admin.php?page=gd-content-tools-meta-boxes&panel=meta') ?>"><?php _e("New Meta Box", "gd-content-tools"); ?></a>
                </div>
            <?php } else if ($_panel == 'php') { ?>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <?php _e("These are examples on how to get and display meta data saved with the meta box. Depending on your project, you will need to adjust them. Make sure to check out the knowledge base.", "gd-content-tools"); ?>
                </div>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <strong><?php _e("These examples require basic understanding of PHP and WordPress development.", "gd-content-tools"); ?></strong>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            require_once(GDCET_PATH.'meta/grids/boxes.php');

            $_grid = new gdcet_box_grid();
            $_grid->prepare_items();
            $_grid->views();
            $_grid->display();
        } else {
            include(GDCET_PATH.'forms/meta/box-'.$_panel.'.php');
        }

        ?>
    </div>
</form>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
