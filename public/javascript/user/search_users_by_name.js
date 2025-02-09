var route = $("#users").attr("data-route");

$("#users").select2({
    allowClear: true,
    width: "resolve",
    placeholder: "Choose users...",
    minimumInputLength: 2,
    ajax: {
        url: route,
        dataType: "json",
        data: function (params) {
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
