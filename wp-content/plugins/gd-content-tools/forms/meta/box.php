<?php

$all_fields = array();
$list_fields = array(
    'simple' => array('title' => __("Simple Fields", "gd-content-tools"), 'values' => array()),
    'custom' => array('title' => __("Custom Fields", "gd-content-tools"), 'values' => array())
);

$list_priorities = array(
    'default' => __("Default", "gd-content-tools"),
    'low' => __("Low", "gd-content-tools"),
    'high' => __("High", "gd-content-tools")
);

$list_locations = array(
    'side' => __("Side", "gd-content-tools"),
    'normal' => __("Normal", "gd-content-tools"),
    'advanced' => __("Advanced", "gd-content-tools")
);

$list_layouts = array(
    'left' => __("Left aligned labels", "gd-content-tools"),
    'top' => __("Top aligned labels", "gd-content-tools")
);

$list_information = array(
    'label' => __("Under the label", "gd-content-tools"),
    'field' => __("Under the field", "gd-content-tools")
);

foreach (gdcet_settings()->current['meta']['fields'] as $id => $field) {
    $add = false;

    if ($_box_type == 'legacy') {
        if ($field['type'] == 'simple') {
            $add = true;
        }
    } else {
        $add = true;
    }

    if ($add) {
        $f = null;

        switch ($field['type']) {
            case 'simple':
                $f = new gdcet_meta_simple_field($field);
                break;
            case 'custom':
                $f = new gdcet_meta_custom_field($field);
                break;
        }

        $all_fields[$f->id] = $f;
        $list_fields[$field['type']]['values'][$f->id] = $f->get_label();
    }
}

if (empty($list_fields['simple']['values'])) {
    unset($list_fields['simple']);
}

if (empty($list_fields['custom']['values'])) {
    unset($list_fields['custom']);
}

