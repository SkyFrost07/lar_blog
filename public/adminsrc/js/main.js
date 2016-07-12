(function ($) {
    $('.remove-btn').click(function (e) {
        var conf = confirm($(this).attr('title') + '?');
        if (!conf) {
            return false;
        }
    });

    $('.remove-form').submit(function () {
        var conf = confirm($(this).attr('title') + '?');
        if (conf) {
            var ids = [];
            $('.checkitem').each(function () {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            var action = $(this).find('input[name="action"]').val();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: {
                    action: action,
                    _token: _token,
                    item_ids: ids
                },
                success: function () {
                    window.location.reload();
                },
                error: function () {
                    window.location.reload();
                }
            });
        }
        return false;
    });

    $('.checkall').click(function () {
        if ($(this).is(':checked')) {
            $('.checkitem').prop('checked', true);
        } else {
            $('.checkitem').prop('checked', false);
        }
    });

    $('.checkitem').change(function () {
        if ($('.checkitem:checked').size() === $('.checkitem').size()) {
            $('.checkall').prop('checked', true);
        } else {
            $('.checkall').prop('checked', false);
        }
    });

})(jQuery);

