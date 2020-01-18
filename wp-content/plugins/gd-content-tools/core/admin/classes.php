<?php


if (!defined('ABSPATH')) exit;

class gdcet_walker_category_checklist extends Walker {
    public $tree_type = 'category';
    public $selection = 'multi';
    public $hierarchy = false;
    public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output.= "$indent<ul class='children'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output.= "$indent</ul>\n";
    }

    function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0) {
        extract($args);

        if (empty($taxonomy)) {
            $taxonomy = 'category';
        }

        $class = '';
        $class_item = '';
        $term_value = $object->term_id;

        if ($this->hierarchy) {
            if ($taxonomy == 'category') {
                $name = 'post_category';
            } else {
                $name = 'tax_input['.$taxonomy.']';
            }
        } else {
            $name = '_gdcet_tax_input['.$taxonomy.']';
            $class_item = 'gdcet-term-limited';
            $term_value = $object->name;
        }

        $type = $this->selection === 'single' ? 'radio' : 'checkbox';

        if (isset($popular_cats) && is_array($popular_cats) && !empty($popular_cats)) {
            $class = in_array($object->term_id, $popular_cats) ? ' class="popular-category"' : '';
        }

        $output.= "\n<li id='{$taxonomy}-{$object->term_id}'$class>";
        $output.= '<label class="selectit">';
        $output.= '<input class="'.$class_item.'" value="'.$term_value.'" type="'.$type.'" name="'.$name.'[]" id="in-'.$taxonomy.'-'.$object->term_id.'"'.checked(in_array($object->term_id, $selected_cats), true, false).disabled(empty($args['disabled']), false, false).' /> '.esc_html(apply_filters('the_category', $object->name));
        $output.= '</label>';
    }

    function end_el(&$output, $object, $depth = 0, $args = array()) {
        $output.= "</li>\n";
    }
}
