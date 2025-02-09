  $(function() {
    // Start load partials
    $(".home-slider").slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      cssEase: "ease",
      dots: true,
      autoplay: true,
      autoplaySpeed: 4000,
    });
    $(".products-slider").slick({
      infinite: true,
      slidesToShow: 6,
      slidesToScroll: 2,
      dots: true,
      autoplay: true,
      autoplaySpeed: 2500,
      arrows: true,
      touchMove: true,
      pauseOnHover: false,
      cssEase: "ease",
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 2
        }
      }
                   , {
                     breakpoint: 768,
                     settings: {
                       slidesToShow: 3,
                       slidesToScroll: 1
                     }
                   }
                   , {
                     breakpoint: 576,
                     settings: {
                       slidesToShow: 2,
                       slidesToScroll: 1
                     }
                   }
                  //  , {
                  //    breakpoint: 480,
                  //    settings: {
                  //      slidesToShow: 1,
                  //      slidesToScroll: 1
                  //    }
                  //  }
                  ]
    });
    $(".companies-slider").slick({
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
      responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }
                   , {
                     breakpoint: 768,
                     settings: {
                       slidesToShow: 2,
                       slidesToScroll: 1
                     }
                   }
                  //  , {
                  //    breakpoint: 480,
                  //    settings: {
                  //      slidesToShow: 1,
                  //      slidesToScroll: 1
                  //    }
                  //  }
                  ]
    });
    $(".brands-slider").slick({
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
      responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      }
                   , {
                     breakpoint: 768,
                     settings: {
                       slidesToShow: 2,
                       slidesToScroll: 1
                     }
                   }
                  //  , {
                  //    breakpoint: 480,
                  //    settings: {
                  //      slidesToShow: 1,
                  //      slidesToScroll: 1
                  //    }
                  //  }
                  ]
    });
    // End load partials
  });
