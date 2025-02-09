$(".select-all").click(function () {
    $('input[type="checkbox"][name="images[]"]')
        .not(this)
        .prop("checked", this.checked);
    $("#deleteCount").text($('input[name="images[]"]:checked').length);
});
