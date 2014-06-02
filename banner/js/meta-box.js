jQuery(document).ready(function ($) {

    var day_names = ['일', '월', '화', '수', '목', '금', '토'],
        mon_names = ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        datepicker_opts = {
            dateFormat:      'yymmdd',
            constrainInput:  true,
            dayNames:        day_names,
            dayNamesShort:   day_names,
            dayNamesMin:     day_names,
            monthNames:      mon_names,
            monthNamesShort: mon_names,
            monthNamesMin:   mon_names,
            showMonthAfterYear: true,
            yearSuffix: "년" 
        },

        load_preview = function (id) {
            $.get(ajaxurl, {
                id: id,
                action: 'banner_meta_box::load_preview'
            }, $.fn.html.bind(this));
        },

        on_select = function ($input, callback) {
            var id = this.state().get('selection').first().id
            $input.val(id);
            callback(id);
        },

        on_open = function ($input) {
            var selection = this.state().get('selection'),
                id        = $input.val(),
                attach    = wp.media.attachment(id);
            attach.fetch();
            selection.add(attach ? [attach] : []);
        },

        setup_img_selector = function ($input, $preview) {
            var media_lib = wp.media({ title: '이미지 선택', 
                                               library: {type: 'image'}});

            $('<a>', { 'class': 'button',
                       'href' : '#',
                       'text' : '이미지 선택' })
                .on('click', media_lib.open.bind(media_lib))
                .insertAfter($input);

            media_lib.on('open',   on_open.bind(media_lib, $input));
            media_lib.on('select',
                         on_select.bind(media_lib,
                                        $input,
                                        load_preview.bind($preview)));
        }

        $el = $('#banner_meta_box');

    $el.find('.js-datepicker').datepicker(datepicker_opts);

    setup_img_selector($el.find('.js-img-desktop'), $el.find('#preview-desktop'));
    setup_img_selector($el.find('.js-img-mobile'),  $el.find('#preview-mobile'));

});
