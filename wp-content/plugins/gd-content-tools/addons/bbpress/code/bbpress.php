<?php

if (!defined('ABSPATH')) exit;

class gdcet_bbpress_embed {
    public function __construct() {
        add_action('bbp_theme_before_topic_form', array($this, 'init_topic'));
        add_action('bbp_theme_before_reply_form', array($this, 'init_reply'));

        if (!is_admin()) {
            add_action('gdcet_meta_load_enqueue_files', array($this, 'enqueue_files'));
        }

        add_action('bbp_new_topic', array($this, 'new_topic'), 10, 1);
        add_action('bbp_new_reply', array($this, 'new_reply'), 10, 1);
        add_action('bbp_edit_topic', array($this, 'edit_topic'), 10, 1);
        add_action('bbp_edit_reply', array($this, 'edit_reply'), 10, 1);

        if (gdcet_bbpress()->get('embed')) {
            add_filter('bbp_get_reply_content', array($this, 'reply_embed'), 60, 2);
            add_filter('bbp_get_topic_content', array($this, 'topic_embed'), 60, 2);
        }
    }

    public function embed($content, $gdcet_type, $gdcet_post_type, $gdcet_post_id) {
        $rules = $this->list_rules($gdcet_type, false);

        $render = '';

        foreach ($rules as $rule) {
            ob_start();

            $template = apply_filters('gdcet_bbpress_metabox_emded', 'gdcet-metabox-embed.php', $rule);

            $gdcet_metabox_id = $rule['metabox'];

            include(gdcet_get_bbpress_template_part($template));

            $render.= ob_get_contents();
            ob_end_clean();

            $this->enqueue_files();
        }

        return $content.$render;
    }

    public function save($real, $id, $name) {
        gdcet_meta()->load_control();

        gdcet_control_meta()->save(array(
            'id' => $id, 
            'type' => 'post', 
            'name' => $name, 
            'real_id' => $real
        ));
    }

    public function topic_embed($content, $topic_id) {
        return $this->embed($content, 'topic', bbp_get_topic_post_type(), $topic_id);
    }

    public function reply_embed($content, $reply_id) {
        if (bbp_get_topic_post_type() === get_post_type($reply_id)) {
            return $this->embed($content, 'topic', bbp_get_topic_post_type(), $reply_id);
        }

        return $this->embed($content, 'reply', bbp_get_reply_post_type(), $reply_id);
    }

    public function new_topic($topic_id) {
        $this->save($topic_id, 0, bbp_get_topic_post_type());
    }

    public function new_reply($reply_id) {
        $this->save($reply_id, 0, bbp_get_reply_post_type());
    }

    public function edit_topic($topic_id) {
        $this->save(null, $topic_id, bbp_get_topic_post_type());
    }

