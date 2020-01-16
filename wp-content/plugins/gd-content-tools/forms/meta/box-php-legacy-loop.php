<div class="d4p-group d4p-group-information gdcet-php-code-block">
    <h3><?php _e("Metabox and fields loop", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">

        <h4><?php _e("Loop all fields, all available values and display them", "gd-content-tools"); ?>:</h4>
        <pre class="line-numbers"><code class="language-php">&lt;?php

// <?php _e("Init metabox object", "gd-content-tools"); ?> '<?php echo $_box->label; ?>'
$metabox = gdcet_metabox('<?php echo $_box->slug; ?>');

// <?php _e("Loop all the fields in the metabox", "gd-content-tools"); ?>

while ($metabox->have_fields()) :
  $metabox->the_field();

  // <?php _e("Display label", "gd-content-tools"); ?> //
  gdcet_the_field()->label(array('before' => '&lt;label&gt;', 'after' => ':&lt;/label&gt;'));

  // <?php _e("Loop through the values", "gd-content-tools"); ?> //
  if (gdcet_the_field()->have_values()) :
    while (gdcet_the_field()->have_values()) :
      // <?php _e("Set up the value for field to use", "gd-content-tools"); ?> //
      gdcet_the_field()->the_value();

      // <?php _e("Display the current value for the field", "gd-content-tools"); ?> //
      gdcet_the_field()->display(array('before' => '&lt;div&gt;', 'after' => '&lt;/div&gt;'));
    endwhile;
  endif;
endwhile;

?&gt;</code></pre>

    </div>
</div>
