jQuery(document).ready(function ($) {
    var $el = $('#post_attachment'), 
        $row_container = $el.find('.js-rows');
        row_template   = $el.find('.js-row-template').html();

    var add_row = $.fn.append.bind($row_container, row_template);

    var on_change = function (e) {
        var $row = $(this).parent();

        if (this.value === "") {
            $row.remove();
        } else {
            $row.find('a').show();
            add_row();
        }
        init();

        e.stopPropagation();
        e.preventDefault();
    };

    var init = function () {
        if (!$row_container.children(':not(.js-old)').length) add_row();
    };

    $el.closest('form').attr('enctype', 'multipart/form-data');
    $row_container.on('change', 'input', on_change);
    $row_container.on('click', '.js-cancel', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).siblings('input').val('').trigger('change');
    });

    init();
});