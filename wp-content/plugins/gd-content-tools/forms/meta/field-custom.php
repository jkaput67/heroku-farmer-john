<?php

if (!is_null($_errors)) {
    $errors_js = array(
        'field' => array(),
        'items' => array()
    );

    $_errors_field = array();
    $_errors_items = false;

    foreach ($_errors->errors as $code => $r) {
        $parts = explode('.', $code);
        $coder = $parts[0];
        $scope = $parts[1];

        if ($scope == 'field') {
            $errors_js['field'][] = $coder;
            $_errors_field[] = join('</li><li>', $r);
        } else {
            $errors_js['items'][$scope][] = $coder;
        }
    }

?>
    <div class="d4p-group d4p-group-error">
        <h3><?php _e("Errors", "gd-content-tools"); ?></h3>
        <div class="d4p-group-inner">
            <?php if (!empty($errors_js['field'])) { ?>
                <p><?php _e("Please, fix these errors before this field can be saved.", "gd-content-tools"); ?></p>
                <ul>
                    <li><?php echo join('</li><li>', $_errors_field); ?></li>
                </ul>
            <?php } if (!empty($errors_js['items'])) { ?>
                <p style="margin: 1em 0 0;"><?php _e("Please, fix errors in individual field elements before this field can be saved.", "gd-content-tools"); ?></p>
            <?php } ?>
        </div>
    </div>

    <script type="text/javascript">
        var gdcet_meta_errors_keys = <?php echo json_encode($errors_js); ?>;
    </script>
<?php

}

$_classes = array('d4p-group', 'gdcet-group-meta-field', 'gdcet-meta-opened');
$_classes[] = 'gdcet-group-meta-field-custom';
$_classes[] = 'gdcet-group-field-main';

?>

<div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $_field_id; ?>">
    <h3>
        <?php _e("Meta Field", "gd-content-tools"); ?>: <span class="gdcet-field-name"><?php echo $_field->label; ?></span>
        <span class="gdcet-field-toggler"><i class="fa fa-minus-square"></i></span>
    </h3>
    <div class="d4p-group-inner">
        <div class="gdcet-field-block-basic">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e("Label", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-label" name="gdcet[field][label]" type="text" value="<?php echo esc_attr($_field->label); ?>" />
                            <p class="description">
                                <?php _e("Each field should have unique label.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Slug", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-slug" name="gdcet[field][slug]" type="text" value="<?php echo esc_attr($_field->slug); ?>" />
                            <p class="description">
                                <?php _e("Each field must have unique slug. Slug can contain lower case letters, numbers, hyphen and underscore.", "gd-content-tools"); ?><br />
                                <strong><?php _e("Slug is used as the field name in metabox and meta fields functions and objects.", "gd-content-tools"); ?></strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Description", "gd-content-tools"); ?></th>
                        <td>
                            <textarea class="widefat gdcet-field-property-basic-description" name="gdcet[field][description]"><?php echo esc_textarea($_field->description); ?></textarea>
                            <p class="description">
                                <?php _e("Description should explain the purpose of this field, and it will be displayed alongside the field control.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="gdcet-field-block-extended">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e("Required", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-required" name="gdcet[field][required]" type="checkbox"<?php echo $_field->required ? ' checked="checked"' : ''; ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Repeater", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-switch-property gdcet-field-property-basic-repeater" name="gdcet[field][repeater]" type="checkbox"<?php echo $_field->repeater ? ' checked="checked"' : ''; ?> />
                        </td>
                    </tr>
                    <tr style="<?php echo $_field->repeater ? '' : 'display: none;'; ?>">
                        <th scope="row"><?php _e("Repeater Limit", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-repeater_limit" name="gdcet[field][repeater_limit]" type="number" min="0" step="1" value="<?php echo esc_attr($_field->repeater_limit); ?>" />
                            <p class="description">
                                <?php _e("Leave to 0 to allow any number of repeated fields.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="gdcet-field-block-extras">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e("CSS Class", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-class" name="gdcet[field][class]" type="text" value="<?php echo esc_attr($_field->class); ?>" />
                            <p class="description">
                                <?php _e("This CSS class will be applied to the field in the editor, it is not related to display of saved data.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="clear"></div>

<table class="gdcet-meta-fields-wrapper">
    <caption><?php _e("List of included basic fields", "gd-content-tools"); ?></caption>
    <tbody>
        <tr>
            <td class="gdcet-meta-fields-control">
                <a href="#"><i class="fa fa-plus-square"></i></a>
            </td>
            <td class="gdcet-meta-fields-list">
                <div class="gdcet-meta-fields-list-wrapper">
                    <?php $_field->render(false, true); ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

