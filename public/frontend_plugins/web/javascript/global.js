$(function() {
  console.log("document is ready");
  // fadout loading icon
  setTimeout(() => {
    $(".loading").fadeOut("slow");
  }, 2000)


  $('.swap-screen-login').click(function (e) {
    e.preventDefault();
    $(".login-trans-holder").addClass("trans-hide").removeClass("trans-active");
    $(".signup-trans-holder").addClass("trans-active").removeClass("trans-hide");
    $(".modal-dialog .modal-title").text($(".signup-trans-holder h1").text());
});
$('.swap-screen-signup').click(function (e) {
    e.preventDefault();
    $(".signup-trans-holder").addClass("trans-hide").removeClass("trans-active");
    $(".login-trans-holder").addClass("trans-active").removeClass("trans-hide");
    $(".modal-dialog .modal-title").text($(".login-trans-holder .primary-fill.submit-btn").text());
});

  // trigger close open menu
  $(document).on("click", function(e) {
    if (
      !$(e.target)
        .parents()
        .hasClass("user-menu")
    ) {
      $(".user-menu .content").removeClass("active");
    }
    if (!$(e.target).parents().hasClass("cart")) {
      $(".cart-detailes").removeClass("cart-detailes-active");
    }
    if (
      !$(e.target)
        .parents()
        .hasClass("categories-btn") &&
      isCategoryOpen
    ) {
      $(".categories-menu-wrapper").slideUp(500);
    }
  });

  let isCategoryOpen = false;
  $(".categories-btn").click(function(e) {
    if (!isCategoryOpen) {
      $(".categories-menu-wrapper").slideDown(500);
    } else {
      $(".categories-menu-wrapper").slideUp(500);
    }
    isCategoryOpen = !isCategoryOpen;
  });

  $(".megamenu li, .cart-detailes").click(function(e) {
    e.stopPropagation();
  });
  $(".res-menu button").click(function(e) {
    $(".res-menu").toggleClass("menu-opened");
  });
  $(".res-menu .close-menu-btn, .res-menu .overlay").click(function() {
    $(".res-menu").removeClass("menu-opened");
  });
  $(".user-menu .user-drop-holder").click(function(e) {
    $(".user-menu .content").toggleClass("active");
  });
  $('.main-header .cart').click( () => {
    $('.cart-detailes').toggleClass('cart-detailes-active');
  });


});
$(function() {

      $(".call-company-login").click(function() {
        $('#c_i_d').val($(this).data('company'));
        $('#c_n_m').val($(this).data('company-name').replace(" ", "-"));
    });
    $(".res-filter-icon").click(function() {
      $(".filter-wrapper").toggleClass("active");
    });
    $(".filter-wrapper + .overlay button, .filter-wrapper + .overlay").click(function() {
      $(".filter-wrapper").removeClass("active");
    });
    // $(".filter-wrapper").offset().top;
    // console.log($(".filter-wrapper").offset().top - $(window).scrollTop());
    var priceRangeSlider = $(".price-range").slider({
        min: 0,
        max: 1000,
        value: [0, 5000]
    });
    $(".price-range").on("slide", function (slideEvt) {
        $('#priceFrom').val(slideEvt.value[0]);
        $('#priceTo').val(slideEvt.value[1]);
    });
});

$(document).on('click', '.call-company', function(event) {
  $(this).closest(".call-tel-style").addClass("active")
      if ($(window).width() > 768) {// stop the default event
        event.preventDefault();
        console.log('call-company')
        return false;
      }else{

      var $a = $(this);
      var companyID = $(this).data("company");
      var route = $(this).data("route");
      var token = $('meta[name="csrf-token"]').attr('content');
      var from = new FormData();
      from.append('_token', token);
      from.append('companyID', companyID);
      $.ajax({
          url: route,
          method: "POST",
          data: from,
          contentType: false,
          cache: false,
          processData: false,
          dataType: "json",
          success: function(data) {
              if (data['success']) {
                toastr.success(data['success']);
                window.location.assign($a.data('telephone'));
                $(this).closest(".call-tel-style").addClass("active")
              }else if(data['error']){
                 toastr.error(data['error']);
              }
          },
          error: function(data) {
              toastr.error('error occured,please try again !');
          }
      });

      }
});




$(document).on('click', '.bet-best-price-product', function(event) {
    var $a = $(this);
    $('#bestpriceModal #best-price-product-name').html($(this).data("product"));
    $('#bestpriceModal #best-price-product-brand').html($(this).data("brand"));
     $('#bestpriceModal #best-price-product-sku').html($(this).data("sku"));
    $("#bestpriceModal #best-price-product-image").attr("src",$(this).data("image"));
    $('#bestpriceModal #best-price-product-form').attr('action', $(this).data("route"));
  });

  $(document).on('submit', '#bestpriceModal #best-price-product-form', function(event) {
    route = $(this).attr('action');
    event.preventDefault()
    $.ajax({
        url: route,
        method: "POST",
        data: new FormData(this),
        contentType: false,
        // cache: false,
        processData: false,
        dataType: "json",
        // async: false,
        beforeSend:function(){
        },
        success: function(data) {
            if(data['success']){
                $('#bestpriceModal').modal('hide');
                $('#productBestSellignSent').modal('show');
            }else if(data['validator'])
                toastr.error(data['validator']);
        },
        error: function() {
            toastr.error('error occured, please try again later!');
        }
    });
});
