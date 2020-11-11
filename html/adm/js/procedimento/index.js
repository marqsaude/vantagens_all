/**
 * Created by tony on 13/11/17.
 */

function clickExame(obj){
    $(function() {
        $("#consulta-procedimento").hide();
        $("#laboratorio-procedimento").hide();
        $("#exame-procedimento").show();
        onAllBtn();
        $(".btn-exame").addClass("btn-desativo");
    });
}

function clickConsulta(obj){
    $(function() {
        $("#laboratorio-procedimento").hide();
        $("#exame-procedimento").hide();
        $("#consulta-procedimento").show();
        onAllBtn();
        $(".btn-consulta").addClass("btn-desativo");
    });
}

function clickLaboratorio(obj){
    $(function() {
        $("#consulta-procedimento").hide();
        $("#exame-procedimento").hide();
        $("#laboratorio-procedimento").show();
        onAllBtn();
        $(".btn-laboratorio").addClass("btn-desativo");
    });
}

function init(){
    $(function(){
        $("#consulta-procedimento").hide();
        $("#laboratorio-procedimento").hide();
    });
}

init();

function onAllBtn(){
    $(".btn-exame").removeClass("btn-desativo");
    $(".btn-consulta").removeClass("btn-desativo");
    $(".btn-laboratorio").removeClass("btn-desativo");
}