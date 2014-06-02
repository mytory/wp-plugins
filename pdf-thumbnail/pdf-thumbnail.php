<?php
    Class Pdf_Thumbnail {

        static function generate_thumbnail ($post_id) {
            $post = get_post($post_id);
            if ($post->post_mime_type !== 'application/pdf') return;
            $path = get_attached_file($post_id);

            try {

                $imagick = new Imagick();
                $imagick->setResolution(144, 144);
                $imagick->readImage($path . '[0]');
                $imagick->setImageFormat('jpg');

                $target = sprintf('%s-cover.jpg', basename($path, '.pdf'));

                $attr = wp_upload_bits($target, null,
                                       $imagick->flattenImages()->getImageBlob());

                $id = wp_insert_attachment(array(
                    'guid'           => $attr['url'],
                    'post_mime_type' => 'image/jpeg',
                    'post_title'     => basename($target, '.jpg'),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ), $attr['file'] , $post_id);

                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $attr['file']));

                if ($post->post_parent) {
                    if (!get_post_thumbnail_id($post->post_parent)) {
                        set_post_thumbnail($post->post_parent, $id);
                    }
                }

            } catch (ImagickException $exp) {
                return;

            }
        }

    }

    add_action('add_attachment', array('Pdf_Thumbnail', 'generate_thumbnail'));
