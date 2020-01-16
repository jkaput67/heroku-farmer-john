<?php

if (!defined('ABSPATH')) exit;

abstract class gdcet_core_basefield {
    public $type = '';
    public $value = null;

    public $settings = array();
    public $values = array();

    public $in_the_loop = false;
    public $current_value = -1;

    public function __construct() { }

    public function init() { }

    public function __get($name) {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }

        return null;
    }

    public function count_values() {
        return count($this->values);
    }

    public function value($index = 0) {
        $this->value = isset($this->values[$index]) ? $this->values[$index] : null;

        return $this;
    }

    public function have_values() {
        if ($this->current_value + 1 < $this->count_values()) {
            return true;
        } else if ($this->current_value + 1 == $this->count_values() && $this->count_values() > 0) {
            $this->rewind_values();
        }

        $this->in_the_loop = false;

        return false;
    }

    public function rewind_values() {
        $this->current_value = -1;
    }

    public function value_index() {
        return $this->current_value;
    }

    public function the_value() {
        $this->in_the_loop = true;

        $this->next_value();
    }

    public function next_value() {
        $this->current_value++;

        $this->value = $this->values[$this->current_value];
    }

    public function get_label($args = array()) {
        $defaults = array('before' => '', 'after' => '');

        $args = wp_parse_args($args, $defaults);

        return $args['before'].$this->label.$args['after'];
    }

    public function get_description($args = array()) {
        $defaults = array('before' => '', 'after' => '');

        $args = wp_parse_args($args, $defaults);

        return $args['before'].$this->description.$args['after'];
    }

    public function label($args = array()) {
        echo $this->get_label($args);
    }

    public function description($args = array()) {
        echo $this->get_description($args);
    }

    public function raw() {
        return $this->value;
    }

    public function display($args = array()) {
        $value = $this->render($args);

        if (is_wp_error($value)) {
            echo '<div class="gdcet-meta-value-error">'.$value->get_error_message().'</div>';
        } else {
            echo $value;
        }
    }

    abstract public function render($args = array());
}

abstract class gdcet_core_basefield_dates extends gdcet_core_basefield {
    protected $default_format = 'c';

    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'format' => $this->default_format, 'defualt' => '');

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $timestamp = strtotime($_value);

        $render = date($args['format'], $timestamp);

        return $args['before'].$render.$args['after'];
    }
}

abstract class gdcet_core_basefield_content extends gdcet_core_basefield {
    public $_defaults = array('before' => '', 'after' => '', 'wptexturize' => true,
            'smilies' => true, 'wpautop' => true, 'shortcodes' => true, 'defualt' => '');

    public function render($args = array()) {
        $defaults = $this->_defaults;

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $render = $_value;

        if ($args['wptexturize']) {
            $render = wptexturize($render);
        }

        if ($args['wpautop']) {
            $render = wpautop($render);
        }

        if ($args['shortcodes']) {
            if ($args['wpautop']) {
                $render = shortcode_unautop($render);
            }

            $render = do_shortcode($render);
        }

        if ($args['smilies']) {
            $render = convert_smilies($render);
        }

        return $args['before'].$render.$args['after'];
    }
}

abstract class gdcet_core_basefield_simple extends gdcet_core_basefield {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $render = $_value;

        return $args['before'].$render.$args['after'];
    }
}

abstract class gdcet_core_basefield_selection extends gdcet_core_basefield {
    public $list = array();

    public function init() {
        if ($this->settings['source'] == 'list') {
            $this->list = $this->settings['list'];
        } else if ($this->settings['source'] == 'function') {
            $this->list = call_user_func($this->settings['function']);
        }
    }
}

abstract class gdcet_core_basefield_list extends gdcet_core_basefield_selection {
    public function render($args = array()) {
        $defaults = array('before' => '', 'after' => '',
            'method' => 'list', 'sep' => ', ', 'list' => 'ul', 
            'class' => '', 'default' => '');

        $args = wp_parse_args($args, $defaults);

        $_value = is_null($this->value) ? $args['default'] : $this->value;

        $values = array();

        if ($this->mode == 'associative') {
            foreach ((array)$_value as $v) {
                if (isset($this->list[$v])) {
                    $values[] = $this->list[$v];
                }
            }
        } else {
            $values = (array)$_value;
        }

        $render = '';

        switch ($args['method']) {
            case 'list':
                $render.= '<'.$args['list'].' class="'.$args['class'].'">';
                $render.= '<li>'.join('</li><li>', $values).'</li>';
                $render.= '</'.$args['list'].'>';
                break;
            case 'string':
                $render.= join($args['sep'], $values);
                break;
        }

        return $args['before'].$render.$args['after'];
    }
}

