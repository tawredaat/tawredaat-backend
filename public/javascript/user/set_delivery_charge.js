// console.log('hi');
$(document).ready(function () {
    setDeliveryCharge();
});

$("#addresses").change(function () {
    setDeliveryCharge();
}); //end of change event

function setDeliveryCharge() {
    var route = $("#delivery-charge").attr("data-route");

    var address_id = $("#addresses").find(":selected").val();

    $("#delivery-charge").val();

    // console.log("address_id=" + address_id);

    if (address_id != "address") {
        $.ajax({
            url: route,
            method: "get",
            data: {
                address_id: address_id,
                // _token: _token,
            },
            success: function (data) {
                // console.log(data);

                if (data.length != 0) {
                    $("#delivery-charge").val(data);
                }
            },
        });
    }
}
