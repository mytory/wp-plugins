<?php
/*
 * setting up global states...
 */
class Banner {
    static $positions = array();
    static $styles    = array();
}

register_post_type('banner', array(
    'labels'      => array('name' => '배너'), 
    'public'      => true, 
    'has_archive' => true
));

/*
 * meta box 
 */
require plugin_dir_path(__FILE__) . '/meta-box.class.php';

add_action('init', array('Banner_meta_box', 'conditional_creation'));

/*
 * manager
 */
require plugin_dir_path(__FILE__) . '/manager.class.php';

add_action('load-edit.php', array('Banner_manager', 'create_instance'));

/*
 * utility functions
 */
require plugin_dir_path(__FILE__) . '/functions.php';
