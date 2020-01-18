<?php

$_metabox = gdcet_metabox_by_id($gdcet_metabox_id, 'post', $gdcet_post_id);

?>

<div class="gdcet-metabox-embed">
    <h5><?php echo $_metabox->label; ?></h5>

    <?php

    while ($_metabox->have_fields()) :
        $_metabox->the_field();

    ?>

    <div class="gdcet-metabox-field">
        <?php gdcet_the_field_label(array('before' => '<label>', 'after' => ':</label>')); ?>

        <?php

            if (gdcet_the_field()->is_simple_field()) :

                if (gdcet_the_field()->have_values()) :

                    while (gdcet_the_field()->have_values()) :
                        gdcet_the_field()->the_value();

                        gdcet_the_field()->display(array('before' => '<div>', 'after' => '</div>'));
                    endwhile;

                endif;

            else :

                if (gdcet_the_field()->have_values()) :

                    while (gdcet_the_field()->have_values()) :
                        gdcet_the_field()->the_value();

                        echo '<div class="gdcet-metabox-subfield">';

                        while (gdcet_the_field()->have_sub_fields()) :
                            gdcet_the_field()->the_sub_field();

                            gdcet_the_sub_field_label(array('before' => '<em>', 'after' => ':</em>'));

                            if (gdcet_the_sub_field()->count_values() == 1) :

                                gdcet_the_sub_field()->display(array('before' => '<div>', 'after' => '</div>'));

                            elseif (gdcet_the_sub_field()->count_values() > 1):

                                while (gdcet_the_sub_field()->have_values()) :
                                    gdcet_the_sub_field()->the_value();

                                    gdcet_the_sub_field()->display(array('before' => '<div>', 'after' => '</div>'));
                                endwhile;

                            endif;
                        endwhile;

                        echo '</div>';
                    endwhile;

                endif;

            endif;

        ?>
    </div>
    
    <?php

    endwhile;

    ?>

</div>