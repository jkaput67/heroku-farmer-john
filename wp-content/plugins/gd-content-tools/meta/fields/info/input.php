<?php

$information = $this->s('information');
$information = apply_filters('gdcet_field_info_display_information_value', $information, $this);

echo $information;
