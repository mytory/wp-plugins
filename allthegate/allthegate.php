<?php

    wp_register_script('allthegate', 'http://www.allthegate.com/plugin/AGSWallet_utf8.js');

    function allthegate_hidden_inputs () {
        include plugin_dir_path(__FILE__) . '/hidden-inputs.php';
    }

    include plugin_dir_path(__FILE__) . '/functions.php';
