<?php

if ($instance['render'] == 'drop') {
    $instance['name'] = 'gdcet-dropdown-'.$this->widget_id;
    $instance['class'] = 'gdcet-dropdown-terms';
    $instance['show_option_none'] = __("Select Term", "gd-content-tools");

    gdcet_terms_dropdown($instance);
} else {
    gdcet_terms_list($instance);
}

if ($instance['render'] == 'drop') {
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery(".gdcet-dropdown-terms").change(function(){
                location.href = $(this).val();
            });
        });
    </script>

    <?php
}