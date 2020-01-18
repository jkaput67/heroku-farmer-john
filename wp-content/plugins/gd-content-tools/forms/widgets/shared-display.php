<?php

global $wp_roles;
$list = array(
    array('title' => __("Global", "gd-content-tools"), 
          'values' => array('all' => __("Everyone", "gd-content-tools"), 'visitor' => __("Only Visitors", "gd-content-tools"), 'user' => __("All Users", "gd-content-tools"))),
    array('title' => __("User Roles", "gd-content-tools"), 
          'values' => array())
);

foreach ($wp_roles->role_names as $role => $title) {
    $list[1]['values']['role:'.$role] = $title;
}

?>

<h4><?php _e("Visibility", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <label for="<?php echo $this->get_field_id('_display'); ?>"><?php _e("Display To", "gd-content-tools"); ?>:</label>
                <?php d4p_render_grouped_select($list, array('id' => $this->get_field_id('_display'), 'class' => 'widefat', 'name' => $this->get_field_name('_display'), 'selected' => $instance['_display'])); ?>
            </td>
            <td class="cell-right">
                <label for="<?php echo $this->get_field_id('_hook'); ?>"><?php _e("Visibility Hook", "gd-content-tools"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_hook'); ?>" name="<?php echo $this->get_field_name('_hook'); ?>" type="text" value="<?php echo esc_attr($instance['_hook']); ?>" />
            </td>
        </tr>
        <tr>
            <td class="cell-singular" colspan="2">
                <label for="<?php echo $this->get_field_id('_class'); ?>"><?php _e("Additional CSS Class", "gd-content-tools"); ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id('_class'); ?>" name="<?php echo $this->get_field_name('_class'); ?>" type="text" value="<?php echo esc_attr($instance['_class']); ?>" />
            </td>
        </tr>
    </tbody>
</table>
