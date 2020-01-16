<?php

function gdcet_box_single_field($fields, $all_fields, $field = array(), $toggle = true) {
    $default = array(
        'id' => '%id%',
        'open_tab' => false,
        'tab_label' => '',
        'field_id' => 0
    );

    $field = wp_parse_args($field, $default);

    $_classes = array(
        'd4p-group', 
        'gdcet-group-meta-field', 
        'gdcet-meta-box-single-field');
    $_classes[] = 'gdcet-meta-'.($toggle ? 'opened' : 'closed');

    $_toggle = $toggle ? 'fa fa-minus-square' : 'fa fa-plus-square';

    ?>

<div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $field['id']; ?>">
    <h3<?php echo $toggle ? '' : ' class="gdcet-group-sort-handler"'; ?>>
        <span class="gdcet-field-icon"><i class="fa fa-square"></i></span>
        <?php _e("Field", "gd-content-tools"); ?>: <span class="gdcet-field-name"><?php echo isset($all_fields[$field['field_id']]) ? $all_fields[$field['field_id']]->get_label() : ''; ?></span>
        <span class="gdcet-field-toggler"><i class="<?php echo $_toggle; ?>"></i></span>
    </h3>
    <div class="d4p-group-inner">
        <div class="gdcet-field-block-control">
            <div class="gdcet-field-move">
                <a class="gdcet-field-move-up" href="#"><?php _e("Move up", "gd-content-tools"); ?></a><a class="gdcet-field-move-down" href="#"><?php _e("Move down", "gd-content-tools"); ?></a>
            </div>
            <input name="" class="button-secondary" type="button" value="<?php _e("Remove this element", "gd-content-tools"); ?>" />
        </div>
        <div class="gdcet-field-block-basic">
            <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><?php _e("Start new tab", "gd-content-tools"); ?></th>
                <td>
                    <input class="widefat gdcet-field-switch-property gdcet-metabox-field-open-tab" name="gdcet[box][fields][<?php echo $field['id']; ?>][open_tab]" type="checkbox"<?php echo $field['open_tab'] ? ' checked="checked"' : ''; ?> />
                </td>
            </tr>
            <tr style="<?php echo $field['open_tab'] ? '' : 'display: none;'; ?>">
                <th scope="row"><?php _e("Tab Label", "gd-content-tools"); ?></th>
                <td>
                    <input class="widefat gdcet-metabox-field-tab-label" name="gdcet[box][fields][<?php echo $field['id']; ?>][tab_label]" type="text" value="<?php echo esc_attr($field['tab_label']); ?>" />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Field", "gd-content-tools"); ?></th>
                <td>
                    <?php

                    gdcet_render_grouped_select($fields, array('selected' => $field['field_id'], 'name' => 'gdcet[box][fields]['.$field['id'].'][field_id]', 'class' => 'widefat gdcet-metabox-field-field-id'));

                    ?>
                    <p class="description">
                        <?php _e("Each field can be used once!", "gd-content-tools"); ?>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
        </div>
    </div>
</div>

    <?php
}

?>
<table class="gdcet-meta-fields-wrapper">
    <caption><?php _e("List of included fields", "gd-content-tools"); ?></caption>
    <tbody>
        <tr>
            <td class="gdcet-meta-fields-control">
                <a href="#"><i class="fa fa-plus-square"></i></a>
            </td>
            <td class="gdcet-meta-fields-list">
                <div class="gdcet-meta-fields-list-wrapper" style="display: <?php echo empty($_box->fields) ? 'none' : 'block'; ?>">
                    <?php

                    $id = 0;
                    foreach ($_box->fields as $item) {
                        $item['id'] = $id;

                        gdcet_box_single_field($list_fields, $all_fields, $item, false);

                        $id++;
                    }

                    ?>
                </div>
                <div class="gdcet-meta-fields-empty" style="display: <?php echo empty($_box->fields) ? 'block' : 'none'; ?>">
                    <?php _e("There are no fields in this meta box. Use the button on the left to add one or more fields.", "gd-content-tools"); ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<div id="gdcet-box-meta-fields-holder" style="display: none;">
    <?php gdcet_box_single_field($list_fields, $all_fields); ?>
</div>
