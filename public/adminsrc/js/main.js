(function ($) {
    $('.toggle_menu_bar').click(function(e){
        e.preventDefault();
        var menu_w = 230;
        var clw = 45;
        var elcontent = $('.content_col');
        var elcol = $('.menu_col');
        
        if(elcol.hasClass('mn_toggle')){
            elcol.removeClass('mn_toggle');
            elcontent.removeClass('mn_toggle');
        }else{
            elcol.addClass('mn_toggle');
            elcontent.addClass('mn_toggle');
        }
    });
    
    $('.remove-btn').click(function (e) {
        var conf = confirm($(this).attr('title') + '?');
        if (!conf) {
            return false;
        }
    });

    $('.action-form').submit(function () {
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
                success: function (data) {
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

    $('.new_tags').select2({
        tags: true
    });
    $('.av_tags').select2();
    
    $('.lang-tabs li a').click(function(e){
        var mce_iframe = $('.mce-edit-area iframe');
        var height = mce_iframe.height();
        mce_iframe.css('height', height);
    });

})(jQuery);



