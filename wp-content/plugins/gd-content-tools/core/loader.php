<?php

if (!defined('ABSPATH')) exit;

class gdcet_core_loader {
    /** @var gdcet_core_tweaks */
    public $tweaks;
    /** @var gdcet_core_sprites */
    public $sprites;
    /** @var gdcet_core_rewriter */
    public $rewriter;
    /** @var gdcet_core_navmenu */
    public $navmenu;
    /** @var gdcet_core_templates */
    public $templates;

    public $keywords = array();

    public $cpt = array();
    public $cpt_override = array();
    public $cpt_activated = array();

    public $tax = array();
    public $tax_override = array();
    public $tax_activated = array();

    public $mod_cpt_expand_home = array();
    public $mod_cpt_expand_feed = array();

    public $mod_tax_metabox = array();
    public $mod_tax_image = array();
    public $mod_tax_filter = array();

    public function __construct() {
        add_action('init', array($this, 'register_post_types'), 1);
        add_action('init', array($this, 'register_taxonomies'), 2);
        add_action('init', array($this, 'register_post_types_late'), 20);
        add_action('init', array($this, 'register_taxonomies_late'), 30);
        add_action('init', array($this, 'register_permalinks'), 3);
        add_action('init', array($this, 'init'));

        add_action('gdcet_settings_loaded', array($this, 'settings'), 1);

        add_filter('post_type_link', array($this, 'post_type_link'), 10, 3);
        add_filter('post_link', array($this, 'post_link'), 10, 3);

        add_filter('query_vars', array($this, 'query_vars'));
        add_filter('request', array($this, 'request'));
        add_action('generate_rewrite_rules', array($this, 'generate_rewrite_rules'), 8);

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        require_once(GDCET_PATH.'core/objects/core.tweaks.php');
        $this->tweaks = new gdcet_core_tweaks();

        require_once(GDCET_PATH.'core/objects/core.sprites.php');
        $this->sprites = new gdcet_core_sprites();

        require_once(GDCET_PATH.'core/objects/core.rewriter.php');
        $this->rewriter = new gdcet_core_rewriter();

        require_once(GDCET_PATH.'core/objects/core.navmenu.php');
        $this->navmenu = new gdcet_core_navmenu();

        add_action('wp', array($this, 'wp'), 1000);
    }

    public function wp() {
        global $wp_query;

        $wp_query->is_cpt_taxonomy_index = false;
        $wp_query->is_cpt_archive_intersection = false;
        $wp_query->is_cpt_date_intersection = false;
        $wp_query->is_cpt_author_intersection = false;

        if (get_query_var('tax_index') != '') {
            $wp_query->is_home = false;
            $wp_query->is_cpt_taxonomy_index = true;
        }

        if (is_any_tax()) {
            $cpt = get_query_var('post_type');

            if (is_string($cpt) && !empty($cpt) && $this->rewriter->has_rules('post_type', 'intersect_archives', $cpt)) {
                $wp_query->is_cpt_archive_intersection = true;

                $wp_query->cpt_intersection = array(
                    'post_type' => $cpt,
                    'taxonomies' => array(),
                    'terms' => array()
                );

                foreach ($wp_query->tax_query->queries as $tax) {
                    $wp_query->cpt_intersection['taxonomies'][] = $tax['taxonomy'];
                    $wp_query->cpt_intersection['terms'][$tax['taxonomy']] = $tax['terms'][0];
                }

                $wp_query->cpt_intersection['method'] = count($wp_query->cpt_intersection['taxonomies']) == 1 ? 'simple' : 'custom';
            }
        }

        if (is_post_type_archive()) {
            $cpt = get_query_var('post_type');

            if (is_string($cpt)) {
                if (is_author() && $this->rewriter->has_rules('post_type', 'author_archives', $cpt)) {
                    $wp_query->is_cpt_author_intersection = true;
                }

                if (is_date() && $this->rewriter->has_rules('post_type', 'date_archives', $cpt)) {
                    $wp_query->is_cpt_date_intersection = true;
                }
            }
        }
    }

