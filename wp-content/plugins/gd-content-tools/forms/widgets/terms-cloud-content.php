<?php

$_sel_orderby = array(
    'name' => __("Term name", "gd-content-tools"), 
    'slug' => __("Term slug", "gd-content-tools"), 
    'count' => __("Posts count", "gd-content-tools"), 
    'rand' => __("Random", "gd-content-tools") 
);

$_sel_order = array(
    'ASC' => __("Ascending", "gd-content-tools"), 
    'DESC' => __("Descending", "gd-content-tools")
);

$_sel_taxonomy = gdcet_get_taxonomies(array('public' => true, 'show_tagcloud' => true), 'list');

$_sel_post_type = array_merge(array('any' => __("All post types", "gd-content-tools")), gdcet_get_post_types(array('public' => true, 'has_taxonomies' => true), 'list'));

?>
<h4><?php _e("Taxonomy and Post Type", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e("Taxonomy", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select($_sel_taxonomy, array('id' => $this->get_field_id('taxonomy'), 'class' => 'widefat', 'name' => $this->get_field_name('taxonomy'), 'selected' => $instance['taxonomy'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('post_types'); ?>"><?php _e("Post Type", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select($_sel_post_type, array('id' => $this->get_field_id('post_types'), 'class' => 'widefat', 'name' => $this->get_field_name('post_types'), 'selected' => $instance['post_types'])); ?>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Extra Options", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e("Limit number of terms", "gd-content-tools"); ?>:</label>
                <input class="widefat d4p-setting-integer" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $instance['number']; ?>" />
            </td>
            <td class="cell-right">
                <label><?php _e("And more", "gd-content-tools"); ?>:</label>
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('hide_empty'); ?>">
                        <input class="widefat" <?php echo $instance['hide_empty'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('hide_empty'); ?>" name="<?php echo $this->get_field_name('hide_empty'); ?>" />
                        <?php _e("Hide empty terms", "gd-content-tools"); ?></label>

                    <label for="<?php echo $this->get_field_id('mark_current'); ?>">
                        <input class="widefat" <?php echo $instance['mark_current'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('mark_current'); ?>" name="<?php echo $this->get_field_name('mark_current'); ?>" />
                        <?php _e("Mark current term", "gd-content-tools"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Terms ordering", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e("Order By", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select($_sel_orderby, array('id' => $this->get_field_id('orderby'), 'class' => 'widefat', 'name' => $this->get_field_name('orderby'), 'selected' => $instance['orderby'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('order'); ?>"><?php _e("Order", "gd-content-tools"); ?>:</label>
                <?php d4p_render_select($_sel_order, array('id' => $this->get_field_id('order'), 'class' => 'widefat', 'name' => $this->get_field_name('order'), 'selected' => $instance['order'])); ?>
            </td>
        </tr>
    </tbody>
</table>