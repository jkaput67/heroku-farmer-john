<div class="gdcet-render-metabox-tabs-wrapper">
    <ul class="wp-tab-bar">
        <?php

        $_tab_active = true;
        foreach ($_list_tabs as $_tab_id => $_tab) {
            echo '<li class="gdcet-tabs-'.$_tab_id.($_tab_active ? ' wp-tab-active' : '').'"><a href="#'.$_id_base.'tab-'.$_tab_id.'">'.$_tab['label'].'</a></li>';
            $_tab_active = false;
        }

    ?>
    </ul>
    <div class="d4plib-tabs-content-wrapper">
        <?php

        $_tab_active = true;
        foreach ($_list_tabs as $_tab_id => $_tab) {
            echo '<div id="'.$_id_base.'tab-'.$_tab_id.'" class="wp-tab-panel '.($_tab_active ? 'tabs-panel-active' : 'tabs-panel-inactive').'">';
                echo '<div class="d4plib-tabs-content-fields">';

                foreach ($_tab['fields'] as $_field_id) {
                    $_field = $_meta_box->data[$_meta_box->mapped[$_field_id]];

                    include(GDCET_PATH.'meta/forms/field.php');
                }

                echo '</div>';
            echo '</div>';

            $_tab_active = false;
        }

        ?>
    </div>
</div>
