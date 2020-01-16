<?php $_non_hierarchy = $taxonomy != 'category' ? 'tax_input['.$taxonomy.']' : 'post_category'; ?>
<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
    <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
        <input type="hidden" name="<?php echo $_non_hierarchy; ?>[]" value="0" />

        <ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
            <?php

                $walker = new gdcet_walker_category_checklist();
                $walker->selection = $selection;
                $walker->hierarchy = is_taxonomy_hierarchical($taxonomy);

                wp_terms_checklist($post->ID, array('taxonomy' => $taxonomy, 'walker' => $walker));

            ?>
        </ul>
        <?php if (!is_taxonomy_hierarchical($taxonomy)) { ?>
            <input class="gdcet_tax_input" name="<?php echo $_non_hierarchy ?>[]" type="hidden" value="<?php echo get_terms_to_edit($post->ID, $taxonomy); ?>" />
        <?php } ?>
    </div>
</div>
