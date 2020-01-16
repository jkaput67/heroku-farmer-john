<?php $post_types = get_post_types(array('_builtin' => false, 'public' => true, 'has_archive' => true), 'objects'); ?>

<?php if (empty($post_types)) { ?>
    <p><?php _e("No items.", "gd-content-tools"); ?></p>
<?php } else { ?>
    <div class="posttypediv" id="gdtt-cpt-archives-box">
        <div id="gdtt-cpt-archives" class="tabs-panel tabs-panel-active">
            <ul id="gdtt-cpt-archives-list" class="categorychecklist">
                <?php foreach ($post_types as $pt) { ?>
                    <li><label class="menu-item-title"><input type="checkbox" value="<?php echo esc_attr($pt->name); ?>" /> <?php echo esc_attr($pt->labels->name); ?></label></li>
                <?php } ?>
            </ul>
        </div>

        <p class="button-controls wp-clearfix">
            <span class="list-controls">
                <a class="select-all" href="#gdtt-cpt-archives-box">Select All</a>
            </span>
            <span class="add-to-menu">
                <input type="submit" id="gdtt-cpt-archives-box-submit" name="add-gdtt-cpt-archive-menu-item" value="Add to Menu" class="button-secondary submit-add-to-menu right">
                <span class="spinner"></span>
            </span>
        </p>
    </div>
<?php } 