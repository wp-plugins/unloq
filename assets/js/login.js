/*
* Included when the site uses both UNLOQ and password login. This is used to perform the toggle.
* */
jQuery(function($) {
  var $btn = $("#btnInitUnloq"),
    $login = $("#login"),
    $form = $login.find("form").first();
  if($login.size() === 0 || $btn.size() === 0) {
    // something went wrong.
    console.error('UNLOQ Failed to initialize, the login form was no-where to be found.');
    return;
  }
  var PLUGIN_URL = $btn.attr("data-script"),
    PLUGIN_THEME = $btn.attr("data-theme"),
    PLUGIN_KEY = $btn.attr("data-key");
  $btn.remove();
  $form.wrap("<div class='tabs unloq-active'></div>");
  var $tabs = $form.parent();
  $tabs.prepend('<div class="unloq-login-box"></div>');
  $tabs.prepend("<div class='tab tab-unloq'><span>UNLOQ</span></div>");
  $tabs.prepend("<div class='tab tab-login'><span>Password login</span></div>");
  $tabs.prepend("<div class='tab-line'></div>");

  var $unloqBox = $tabs.children(".unloq-login-box"),
    isInitialized = false;

  /* initializez the unloq plugin. */
  function initialize() {
    $unloqBox.html("<script type='text/javascript' src='"+PLUGIN_URL+"' data-unloq-key='"+PLUGIN_KEY+"' data-unloq-theme='"+PLUGIN_THEME+"'></script>");
    isInitialized = true;
  }

  function onChange() {
    var which = ($(this).hasClass('tab-unloq') ? 'unloq' : 'password'),
      $parent = $(this).parent();
    if(which == 'unloq') {
      if($parent.hasClass('password-active')) {
        $parent.removeClass('password-active');
      }
      if($parent.hasClass('unloq-active')) return;
      $parent.addClass('unloq-active');
      if(isInitialized) return;
      initialize();
    } else {
      if($parent.hasClass('unloq-active')) {
        $parent.removeClass('unloq-active');
      }
      if($parent.hasClass('password-active')) return;
      $parent.addClass('password-active');
    }
  }
  $tabs.on('click touchstart', '> .tab', onChange);
  if($tabs.hasClass('unloq-active')) {
    initialize();
  }
});
