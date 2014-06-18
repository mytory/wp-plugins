<?php

if(function_exists('wp_register_script')){
    class Postcode_Search {
        static function get_endpoint () {
            return plugins_url('search.php', __FILE__);
        }
    }

    function postcode_enqueue_scripts(){
        wp_enqueue_script('postcode-search',
            plugins_url('js/ui.js', __FILE__),
            array('backbone', 'jquery'));
        wp_enqueue_script('postcode-search-interface',
            plugins_url('js/interface.js', __FILE__),
            array('postcode-search'));

        // 워드프레스를 사용하는 게 아니면 아래처럼 변수 세팅을 해 줘야 한다.
        // var postcode_search = {"ajaxurl":"http:\/\/marxism.or.kr\/2014\/wp-content\/plugins\/postcode-search\/search.php"};
        wp_localize_script('postcode-search', 'postcode_search',
            array('ajaxurl' => Postcode_Search::get_endpoint()));
    }

    add_action('wp_enqueue_scripts', 'postcode_enqueue_scripts');
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
    include dirname(__FILE__) . '/search-form.php';
}