    public function init() {
        require_once(GDCET_PATH.'core/objects/core.templates.php');
        $this->templates = new gdcet_core_templates();

        if (!empty($this->mod_cpt_expand_home)) {
            add_filter('pre_get_posts', array($this, 'expand_query_home_page'));
        }

        if (!empty($this->mod_cpt_expand_feed)) {
            add_filter('pre_get_posts', array($this, 'expand_query_feed'));
        }
    }

    public function settings() {
        foreach (gdcet_settings()->current['cpt']['list'] as $id => $data) {
            $this->cpt[$id] = new gdcet_base_cpt($data);
            $this->cpt[$id]->run();
            $this->keywords[] = $data['post_type'];
        }

        foreach (gdcet_settings()->current['cpt']['override'] as $name => $data) {
            $this->cpt_override[$name] = new gdcet_base_cpt_override($data);
            $this->cpt_override[$name]->run();
        }

        foreach (gdcet_settings()->current['tax']['list'] as $id => $data) {
            $this->tax[$id] = new gdcet_base_tax($data);
            $this->tax[$id]->run();
            $this->keywords[] = $data['taxonomy'];
        }

        foreach (gdcet_settings()->current['tax']['override'] as $name => $data) {
            $this->tax_override[$name] = new gdcet_base_tax_override($data);
            $this->tax_override[$name]->run();
        }
    }

    public function register_post_types() {
        do_action('gdcet_init_register_post_types');
    }

    public function register_taxonomies() {
        do_action('gdcet_init_register_taxonomies');

        do_action('gdcet_init_assign_taxonomies');
    }

    public function register_post_types_late() {
        do_action('gdcet_init_late_register_post_types');
    }

    public function register_taxonomies_late() {
        do_action('gdcet_init_late_register_taxonomies');
    }

    public function register_permalinks() {
        do_action('gdcet_init_register_permalinks');
    }

    public function query_vars($qv) {
        $qv = apply_filters('gdcet_rewriter_query_vars', $qv);

        $qv[] = 'tax_index';

        return $qv;
    }

