<?php

$selected_ids = (array)$this->get_edit_value($index);

if (isset($this->settings['display']) && $this->settings['display'] == 'select2') {

    $_class = 'gdcet-control gdcet-control-multiple';

    $_properties = array(
        'id' => $id_base,
        'name' => $name_base,
        'data-wp' => 'user',
        'data-filter' => $this->settings['type'],
        'data-attr' => join(',', $this->settings['roles']),
        'data-maximum-selection-length' => $this->settings['limit']
    );

    if ($this->is_required()) {
        $_class.= ' gdcet-control-required gdcet-required-textual';
    }

    if ($this->settings['limit'] > 0) {
        $_properties['data-close-on-select'] = true;
    }

    $_class.= ' gdcet-control-wpsource-enhanced gdcet-enhanced-select2';

    $_properties['class'] = $_class;

    $_render = array();

    foreach ($_properties as $key => $value) {
        $_render[] = $key.'="'.esc_attr($value).'"';
    }

?><select <?php echo join(' ', $_render); ?> multiple>

    <?php

    foreach ($selected_ids as $id) {
        $user = get_user_by('id', $id);

        if ($term !== false) {
        ?>
    <option value="<?php echo esc_attr($id); ?>" selected="selected"><?php echo esc_html($user->display_name); ?></option>
        <?php
        }
    }

    ?>

</select><?php

} else {

?><div class="gdcet-content-select-wrapper" data-wp="user" data-filter="<?php echo esc_attr($this->s('type')); ?>" data-attr="<?php echo esc_attr(join(',', $this->s('roles'))); ?>">
    <?php

    $_class = 'gdcet-selected-items';

    if ($this->is_required()) {
        $_class.= ' gdcet-control-required gdcet-required-textual';
    }

    $_input_properties = array(
        'id="'.$id_base.'"',
        'name="'.$name_base.'"',
        'value="'.esc_attr(join(',', $selected_ids)).'"',
        'class="'.$_class.'"'
    );

    ?>

    <input class="gdcet-control gdcet-search" type="text" value="" placeholder="<?php _e("Search by name or email...", "gd-content-tools"); ?>" />
    <div class="gdcet-content-inner">
        <div class="gdcet-content-list gdcet-content-results">
            <h5><?php _e("Search Results", "gd-content-tools"); ?></h5>
        </div><div class="gdcet-content-list gdcet-content-selected">
            <input <?php echo join(' ', $_input_properties); ?> type="hidden" />
            <h5><?php _e("Selected Users", "gd-content-tools"); ?></h5>
            <ul><?php

            foreach ($selected_ids as $id) {
                $user = get_user_by('id', $id);

                if ($user !== false) {
                    ?><li data-item="<?php echo esc_attr($id); ?>"><span class="dashicons dashicons-no-alt"></span>
                        <img src="<?php echo esc_attr(get_avatar_url($user->user_email, array('size' => 64))); ?>" title="<?php echo esc_attr($user->display_name); ?>" />
                        <strong><?php echo esc_attr($user->display_name); ?></strong><?php echo $user->user_email; ?>
                    </li><?php
                }
            }

            ?></ul>
        </div><div class="gdcet-clear"></div>
    </div>
</div><?php
    
}
