<?php

$_classes = array('d4p-group', 'gdcet-group-meta-field');
$_classes[] = 'gdcet-group-meta-field-'.$field_type;
$_classes[] = 'gdcet-meta-'.($show_open ? 'opened' : 'closed');

$_toggle = $show_open ? 'fa fa-minus-square' : 'fa fa-plus-square';

?>
<div id="gdcet-field-element-<?php echo $field_id; ?>" class="<?php echo join(' ', $_classes); ?>" data-field="<?php echo $field_id; ?>">
    <h3<?php echo $show_open ? '' : ' class="gdcet-group-sort-handler"'; ?>>
        <span class="gdcet-field-icon"><i title="<?php echo $this->label; ?>" class="fa fa-<?php echo $this->icon; ?>"></i></span>
        <?php _e("Element", "gd-content-tools"); ?>: <span class="gdcet-field-name"><?php echo $this->basic['label']; ?></span>
        <span class="gdcet-field-toggler"><i class="<?php echo $_toggle; ?>"></i></span>
    </h3>
    <div class="d4p-group-inner">
        <div class="gdcet-field-block-control">
            <div class="gdcet-field-move">
                <a class="gdcet-field-move-up" href="#"><?php _e("Move up", "gd-content-tools"); ?></a><a class="gdcet-field-move-down" href="#"><?php _e("Move down", "gd-content-tools"); ?></a>
            </div>
            <input class="button-secondary" type="button" value="<?php _e("Remove this element", "gd-content-tools"); ?>" />
        </div>
        <div class="gdcet-field-block-basic">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e("Label", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-label" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][label]" type="text" value="<?php echo esc_attr($this->basic['label']); ?>" />
                            <p class="description">
                                <?php _e("Each field should have unique label.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Slug", "gd-content-tools"); ?> <span class="gdcet-is-required" title="<?php _e("This field is required", "gd-content-tools"); ?>">*</span></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-slug" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][slug]" type="text" value="<?php echo esc_attr($this->basic['slug']); ?>" />
                            <p class="description">
                                <?php _e("Each field must have unique slug. Slug can contain lower case letters, numbers, hyphen and underscore.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Description", "gd-content-tools"); ?></th>
                        <td>
                            <textarea class="widefat gdcet-field-property-basic-description" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][description]"><?php echo esc_textarea($this->basic['description']); ?></textarea>
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
                            <input class="widefat gdcet-field-property-basic-required" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][required]" type="checkbox"<?php echo $this->basic['required'] ? ' checked="checked"' : ''; ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php _e("Repeater", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-switch-property gdcet-field-property-basic-repeater" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][repeater]" type="checkbox"<?php echo $this->basic['repeater'] ? ' checked="checked"' : ''; ?> />
                        </td>
                    </tr>
                    <tr style="<?php echo $this->basic['repeater'] ? '' : 'display: none;'; ?>">
                        <th scope="row"><?php _e("Repeater Limit", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-repeater_limit" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][repeater_limit]" type="number" min="0" step="1" value="<?php echo esc_attr($this->basic['repeater_limit']); ?>" />
                            <p class="description">
                                <?php _e("Leave to 0 to allow any number of repeated fields.", "gd-content-tools"); ?>
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
                        <th scope="row"><?php _e("Type", "gd-content-tools"); ?></th>
                        <td>
                            <?php

                            gdcet_render_grouped_select(gdcet_meta_basic_fields_select_list(), array('selected' => $this->basic['type'], 'name' => 'gdcet[field][fields]['.$field_id.'][basic][type]', 'class' => 'widefat gdcet-field-property-basic-type'));

                            ?>
                            <p class="description">
                                <?php _e("Changing type of the field will load settings specific for the newely selected type, and previous settings will be lost. Type specific settings are listed below.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="gdcet-field-block-type-loading" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-fw"></i> <?php _e("Please wait...", "gd-content-tools"); ?>
        </div>
        <div class="gdcet-field-block-settings">
            <?php $this->controls($field_id, true); ?>
        </div>
        <div class="gdcet-field-block-extras">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php _e("CSS Class", "gd-content-tools"); ?></th>
                        <td>
                            <input class="widefat gdcet-field-property-basic-class" name="gdcet[field][fields][<?php echo $field_id; ?>][basic][class]" type="text" value="<?php echo esc_attr($this->basic['class']); ?>" />
                            <p class="description">
                                <?php _e("This CSS class will be applied to the element in the editor, it is not related to display of saved data.", "gd-content-tools"); ?>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
