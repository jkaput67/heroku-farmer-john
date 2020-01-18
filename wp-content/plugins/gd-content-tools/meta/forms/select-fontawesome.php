<div class="gdcet-fontawesome-selector">
    <?php

    d4p_include('fontawesome', 'classes', GDCET_D4PLIB);

    $icons = new d4p_object_fontawesome();

    echo $icons->render_selector(array('selected' => $_current_icon_selected));

    ?>
</div>