$(document).ready(function () {
    discountChange();

    $("#discount_type").on("change", function () {
        discountChange(this);
    });

    //
    $("#promo-code-form").on("submit", function () {
        $("#discount").prop("disabled", false);
    });
});

function discountChange(discount_type) {
    var discount_type = $(discount_type).find(":selected").val();
    if (discount_type == "remove shipping fees") {
        $("#discount").val(0);
        $("#discount").prop("disabled", true);
    } else {
        $("#discount").prop("disabled", false);
    }
}
