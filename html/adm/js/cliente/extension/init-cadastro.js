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

function voltarVendedorCliente(){
    mountHtmlVendedor();
    //Remove Caminho
    for(var i=0; i<7; i++) {
        $(".icon-circle:last").addClass("icon-circle-blank");
        $(".icon-circle:last").removeClass("icon-circle");
    }
}

function voltarClienteCliente(){
    mountHtmlCliente();
    //Remove Caminho
    for(var i=0; i<7; i++) {
        $(".icon-circle:last").addClass("icon-circle-blank");
        $(".icon-circle:last").removeClass("icon-circle");
    }
}

function voltarVantagemCliente(){
    if (countVantagem > 1) {
        mountHtmlTipoVantagem();
    }else{
        if(countVantagem == 0){
            alert("Não existe contrato!");
        }else {
            mountHtmlUmTipoVantagem();
        }
    }
    //Remove Caminho
    for(var i=0; i<7; i++) {
        $(".icon-circle:last").addClass("icon-circle-blank");
        $(".icon-circle:last").removeClass("icon-circle");
    }
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

init("cliente");