abstract class gdcet_core_metafield {
    public $type;
    public $id;
    public $fields = array();
    public $values = array();
    public $index = array();

    public $current = null;
    public $in_the_loop = false;
    public $current_value = -1;

    public $label = '';
    public $slug = '';
    public $description = '';
    public $is_required = false;
    public $is_repeater = false;

    public function __construct() { }

    public function setup_value($value) {
        foreach ($this->index as $key) {
            $this->fields[$key]->values = isset($value[$key]) ? $value[$key] : array();
            $this->fields[$key]->value = isset($value[$key]) ? $value[$key][0] : null;
        }
    }

    public function count_values() {
        return count($this->values);
    }

    public function value($index = 0) {
        $this->current = $this->values[$index];

        $this->setup_value($this->current);

        return $this;
    }

    public function have_values() {
        if ($this->current_value + 1 < $this->count_values()) {
            return true;
        } else if ($this->current_value + 1 == $this->count_values() && $this->count_values() > 0) {
            $this->rewind_values();
        }

        $this->in_the_loop = false;

        return false;
    }

    public function rewind_values() {
        $this->current_value = -1;
    }

    public function value_index() {
        return $this->current_value;
    }

    public function the_value() {
        $this->in_the_loop = true;

        $this->next_value();

        $this->setup_value($this->current);
    }

    public function next_value() {
        $this->current_value++;

        $this->current = $this->values[$this->current_value];
    }

    public function is_simple_field() {
        return $this->type == 'simple';
    }

    public function is_custom_field() {
        return $this->type == 'custom';
    }
}

class gdcet_core_metafield_simple extends gdcet_core_metafield {
    public $type = 'simple';

    public function setup_value($value) {
        $this->fields[$this->index[0]]->values = $value;
        $this->fields[$this->index[0]]->value = $value;
    }

    public function __call($name, $arguments) {
        if (method_exists($this->fields[$this->index[0]], $name)) {
            return call_user_func_array(array($this->fields[$this->index[0]], $name), $arguments);
        }
    }
}

class gdcet_core_metafield_custom extends gdcet_core_metafield {
    public $type = 'custom';

    public $in_the_loop = false;
    public $current_sub_field = -1;

    public function raw() {
        echo $this->render()->get_error_message();
    }

    public function display($args = array()) {
        echo $this->render($args)->get_error_message();
    }

    public function render($args = array()) {
        return new WP_Error('doing_it_wrong', __("This is custom field, you need to access individual subfields to render.", "gd-content-tools"), $args);
    }

    public function sub_field_exists($name) {
        return isset($this->fields[$name]);
    }

    public function sub_field_index() {
        return $this->current_sub_field;
    }

    /** @return gdcet_core_basefield */
    public function sub_field($name) {
        if ($this->sub_field_exists($name)) {
            return $this->fields[$name];
        }

        return new WP_Error('sub_field_missing', __("This sub field is not found in this field", "gd-content-tools"));
    }

    public function list_sub_fields() {
        return array_keys($this->fields);
    }

    public function count_sub_fields() {
        return count($this->fields);
    }

    public function have_sub_fields() {
        if ($this->current_sub_field + 1 < $this->count_sub_fields()) {
            return true;
        } else if ($this->current_sub_field + 1 == $this->count_sub_fields() && $this->count_sub_fields() > 0) {
            $this->rewind_sub_fields();
        }

        $this->in_the_loop = false;

        return false;
    }

    public function rewind_sub_fields() {
        $this->current_sub_field = -1;
    }

    public function the_sub_field() {
        global $_gdcet_sub_field;

        $this->in_the_loop = true;

        $_gdcet_sub_field = $this->next_sub_field();

        $this->setup_field($_gdcet_sub_field);
    }

    /** @return gdcet_core_basefield */
    public function next_sub_field() {
        $this->current_sub_field++;

        $this->field = $this->fields[$this->index[$this->current_sub_field]];

        return $this->field;
    }

    public function setup_field($sub_field) { }

    public function get_label($args = array()) {
        $defaults = array('before' => '', 'after' => '');

        $args = wp_parse_args($args, $defaults);

        return $args['before'].$this->label.$args['after'];
    }

    public function get_description($args = array()) {
        $defaults = array('before' => '', 'after' => '');

        $args = wp_parse_args($args, $defaults);

        return $args['before'].$this->description.$args['after'];
    }

    public function label($args = array()) {
        echo $this->get_label($args);
    }

    public function description($args = array()) {
        echo $this->get_description($args);
    }
}