    private function _rewrite_taxonomies($post_link, $post) {
        $return = array(
            'rewrite_code' => array(),
            'rewrite_replace' => array()
        );

        $taxonomies = get_taxonomies(array('public' => true));
        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                $t = get_taxonomy($taxonomy);
                $tax = '%'.$taxonomy.'%';

                if (strpos($post_link, $tax) !== false) {
                    $term = null;
                    $term_slug = '-';
                    $terms = get_the_terms($post->ID, $taxonomy);

                    if ($terms) {
                        usort($terms, 'gdcet_sort_terms_by_ID');
                        $term = $terms[0];
                        $term_slug = $term->slug;
                    }

                    if (is_object($term) && is_taxonomy_hierarchical($taxonomy) && $t->rewrite["hierarchical"]) {
                        $hierarchical_slugs = array();
                        $ancestors = get_ancestors($term->term_id, $taxonomy);

                        foreach ((array)$ancestors as $ancestor) {
                            $ancestor_term = get_term($ancestor, $taxonomy);
                            $hierarchical_slugs[] = $ancestor_term->slug;
			}

                        $hierarchical_slugs = array_reverse($hierarchical_slugs);
			$hierarchical_slugs[] = $term_slug;
                        $term_slug = implode('/', $hierarchical_slugs);
                    }

                    $return['rewrite_code'][] = $tax;
                    $return['rewrite_replace'][] = $term_slug;
                }
            }
        }

        return $return;
    }

    public function post_link($post_link, $post, $leavename) {
        $_taxonomies = $this->_rewrite_taxonomies($post_link, $post);

        $rewrite_code = $_taxonomies['rewrite_code'];
        $rewrite_replace = $_taxonomies['rewrite_replace'];

        $post_link = str_replace($rewrite_code, $rewrite_replace, $post_link);
        $post_link = user_trailingslashit($post_link, 'single');

        return $post_link;
    }

    public function post_type_link($post_link, $post, $leavename) {
        $rewrite_code = array(
            '%year%', '%monthnum%', '%day%',
            '%hour%', '%minute%', '%second%',
            $leavename ? '' : '%'.$post->post_type.'%',
            '%post_id%', '%'.$post->post_type.'_id%');

        $date = explode(' ', date('Y m d H i s', strtotime($post->post_date)));
        $rewrite_replace = array(
            $date[0], $date[1], $date[2],
            $date[3], $date[4], $date[5],
            $post->post_name,
            $post->ID, $post->ID);
        
        if (strpos($post_link, '%author%') !== false) {
            $author_data = get_userdata($post->post_author);

            $rewrite_code[] = '%author%';
            $rewrite_replace[] = $author_data->user_nicename;
        }

        $_taxonomies = $this->_rewrite_taxonomies($post_link, $post);

        $rewrite_code = array_merge($rewrite_code, $_taxonomies['rewrite_code']);
        $rewrite_replace = array_merge($rewrite_replace, $_taxonomies['rewrite_replace']);

        $post_link = str_replace($rewrite_code, $rewrite_replace, $post_link);
        $post_link = user_trailingslashit($post_link, 'single');

        return $post_link;
    }

    public function request($query_vars) {
        $new_query_vars = array();

        foreach ($query_vars as $key => $value) {
            if (substr($key, 0, 4) == 'cpt_') {
                $parts = explode('_', $key, 3);

                switch ($parts[1]) {
                    case 'postid':
                        $new_query_vars['post_type'] = $parts[2];
                        $new_query_vars['p'] = $value;
                        break;
                }
            } else {
                $new_query_vars[$key] = $value;
            }
        }

        return $new_query_vars;
    }

    public function generate_rewrite_rules($wp_rewrite) {
        do_action('gdcet_init_rewriter_rules');

        $rules = apply_filters('gdcet_rewriter_rules', array(), $wp_rewrite);
        
        if (!empty($rules)) {
            $wp_rewrite->rules = $rules + $wp_rewrite->rules;
        }
    }

    public function get_cpt_override($name = '', $what = 'settings') {
        if (isset($this->cpt_override[$name])) {
            return $this->cpt_override[$name]->get($what);
        } else {
            if (post_type_exists($name)) {
                $_cpt_obj = get_post_type_object($name);

                $_cpt = new gdcet_base_cpt_override();
                $_cpt->post_type = $_cpt_obj->name;
                $_cpt->taxonomies = get_object_taxonomies($name, 'names');

                gdcet_settings()->save_cpt_override($_cpt->into_array());

                return $_cpt->get($what);
            }
        }

        return false;
    }

    public function get_cpt($id = 0, $what = 'settings') {
        if (isset($this->cpt[$id])) {
            return $this->cpt[$id]->get($what);
        } else {
            $_cpt = new gdcet_base_cpt();

            return $_cpt->get($what);
        }
    }

    public function get_tax_override($name = '', $what = 'settings') {
        if (isset($this->tax_override[$name])) {
            return $this->tax_override[$name]->get($what);
        } else {
            if (taxonomy_exists($name)) {
                $_tax_obj = get_taxonomy($name);

                $_tax = new gdcet_base_tax_override();
                $_tax->taxonomy = $_tax_obj->name;

                gdcet_settings()->save_tax_override($_tax->into_array());

                return $_tax->get($what);
            }
        }

        return false;
    }

    public function get_tax($id = 0, $what = 'settings') {
        if (isset($this->tax[$id])) {
            return $this->tax[$id]->get($what);
        } else {
            $_tax = new gdcet_base_tax();

            return $_tax->get($what);
        }
    }
    
    private function _expand_query($query, $post_types, $name = 'home') {
        if (empty($post_types)) {
            return $query;
        }

        $included = isset($query->query_vars['post_type']) ? (array)$query->query_vars['post_type'] : array();

        if (empty($included)) {
            $included[] = 'post';
        }

        $included = array_merge($included, $post_types);

        $included = apply_filters('gdcet_expand_'.$name.'_query_post_types', $included);
        $query->set('post_type', $included);

        return $query;
    }

    public function expand_query_home_page($query) {
        if ((is_home() && $query->is_main_query()) && (!isset($query->query_vars['suppress_filters']) || false == $query->query_vars['suppress_filters'])) {
            return $this->_expand_query($query, $this->mod_cpt_expand_home, 'home');
        }

        return $query;
    }

    public function expand_query_feed($query) {
        if ($query->is_feed && !isset($query->query['post_type'])) {
            return $this->_expand_query($query, $this->mod_cpt_expand_feed, 'feed');
        }

        return $query;
    }

    public function enqueue_scripts() {
        do_action('gdcet_wp_enqueue_scripts');
    }
}
