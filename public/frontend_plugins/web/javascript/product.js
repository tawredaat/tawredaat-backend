 $(function() {
    // start code for product counter

    $(".add-cart-btn").click( function(){
      var proudectCount = $(this).parent().siblings('.quantity-holder').find('.count'),
          proudectCountInStock = $(this).parent().siblings('.stock-holder').find('.stock-num'),
          proudectName = $(this).parent().siblings('.seller-name').find('.name').text(),
          cartProductsNum = +$('.cart-products-num').text(),
          restInStock;
      restInStock = +proudectCountInStock.text() - +proudectCount.attr('value');
      proudectCount.attr('max', restInStock)
      proudectCountInStock.text(restInStock);
      $('.cart-products-num').text(cartProductsNum + +proudectCount.attr('value'));
      $(".cart-detailes").addClass("cart-has-data");
      $(".qty .count").val(1);
      $(".alert").addClass("show");
      setTimeout(() => {
        $(".alert").removeClass("show");
      }, 2000);
    });
    $(".slider-multi-img").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: ".slider-single-img",
      arrows: false,
      dots: false,
      rtl: $(this).data('rtl'),
      // vertical: true,
      verticalSwiping: true,
      focusOnSelect: true,
      autoplay: true,
      autoplaySpeed: 2500,
      touchMove: true,
      pauseOnHover: false,
      cssEase: "ease",
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        }
      ]
    });
    $(".slider-single-img").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      rtl: $(this).data('rtl'),
      arrows: false,
      fade: true,
      asNavFor: ".slider-multi-img"
    });
    $(".related-product").load(
      "./partials/sliders/products-slider.html",
      () => {
        $(".products-slider").slick({
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 1,
          dots: true,
          autoplay: true,
          autoplaySpeed: 2500,
          arrows: true,
          touchMove: true,
          pauseOnHover: false,
          cssEase: "ease",
          responsive: [
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            }
            ,
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
            ,
            // {
            //   breakpoint: 480,
            //   settings: {
            //     slidesToShow: 1,
            //     slidesToScroll: 1
            //   }
            // }
          ]
        });
      });
    let pageUrl = window.location.href;
    var facebookShare = document.querySelector(
      '[data-js="facebook-share"]'
    );
    facebookShare.onclick = function(e) {
      e.preventDefault();
      var facebookWindow = window.open(
        `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`,
        "facebook-popup",
        "height=350,width=600"
      );
      if (facebookWindow.focus) {
        facebookWindow.focus();
      }
      return false;
    };

    document
    .querySelector(".count")
    .addEventListener("keypress", function(evt) {
    if (
      (evt.which != 8 && evt.which != 0 && evt.which < 48) ||
      evt.which > 57
    ) {
      evt.preventDefault();
    }
  });
  });
