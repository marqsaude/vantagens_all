/**
 * Created by tony on 22/03/16.
 */
$("#ancora_quem_somos").click(function(){
    $('html, body').animate({
        scrollTop: $("#quem_somos").offset().top
    }, 700);
});

$("#ancora_especialidade").click(function(){
    $('html, body').animate({
        scrollTop: $("#especialidade").offset().top
    }, 700);
});