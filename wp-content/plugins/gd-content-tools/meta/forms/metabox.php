<?php

require_once(GDCET_PATH.'meta/forms/functions.php');

$_name_base = 'gdcet-metabox['.$_render_args['metabox'].']';
$_id_base = 'gdcet-metabox-'.$_render_args['metabox'].'-';

$_meta_box = gdcet_meta()->get_box($_render_args['metabox']);
$_meta_box->prepare($_render_args['type'], $_render_args['id']);

$_metabox_classes = array(
    'gdcet-render-metabox-wrapper',
    'gdcet-render-metabox-layout-'.$_meta_box->layout,
    'gdcet-render-metabox-information-'.$_meta_box->information
);

$_no_tabs = array();
$_list_tabs = array();

$id = -1;

foreach ($_meta_box->fields as $field) {
    if ($field['open_tab']) {
        $id++;
        $_list_tabs[$id] = array('label' => $field['tab_label'], 'fields' => array($field['field_id']));
    } else if (empty($_list_tabs)) {
        $_no_tabs[] = $field['field_id'];
    } else {
        $_list_tabs[$id]['fields'][] = $field['field_id'];
    }
}

$_metabox_data = array(
    'data-nonce="'.$_render_args['nonce'].'"',
    'data-metabox="'.$_render_args['metabox'].'"',
    'data-type="'.$_render_args['type'].'"',
    'data-name="'.$_render_args['name'].'"',
    'data-id="'.$_render_args['id'].'"'
);

?>
<div class="<?php echo join(' ', $_metabox_classes); ?>" <?php echo join(' ', $_metabox_data); ?>>
    <input type="hidden" name="<?php echo $_name_base; ?>[init][nonce]" value="<?php echo $_render_args['nonce']; ?>" />
    <input type="hidden" name="<?php echo $_name_base; ?>[init][scope]" value="<?php echo $_render_args['scope']; ?>" />
    <input type="hidden" name="<?php echo $_name_base; ?>[init][metabox]" value="<?php echo $_render_args['metabox']; ?>" />
    <input type="hidden" name="<?php echo $_name_base; ?>[init][type]" value="<?php echo $_render_args['type']; ?>" />
    <input type="hidden" name="<?php echo $_name_base; ?>[init][name]" value="<?php echo $_render_args['name']; ?>" />
    <input type="hidden" name="<?php echo $_name_base; ?>[init][id]" value="<?php echo $_render_args['id']; ?>" />

    <?php if ($_meta_box->description != '') { ?>
    <div class="gdcet-render-metabox-description">
        <?php echo $_meta_box->description; ?>
    </div>
    <?php } ?>
    <div class="gdcet-render-metabox-fields">
        <?php

            $_name_base.= '[fields]';
            $_id_base.= 'fields-';

            foreach ($_meta_box->data as $_field) {
                if (in_array($_field->id, $_no_tabs)) {
                    include(GDCET_PATH.'meta/forms/field.php');
                }
            }

            if (!empty($_list_tabs)) {
                include(GDCET_PATH.'meta/forms/tabs.php');
            }

        ?>
    </div>
</div>
