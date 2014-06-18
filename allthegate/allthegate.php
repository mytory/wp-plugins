<?php
    if(function_exists('wp_register_script')){
        wp_register_script('allthegate', 'http://www.allthegate.com/plugin/AGSWallet_utf8.js');
    }

    function allthegate_hidden_inputs () {
        include dirname(__FILE__) . '/hidden-inputs.php';
    }

    include dirname(__FILE__) . '/functions.php';
