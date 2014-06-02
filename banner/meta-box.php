<?php
    $the_ID       = $post->ID;
    $the_position = get_post_meta($the_ID, 'position', true);
    $img_desktop  = get_post_meta($the_ID, 'img-desktop', true);
    $img_mobile   = get_post_meta($the_ID, 'img-mobile', true);
    $url          = get_post_meta($the_ID, 'url', true);
    $the_style    = get_post_meta($the_ID, 'style', true);
?>
<?php wp_nonce_field('save_banner', 'save_banner_nonce'); ?>
<table class='form-table'>
    <tbody>
        <tr>
            <th scope='row'>게시 기간</th>
            <td>
                <fieldset>
                    <label>
                        <input class='js-datepicker'
                            type='text'
                            name='banner-meta-게시_시작'
                            value='<?= get_post_meta($the_ID, '게시_시작', true) ?>'
                        >부터
                    </label>
                    <br>
                    <label>
                        <input class='js-datepicker'
                            type='text'
                            name='banner-meta-게시_종료'
                            value='<?= get_post_meta($the_ID, '게시_종료', true) ?>'
                        >까지
                    </label>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope='row'>링크</th>
            <td><input type='text' name='banner-meta-url' value='<?= esc_attr($url) ?>'></td>
        </tr>
        <tr>
            <th scope='row'>위치</th>
            <td>
                <fieldset>
                    <?php foreach (Banner::$positions as $position => $label): ?>
                        <label>
                            <input
                                type='radio'
                                name='banner-meta-position' 
                                value='<?= esc_attr($position) ?>'
                                <?= $the_position == $position ? 'checked' : ''; ?>>
                            <?= $label ?>
                        </label>
                        <br>
                    <?php endforeach; ?>
                </fieldset>
            </td>
        </tr>
    
        <?php if (count(Banner::$styles)): ?>
            <tr>
                <th scope='row'>
                    유형
                </th>
                <td>
                    <fieldset>
                        <?php foreach (Banner::$styles as $style => $label): ?>
                            <label>
                                <input type='radio'
                                       name='banner-meta-style'
                                       value='<?= esc_attr($style) ?>'
                                       <?= $the_style === $style ? 'checked' : '' ?>>
                                <?= $label ?>
                            </label>
                            <br>
                        <?php endforeach; ?>
                    </fieldset>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <th scope='row'>
                이미지
                <input type="hidden"
                       name="banner-meta-img-desktop"
                       class='js-img-desktop'
                       value="<?= $img_desktop ?>">
            </th>
            <td>
                <div id="preview-desktop">
                    <?= $this->load_preview($img_desktop) ?>
                </div>
                <style>
                    #preview-desktop img {
                        max-width: 600px;
                    }
                </style>
            </td>
        </tr>

        <tr>
            <th scope='row'>
                모바일 화면용
                <input type="hidden"
                       name="banner-meta-img-mobile"
                       class='js-img-mobile'
                       value="<?= $img_mobile ?>">
            </th>
            <td>
                <div id="preview-mobile">
                    <?= $this->load_preview($img_mobile) ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>
