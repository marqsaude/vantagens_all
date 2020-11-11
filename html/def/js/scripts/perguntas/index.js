$(function() {
    $(".features li").click(function () {
        $(this).children("p").slideToggle( "slow", function() {});
        $(this).children(".seta-pergunta").rotate(-180, {
            duration: 677,
            easing: 'easeOutExpo',
            complete: function() {
                console.debug($(this));
            }
        });
    });
});