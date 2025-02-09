$(document).ready(function () {
    productChange();

    $("#products").on("change", function () {
        productChange();
    });

    $("#manual_product_name").on("input", function () {
        $("#products").prop("disabled", true);

        if ($("#manual_product_name").val() == "") {
            $("#products").prop("disabled", false);
        }
    });
});

function productChange() {
    var product_id = $("#products").find(":selected").val();

    //   console.log("product_id=" + product_id);

    if (product_id == "product_id") {
        $("#manual_product_name").prop("disabled", false);
        $("#price").prop("disabled", false);
    } else {
        $("#manual_product_name").prop("disabled", true);
        $("#manual_product_name").val();

        $("#price").prop("disabled", true);
        $("#price").val("");
    }
}
