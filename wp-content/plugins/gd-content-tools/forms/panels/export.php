<input type="hidden" value="<?php echo admin_url('admin.php?page=gd-content-tools-tools&gdcet_handler=getback&run=export&_ajax_nonce='.wp_create_nonce('dev4press-plugin-export')); ?>" id="gdcet-export-url" />

<div class="d4p-group d4p-group-export d4p-group-important">
    <h3><?php _e("Important", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <?php _e("With this tool you export all plugin settings into plain text file (PHP serialized content). Do not modify export file, any change you make can make it unusable.", "gd-content-tools"); ?>
    </div>
</div>