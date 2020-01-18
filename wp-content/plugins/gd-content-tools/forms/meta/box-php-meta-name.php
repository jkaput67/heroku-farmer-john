<div class="d4p-group d4p-group-information gdcet-php-code-block">
    <h3><?php _e("Metabox and fields by name", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">

        <h4><?php _e("Get each field into own variable, setup value and display it", "gd-content-tools"); ?>:</h4>
        <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox object", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>');
<?php foreach ($_box->data as $fname => $field) { ?>

// <?php _e("Field", "gd-content-tools"); ?> '<?php echo $field->get_label(); ?>' //
$metafield_<?php echo str_replace('-', '_', $fname); ?> = $metabox->field('<?php echo $fname; ?>');
$metafield_<?php echo str_replace('-', '_', $fname); ?>->label();
<?php

    if ($field->is_simple() && $field->is_repeater()) {

?>
while ($metafield_<?php echo str_replace('-', '_', $fname); ?>->have_values()) :
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->the_value();
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->display();
endwhile;
<?php

    } else if ($field->is_simple() && !$field->is_repeater()) {

?>
$metafield_<?php echo str_replace('-', '_', $fname); ?>->value();
$metafield_<?php echo str_replace('-', '_', $fname); ?>->display();
<?php

    } else if (!$field->is_simple() && $field->is_repeater()) {

?>
while ($metafield_<?php echo str_replace('-', '_', $fname); ?>->have_values()) :
  $metafield_<?php echo str_replace('-', '_', $fname); ?>->the_value();
<?php

  include(GDCET_PATH.'forms/meta/box-php-subfield.php');

?>
endwhile;
<?php

    } else {

?>
$metafield_<?php echo str_replace('-', '_', $fname); ?>->value();
<?php

  include(GDCET_PATH.'forms/meta/box-php-subfield.php');

    }

} ?>

?&gt;</code></pre>

    </div>
</div>
