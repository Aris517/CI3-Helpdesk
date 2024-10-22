$(document).ready(function() {
    $('.filter').click(function() {
        var filterValue = $(this).attr('data');

        $('.filter').removeClass('active');
        $(this).addClass('active');

        if (filterValue == 'all') {
            $('.item').show();
        } else {
            $('.item').hide();
            $('#' + filterValue).show();
        }
    });
});
