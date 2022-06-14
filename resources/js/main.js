(function ($) {
    "use-strict"

    jQuery(document).ready(function () {
        
        $(document).on('click', '.nav-bar', function() {
            $('.wrapper').toggleClass('no-sidebar');
            $('.header-logo').toggleClass('no-header-logo');
        });
    });



}(jQuery));