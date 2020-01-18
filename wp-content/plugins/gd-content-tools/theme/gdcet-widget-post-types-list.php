<?php

$_post_types_list = $instance['list'];

if (empty($_post_types_list)) {

?>

<p><?php _e("No post types selected.", "gd-content-tools"); ?></p>

<?php

} else {

?>

<ul>

<?php

    $_current_post_type = gdcet_get_current_post_type();

    foreach ($_post_types_list as $post_type) {
        $class = 'post-type-'.$post_type;

        if (is_post_type_archive($post_type)) {
            $class.= ' archive';
        }

        if ($instance['current'] == 1 && !is_null($_current_post_type) && $_current_post_type->name == $post_type) {
            $class.= ' current';
        }

        $cpt = get_post_type_object($post_type);
        $url = get_post_type_archive_link($post_type);

        $item = '<li class="'.$class.'">';
        $item.= D4P_EOL.D4P_TAB.'<a title="'.sprintf(__("View posts for %s", "gd-content-tools"), $cpt->label).'" href="'.$url.'">'.$cpt->label.'</a>';

        if ($instance['counts']) {
            $counts = wp_count_posts($post_type);

            $item.= ' <span class="gdcet-count">'.absint($counts->publish).'</span>';
        }

        $item.= D4P_EOL.'</li>'.D4P_EOL;

        echo $item;
    }

?>

</ul>

<?php }