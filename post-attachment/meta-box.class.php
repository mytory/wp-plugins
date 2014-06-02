<?php
    class Post_attachment {

        static function conditional_creation () {
            if (is_admin()) {
                add_action('load-post.php',     array('Post_attachment', 'create_instance'));
                add_action('load-post-new.php', array('Post_attachment', 'create_instance'));
            }
        }

        static function create_instance () { new self; }


        function __construct () {

            $this->title     = '첨부파일';
            $this->name      = 'post_attachment';
            $this->action    = 'post_attachment_action';
            $this->nonce     = 'post_attachment_nonce';
            $this->post_type = 'post';
            $this->context   = 'advanced';

            wp_register_script('post-attachment-js',
                               plugins_url('js/post-attachment.js', __FILE__),
                               array('jquery'));

            add_action('add_meta_boxes', array($this, 'add_meta_box'));
            add_action('save_post',      array($this, 'save'));
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
            wp_print_scripts(array('post-attachment-js'));
        }

        function save ($post_id) {

            if (isset($_POST[$this->nonce])
                && wp_verify_nonce($_POST[$this->nonce], $this->action)
                && $_POST['post_type'] == $this->post_type
                && current_user_can('edit_post', $post_id)
                && !wp_is_post_revision($post_id)
                && !wp_is_post_autosave($post_id))
            {

                // for wp_generate_attachment_metadata
                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                $field_name  = 'my-post-attachments';
                $attachments = get_post_attachments($post_id);
                $files       = self::flip_FILES($field_name);

                foreach ($files as $file):

                    // skip empty inputs
                    if (!$file['name']) continue;

                    $file_attr = wp_handle_upload($file,
                                                  array('test_form' => false,
                                                        'upload_error_handler' => array($this, 'upload_error_handler')));

                    $attach_id = wp_insert_attachment(array(
                        'guid'           => $file_attr['url'],
                        'post_mime_type' => $file_attr['type'],
                        'post_title'     => $file['name'],
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    ), $file_attr['file'], $post_id);

                    # 이 플러그인으로 첨부했음을 표시한다
                    update_post_meta($attach_id, 'attached-by', 'post-attachment-plugin');

                    wp_update_attachment_metadata(
                        $attach_id,
                        wp_generate_attachment_metadata($attach_id, $file_attr['file']));

                endforeach;

                if (!isset($_POST[$field_name])) $_POST[$field_name] = array();
                foreach (array_diff(array_keys($attachments), $_POST[$field_name]) as $attachment) {
                    wp_delete_post($attachment);
                }
            }

        }

        static function flip_FILES ($field) {
            $result = array();
            if (isset($_FILES[$field])) {
                foreach($_FILES[$field] as $key1 => $value1) {
                foreach($value1 as $key2 => $value2) {
                    $result[$key2][$key1] = $value2;
                }}
            }
            return $result;
        }

        static function get_children_ids ($post_id) {
            $attachments = get_children("post_type=attachment&post_parent=$post_id");
            $result = array();
            foreach ($attachments as $attachment) {
                $result[] = $attachment->ID;
            }
            return $result;
        }

        function upload_error_handler ($file, $error) {
          ?><!doctype html>
            <html>
                <head><meta charset="UTF-8"></head>
            <body>
                <?= sprintf("다음 파일을 올리는 데에 실패했습니다: %s", $file['name']) ?><br>
                <?= $error ?>
            </body><?php
            die();
        }
    }