// admin/js/custom-variations.js
jQuery(document).ready(function ($) {
  $(".variation-option").on("click", function () {
    var $button = $(this);
    var attributeName = $button.data("attribute-name");
    var value = $button.data("value");

    // Update the hidden select field
    var $select = $('select[name="' + attributeName + '"]');
    $select.val(value).trigger("change");

    // Highlight the selected button
    $button.siblings(".variation-option").removeClass("selected");
    $button.addClass("selected");
  });
});
