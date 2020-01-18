<div class="gdcet-metabox-block-wrapper">
    <?php

    while ($metabox->have_fields()) :
        $metabox->the_field();

        gdcet_the_field()->label(array('before' => '<label>', 'after' => ':</label>'));

        if (gdcet_the_field()->have_values()) :
            while (gdcet_the_field()->have_values()) :
                gdcet_the_field()->the_value();

                echo '<div class="gdcet-metabox-subfield">';

                while (gdcet_the_field()->have_sub_fields()) :
                    gdcet_the_field()->the_sub_field();

                    if (gdcet_the_sub_field()->have_values()) :
                        gdcet_the_sub_field_label(array('before' => '<em>', 'after' => ':</em>'));

                        while (gdcet_the_sub_field()->have_values()) :
                            gdcet_the_sub_field()->the_value();

                            gdcet_the_sub_field()->display(array('before' => '<div>', 'after' => '</div>'));
                        endwhile;
                    endif;
                endwhile;

                echo '</div>';

            endwhile;
        endif;
    endwhile;

    ?>
</div>
