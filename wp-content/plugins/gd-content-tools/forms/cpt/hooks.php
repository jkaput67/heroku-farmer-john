<?php

add_action('d4p_settings_group_top', 'gdcet_hook_settings_group_top', 10, 2);
add_action('d4p_settings_group_bottom', 'gdcet_hook_settings_group_bottom', 10, 2);

function gdcet_hook_settings_group_top($setting, $group) {
    if ($setting->name == '_permalinks_single_structure') {
        global $_id;

        $obj = gdcet_ctrl()->get_cpt($_id, 'object');
        $ptn = $obj->slug_single();

        $list = array(
            __("Default", "gd-content-tools") => array(
                $ptn.'/%'.$ptn.'%/', 
                site_url($ptn.'/sample-post/'),
            ),
            __("Year and Name", "gd-content-tools") => array(
                $ptn.'/%year%/%'.$ptn.'%/', 
                site_url($ptn.'/2016/sample-post/'),
            ),
            __("Month and Name", "gd-content-tools") => array(
                $ptn.'/%year%/%monthnum%/%'.$ptn.'%/', 
                site_url($ptn.'/2016/05/sample-post/'),
            ),
            __("Numeric", "gd-content-tools") => array(
                $ptn.'/%'.$ptn.'_id%', 
                site_url($ptn.'/123'),
            ),
            __("Numeric and Name", "gd-content-tools") => array(
                $ptn.'/%'.$ptn.'_id%_%'.$ptn.'%/', 
                site_url($ptn.'/123_sample-post/'),
            )
        );

        $render = '<table class="form-table gdcet-permalinks-examples" style="width: 100%;"><tbody>';

        $checked = true;
        foreach ($list as $name => $data) {
            $render.= '<tr><th>';
            $render.= '<label><input'.($checked ? ' checked="checked"' : '').' type="radio" class="gdcet-permalink-example" value="'.$data[0].'" name="permalink_examples"> '.$name.'</label>';
            $render.= '</th><td><code>'.$data[1].'</code>';
            $render.= '</td></tr>';

            $checked = false;
        }
        
        $render.= '</tbody></table>';

        echo d4p_render_toggle_block(__("List of permalinks examples", "gd-content-tools"), $render, array('d4p-free-height gdcet-bottom-margin'));
    }
}

function gdcet_hook_settings_group_bottom($setting, $group) {
    if ($setting->name == '_permalinks_archive_intersection_structure') {
        global $_id;

        $obj = gdcet_ctrl()->get_cpt($_id, 'object');
        $taxonomies = $obj->get_taxonomies();

        if (!empty($taxonomies)) {
            $render = '<code>%'.join('%</code> &middot; <code>%', $obj->get_taxonomies()).'%</code>';
            echo d4p_render_toggle_block(__("Taxonomy URL elements you can use", "gd-content-tools"), $render, array('d4p-free-height'));
        }
    }

    if ($setting->name == '_permalinks_single_structure') {
        global $_id;

        $obj = gdcet_ctrl()->get_cpt($_id, 'object');
        $ptn = $obj->post_type;

        $list = array(
            __("Post Type", "gd-content-tools") => array($ptn, $ptn.'_id'),
            __("Date", "gd-content-tools") => array('year', 'monthnum', 'day'),
            __("Time", "gd-content-tools") => array('hour', 'minute', 'second'),
            __("Taxonomies", "gd-content-tools") => $obj->get_taxonomies(),
            __("More", "gd-content-tools") => array('author'),
        );

        $render = '<table class="form-table gdcet-permalinks-examples" style="width: 100%;"><tbody>';

        foreach ($list as $name => $data) {
            if (!empty($data)) {
                $render.= '<tr><th><label>'.$name.'</label>';
                $render.= '</th><td><code>%'.join('%</code> &middot; <code>%', $data).'%</code>';
                $render.= '</td></tr>';
            }
        }
        
        $render.= '</tbody></table>';

        echo d4p_render_toggle_block(__("URL elements you can use", "gd-content-tools"), $render, array('d4p-free-height'));
    }

    if ($setting->name == 'internal_ctrl_labels') {
        echo '<br/><br/><a class="gdcet-ctrl-clear-all-labels button-secondary" href="#">'.__("Clear all standard and additional labels", "gd-content-tools").'</a>';
    }
}
