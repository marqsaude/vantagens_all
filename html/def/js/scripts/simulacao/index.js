var price="";
var apelido="";
var dependents="";
var contrato = "";
var nome = "";
var idContrato=0;
var htmlSimulador="";
var vezes=0;

function validaSimulacao(objClientForm){
    var html = "";
    if(objClientForm.nm_cliente.value==""){
        html += "Nome do Cliente vazio!\n";
    }
    if(objClientForm.nu_telefone.value==""){
        html += "Número do Telefone vazio!\n";
    }
    if(objClientForm.nm_email.value==""){
        html += "Email do Cliente vazio!\n";
    }
    if($("#contrato_gog").val()==0 || $("#contrato_gog").val()=="0"){
        html += "Selecione um contrato para a Simulação!\n";
    }
    if($("#forma_pagamento").val()==0 || $("#forma_pagamento").val()=="0"){
        html += "Selecione uma forma de pagamento para a Simulação!\n";
    }
    if($("#nu_vezes").val()==0 || $("#nu_vezes").val()=="0"){
        html += "Selecione o número de vezes que pretende dividir!\n";
    }
    if(html == ""){
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
        $(window).ready(function() {
            $('#loading').show();
        });
        vezes=$("#nu_vezes").val();
        var array = {"co_contrato_gog":$("#contrato_gog").val(), "co_forma_pagamento":$("#forma_pagamento").val(), "nm_cliente":objClientForm.nm_cliente.value, "nm_email":objClientForm.nm_email.value, "nu_vezes":$("#nu_vezes").val(), "nu_telefone":objClientForm.nu_telefone.value};
        ajaxPost(funcaoValidaSimulacao, array, "/simulacao/ajax-add/", "/default");
    }else{
        alert(html);
    }
    return false;
}

var funcaoValidaSimulacao = function(json){
    if(json != ""){
        price = parseFloat(price);
        var valor = price/vezes;
        valor = parseFloat(valor).toFixed(2);
        htmlSimulador += "Plano "+nome+" ("+apelido+"). "+contrato+"<br/>";
        if(vezes==1){
            htmlSimulador += "R$ "+valor+" reais de "+vezes+" vez mensal";
        }else{
            htmlSimulador += "R$ "+valor+" reais de "+vezes+" vezes mensais";
        }
        htmlSimulador += "<br/><br/><br/>";
        htmlSimulador += "<div class='span4'>";
        htmlSimulador += "  <a class='button fit special' href='"+getUrlController()+"/cliente/index/id/"+idContrato+"'>Fazer o Plano</a>";
        htmlSimulador += "</div>";
        htmlSimulador += "<div class='span1'></div>";
        htmlSimulador += "<div class='span6'>";
        htmlSimulador += "  <a class='button fit special' href='"+getUrlController()+"/simulacao'>Fazer outra Simulação</a>";
        htmlSimulador += "</div>";
        htmlSimulador += "<br/><br/><br/><br/>";
        $("#cartao-vantagem").hide();
        $("#sobre-contrato-gog").html(htmlSimulador);
        overlay.remove();
        $(window).ready(function() {
            $('#loading').hide();
        });
    }
};


function init() {
    $(function () {
        $("#contrato_gog").change(function () {
            mudaValoresMensagem(this);
        });
        jQuery(".nu_telefone").mask("(00) 0000-00009");
        jQuery("#nu_telefone").keyup(function(event) {
            if(jQuery(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                jQuery('.nu_teefone').mask('(00) 00000-0009');
            }else{
                jQuery('.nu_telefone').mask('(00) 0000-00009');
            }
        });
    });
}

function mudaValoresMensagem(obj){
    price = $(obj).find(":selected").attr("price");
    dependents = $(obj).find(":selected").attr("dependents");
    apelido = $(obj).find(":selected").attr("apelido");
    contrato = $(obj).find(":selected").attr("contrato");
    nome = $(obj).find(":selected").html();
    idContrato = $(obj).find(":selected").val();
    mensagem();
}

function mensagem() {
    var text = "";
    if(idContrato!=0){
        text += "Plano "+nome+" ("+apelido+"). "+contrato;
    }
    $("#sobre-contrato-gog").html(text);
}


function submitCadastroSimulacao(){
    jQuery("#fmain-contact-form").submit();
}

init();