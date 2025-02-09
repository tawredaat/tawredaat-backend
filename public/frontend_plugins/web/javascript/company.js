  $(function() {
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

$(document).on('click', '.btn_click', function(event) {
    var companyID = $(this).data("company");
    var route = $(this).data("route");
    var click = $(this).data("click");
    var token = $('meta[name="csrf-token"]').attr('content');
    var from = new FormData();
    from.append('_token', token);
    from.append('companyID', companyID);
    from.append('click', click);
    $.ajax({
        url: route,
        method: "POST",
        data: from,
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function(data) {
            if(data['error']){
               toastr.error(data['error']);
            }
        },
        error: function(data) {
            toastr.error('error occured,please try again !');
        }
    });
});

$(document).on('submit', '#requestQuotationForm', function(event) {
    var token = $('meta[name="csrf-token"]').attr('content');
    var route = $(this).attr("action");
    event.preventDefault()
    var from = new FormData(this);
    from.append('_token', token);
    $.ajax({
        url: route,
        method: "POST",
        data: from,
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        // async: false,
        beforeSend:function(){
        },
        success: function(data) {
            if (data['success']) {
              toastr.success(data['success']);
            }else if(data['error']){
              toastr.error(data['error']);
            }
            $('#RequestQuotationModal').modal('hide');
             $("#msgQuotationBox").val("");
        },
        error: function(data) {
            toastr.error('error occuredd,please try again !');
        }
    });
});
