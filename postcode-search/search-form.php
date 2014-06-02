<div id='<?= $opts['id'] ?>' class='<?= $opts['classes'] ?>'>
    <div>
        <input type='text'
               name='<?= $opts['head-name'] ?>'
               value='<?= $opts['head-value'] ?>'
               maxlength='3'
               size='3'
               class='js-head'> -
        <input type='text'
               name='<?= $opts['tail-name'] ?>'
               value='<?= $opts['tail-value'] ?>'
               maxlength='3'
               size='3'
               class='js-tail'>
        <button class='js-open' type='button'><?= $opts['search-text'] ?></button>
    </div>
    <div style='display:none' class='js-search'>
        <br>
        <input type='text' class='js-input'>
        <button type='button' class='js-submit'>검색</button>
        <button type='button' class='js-close'>닫기</button>
        <div class='js-spinner' style='display:none'>
            <img src='<?= $opts['spinner-img'] ?>'>
        </div>
        <ul class='js-list'><li>동/면/읍 이름으로 검색해주세요</li></ul>
        <div class='js-paging-controls'>
            <a href='#' class='js-prev'>&laquo; 이전</a>
            <a href='#' class='js-next'>다음 &raquo;</a>
        </div>
    </div>
    <div>
        <input type='text' class='js-addr' name='<?= $opts['addr-name'] ?>' value='<?= $opts['addr-value'] ?>' size='<?= $opts['addr-size'] ?>'>
    </div>
    <script>
        (function ($) {
            var postcode = window.postcode_search,
                $el = $('#<?= $opts["id"] ?>'),
                $open   = $el.find('.js-open'),
                $close  = $el.find('.js-close'),
                $search = $el.find('.js-search'),
                $head   = $el.find('.js-head'),
                $tail   = $el.find('.js-tail'),
                $addr   = $el.find('.js-addr');

            new postcode.View({
                    el: '#<?= $opts["id"] ?>',
                    collection: new postcode.List(),
                    model: new postcode.Paging({
                        on_select: function (item) {
                            $head.val(item.head);
                            $tail.val(item.tail);
                            $addr.val(item.addr);
                            $search.slideUp();
                        }
                    })
                });

            $open.click(function (e) {
                $search.slideDown();
                e.stopPropagation();
                e.preventDefault();
            });

            $close.click(function (e) {
                $search.slideUp();
                e.preventDefault();
                e.stopPropagation();
            });

        })(jQuery);
    </script>
</div>