<div class="d4p-group d4p-group-information gdcet-php-code-block">
    <h3><?php _e("Metabox and fields by name", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">

        <h4><?php _e("Get each field into own variable, setup value and display it", "gd-content-tools"); ?>:</h4>
        <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox object", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>');
<?php foreach ($_box->data as $fname => $field) { if ($field->fields[0]->name == 'info') { continue; } ?>

// <?php _e("Field", "gd-content-tools"); ?> '<?php echo $field->get_label(); ?>' //
$metafield_<?php echo str_replace('-', '_', $fname); ?> = $metabox->field('<?php echo $fname; ?>');
  // <?php _e("Display label", "gd-content-tools"); ?> //
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->label();
<?php 

    if ($field->is_repeater()) {

?>
  // <?php _e("Loop through the field values", "gd-content-tools"); ?> //
  while ($metafield_<?php echo str_replace('-', '_', $fname); ?>->have_values()) :
    // <?php _e("Set up the value for the loop", "gd-content-tools"); ?> //
    $metafield_<?php echo str_replace('-', '_', $fname); ?>->the_value();
    // <?php _e("Display the current loop value", "gd-content-tools"); ?> //
    $metafield_<?php echo str_replace('-', '_', $fname); ?>->display();
  endwhile;
<?php

    } else {

?>
  // <?php _e("Load the value for the field", "gd-content-tools"); ?> //
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->value();
  // <?php _e("Display the field value", "gd-content-tools"); ?> //
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->display();
<?php

    }

} ?>

?&gt;</code></pre>

    </div>
</div>
