// admin/js/admin-toggles.js
jQuery(document).ready(function ($) {
  // Validate localization objects
  if (typeof wtToggleParams === "undefined") {
    console.error("wtToggleParams not defined - some AJAX will fail");
    return;
  }
  if (typeof wtSfttAjax === "undefined") {
    console.error("wtSfttAjax not defined - Middle Menu toggle will fail");
    return;
  }

  // Generic toggle update function
  function updateToggle(toggleId, action, ajaxObj) {
    $(toggleId).on("change", function () {
      const status = this.checked ? "on" : "off";
      console.log(`${toggleId} toggled to ${status}`);
      $.ajax({
        url: ajaxObj.ajaxurl || ajaxObj.ajaxUrl,
        type: "POST",
        data: {
          action: action,
          status: status,
          ...(ajaxObj.nonce ? { nonce: ajaxObj.nonce } : {}), // Add nonce if present
        },
        success: function (response) {
          if (response.success) {
            console.log(
              `${action} updated to ${status}`,
              response.data?.status || ""
            );
          } else {
            console.log(`${action} updated to ${status} (no success flag)`);
          }
        },
        error: function (xhr, status, error) {
          console.error(`AJAX error for ${action}: ${error}`, xhr.responseText);
        },
      });
    });
  }

  // Configure toggles
  updateToggle("#wt-toggle-style", "wt_toggle_style_action", wtToggleParams);
  updateToggle("#wt-middle-menu-toggle", "toggle_middle_menu", wtSfttAjax); // Uses main plugin's handler
  updateToggle(
    "#wt-admin-css-toggle",
    "wt_toggle_admin_css_action",
    wtToggleParams
  );

  // Admin CSS form visibility toggle
  $("#wt-admin-css-toggle").on("change", function () {
    $("#wt-admin-css-form").toggle(this.checked);
  });

  // Initialize CodeMirror for CSS editors
  $(".css-editor").each(function () {
    const $editor = $(this);
    const $hiddenInput = $editor.next('input[type="hidden"]');
    const editor = CodeMirror($editor[0], {
      value: $editor.data("content") || "",
      mode: "css",
      theme: "monokai",
      lineNumbers: true,
      tabSize: 4,
      indentWithTabs: true,
      showHint: true,
      extraKeys: { "Ctrl-Space": "autocomplete" },
    });
    editor.on("change", () => $hiddenInput.val(editor.getValue()));
  });
});
