<?php

if (empty($_post_templates)) {

?>
<p>
    <?php _e("No post templates found.", "gd-content-tools"); ?>
</p>
<?php

} else {
    $_post_templates = array_merge(array('' => __("None", "gd-content-tools")), $_post_templates);

    wp_nonce_field('gdcet_meta_post_template_'.$post->ID, 'gdcet_meta[post_template][_wpnonce]', false, true);
?>
<p>
    <label>
        <span><?php _e("Select Post Template", "gd-content-tools"); ?>:</span>
        <?php d4p_render_select($_post_templates, array('selected' => $_post_template, 'name' => 'gdcet_meta[post_template][template]', 'class' => 'widefat')); ?>
    </label>
</p>
<?php

}