    public function edit_reply($reply_id) {
        $this->save(null, $reply_id, bbp_get_reply_post_type());
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 10) == 'embed_box_') {
            $call = explode('_', substr($name, 10));

            $_type = $call[0];
            $_id = absint($call[1]);
            $_rule = gdcet_bbpress()->get_rule($_id);
            $_box = intval($_rule['metabox']);
            $_css = 'gdcet-bbpress-metabox-wrapper';

            if (isset($_rule['style']) && $_rule['style'] == 'light') {
                $_css.= ' gdcet-bbpress-style-light';
            }

            $metabox = gdcet_meta()->get_box($_box);
            
            gdcet_meta()->enqueue();
            gdcet_meta()->load_control();

            if ($_rule['wrapper'] == 'fieldset') {
                echo '<fieldset class="bbp-form gdcet-bbpress-form">';
                echo '<legend>'.$metabox->label.'</legend>';
                echo '<div class="'.$_css.'">';

                $this->render($_box, $_type);

                echo '</div>';
                echo '</fieldset>';
            } else {
                echo '<div class="gdcet-bbpress-form">';
                echo '<h4>'.$metabox->label.'</h4>';
                echo '<div class="'.$_css.'">';

                $this->render($_box, $_type);

                echo '</div>';
                echo '</div>';
            }
        }
    }

    public function render($metabox, $type) {
        $id = 0;
        $post_type = 'bbpress';

        if ($type == 'topic') {
            $post_type = bbp_get_topic_post_type();

            if (bbp_is_topic_edit()) {
                $id = bbp_get_topic_id();
            }
        } else if ($type == 'reply') {
            $post_type = bbp_get_reply_post_type();

            if (bbp_is_reply_edit()) {
                $id = bbp_get_reply_id();
            }
        }

        gdcet_control_meta()->render(array(
            'id' => $id,
            'type' => 'post',
            'name' => $post_type,
            'metabox' => intval($metabox),
            'nonce' => wp_create_nonce('gdcet-metabox-'.$post_type.'-'.$id.'-'.$metabox),
            'scope' => 'front'
        ));
    }

    public function enqueue_files() {
        $base_url = GDCET_URL.'addons/bbpress/';

        wp_enqueue_style('gdcet-meta-bbpress', gdcet()->file('css', 'meta-bbpress', false, true, $base_url), array(), gdcet_settings()->file_version());
        wp_enqueue_script('gdcet-meta-bbpress', gdcet()->file('js', 'meta-bbpress', false, true, $base_url), array(), gdcet_settings()->file_version(), true);
    }

    public function list_rules($type = 'both', $use_roles = true) {
        $list = array();

        $roles = d4p_current_user_roles();
        $forum = bbp_get_forum_id();

        if ($forum == 0) {
            if ($type == 'topic') {
                $forum = bbp_get_topic_forum_id();
            } else if ($type == 'reply') {
                $forum = bbp_get_reply_forum_id();
            }
        }

        foreach (gdcet_bbpress()->_settings['boxes'] as $rule) {
            $show = true;

            if ($rule['scope'] == 'forums' && !in_array($forum, $rule['forums'])) {
                $show = false;
            }

            $_valid_roles = array_intersect($rule['roles'], $roles);
            if ($use_roles && $show && is_array($rule['roles']) && empty($_valid_roles)) {
                $show = false;
            }

            if ($show && !($rule['type'] == $type || $rule['type'] == 'both')) {
                $show = false;
            }

            if ($show) {
                $list[] = $rule;
            }
        }

        return $list;
    }

    public function rules($type = 'both') {
        $rules = array();

        if (is_user_logged_in()) {
            $rules = $this->list_rules($type);
        }

        foreach ($rules as $rule) {
            $id = $rule['id'];
            $priority = $rule['priority'];

            if ($type == 'topic') {
                switch ($rule['location']) {
                    case 'before_content':
                        add_action('bbp_theme_before_topic_form_content', array($this, 'embed_box_topic_'.$id), $priority);
                        break;
                    case 'after_content':
                        add_action('bbp_theme_after_topic_form_content', array($this, 'embed_box_topic_'.$id), $priority);
                        break;
                    case 'form_end':
                        add_action('bbp_theme_before_topic_form_submit_wrapper', array($this, 'embed_box_topic_'.$id), $priority);
                        break;
                }
            } else if ($type == 'reply') {
                switch ($rule['location']) {
                    case 'before_content':
                        add_action('bbp_theme_before_reply_form_content', array($this, 'embed_box_reply_'.$id), $priority);
                        break;
                    case 'after_content':
                        add_action('bbp_theme_after_reply_form_content', array($this, 'embed_box_reply_'.$id), $priority);
                        break;
                    case 'form_end':
                        add_action('bbp_theme_before_reply_form_submit_wrapper', array($this, 'embed_box_reply_'.$id), $priority);
                        break;
                }
            }
        }
    }

    public function init_topic() {
        $this->rules('topic');
    }

    public function init_reply() {
        $this->rules('reply');
    }
}

global $_gdcet_embed_bbpress;
$_gdcet_embed_bbpress = new gdcet_bbpress_embed();

function gdcet_bbpress_embed() {
    global $_gdcet_embed_bbpress;
    return $_gdcet_embed_bbpress;
}

function gdcet_get_bbpress_template_part($name) {
    $stack = bbp_get_template_stack();

    $found = false;
    foreach ($stack as $path) {
        if (file_exists(trailingslashit($path).$name)) {
            $found = trailingslashit($path).$name;
            break;
        }
    }

    if ($found === false) {
        $found = GDCET_PATH.'addons/bbpress/theme/'.$name;
    }

    return $found;
}
