<?php

$_field_classes = array(
    'gdcet-render-metabox-field',
    'gdcet-render-metabox-field-'.$_field->type
);

if ($_field->is_required()) {
    $_field_classes[] = 'gdcet-render-metabox-field-required';
}

$_field_required = $_field->is_required();
$_field_repeater = $_meta_box->is_repeater() && $_field->is_repeater();

?>

<div class="<?php echo join(' ', $_field_classes); ?>">
    <div class="gdcet-field-label">
        <label><?php

        echo $_field->get_label();

        if ($_field->is_required()) {
            echo '<span class="gdcet-field-is-required" title="'.__("This field is required.", "gd-content-tools").'">*</span>';
        }

        ?></label>
        <?php if ($_meta_box->information == 'label') { ?>
        <div class="gdcet-field-description">
            <?php echo $_field->get_description(); ?>
        </div>
        <?php } ?>
    </div>
    <div class="gdcet-field-input">
        <?php

        $_field_next_index = $_field->count_values();

        if ($_field_next_index == 0) {
            $_field_next_index = 1;
        }

        $_input_class = array(
            'gdcet-field-input-wrapper',
            'gdcet-field-input-'.($_field_repeater ? 'repeat' : 'single'),
            'gdcet-field-type-'.$_field->type
        );

        $_input_data = array(
            'data-repeater="'.($_field_repeater ? '1' : '0').'"',
            'data-limit="'.$_field->get_repeater_limit().'"',
            'data-field="'.$_field->get_slug().'"',
            'data-next-index="'.$_field_next_index.'"'
        );

        ?>

        <div class="<?php echo join(' ', $_input_class); ?>" <?php echo join(' ', $_input_data); ?>>
            <?php

            if ($_field_repeater) {
                $_field_values = $_field->count_values();

                for ($i = 0; $i < $_field_values; $i++) {
                    gdcet_field_render_wrap_repeater_open($i);
                    $_field->form($_id_base, $_name_base, $i);
                    gdcet_field_render_wrap_repeater_close($i);
                }

                if ($_field_values == 0) {
                    gdcet_field_render_wrap_repeater_open(0, true);
                    $_field->form($_id_base, $_name_base, 0);
                    gdcet_field_render_wrap_repeater_close();
                }
            } else {
                $_field->form($_id_base, $_name_base, 0);
            }

            ?>
        </div>
        <?php if ($_meta_box->information == 'field') { ?>
        <div class="gdcet-field-description">
            <?php echo $_field->get_description(); ?>
        </div>
        <?php } ?>
    </div>
</div>
