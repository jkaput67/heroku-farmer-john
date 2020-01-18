<div class="d4p-group gdcet-group-info">
    <h3><?php _e("Registration Function", "gd-content-tools"); ?></h3>
    <div class="d4p-group-inner">
        <pre class="line-numbers"><code class="language-php"><?php

        global $_id;

        $cpt = gdcet_ctrl()->get_cpt($_id, 'object');
        $reg = $cpt->build_registration();
        $arr = gdcet_array_to_string($reg);

        echo sprintf("register_post_type('%s', %s);", $cpt->post_type, $arr);

        ?></code></pre>
    </div>
</div>
