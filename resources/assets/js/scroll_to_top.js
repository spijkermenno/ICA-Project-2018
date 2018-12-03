$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {
        $('#return-to-top').removeClass('hidden');
    } else {
        $('#return-to-top').addClass('hidden');
    }
});
$('#return-to-top').click(function() {
    $('body,html').animate({
        scrollTop : 0
    }, 500);
});
