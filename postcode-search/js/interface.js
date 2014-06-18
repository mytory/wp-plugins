jQuery(document).ready(function ($) {
    var postcode = window.postcode_search,
        $el = $('.js-postcode-search'),
        $open   = $el.find('.js-open'),
        $close  = $el.find('.js-close'),
        $search = $el.find('.js-search'),
        $head   = $el.find('.js-head'),
        $tail   = $el.find('.js-tail'),
        $addr   = $el.find('.js-addr');

    new postcode.View({
        el: '.js-postcode-search',
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

});