if (!empty($list_fields)) {
    if (!is_null($_errors)) {

    ?>
        <div class="d4p-group d4p-group-error">
            <h3><?php _e("Errors", "gd-content-tools"); ?></h3>
            <div class="d4p-group-inner">
                <p><?php _e("Please, fix these errors before this box can be saved.", "gd-content-tools"); ?></p>
                <ul>
                    <?php foreach ($_errors->errors as $code => $r) { 
                        $parts = explode('.', $code);
                        $_js_errors[] = $parts[0]; ?>
                    <li><?php echo join('</li><li>', $r); ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <script type="text/javascript">
            var gdcet_meta_errors_keys = ['<?php echo join("', '", $_js_errors) ?>'];
        </script>
    <?php

    }

    $_classes = array('d4p-group', 
        'gdcet-group-meta-field', 
        'gdcet-group-meta-box', 
        'gdcet-meta-opened',
        'gdcet-group-meta-box-'.$_box_type,
        'gdcet-group-box-main');

    ?>
    <div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $_box_id; ?>">
        <h3>
            <?php _e("Meta Box", "gd-content-tools"); ?>: <span class="gdcet-field-name"><?php echo $_box->label; ?></span>
            <span class="gdcet-field-toggler"><i class="fa fa-minus-square"></i></span>
        </h3>
        <div class="d4p-group-inner">
            <div class="gdcet-field-block-basic">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e("Label", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                            <td>
                                <input class="widefat gdcet-box-property-label" name="gdcet[box][label]" type="text" value="<?php echo esc_attr($_box->label); ?>" />
                                <p class="description">
                                    <?php _e("Each box should have unique label.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e("Slug", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                            <td>
                                <input class="widefat gdcet-box-property-slug" name="gdcet[box][slug]" type="text" value="<?php echo esc_attr($_box->slug); ?>" />
                                <p class="description">
                                    <?php _e("Each box must have unique slug. Slug can contain lower case letters, numbers, hyphen and underscore.", "gd-content-tools"); ?><br />
                                    <strong><?php _e("Slug is used as the box name in metabox functions and objects.", "gd-content-tools"); ?></strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e("Description", "gd-content-tools"); ?></th>
                            <td>
                                <textarea class="widefat gdcet-box-property-description" name="gdcet[box][description]"><?php echo esc_textarea($_box->description); ?></textarea>
                                <p class="description">
                                    <?php _e("Description should explain the purpose of this box, and it will be displayed on top of the meta box.", "gd-content-tools"); ?>
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
                            <th scope="row"><?php _e("Repeater", "gd-content-tools"); ?></th>
                            <td>
                                <input class="widefat gdcet-box-property-repeater" name="gdcet[box][repeater]" type="checkbox"<?php echo $_box->repeater ? ' checked="checked"' : ''; ?> />
                                <p class="description">
                                    <?php _e("If this option is disabled, all the fields will be forced to have repeater disabled too.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="gdcet-field-block-type">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e("Field Layout", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                d4p_render_select($list_layouts, array('selected' => $_box->layout, 'name' => 'gdcet[box][layout]', 'class' => 'widefat gdcet-box-property-layout'));

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e("Field Information", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                d4p_render_select($list_information, array('selected' => $_box->information, 'name' => 'gdcet[box][information]', 'class' => 'widefat gdcet-box-property-information'));

                                ?>
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
                                <input class="widefat gdcet-box-property-class" name="gdcet[box][class]" type="text" value="<?php echo esc_attr($_box->class); ?>" />
                                <p class="description">
                                    <?php _e("This CSS class will be applied to the meta box in the editor, it is not related to display of saved data.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <h2 class="gdcet-box-integration"><?php _e("Integration", "gd-content-tools"); ?></h2>

    <?php

    $_classes = array('d4p-group', 
        'gdcet-group-meta-field', 
        'gdcet-group-meta-box', 
        'gdcet-meta-closed',
        'gdcet-group-box-main');

    ?>
    <div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $_box_id; ?>">
        <h3>
            <?php _e("Add this Metabox into Post editor", "gd-content-tools"); ?>:
            <span class="gdcet-field-toggler"><i class="fa fa-plus-square"></i></span>
        </h3>
        <div class="d4p-group-inner">
            <div class="gdcet-field-block-basic">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e("Post Types", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                $_post_types = get_post_types(array('public' => true), 'objects');
                                $post_types = array();

                                foreach ($_post_types as $name => $obj) {
                                    if ($name != 'attachment') {
                                        $post_types[$name] = $obj->label;
                                    }
                                }

                                d4p_render_checkradios($post_types, array('selected' => $_box->get_types('post_types'), 'name' => 'gdcet[box][types][post_types]'));

                                ?>
                                <p class="description">
                                    <?php _e("This metabox will be integrated into editors for selected post types.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e("Priority", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                d4p_render_select($list_priorities, array('selected' => $_box->priority, 'name' => 'gdcet[box][priority]', 'class' => 'widefat gdcet-box-property-priority'));

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e("Location", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                d4p_render_select($list_locations, array('selected' => $_box->location, 'name' => 'gdcet[box][location]', 'class' => 'widefat gdcet-box-property-location'));

                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $_box_id; ?>">
        <h3>
            <?php _e("Add this Metabox into Term editor", "gd-content-tools"); ?>:
            <span class="gdcet-field-toggler"><i class="fa fa-plus-square"></i></span>
        </h3>
        <div class="d4p-group-inner">
            <div class="gdcet-field-block-extended">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e("Taxonomies", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                $_taxonomies = get_taxonomies(array('public' => true), 'objects');
                                $taxonomies = array();

                                foreach ($_taxonomies as $name => $obj) {
                                    $taxonomies[$name] = $obj->label;
                                }

                                d4p_render_checkradios($taxonomies, array('selected' => $_box->get_types('taxonomies'), 'name' => 'gdcet[box][types][taxonomies]'));

                                ?>
                                <p class="description">
                                    <?php _e("This metabox will be integrated into term editors for selected taxonomies.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $_box_id; ?>">
        <h3>
            <?php _e("Add this Metabox into User profile editor", "gd-content-tools"); ?>:
            <span class="gdcet-field-toggler"><i class="fa fa-plus-square"></i></span>
        </h3>
        <div class="d4p-group-inner">
            <div class="gdcet-field-block-extras">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><?php _e("User Roles", "gd-content-tools"); ?></th>
                            <td>
                                <?php

                                global $wp_roles;

                                d4p_render_checkradios($wp_roles->get_names(), array('selected' => $_box->get_types('user_roles'), 'name' => 'gdcet[box][types][user_roles]'));

                                ?>
                                <p class="description">
                                    <?php _e("This metabox will be integrated into user editors for users belonging to selected user roles.", "gd-content-tools"); ?>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="clear"></div>

    <?php

    include(GDCET_PATH.'forms/meta/box-fields.php');

    ?>

    <?php
} else {
    ?>

    <div>
        <?php _e("There are no fields available for this meta box.", "gd-content-tools"); ?>
    </div>

    <?php
}
