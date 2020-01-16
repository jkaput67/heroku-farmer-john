<?php

if (!is_null($_errors)) {

?>
    <div class="d4p-group d4p-group-error">
        <h3><?php _e("Errors", "gd-content-tools"); ?></h3>
        <div class="d4p-group-inner">
            <p><?php _e("Please, fix these errors before this field can be saved.", "gd-content-tools"); ?></p>
            <ul>
                <?php foreach ($_errors->errors as $code => $r) { 
                    $parts = explode('.', $code);
                    $_js_errors[] = $parts[0]; ?>
                <li><?php echo join('</li><li>', $r); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        var gdcet_meta_errors_keys = ['<?php echo join("', '", $_js_errors) ?>'];
    </script>
<?php

}

$_field->render(true, true);
