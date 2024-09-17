$(function () {
  //Button controls
  $(document).on("click", ".btn-unlink", function () {
    $(".platform-text").html($(this).attr("name"));
    $(".platform").val($(this).attr("name"));
    $(".linked").val($(this).attr("id"));
  });

  $(function () {
    $("input[type=tel]").keyup(function () {
      this.value = this.value.replace(/[^0-9]/g, "").replace(/(\..*)\./g, "$1");
    });
  });
  //Button controls
});
