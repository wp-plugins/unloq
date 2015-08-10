jQuery(function($) {
  var $select = $("#unloqTheme"),
    $status = $("#unloqStatus");

  function themePreview() {
    var theme = $select.val();
    $(".unloq-card").find(".login-theme").each(function() {
      if ($(this).hasClass("login-" + theme)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }
  $select.on('change', themePreview);
  themePreview();
});