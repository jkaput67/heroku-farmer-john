<?php

$selected_ids = (array)$this->get_edit_value($index);
$posts_list = array();

if (!empty($selected_ids)) {
    $posts_list = get_posts(array(
        'post__in' => $selected_ids,
        'orderby' => 'post__in',
        'numberposts' => -1
    ));
}

if (isset($this->settings['display']) && $this->settings['display'] == 'select2') {

    $_class = 'gdcet-control gdcet-control-multiple';

    $_properties = array(
        'id' => $id_base,
        'name' => $name_base,
        'data-wp' => 'post',
        'data-filter' => $this->settings['post_type'],
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

    foreach ($posts_list as $post) {
        $id = $post->ID;

        ?>
    <option value="<?php echo esc_attr($id); ?>" selected="selected"><?php echo esc_html($post->post_title); ?></option>
        <?php
    }

    ?>

</select><?php

} else {

?><div class="gdcet-content-select-wrapper" data-wp="post" data-filter="<?php echo esc_attr($this->s('post_type')); ?>" data-attr="">
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
            <h5><?php _e("Selected Posts", "gd-content-tools"); ?></h5>
            <ul><?php

            foreach ($posts_list as $post) {
                $id = $post->ID;

                if ($post !== false) {
                    ?><li data-item="<?php echo esc_attr($id); ?>"><span class="dashicons dashicons-no-alt"></span>
                        <?php if (has_post_thumbnail($post)) { ?>
                        <img src="<?php echo esc_attr(wp_get_attachment_thumb_url(get_post_thumbnail_id($post))); ?>" title="<?php echo esc_attr($post->post_title); ?>" />
                        <?php } ?>
                        <strong><?php echo esc_html($post->post_title); ?></strong><?php echo get_the_date('', $post); ?>
                    </li><?php
                }
            }

            ?></ul>
        </div><div class="gdcet-clear"></div>
    </div>
</div><?php
    
}
