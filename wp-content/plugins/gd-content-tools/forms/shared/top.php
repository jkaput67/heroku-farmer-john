<?php

do_action('gdcet_admin_panel_top');

$pages = gdcet_admin()->menu_items;
$_page = gdcet_admin()->page;
$_panel = gdcet_admin()->panel;

$_real_page = $_page;

if (!empty($panels)) {
    if ($_panel === false || empty($_panel)) {
        $_panel = 'index';
    }

    $_available = array_keys($panels);

    if (!in_array($_panel, $_available)) {
        $_panel = 'index';
        gdcet_admin()->panel = false;
    }
}

$_classes = array('d4p-wrap', 'wpv-'.GDCET_WPV, 'd4p-page-'.$_real_page);

if ($_panel !== false) {
    $_classes[] = 'd4p-panel';
    $_classes[] = 'd4p-panel-'.$_panel;
}

$_message = '';
$_color = '';

if (isset($_GET['message']) && $_GET['message'] != '') {
    $msg_code = d4p_sanitize_slug($_GET['message']);

    switch ($msg_code) {
        case 'invalid':
            $_message = __("Requested operation is invalid.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'saved':
            $_message = __("Settings are saved.", "gd-content-tools");
            break;
        case 'cpt-created':
            $_message = __("New custom post type created.", "gd-content-tools");
            break;
        case 'cpt-deleted':
            $_message = __("Custom post type deleted.", "gd-content-tools");
            break;
        case 'cpt-delete-failed':
            $_message = __("Custom post type delete failed.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'cpt-saved':
            $_message = __("Custom post type saved.", "gd-content-tools");
            break;
        case 'tax-created':
            $_message = __("New custom taxonomy created.", "gd-content-tools");
            break;
        case 'tax-deleted':
            $_message = __("Custom taxonomy deleted.", "gd-content-tools");
            break;
        case 'tax-delete-failed':
            $_message = __("Custom taxonomy delete failed.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'tax-saved':
            $_message = __("Custom taxonomy saved.", "gd-content-tools");
            break;
        case 'meta-created':
            $_message = __("New meta field created.", "gd-content-tools");
            break;
        case 'meta-deleted':
            $_message = __("Meta field deleted.", "gd-content-tools");
            break;
        case 'meta-delete-failed':
            $_message = __("Meta field delete failed.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'meta-saved':
            $_message = __("Meta field saved.", "gd-content-tools");
            break;
        case 'box-created':
            $_message = __("New meta box created.", "gd-content-tools");
            break;
        case 'box-deleted':
            $_message = __("Meta box deleted.", "gd-content-tools");
            break;
        case 'box-delete-failed':
            $_message = __("Meta box delete failed.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'box-saved':
            $_message = __("Meta box saved.", "gd-content-tools");
            break;
        case 'imported':
            $_message = __("Import operation completed.", "gd-content-tools");
            break;
        case 'import-failed':
            $_message = __("Import operation failed.", "gd-content-tools");
            $_color = 'error';
            break;
        case 'transfer-failed':
            $_color = 'error';
            $_message = __("Invalid transfer configuration. Transfer failed.", "gd-content-tools");
            break;
        case 'transfered':
            $_message = __("Data transfer completed.", "gd-content-tools");
            break;
        case 'nothing':
            $_message = __("Nothing done.", "gd-content-tools");
            break;
        case 'nothing-removed':
            $_message = __("Nothing removed.", "gd-content-tools");
            break;
        case 'removed':
            $_message = __("Removal operation completed.", "gd-content-tools");
            break;
        default:
            $_color = apply_filters('gdcet_admin_operation_notice_color', '', $msg_code);
            $_message = apply_filters('gdcet_admin_operation_notice', ucwords(str_replace('-', ' ', $msg_code)), $msg_code);
            break;
    }
}

?>
<div class="<?php echo join(' ', $_classes); ?>">
    <div class="d4p-header">
        <div class="d4p-navigator">
            <ul>
                <li class="d4p-nav-button">
                    <a href="#"><i class="<?php echo d4p_get_icon_class($pages[$_page]['icon']); ?>"></i> <?php echo $pages[$_page]['title']; ?></a>
                    <ul>
                        <?php

                        foreach ($pages as $page => $obj) {
                            if ($page != $_page) {
                                echo '<li><a href="admin.php?page=gd-content-tools-'.$page.'"><i class="'.(d4p_get_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</a></li>';
                            } else {
                                echo '<li class="d4p-nav-current"><i class="'.(d4p_get_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</li>';
                            }
                        }

                        ?>
                    </ul>
                </li>
                <?php if (!empty($panels)) { ?>
                <li class="d4p-nav-button">
                    <a href="#"><i class="<?php echo d4p_get_icon_class($panels[$_panel]['icon']); ?>"></i> <?php echo $panels[$_panel]['title']; ?></a>
                    <ul>
                        <?php

                        foreach ($panels as $panel => $obj) {
                            if ($panel != $_panel) {
                                $extra = $panel != 'index' ? '&panel='.$panel : '';

                                echo '<li><a href="admin.php?page=gd-content-tools-'.$_real_page.$extra.'"><i class="'.(d4p_get_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</a></li>';
                            } else {
                                echo '<li class="d4p-nav-current"><i class="'.(d4p_get_icon_class($obj['icon'], 'fw')).'"></i> '.$obj['title'].'</li>';
                            }
                        }

                        ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="d4p-plugin">
            GD Content Tools
        </div>
    </div>
    <?php

    if ($_message != '') {
        echo '<div class="updated '.$_color.'">'.$_message.'</div>';

        if ($_page == 'cpt' || $_page == 'tax') {
            wp_flush_rewrite_rules();
        }
    }

    ?>
    <div class="d4p-content">
