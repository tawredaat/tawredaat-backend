// console.log('hi');
$(document).ready(function () {
    getAddresses();
});

$("#users").change(function () {
    getAddresses();
}); //end of change event

function getAddresses() {
    var route = $("#addresses").attr("data-route");

    var userId = $("#users").find(":selected").val();

    // empty the addresses dropdownlist
    $("#addresses").empty();
    $("#addresses").val(" ");

    //  console.log("userId=" + userId);

    $.ajax({
        url: route,
        method: "get",
        data: {
            user_id: userId,
            // _token: _token,
        },
        success: function (data) {
            // console.log(data);

            if (data.length != 0) {
                $.each(data, function (index, el) {
                    // index is your 0-based array index
                    // el is your value
                    var name =
                        el.street + " " + el.area + " " + el.landmark + " ";

                    $("#addresses").append(
                        "<option value='" + el.id + "'>" + name + "</option>"
                    );
                });
            }
        },
    });
}
