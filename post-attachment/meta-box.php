<?php
    $id = $post->ID;
    $attachments = get_post_attachments($id);
?>
<ul class='js-rows  inside'>
    <?php foreach ($attachments as $attachment): ?>
        <li class='js-old'>
            <img src='<?= mime_type_icon_url(wp_get_attachment_url($attachment->ID)) ?>'>
            <a href='<?= $attachment->guid ?>'><?= $attachment->post_title ?></a>
            <input type='hidden' name='my-post-attachments[]' value='<?= $attachment->ID ?>'>
            &nbsp;
            <a href='#' class='js-cancel'>삭제</a>
        </li>
    <?php endforeach; ?>
</ul>
<ul class='js-row-template' style='display:none'>
    <li>
        <input type='file' name='my-post-attachments[]'>
        <a href='#' class='js-cancel'>취소</a>
    </li>
</ul>