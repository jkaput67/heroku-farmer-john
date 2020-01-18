<div class="d4p-group d4p-group-reset d4p-group-important">
    <h3><?php _e("Important", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("This tool can remove plugin settings saved in the WordPress options table added by the plugin. Plugin can't remove meta data saved for posts, terms or users. It can't remove custom post types posts or custom taxonomies terms, only their definitions from the plugin settings.", "gd-content-tools"); ?><br/><br/>
        <?php _e("Deletion operations are not reversible, and it is highly recommended to create database backup before proceeding with this tool.", "gd-content-tools"); ?> 
        <?php _e("If you choose to remove plugin settings, once that is done, all settings will be reinitialized to default values if you choose to leave plugin active.", "gd-content-tools"); ?>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Remove plugin settings", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][settings]" value="on" /> <?php _e("Main Plugin Settings", "gd-content-tools"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][addons]" value="on" /> <?php _e("Addons Settings", "gd-content-tools"); ?>
        </label>
        <hr/>
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][cpt]" value="on" /> <?php _e("Custom Post Types", "gd-content-tools"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][tax]" value="on" /> <?php _e("Custom Taxonomies", "gd-content-tools"); ?>
        </label>
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][meta]" value="on" /> <?php _e("Meta Fields and Meta Boxes", "gd-content-tools"); ?>
        </label>
    </div>
</div>

<div class="d4p-group d4p-group-tools d4p-group-reset">
    <h3><?php _e("Disable Plugin", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <label>
            <input type="checkbox" class="widefat" name="gdcettools[remove][disable]" value="on" /> <?php _e("Disable plugin", "gd-content-tools"); ?>
        </label>
    </div>
</div>
