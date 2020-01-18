<?php

$_field_id = 0;
$_field_blank = '';
$_field_type = '';
$_field = null;
$_errors = null;

$_js_errors = array();

include(GDCET_PATH.'forms/shared/top.php');

$panels = array(
    'index' => array(
        'title' => __("Meta Fields", "gd-content-tools"), 'icon' => 'th-list', 
        'info' => __("Manage meta fields from this panel.", "gd-content-tools")),
    'simple' => array(
        'title' => __("Simple Field", "gd-content-tools"), 'icon' => 'sticky-note', 
        'button' => 'submit', 'button_text' => __("Save", "gd-content-tools"),
        'info' => __("Simple field can contain only one basic meta field.", "gd-content-tools")),
    'custom' => array(
        'title' => __("Custom Field", "gd-content-tools"), 'icon' => 'ticket', 
        'button' => 'submit', 'button_text' => __("Save", "gd-content-tools"),
        'info' => __("Custom field can contain one or more basic meta fields.", "gd-content-tools"))
);

if ($_panel == '') {
    $_panel = 'index';
} else {
    $_feedback = gdcet_admin()->feedback !== false;

    if ($_feedback) {
        $_errors = gdcet_admin()->feedback['errors'];
        $_object = gdcet_admin()->feedback['object'];

        $_field_id = $_object['id'];
        $_field_type = $_object['type'];

        switch ($_field_type) {
            case 'custom':
                $_field = new gdcet_meta_custom_field($_object);
            case 'simple':
                $_field = new gdcet_meta_simple_field($_object);
        }
    } else {
        $_copy_id = isset($_GET['copy']) ? intval($_GET['copy']) : 0;

        $_field_blank = $_panel == 'simple' ? 'simple' : 'custom';

        if ($_copy_id > 0) {
            $_field = gdcet_meta()->get_field($_copy_id, $_field_blank);
            $_field->id = 0;
        } else {
            $_field_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $_field = gdcet_meta()->get_field($_field_id, $_field_blank);
        }
    }

    $_panel = $_field->type;
    $_field_type = $_field->type;
}

?>

<form method="post" action="" enctype="multipart/form-data" id="gdcet-tools-form">
    <?php settings_fields('gd-content-tools-meta-fields'); ?>

    <input type="hidden" value="<?php echo $_panel; ?>" name="gdcettools[panel]" />
    <input type="hidden" value="postback" name="gdcet_handler" />

    <input type="hidden" value="<?php echo $_field_id; ?>" name="gdcet[field][id]" />
    <input type="hidden" value="<?php echo $_field_type; ?>" name="gdcet[field][type]" id="gdcet-meta-field-editor-type" />
    <input type="hidden" value="<?php echo isset($_field->fields) ? join(',', array_keys($_field->fields)) : ''; ?>" name="gdcet[fields-order]" id="gdcet-meta-field-fields-order" />
    <input type="hidden" value="<?php echo isset($_field->fields) ? count($_field->fields) - 1 : 0; ?>" id="gdcet-meta-field-fields-count" />

    <div class="d4p-content-left">
        <div class="d4p-panel-scroller d4p-scroll-active">
            <div class="d4p-panel-title">
                <i class="fa fa-th-list"></i>
                <h3><?php _e("Meta Fields", "gd-content-tools"); ?></h3>
                <?php if ($_panel != 'index') { ?>
                <h4><i class="fa fa-<?php echo $panels[$_panel]['icon']; ?>"></i> <?php echo $panels[$_panel]['title']; ?></h4>
                <?php } ?>
            </div>
            <div class="d4p-panel-info">
                <?php echo $panels[$_panel]['info']; ?>
            </div>
            <?php if ($_panel != 'index') { ?>
                <div class="d4p-panel-buttons">
                    <input id="gdcet-tool-<?php echo $_panel; ?>" class="button-primary" type="<?php echo $panels[$_panel]['button']; ?>" value="<?php echo $panels[$_panel]['button_text']; ?>" />
                </div>
            <?php } else { ?>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <?php _e("For a regular meta field with one field type, use Simple Field.", "gd-content-tools"); ?>
                    <a style="margin-top: 10px; text-align: center;" class="button-secondary" href="<?php echo admin_url('admin.php?page=gd-content-tools-meta-fields&panel=simple') ?>"><?php _e("New Simple Field", "gd-content-tools"); ?></a>
                </div>
                <div class="d4p-panel-buttons" style="text-align: center;">
                    <?php _e("For complex meta field made from more than one field type, use Custom Field.", "gd-content-tools"); ?>
                    <a style="margin-top: 10px; text-align: center;" class="button-secondary" href="<?php echo admin_url('admin.php?page=gd-content-tools-meta-fields&panel=custom') ?>"><?php _e("New Custom Field", "gd-content-tools"); ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="d4p-content-right">
        <?php

        if ($_panel == 'index') {
            require_once(GDCET_PATH.'meta/grids/fields.php');

            $_grid = new gdcet_field_grid();
            $_grid->prepare_items();
            $_grid->views();
            $_grid->display();
        } else {
            include(GDCET_PATH.'forms/meta/field-'.$_panel.'.php');
        }

        ?>
    </div>
</form>

<?php 

include(GDCET_PATH.'forms/shared/bottom.php');
