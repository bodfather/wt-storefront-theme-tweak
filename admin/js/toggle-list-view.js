jQuery(document).ready(function($) {
    // Check initial state of the checkbox and set the class accordingly
    if ($('#bpp_list_style_toggle_stylesheet').prop('checked')) {
        $('.products').addClass('list-view');
    } else {
        $('.products').removeClass('list-view');
    }

    // Listen for changes to the checkbox
    $('#bpp_list_style_toggle_stylesheet').change(function() {
        if ($(this).prop('checked')) {
            $('.products').addClass('list-view');
        } else {
            $('.products').removeClass('list-view');
        }
    });
});
