// admin/js/admin-toggles.js
jQuery(document).ready(function ($) {
  // Tab switching
  $(".settings-tabs a").on("click", function (e) {
    e.preventDefault();
    var tabId = $(this).attr("href").substring(1);
    $(".settings-tabs a").removeClass("active");
    $(this).addClass("active");
    $(".tab-pane").hide();
    $("#" + tabId).show();
  });
  $(".tab-pane").hide();
  $("#general").show();

  // Toggle admin CSS form visibility
  var toggleAdminCss = $("#wt-admin-css-toggle");
  var adminCssContainer = $("#wt-admin-css-form");
  toggleAdminCss.on("change", function () {
    adminCssContainer.toggle(this.checked);
  });

  // AJAX handlers for toggles
  function updateToggleStatus(toggleId, optionName) {
    $(toggleId).on("change", function () {
      var status = this.checked ? "on" : "off";
      $.ajax({
        url: wtToggleParams.ajaxurl,
        type: "POST",
        data: {
          action: "wt_" + optionName + "_action",
          status: status,
        },
        success: function (response) {
          console.log(optionName + " updated to " + status);
        },
      });
    });
  }
  updateToggleStatus("#wt-toggle-style", "toggle_style");
  updateToggleStatus("#wt-middle-menu-toggle", "toggle_middle_menu");
  updateToggleStatus("#wt-admin-css-toggle", "toggle_admin_css");

  // Initialize CodeMirror for CSS editors
  $(".css-editor").each(function () {
    var $editor = $(this);
    var editor = CodeMirror($editor[0], {
      value: $editor.data("content") || "",
      mode: "css",
      theme: "monokai", // Or 'default' if no theme enqueued
      lineNumbers: true,
      tabSize: 4,
      indentWithTabs: true,
      showHint: true,
      extraKeys: { "Ctrl-Space": "autocomplete" }, // Optional: Autocomplete
    });

    // Sync CodeMirror value with hidden input for form submission
    var $hiddenInput = $editor.next('input[type="hidden"]');
    editor.on("change", function () {
      $hiddenInput.val(editor.getValue());
    });
  });
});
