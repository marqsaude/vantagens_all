/**
 * Created by tony on 12/12/17.
 */

var hasModal = false;
var openCodigoPagSeguro = false;
var i = 0;
var objBoleto = null;
var pgBoletoAntigo = 1;

function openModal(obj){
    $(function(){
        var relConhece = $(obj).attr('rel');
        if(hasModal==false) {
            $("#" + relConhece).show();
            hasModal = true;
        }else{
            $("#" + relConhece).hide();
            hasModal = false;
        }
        i++;
    });
}

function clickImg(obj){
    var img = obj.src.replace("thumbnails/", "");
    $(function() {
        $("#myModal").css("display", "block");
        $("#img01").attr("src",img);
    });
}

function closeModal(){
    $('.modal-conheca-dinheiro').hide();
    $('.modal-conheca-pagseguro').hide();
    $('.modal-conheca').hide();
    $('.modal-add-ocorrencia').hide();
}

$(function() {
    $('#modal-conheca1').hover(function(){
        hasModal=true;
    }, function(){
        hasModal=false;
    });

    $("body").mouseup(function(){
        if(! hasModal) $('.modal-conheca').hide();
        if(! hasModal) $('.modal-conheca-dinheiro').hide();
    });
    $("#insert-codigo-pagseguro").click(function(o){
        if(openCodigoPagSeguro == false){
            $("#insert-codigo-pagseguro").html("Fechar Código PagSeguro");
            $("#content-codigo-pagseguro").show();
            openCodigoPagSeguro = true;
        }else{
            $("#insert-codigo-pagseguro").html("Inserir Código PagSeguro");
            $("#content-codigo-pagseguro").hide();
            openCodigoPagSeguro = false;
        }
    });

    $("#btn-add-ocorrencia").click(function () {
        $("#addOcorrencia").submit();
    });

    $("#btn-open-ocorrencia").click(function () {
        $('#modal-add-ocorrencia').show();
    });
    var widthBC=0;
    var heightBC=0;
    console.debug($("#row1").width());
    widthBC = widthBC + parseInt($("#row1").width());
    heightBC = heightBC + parseInt($("#row1").height());
    heightBC = heightBC + parseInt($("#row2").height());
    heightBC = heightBC + parseInt($("#row3").height());
    $(".block-client-t").width(widthBC);
    $(".block-client-t").height((heightBC+17));

});

function naoPagoBoleto(idBoleto, obj){
    objBoleto = obj;
    var array = {"co_seq_boleto": idBoleto};
    ajaxPost(funcaoNaoPagoBoleto, array, "/cliente/ajax-nao-pago-boleto/", "/admin");
}

funcaoNaoPagoBoleto = function(json){
    if(json!=null){
        jQuery(objBoleto).parent().parent().removeClass("success");
        jQuery(objBoleto).parent().parent().addClass("info");
        jQuery(objBoleto).parent().parent().attr("style", "color: #c3c3c3;");
        jQuery(objBoleto).parent().parent().find(".pago-boleto").html("Não Pago");
        var html = '';
        html += '<a href="javascript:void(0);" onclick="pagaBoleto(' + json.data + ', this);">';
        html += '   <i class="icon-ok-circle" style="color: #47a447;" title="Pagar"></i>';
        html += '</a>';
        $(objBoleto).parent().html(html);

        alert("Boleto não pago com sucesso!");
    }
};

function pagaBoleto(idBoleto, obj, antigo){
    objBoleto = obj;
    pgBoletoAntigo = antigo;
    var array = {"co_seq_boleto": idBoleto, "antigo": antigo, "co_seq_cliente":$("#coSeqCliente").html()};
    if(antigo == 1){
        ajaxPost(funcaoPagaBoleto, array, "/cliente/ajax-paga-boleto/", "/admin");
    }else {
        if (confirm('Tem certeza que deseja confirma o pagamento deste boleto? Ao confirma, será gerado outro boleto se o cliente, assim o tiver!')) {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $(window).ready(function() {
                $('#loading').show();
            });
            ajaxPost(funcaoPagaBoleto, array, "/cliente/ajax-paga-boleto/", "/admin");
        }
    }
    return false;
}

