/**
 * Created by tony on 03/08/17.
 */

function init(run){
    $(function(){
        insertMask();
        if(run=="cliente") {
            verifyVantagens();
        }
        if(run=="tipo_vantagem") {
            $("#voltar-cliente-tipo-vantagem").click(function () {
                mountHtmlCliente();
                for(var i=0; i<9; i++) {
                    $(".fa-circle:last").addClass("fa-circle-o");
                    $(".fa-circle:last").removeClass("fa-circle");
                }
            });
        }
        if(run=="dependentes") {
            $("#enviar-dependentes").click(function () {
                $("#dependencias-form").submit();
            });
            $("#voltar-cliente").click(function () {

            });
            $("#mais-dependentes").click(function () {
                insertDependente(0);
            });
            $("#menos-dependentes").click(function () {
                removeDependencia();
            });
            $(".tipo_dependente").change(function(){
                if($(this).find("option:selected").attr("value")==0){
                    $(this).parent().find(".st_agregado").html("");
                }else {
                    if ($(this).find("option:selected").attr("for") == 1) {
                        $(this).parent().find(".st_agregado").html("&nbsp;&nbsp; Agregado");
                    } else {
                        $(this).parent().find(".st_agregado").html("&nbsp;&nbsp; Dependente");
                    }
                }
            });
        }
        if(run=="forma_pagamento") {
        }
    });
}

function remove(str, sub) {
    i = str.indexOf(sub);
    r = "";
    if (i == -1) return str;
    r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
    return r;
}

function comeBack(){
    back = true;
}

function comeBackFormaPagamento(){
    back = true;
    if(dataContratoGog==12){
        for(var i=0; i<27; i++) {
            $(".fa-circle:last").addClass("fa-circle-o");
            $(".fa-circle:last").removeClass("fa-circle");
        }
        mountHtmlTipoVantagem();
    }else{
        for(var i=0; i<18; i++) {
            $(".fa-circle:last").addClass("fa-circle-o");
            $(".fa-circle:last").removeClass("fa-circle");
        }
        mountHtmlDependentes();
    }
}

init("cliente");