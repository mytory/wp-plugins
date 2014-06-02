<?php
    class Banner_manager {

        static $post_type = 'banner';
        static $NOW;

        static function create_instance () {
            global $typenow;
            if ($typenow == self::$post_type) new self;
        }

        function __construct () {

          $this->NOW       = time();
          $this->labels    = Banner::$positions;

          add_action(sprintf('manage_%s_posts_columns', self::$post_type),
                     array($this, 'set_columns'));

          add_action('restrict_manage_posts', array($this, 'render_filters'));

          add_action(sprintf('manage_%s_posts_custom_column', self::$post_type),
                     array($this, 'render_columns'), 10, 2);

          add_action('parse_query', array($this, 'set_query'));

        }

        function set_columns ($columns) {
            return array('cb' => '<input type="checkbox">',
                         'title'           => '제목',
                         'banner_position' => '위치',
                         'banner_date'     => '게시 기간',
                         'banner_image'    => '이미지');
        }

        function render_columns ($column, $id) {
            switch ($column):
                case 'banner_position':
                    $position = get_post_meta($id, 'banner-position', true);
                    echo $position ? $this->labels[$position] : '없음';
                    break;

                case 'banner_date':
                    $from = get_post_meta($id, '게시_시작', true);
                    $to   = get_post_meta($id, '게시_종료', true);
                    $format = 'Y년 n월 j일';
                    printf("%s - %s", 
                           date($format, strtotime($from)),
                           date($format, strtotime($to)));
                    break;

                case 'banner_image':
                    $attach_id  = get_post_meta($id, 'img-desktop', true);
                    if ($attach_id) {
                        $img = wp_get_attachment_image_src($attach_id, 'post_thumbnail');
                        echo '<img src="'.$img[0].'" height=50>';
                    } else {
                        echo '없음';
                    }
                    break;

            endswitch;
        }

        function render_filters () {
            include plugin_dir_path(__FILE__) . '/manager-filter.php';
        }

        function set_query ($query) {

            global $pagenow;
            if ($query->is_admin &&
                $query->is_main_query() &&
                $pagenow == 'edit.php')
            {
                $vars = &$query->query_vars;
                if (!isset($_REQUEST['banner-show-all'])) {
                    $vars['meta_query'][] = array('key'     => '게시_시작',
                                                  'value'   => date('Ymd', $this->NOW),
                                                  'compare' => '<=',
                                                  'type'    => 'numeric');
                    $vars['meta_query'][] = array('key'     => '게시_종료',
                                                  'value'   => date('Ymd', $this->NOW),
                                                  'compare' => '>=',
                                                  'type'    => 'numeric');
                }

                if (!empty($_REQUEST['filter-by-banner-position'])) {
                    $vars['meta_query'][] = array('key'   => 'banner-position',
                                                  'value' => $_REQUEST['filter-by-banner-position']);
                }
            }

        }
    }