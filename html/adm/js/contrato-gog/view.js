/**
 * Created by tony on 10/11/17.
 */

function clickSobre(obj){
    $(function() {
        $("#pdf-contrato-gog").hide();
        $("#sobre-contrato-gog").show();
    });
}

function clickPDF(obj){
    $(function() {
        $("#sobre-contrato-gog").hide();
        $("#pdf-contrato-gog").show();
    });
}

function init(){
    $(function(){
        $("#pdf-contrato-gog").hide();
    });
}

init();