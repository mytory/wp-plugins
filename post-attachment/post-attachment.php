<?php

    include dirname(__FILE__) . '/meta-box.class.php';
    add_action('init', array('Post_attachment', 'conditional_creation'));

    function mime_type_icon_url ($filename) {
        $type = wp_check_filetype($filename);
        $type = $type['type'];
        $path = dirname(__FILE__) . "/img/$type.png";
        if (is_file($path)) {
            return plugins_url("img/$type.png", __FILE__);
        } else {
            return plugins_url("img/fallback.png", __FILE__);
        }
    }

    function get_post_attachments ($post_id) {
        return get_children(array('post_type' => 'attachment',
                                  'post_parent' => $post_id,
                                  'meta_query' => array(
                                        array('key' => 'attached-by',
                                              'value' => 'post-attachment-plugin'))));
    }