<?php
    class Banner_meta_box {
        static function conditional_creation () {
            if (is_admin()) {
                if (defined('DOING_AJAX') && DOING_AJAX) {
                    self::create_instance();

                } else {
                    add_action('load-post.php',     array('Banner_meta_box', 'create_instance'));
                    add_action('load-post-new.php', array('Banner_meta_box', 'create_instance'));

                }
            }
        }

        static function create_instance () { new self; }

        function __construct () {
            $this->title     = '배너 설정';
            $this->post_type = 'banner';
            $this->name      = 'banner_meta_box';
            $this->action    = 'banner_meta_box_action';
            $this->nonce     = 'banner_meta_box_nonce';
            $this->context   = 'advanced';

            add_action('wp_ajax_banner_meta_box::load_preview', array($this, 'ajax_load_preview'));
            add_action('add_meta_boxes', array($this, 'add_meta_box'));
            add_action('save_post', array($this, 'save'));

            wp_register_script('banner/meta-box',
                               plugins_url('js/meta-box.js', __FILE__),
                               array('jquery', 'jquery-ui-datepicker'));
        }


        function add_meta_box  () {
            add_meta_box($this->name,
                         $this->title,
                         array($this, 'render'),
                         $this->post_type,
                         $this->context);
        }

        function render ($post) {
            wp_nonce_field($this->action, $this->nonce);
            include plugin_dir_path(__FILE__) . '/meta-box.php';
            $this->print_scripts();
        }

        function print_scripts () {
            if (!wp_script_is('jquery', 'done')) {
                wp_print_scripts(array('jquery'));
            }
            if (!wp_script_is('jquery-ui-datepicker', 'done')) {
                wp_print_scripts(array('jquery-ui-datepicker'));
            }
            wp_print_scripts(array('banner/meta-box'));
            wp_print_styles(array('jquery-ui-theme'));
        }

        function ajax_load_preview () {
            echo $this->load_preview($_REQUEST['id']);
            exit;
        }

        function load_preview ($id) {
            $img = wp_get_attachment_image_src($id, 'post_thumbnail');
            return '<img src="'.$img[0].'">';
        }

        function save ($post_id) {
            if (isset($_POST[$this->nonce])
                && wp_verify_nonce($_POST[$this->nonce], $this->action)
                && $_POST['post_type'] == $this->post_type
                && current_user_can('edit_post', $post_id))
            {
                if (isset($_POST['banner-meta-게시_시작'])) {
                    $v = sanitize_text_field($_POST['banner-meta-게시_시작']);
                    update_post_meta($post_id, '게시_시작', $v);
                }

                if (isset($_POST['banner-meta-게시_종료'])) {
                    $v = sanitize_text_field($_POST['banner-meta-게시_종료']);
                    update_post_meta($post_id, '게시_종료', $v);
                }

                if (isset($_POST['banner-meta-url'])) {
                    $v = sanitize_text_field($_POST['banner-meta-url']);
                    update_post_meta($post_id, 'url', $v);
                }

                if (isset($_POST['banner-meta-position'])) {
                    update_post_meta($post_id, 'position',
                                     $_POST['banner-meta-position']);
                }

                if (isset($_POST['banner-meta-img-desktop'])) {
                    update_post_meta($post_id, 'img-desktop',
                                     (int) $_POST['banner-meta-img-desktop']);
                }

                if (isset($_POST['banner-meta-img-mobile'])) {
                    update_post_meta($post_id, 'img-mobile',
                                     (int) $_POST['banner-meta-img-mobile']);
                }

                if (isset($_POST['banner-meta-style'])) {
                    update_post_meta($post_id, 'style', $_POST['banner-meta-style']);
                }

                if (!get_post_meta($post_id, 'order', true)) {
                    update_post_meta($post_id, 'order', 0);
                }
            }
        }
    }