funcaoPagaBoleto = function(json){
    if(json!=null){
        jQuery(objBoleto).parent().parent().removeClass("info");
        jQuery(objBoleto).parent().parent().addClass("success");
        jQuery(objBoleto).parent().parent().attr("style", "");
        jQuery(objBoleto).parent().parent().find(".pago-boleto").html("Pago");
        var html = '';
        html += '<a href="javascript:void(0);" onclick="naoPagoBoleto(' + json.data["id"] + ', this);">';
        html += '   <i class="icon-ban-circle" style="color: #f0ad4e;" title="Não Pagar"></i>';
        html += '</a>';
        $(objBoleto).parent().html(html);
        overlay.remove();
        $(window).ready(function() {
            $('#loading').hide();
        });
        if(pgBoletoAntigo == 1){
            alert("Boleto pago com sucesso!");
            window.location.href = getUrlController() + "/admin/cliente/view/id/"+$("#coSeqCliente").html();
        }else {
            if(json.data["gerado"]==1){
                alert("Boleto pago com sucesso! Foi enviado para o email do cliente.");
            }else{
                alert("Boleto pago com sucesso!");
            }
            window.location.href = getUrlController() + "/admin/cliente/view/id/"+$("#coSeqCliente").html();
        }
    }
};

function validaClienteCartaoPresencial(idCliente){
    var array = {"co_seq_cliente": idCliente};
    ajaxPost(funcaoPagaCartaoPresencial, array, "/cliente/ajax-paga-cartao-presencial/", "/admin");
}

var funcaoPagaCartaoPresencial = function(json){
    if(json!=null){
        closeModal();
        alert("Cliente Liberado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/view/id/"+json.data['id'];
    }
};

function validaClienteDinheiro(idCliente){
    var array = {"co_seq_cliente": idCliente};
    ajaxPost(funcaoPagaDinheiro, array, "/cliente/ajax-paga-dinheiro/", "/admin");
}

var funcaoPagaDinheiro = function(json){
    if(json!=null){
        closeModal();
        alert("Cliente Liberado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/view/id/"+json.data['id'];
    }
};

function validaClientePagSeguro(txIdPagseguro, idCliente){
    var array = {"tx_id_pagseguro": txIdPagseguro, "co_seq_cliente": idCliente};
    ajaxPost(funcaoPagaPagseguro, array, "/cliente/ajax-paga-pagseguro/", "/admin");
}

var funcaoPagaPagseguro = function(json){
    if(json!=null){
        closeModal();
        alert("Cliente Liberado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/view/id/"+json.data['id'];
    }
};

function reenviarEmail(idCliente){
    overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
    $(window).ready(function() {
        $('#loading').show();
    });
    var array = {"co_seq_cliente": idCliente};
    ajaxPost(funcaoReenviarEmail, array, "/cliente/ajax-reenviar-email/", "/admin");
}

var funcaoReenviarEmail = function(json){
    if(json!=null){
        overlay.remove();
        $(window).ready(function() {
            $('#loading').hide();
        });
        alert("Enviado com sucesso!");
    }
};

function registraCodigoPagSeguro(obj){
    var html = "";
    if(obj.tx_id_pagseguro.value==""){
        html += "Código esta vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"tx_id_pagseguro":obj.tx_id_pagseguro.value, "co_seq_cliente":obj.co_seq_cliente.value, "co_seq_pagamento":obj.co_seq_pagamento.value};
        ajaxPost(funcaoRegistraCodigoPagSeguro, array, "/cliente/ajax-registra-codigo-pagseguro/", "/admin");
    }
    return false;
}

var funcaoRegistraCodigoPagSeguro = function(json){
    if(json != ""){
        alert("Código registrado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/view/id/"+json.data['id'];
    }
};

function validaAddOcorrencia(obj) {
    var html = "";
    if(obj.tx_ocorrencia.value==""){
        html += "Texto da Ocorrência esta vazia!\n";
    }
    if(html != "") {
        alert(html);
    }else {
        var array = {"tx_ocorrencia": obj.tx_ocorrencia.value, "co_cliente": obj.co_cliente.value};
        ajaxPost(funcaoValidaAddOcorrencia, array, "/cliente/ajax-add-ocorrencia/", "/admin");
    }
    return false;
}

var funcaoValidaAddOcorrencia = function(json){
    if(json != ""){
        alert("Ocorrência adicionada com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/view/id/"+json.data['id'];
    }
};