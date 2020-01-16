<?php

$selected_ids = (array)$this->get_edit_value($index);

if (isset($this->settings['display']) && $this->settings['display'] == 'select2') {

    $_class = 'gdcet-control gdcet-control-multiple';

    $_properties = array(
        'id' => $id_base,
        'name' => $name_base,
        'data-wp' => 'term',
        'data-filter' => $this->settings['taxonomy'],
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
        $term = get_term($id);

        if ($term !== false) {
        ?>
    <option value="<?php echo esc_attr($id); ?>" selected="selected"><?php echo esc_html($term->name); ?></option>
        <?php
        }
    }

    ?>

</select><?php

} else {

?><div class="gdcet-content-select-wrapper" data-wp="term" data-filter="<?php echo esc_attr($this->s('taxonomy')); ?>" data-attr="">
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

    <input class="gdcet-control gdcet-search" type="text" value="" placeholder="<?php _e("Search by name or slug...", "gd-content-tools"); ?>" />
    <div class="gdcet-content-inner">
        <div class="gdcet-content-list gdcet-content-results">
            <h5><?php _e("Search Results", "gd-content-tools"); ?></h5>
        </div><div class="gdcet-content-list gdcet-content-selected">
            <input <?php echo join(' ', $_input_properties); ?> type="hidden" />
            <h5><?php _e("Selected Terms", "gd-content-tools"); ?></h5>
            <ul><?php

            foreach ($selected_ids as $id) {
                $term = get_term($id);

                if ($term !== false) {
                    ?><li data-item="<?php echo esc_attr($id); ?>"><span class="dashicons dashicons-no-alt"></span>
                        <strong><?php echo esc_attr($term->name); ?></strong><?php echo $term->slug; ?>
                    </li><?php
                }
            }

            ?></ul>
        </div><div class="gdcet-clear"></div>
    </div>
</div><?php
    
}
