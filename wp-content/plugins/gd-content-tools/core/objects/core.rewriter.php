<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_rewriter {
    public $rules = array(
        'taxonomy' => array(),
        'post_type' => array()
    );

    public function __construct() {
        // add_filter('gdcet_rewriter_rules', array($this, 'rules_taxonomy_index'), 10, 2);

        add_filter('gdcet_rewriter_rules', array($this, 'rules_post_type_date_archives'), 20, 2);
        add_filter('gdcet_rewriter_rules', array($this, 'rules_post_type_author_archives'), 30, 2);
        add_filter('gdcet_rewriter_rules', array($this, 'rules_post_type_intersections'), 40, 2);
        add_filter('gdcet_rewriter_rules', array($this, 'rules_post_type_overrides'), 50, 2);
    }

    private function _archive_slug($post_type) {
        $slug_archive = $post_type->has_archive;

        if ($slug_archive === true) {
            $slug_archive = $post_type->name;
        }

        return $slug_archive;
    }

    public function add($type, $rule, $name, $args = array()) {
        $this->rules[$type][$rule][$name] = $args;
    }

    public function has_rules($type, $rule, $name) {
        return isset($this->rules[$type]) && 
               isset($this->rules[$type][$rule]) && 
               isset($this->rules[$type][$rule][$name]);
    }

    public function rules_taxonomy_index($rules, $wp_rewrite) {
        if (isset($this->rules['taxonomy']['index'])) {
            foreach (array_keys($this->rules['taxonomy']['index']) as $tax) {
                if (taxonomy_exists($tax)) {
                    $rules = $rules + $this->_build_taxonomy_index($tax, $wp_rewrite);
                }
            }
        }

        return $rules;
    }

    public function rules_post_type_date_archives($rules, $wp_rewrite) {
        if (isset($this->rules['post_type']['date_archives'])) {
            foreach (array_keys($this->rules['post_type']['date_archives']) as $cpt) {
                if (post_type_exists($cpt) && gdcet_post_type_has_archives($cpt)) {
                    $rules = $rules + $this->_build_post_type_date_archives($cpt, $wp_rewrite);
                }
            }
        }

        return $rules;
    }

    public function rules_post_type_author_archives($rules, $wp_rewrite) {
        if (isset($this->rules['post_type']['author_archives'])) {
            foreach ($this->rules['post_type']['author_archives'] as $cpt => $args) {
                if (post_type_exists($cpt) && gdcet_post_type_has_archives($cpt)) {
                    $rules = $rules + $this->_build_post_type_author_archives($cpt, $args, $wp_rewrite);
                }
            }
        }

        return $rules;
    }

    public function rules_post_type_intersections($rules, $wp_rewrite) {
        if (isset($this->rules['post_type']['intersect_archives'])) {
            foreach ($this->rules['post_type']['intersect_archives'] as $cpt => $args) {
                if (post_type_exists($cpt) && gdcet_post_type_has_archives($cpt)) {
                    $rules = $rules + $this->_build_post_type_intersect_archives($cpt, $args, $wp_rewrite);
                }
            }
        }

        return $rules;
    }

    public function rules_post_type_overrides($rules, $wp_rewrite) {
        return $rules;
    }

    private function _build_taxonomy_index($tax, $wp_rewrite) {
        $rules = array();

        $taxonomy = get_taxonomy($tax);
        $slug = isset($taxonomy->rewrite['slug']) ? $taxonomy->rewrite['slug'] : '';

        if (!empty($slug)) {
            $rules[$slug.'/?$'] =                  'index.php?tax_index='.$tax;
            $rules[$slug.'/page/([0-9]{1,})/?$'] = 'index.php?tax_index='.$tax.'&paged='.$wp_rewrite->preg_index(1);
        }

        return $rules;
    }

    private function _build_post_type_intersect_archives($cpt, $args, $wp_rewrite) {
        $rules = array();
        $tmp = array();

        $post_type = get_post_type_object($cpt);

        if ($args['simple']) {
            $taxonomies = get_object_taxonomies($cpt, 'objects');

            $slug_archive = $this->_archive_slug($post_type).'/';

            foreach ($taxonomies as $taxonomy => $tax) {
                $slug = isset($tax->rewrite['slug']) ? $tax->rewrite['slug'] : '';
                $query_var = $tax->query_var === true ? $tax->name : ($tax->query_var !== false ? $tax->query_var : $tax->name);

                if (!empty($slug)) {
                    if ($args['partial'] && $taxonomy == $args['baseless']) {
                        $slug = '';
                    } else {
                        $_list = explode('/', $slug);
                        $slug = end($_list).'/';
                    }

                    $rules[$slug_archive.$slug.'([^/]+)/?$'] =                               'index.php?post_type='.$cpt.'&'.$query_var.'='.$wp_rewrite->preg_index(1);
                    $rules[$slug_archive.$slug.'([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?post_type='.$cpt.'&feed='.$wp_rewrite->preg_index(2).'&'.$query_var.'='.$wp_rewrite->preg_index(1);
                    $rules[$slug_archive.$slug.'([^/]+)/(feed|rdf|rss|rss2|atom)/?$'] =      'index.php?post_type='.$cpt.'&feed='.$wp_rewrite->preg_index(2).'&'.$query_var.'='.$wp_rewrite->preg_index(1);
                    $rules[$slug_archive.$slug.'([^/]+)/page/([0-9]{1,})/?$'] =              'index.php?post_type='.$cpt.'&paged='.$wp_rewrite->preg_index(2).'&'.$query_var.'='.$wp_rewrite->preg_index(1);
                }
            }
        }

        if ($args['custom']) {
            $parts = explode('/', trim($args['structure'], '/'));
            $query = 'index.php?post_type='.$cpt;
            $rule = $this->_archive_slug($post_type);

            $i = 1;
            foreach ($parts as $part) {
                $taxonomy = trim($part, '%');
                $tax = get_taxonomy($taxonomy);
                $query_var = $tax->query_var === true ? $tax->name : ($tax->query_var !== false ? $tax->query_var : $tax->name);

                $query.= '&'.$query_var.'='.$wp_rewrite->preg_index($i);
                $rule.= "/([^/]+)";
                $i++;

                if ($args['partial'] && count($parts) > 1 && $i <= count($parts)) {
                    $tmp[] = array($rule, $query, $i);
                }
            }

            $tmp[] = array($rule, $query, $i);
            $tmp = array_reverse($tmp);

            foreach ($tmp as $t) {
                $rule = $t[0]; $query = $t[1]; $i = $t[2];

                $rules[$rule.'/feed/(feed|rdf|rss|rss2|atom)/?$'] =     $query.'&feed='.$wp_rewrite->preg_index($i);
                $rules[$rule.'/(feed|rdf|rss|rss2|atom)/?$'] =          $query.'&feed='.$wp_rewrite->preg_index($i);
                $rules[$rule.'/page/([0-9]{1,})/?$'] =                  $query.'&paged='.$wp_rewrite->preg_index($i);
                $rules[$rule.'/?$'] =                                   $query;
            }
        }

        return $rules;
    }

    private function _build_post_type_author_archives($cpt, $args, $wp_rewrite) {
        $rules = array();

        $post_type = get_post_type_object($cpt);
        $slug_archive = $this->_archive_slug($post_type);
        $slug_author = isset($args['slug']) && !empty($args['slug']) ? $args['slug'] : 'author';

        $query = 'index.php?post_type='.$cpt.'&author_name='.$wp_rewrite->preg_index(1);
        $rule = $slug_archive.'/'.$slug_author.'/([^/]+)';

        $rules[$rule.'/?$'] =                                   $query;
        $rules[$rule.'/feed/(feed|rdf|rss|rss2|atom)/?$'] =     $query.'&feed='.$wp_rewrite->preg_index(2);
        $rules[$rule.'/(feed|rdf|rss|rss2|atom)/?$'] =          $query.'&feed='.$wp_rewrite->preg_index(2);
        $rules[$rule.'/page/([0-9]{1,})/?$'] =                  $query.'&paged='.$wp_rewrite->preg_index(2);

        return $rules;
    }

    private function _build_post_type_date_archives($cpt, $wp_rewrite) {
        $rules = array();

        $post_type = get_post_type_object($cpt);
        $slug_archive = $this->_archive_slug($post_type);

        $dates = array(
            array('rule' => '([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})', 'vars' => array('year', 'monthnum', 'day')),
            array('rule' => '([0-9]{4})/([0-9]{1,2})', 'vars' => array('year', 'monthnum')),
            array('rule' => '([0-9]{4})', 'vars' => array('year'))
        );

        foreach ($dates as $data) {
            $query = 'index.php?post_type='.$cpt;
            $rule = $slug_archive.'/'.$data['rule'];

            $i = 1;
            foreach ($data['vars'] as $var) {
                $query.= '&'.$var.'='.$wp_rewrite->preg_index($i);
                $i++;
            }

            $rules[$rule.'/?$'] =                                   $query;
            $rules[$rule.'/feed/(feed|rdf|rss|rss2|atom)/?$'] =     $query.'&feed='.$wp_rewrite->preg_index($i);
            $rules[$rule.'/(feed|rdf|rss|rss2|atom)/?$'] =          $query.'&feed='.$wp_rewrite->preg_index($i);
            $rules[$rule.'/page/([0-9]{1,})/?$'] =                  $query.'&paged='.$wp_rewrite->preg_index($i);
        }

        return $rules;
    }
}
