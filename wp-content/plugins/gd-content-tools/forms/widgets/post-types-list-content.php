<h4><?php _e("Select Post Types to Show", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-singular">
                <div class="d4plib-checkbox-list gdcet-post-types-list">
                    <ul class="gdcet-types-ul">
                    <?php

                    $_start_list = get_post_types(array(), 'objects');
                    $_input_list = array();

                    foreach ($instance['list'] as $cpt) {
                        if (isset($_start_list[$cpt])) {
                            $_input_list[$cpt] = $_start_list[$cpt];
                        }
                    }

                    foreach ($_start_list as $name => $cpt) {
                        if (!isset($_input_list[$name])) {
                            $_input_list[$name] = $cpt;
                        }
                    }

                    foreach ($_input_list as $name => $cpt) {
                        if ($cpt->has_archive != false) {
                            $on = in_array($name, $instance['list']);

                            echo sprintf('<li class="gdcet-cpt-item-%s" data-cpt="%s"><label><input type="checkbox" name="%s[]" value="%s"%s />%s</label></li>',
                                    $name, $name, $this->get_field_name('list'), $name, $on ? 'checked="checked"' : '', $cpt->label);
                        }
                    }

                    ?>
                    </ul>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<h4><?php _e("Extra Options", "gd-content-tools"); ?></h4>
<table>
    <tbody>
        <tr>
            <td class="cell-left">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('counts'); ?>">
                        <input class="widefat" <?php echo $instance['counts'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('counts'); ?>" name="<?php echo $this->get_field_name('counts'); ?>" />
                        <?php _e("Show posts counts", "gd-content-tools"); ?></label>
                </div>
            </td>
            <td class="cell-right">
                <div class="d4plib-checkbox-list">
                    <label for="<?php echo $this->get_field_id('current'); ?>">
                        <input class="widefat" <?php echo $instance['current'] == 1 ? 'checked="checked"' : ''; ?> type="checkbox" id="<?php echo $this->get_field_id('current'); ?>" name="<?php echo $this->get_field_name('current'); ?>" />
                        <?php _e("Mark current post type", "gd-content-tools"); ?></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("a.gdcet-tab-post-types-list.d4plib-tab-active").click();
});
</script>