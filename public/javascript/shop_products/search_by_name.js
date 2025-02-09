var route = $(".products").attr("data-route");

$(".products").select2({
    theme: "classic",
    //theme: "flat",
    allowClear: true,
    width: "resolve",
    minimumInputLength: 2,
    ajax: {
        url: route,
        dataType: "json",
        data: function (params) {
            // route
            return {
                part_of_name: $.trim(params.term),
            };
        },
        processResults: function (data) {
            return {
                results: data,
            };
        },
        cache: true,
    },
});

$(".js-programmatic-enable").on("click", function () {
    $(".js-example-disabled").prop("disabled", false);
    $(".js-example-disabled-multi").prop("disabled", false);
});
