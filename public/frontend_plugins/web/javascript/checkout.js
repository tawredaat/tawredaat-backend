$(function() {
    $(document).on('click', '.shop-checkout-content .select-payment-type-radio', function(e) {
        var url = $(this).data('route');
        var payment_id = $(this).val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,payment_id:payment_id},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200')
                        toastr.success(data['message']);
                }
                ,error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });

});
$(function() {
    $(document).on('click', '.select-user-cart-address', function(e) {
        var url = $(this).data('route');
        var address_id = $(this).val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,address_id:address_id},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200')
                        toastr.success(data['message']);
                }
                ,error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });

});

