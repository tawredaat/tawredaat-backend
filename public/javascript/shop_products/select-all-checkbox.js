$(".select-all").click(function () {
    $('input[type="checkbox"][name="products[]"]')
        .not(this)
        .prop("checked", this.checked);
    $("#deleteCount").text($('input[name="products[]"]:checked').length);
});
