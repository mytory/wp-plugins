<?php
    function register_banner_position ($name, $label = null) {
        if (is_null($label)) {
            $label = $name;
        }
        Banner::$positions[$name] = $label;
    }

    function register_banner_style ($name, $label = null) {
        if (is_null($label)) {
            $label = $name;
        }
        Banner::$styles[$name] = $label;
    }

    function get_banners_by_position ($name, $count = null, $date_Ymd = null) {
        if (is_null($date_Ymd)) {
            $date_Ymd = date('Ymd');
        }
        if (is_null($count)) {
            $count = -1;
        }
        $args = array('post_type'  => 'banner',
                      'post_status' => 'any',
                      'meta_query' => array(
                        array('key'     => '게시_시작',
                              'value'   => $date_Ymd,
                              'compare' => '<=',
                              'type'    => 'numeric'), 
                        array('key'     => '게시_종료',
                              'value'   => $date_Ymd, 
                              'compare' => '>=', 
                              'type'    => 'numeric'),
                        array('key' => 'position', 
                              'value' => $name)),
                      'posts_per_page' => $count,
                      'meta_key' => 'order',
                      'orderby' => 'meta_value_num',
                      'order' => 'ASC');
        return new WP_Query($args);
    }