<?php

if(function_exists('plugins_url')){
    class Postcode_Search {
        static function get_endpoint () {
            return plugins_url('search.php', __FILE__);
        }
    }

    wp_register_script('postcode-search',
                       plugins_url('js/ui.js', __FILE__),
                       array('backbone', 'jquery'));

    wp_localize_script('postcode-search', 'postcode_search',
                       array('ajaxurl' => Postcode_Search::get_endpoint()));
}

function postcode_search_form ($opts=array()) {
    $opts = array_merge(array(
        'id' => 'postcode-search',
        'classes'     => '',
        'head-name'   => 'postcode[]',
        'head-value'  => '',
        'tail-name'   => 'postcode[]',
        'tail-value'  => '',
        'addr-name'   => 'address',
        'addr-value'  => '',
        'addr-size'   => 20,
        'spinner-img' => plugins_url('img/spinner.gif', __FILE__),
        'search-text' => '우편번호 찾기',
        'prev-classes' => '',
        'next-classes' => '',
    ), $opts);
    include plugin_dir_path(__FILE__) . '/search-form.php';
}