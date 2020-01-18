<div class="d4p-group d4p-group-information gdcet-php-code-block">
    <h3><?php _e("Initialize metabox object", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">

<?php

if (!empty($_box->get_types('post_types'))) {

    ?>

    <h4><?php _e("Load metabox for current post in the loop", "gd-content-tools"); ?>:</h4>
    <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox object", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>');

?&gt;
    </code></pre>

    <h4><?php _e("Load metabox for any post by using &dollar;post_id", "gd-content-tools"); ?>:</h4>
    <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>', 'post', $post_id);

?&gt;
    </code></pre>

    <?php

}

if (!empty($_box->get_types('taxonomies'))) {

    ?>

    <h4><?php _e("Load metabox for any term by using &dollar;term_id", "gd-content-tools"); ?>:</h4>
    <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>', 'term', $term_id);

?&gt;
    </code></pre>

    <?php

}

if (!empty($_box->get_types('user_roles'))) {

    ?>

    <h4><?php _e("Load metabox for any user by using &dollar;user_id", "gd-content-tools"); ?>:</h4>
    <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>', 'user', $user_id);

?&gt;
    </code></pre>

    <?php

}

?>

    </div>
</div>
