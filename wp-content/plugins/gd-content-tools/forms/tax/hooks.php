<?php

add_action('d4p_settings_group_bottom', 'gdcet_hook_settings_group_bottom', 10, 2);

function gdcet_hook_settings_group_bottom($setting, $group) {
    if ($setting->name == 'internal_ctrl_labels') {
        echo '<br/><br/><a class="gdcet-ctrl-clear-all-labels button-secondary" href="#">'.__("Clear all standard and additional labels", "gd-content-tools").'</a>';
    }
}
