<?php

$_inner_classes = array(
    'gdcet-render-inner-field',
    'gdcet-render-inner-field-'.$_inner->b('type')
);

if ($_inner->is_required()) {
    $_inner_classes[] = 'gdcet-render-inner-field-required';
}

$_inner_required = $this->is_required() && $_inner->b('required');
$_inner_repeater = $_inner->b('repeater');

?>
<div class="<?php echo join(' ', $_inner_classes); ?>">
    <div class="gdcet-inner-label">
        <label><?php

        echo $_inner->b('label');

        if ($_inner_required) {
            echo '<span class="gdcet-field-is-required" title="'.__("This field is required.", "gd-content-tools").'">*</span>';
        }

        ?></label>
        <div class="gdcet-inner-description">
            <?php echo $_inner->b('description'); ?>
        </div>
    </div>
    <div class="gdcet-inner-input">
        <?php

        $_inner_next_index = $_inner->count_values();

        if ($_inner_next_index == 0) {
            $_inner_next_index = 1;
        }

        $_input_class = array(
            'gdcet-field-input-wrapper',
            'gdcet-field-inner-field',
            'gdcet-field-input-'.($_inner_repeater ? 'repeat' : 'single')
        );

        $_input_data = array(
            'data-repeater="'.($_inner_repeater ? '1' : '0').'"',
            'data-limit="'.$_inner->b("repeater_limit").'"',
            'data-field="'.$this->get_slug().'"',
            'data-inner="'.$_inner->b("slug").'"',
            'data-next-index="'.$_inner_next_index.'"',
            'data-parent="'.$_parent_index.'"'
        );

        ?>

        <div class="<?php echo join(' ', $_input_class); ?>" <?php echo join(' ', $_input_data); ?>>
            <?php

            if ($_inner_repeater) {
                $_inner_values = $_inner->count_values();

                for ($i = 0; $i < $_inner_values; $i++) {
                    $_mod_id_base = $_inner_id_base.'-'.$i;
                    $_mod_name_base = $_inner_name_base.'['.$i.']';

                    gdcet_field_render_wrap_repeater_open($i);
                    $_inner->form($_mod_id_base, $_mod_name_base, $i);
                    gdcet_field_render_wrap_repeater_close($i);
                }

                if ($_inner_values == 0) {
                    $_mod_id_base = $_inner_id_base.'-'.$i;
                    $_mod_name_base = $_inner_name_base.'['.$i.']';

                    gdcet_field_render_wrap_repeater_open(0, true);
                    $_inner->form($_mod_id_base, $_mod_name_base, 0);
                    gdcet_field_render_wrap_repeater_close();
                }
            } else {
                $_inner->form($_inner_id_base.'-0', $_inner_name_base.'[0]', 0);
            }
            
            ?>
        </div>
    </div>
</div>