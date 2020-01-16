<?php

foreach ($field->fields as $_sub) {

?>

  // <?php _e("Subfield", "gd-content-tools"); ?> '<?php echo $_sub->b('label'); ?>' //
  $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?> = $metafield_<?php echo str_replace('-', '_', $fname); ?>->sub_field('<?php echo $_sub->b('slug'); ?>');
  $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->label();
<?php

    if ($_sub->is_repeater()) {
?>
  while ($subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->have_values()) :
    $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->the_value();
    $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->display();
  endwhile;
<?php
    } else {
?>
  $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->value();
  $subfield_<?php echo str_replace('-', '_', $fname); ?>_<?php echo str_replace('-', '_', $_sub->b('slug')); ?>->display();
<?php

    }
}
