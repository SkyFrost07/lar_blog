(function($){

    $('.sortable_menu.dd').nestable();
    $('.order-form').submit(function(){
       var data = $('.sortable_menu.dd').nestable('serialize'); 
       $.post($(this).attr('action'), {orders: data, _token: $(this).find('input[name="_token"]').val()}, function(data){
           $('.alert').removeClass('hidden').fadeIn(100).html(data);
            setTimeout(function(){
                
            }, 500);
       });
       return false;
    });

})(jQuery);


