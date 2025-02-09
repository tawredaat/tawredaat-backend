$(function() {
    $(document).on('click', '.shop-category--list .shop-categoryies-l1', function(e) {
        e.preventDefault();
        var url = $(this).data('route');
        var category = $(this).data('category');
        var selected = $(this);
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,category:category},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        $('.category-card-holder').removeClass('active');
                        selected.addClass('active');
                        window.history.pushState('page2', 'Title', data['actual_link']);
                        $('#shop-category-content').html(data['result']).hide().fadeIn('slow');
                    }
                }
                ,error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });
    $(document).on('click', '.shop-category--list .shop-categoryies-l1-products', function(e) {
        e.preventDefault();
        var url = $(this).data('route');
        var selected = $(this);
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        $('.category-card-holder').removeClass('active');
                        selected.addClass('active');
                        window.history.pushState('page2', 'Title', data['actual_link']);
                        $('#shop-products-content-box').html(data['result']).hide().fadeIn('slow');
                    }
                }
                ,error: function () {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });
    //*********************Cart Scripts**********************************************************
    $(".count").keyup(function() {
        var count = $(this);
        var countVal = parseInt($(this).val());
        var minus = $(this).siblings(".minus");
        var plus = $(this).siblings(".plus");
        var warningMsg = $(this).siblings(".warning-max-msg");
        var maxCounter = parseInt(count.attr("max"));
        if (countVal >= maxCounter) {
          count.val(parseInt(count.attr("max")));
          minus.attr("disabled", false);
          plus.attr("disabled", true);
          warningMsg.toggleClass("d-none");
        }
        else if (parseInt($(".count").val()) == 1) {
          minus.attr("disabled", true);
          plus.attr("disabled", false);
        }
        else {
          minus.attr("disabled", false);
          plus.attr("disabled", false);
          warningMsg.addClass("d-none");
        }
      });
      $(document).on("click", ".plus", function() {
        var count = $(this).siblings(".count");
        var countVal = parseInt(
          $(this)
          .siblings(".count")
          .val()
        );
        var incValue = countVal + 1;
        var warningMsg = $(this).siblings(".warning-max-msg");
        var minus = $(this).siblings(".minus");
        var maxCount = count.attr("max");
        count.val(incValue);
        count.attr("value", incValue);
        if (incValue == +maxCount) {
          $(this).attr("disabled", true);
          warningMsg.toggleClass("d-none");
        }
        if (countVal > 1) {
          minus.attr("disabled", false);
        }
      });
      $(document).on("click", ".minus", function() {
        var count = $(this).siblings(".count");
        var countVal = parseInt($(this).siblings(".count").val());
        var decValue = countVal - 1;
        var warningMsg = $(this).siblings(".warning-max-msg");
        var plus = $(this).siblings(".plus");
        var maxCounter = parseInt(count.attr("max"));
        count.val(decValue);
        if (countVal == 1) {
          count.val(1);
          $(this).attr("disabled", true);
        }
        if (countVal <= parseInt(maxCounter)) {
          plus.attr("disabled", false);
          warningMsg.addClass("d-none");
        }
      });
    //add products to cart
    $(document).on('click', '.product-card .add-to-cart-btn', function(e) {
        e.preventDefault();
        var url = $(this).data('route');
        var shopProductId = $(this).data('shopproductid');
        // var companyId = $(this).data('companyid');
        var quantity = $(this).closest('.product-action-btn').find('.quantity-holder .qty .product-qty-'+shopProductId).val();
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,shopProductId:shopProductId,quantity:quantity},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        toastr.success(data['message']);
                        $('.shop-product-content-'+shopProductId).html(data['action']).hide().fadeIn('slow');
                        $('.single-shop-product-page').html(data['shop_product_single_page']).hide().fadeIn('slow');
                        $('.cart-num-holder').html(data['cartCount']).hide().fadeIn('slow');
                    }
                    else if(data['code']=='101'){
                        toastr.error(data['message']);
                    }
                }
                ,error: function () {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });
    //update qty items in cart
    $(document).on('click', '.product-card .update-cart-item', function(e) {
        e.preventDefault();
        var url = $(this).data('route');
        var shopProductId = $(this).data('shopproductid');
        var cartItemId = $(this).data('cartitemid');
        // var companyId = $(this).data('companyid');
        var increment= $(this).data('action');
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,shopProductId:shopProductId,cartItemId:cartItemId,increment:increment},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        toastr.success(data['message']);
                        $('#item-amount-'+data['item']).html(data['amount']).hide().fadeIn('slow');
                        $('.shop-product-content-'+shopProductId).html(data['action']).hide().fadeIn('slow');
                        $('#cart-total-holder').html(data['cartTotal']).hide().fadeIn('slow');
                    }
                    else if(data['code']=='101'){
                        toastr.error(data['message']);
                    }
                }
                ,error: function (data) {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });
    //remove from cart
    $(document).on('click', '.product-card .delete-from-cart-btn', function(e) {
        e.preventDefault();
        var url = $(this).data('route');
        var shopProductId = $(this).data('shopproductid');
        var cartItemId = $(this).data('cartitemid');
        // var companyId = $(this).data('companyid');
        var token = $('meta[name="csrf-token"]').attr('content');
        if (url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {_token:token,shopProductId:shopProductId,cartItemId:cartItemId},
                beforeSend:function(){
                    // $('#search-grid-content').slideDown("slow");
                },
                success: function (data) {
                    if(data['code']=='200'){
                        toastr.success(data['message']);
                        $('.shop-product-content-'+shopProductId).html(data['action']).hide().fadeIn('slow');
                        $('.single-shop-product-page').html(data['shop_product_single_page']).hide().fadeIn('slow');
                        $('#shop-cart-product-holder-'+shopProductId).remove().hide().fadeIn('slow');
                        $('#cart-total-holder').html(data['cartTotal']).hide().fadeIn('slow');
                        $('.cart-num-holder').html(data['cartCount']).hide().fadeIn('slow');
                        $('.cart-num-count').html(data['cartCount']).hide().fadeIn('slow');
                        if(data['cartCount']==0)
                            $('.total-card-wrapper .primary-dark-fill').remove().fadeOut('slow');
                    }
                    else if(data['code']=='101'){
                        toastr.error(data['message']);
                    }
                }
                ,error: function () {
                    toastr.error('somthing went wrong, Try again.');
                }
            });
        }
        else
            toastr.error('somthing went wrong, Try again.');
    });

});
