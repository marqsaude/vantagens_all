function validaSimulacao(obj){
    var array  = {"st_cadastrou":obj.st_cadastrou.value, "tx_sobre_simulacao":obj.tx_sobre_simulacao.value, "st_validado":1, "co_seq_simulacao":obj.co_seq_simulacao.value};
    ajaxPost(funcaoValidaSimulacao, array, "/simulacao/ajax-valid/", "/admin");
    return false;
}

var funcaoValidaSimulacao = function (json) {
    if(json!=null){
        alert("Validado com Sucesso!");
        window.location.href = getUrlController() + "/admin/simulacao/index";
    }
};

function goValidaSimulacao() {
    jQuery(function () {
        $("#validar").submit();
    });
}

function init() {

    jQuery(function () {

    });

}

init();