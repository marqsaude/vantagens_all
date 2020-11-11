/**
 * Created by tony on 03/08/17.
 */

var pagSeguro = false;
var arrayBoleto = [];

function getFormaPagamento(){
    var ids = [1, 3];
    var array = {"verify":true, "ids": ids};
    jQuery(function() {
        ajaxPost(funcaoGetFormaPagamento, array, "/cartao-marq/ajax-get-forma-pagamento/", "/default");
    });
}

var funcaoGetFormaPagamento = function(json){
    if (json != false) {
        dataFormaPagamento=json.data;
        //mountHtmlFormaPagamento();
    }else{
        alert("Ocorreu algum erro!");
    }
};

function getHtmlTipoDependencias(){
    var array = {"verify":true};
    jQuery(function() {
        ajaxPost(funcaoTipoDependencias, array, "/cartao-marq/ajax-get-tipo-dependentes/", "/default");
    });
}

var funcaoTipoDependencias = function(json){
    if(json!=null){
        dataTipoDependentes=json.data;
    }
};

function mountHtmlFormaPagamento(){
    getPrice();
    var htmlFormaPagamento = "";
    //htmlFormaPagamento += '<form id="forma-pagamento-form" onSubmit="return validaFormaPagamento(this);" action="javascript:void(0);" method="post" class="form-validate form-horizontal">';
    //htmlFormaPagamento += '   <div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
    //htmlFormaPagamento += '       <div class="span12">';
    //htmlFormaPagamento += '           <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Forma de Pagamento</h3>';
    //htmlFormaPagamento += '       </div>';
    //htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span12">';
    htmlFormaPagamento += '           &nbsp;';
    htmlFormaPagamento += '       </div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span12">';
    htmlFormaPagamento += '           <div class="status alert alert-success" style="display: none"></div>';
    htmlFormaPagamento += '       </div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '       <div class="span8" style="text-align: center;">';
    htmlFormaPagamento += '         <select name="forma_pagamento" id="forma_pagamento" class="input-block-level" onchange="mountFormaPagamento(this)">';
    htmlFormaPagamento += '                 <option name="0" value="0" selected="selected">Selecione Forma de Pagamento...</option>';
    jQuery.each( dataFormaPagamento, function( key, value ) {
        if(dataFormaPagamento==value["co_seq_forma_pagamento"]){
            htmlFormaPagamento += '               <option name="' + value["co_seq_forma_pagamento"] + '" value="' + value["co_seq_forma_pagamento"] + '" selected="selected">' + value["nm_forma_pagamento"] + '</option>';
        }else {
            htmlFormaPagamento += '               <option name="' + value["co_seq_forma_pagamento"] + '" value="' + value["co_seq_forma_pagamento"] + '">' + value["nm_forma_pagamento"] + '</option>';
        }
    });
    htmlFormaPagamento += '         </select>';
    htmlFormaPagamento += '       </div>';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span12"></div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '       <div class="span4">';
    htmlFormaPagamento += '         <div id="price-vantagem"></div>';
    htmlFormaPagamento += '       </div>';
    htmlFormaPagamento += '       <div class="span4" id="html-boleto">';
    htmlFormaPagamento += '       </div>';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span12"></div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '       <div class="span8" id="form-boleto"></div>';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '   </div>';
    htmlFormaPagamento += '   <div class="row-fluid">';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '       <div class="span8" id="btns"></div>';
    htmlFormaPagamento += '       <div class="span2"></div>';
    htmlFormaPagamento += '   </div>';
    //htmlFormaPagamento += '</form>';

    jQuery(function(){
        jQuery("#cartao-vantagem").html(htmlFormaPagamento);
        jQuery("#main").css("height", "517px");
        if(dataContratoGog==12){
            for(var i=0; i<18; i++) {
                $(".icon-circle-blank:eq(0)").addClass("icon-circle");
                $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
            }
        }else{
            for(var i=0; i<9; i++) {
                $(".icon-circle-blank:eq(0)").addClass("icon-circle");
                $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
            }
        }
    });
    init("forma_pagamento");
}

function htmlBtns(){
    var html = '';
    html += '       <div class="span4">';
    html += '           <button type="submit" onclick="comeBackFormaPagamento();" style="float:left;" class="btn btn-primary btn-large pull-right" id="voltar-dependentes"><< Voltar</button>';
    html += '       </div>';
    html += '       <div class="span4" id="enviar-forma-pagamento">';
    html += '       </div>';
    return html;
}

function mountFormaPagamento(obj){
    jQuery(function(){
        var htmlFormaPagamento = '';
        jQuery('.remove-linha').remove();
        if(jQuery(obj).find(":selected").val()=="1" || jQuery(obj).find(":selected").val()==1){
            jQuery("#btns").html(htmlBtns());
            htmlFormaPagamento += '<div style="color: #373435; float: left;">';
            htmlFormaPagamento += '     <h4>Valor do Contrato:</h4>  ';
            htmlFormaPagamento += '</div>';
            htmlFormaPagamento += '<div style="color: #373435; float: right;">';
            htmlFormaPagamento += '     <h4>R$ '+priceContratoGog+'</h4>';
            htmlFormaPagamento += '</div>';
            jQuery("#price-vantagem").html(htmlFormaPagamento);
            jQuery("#main").css("height", "587px");
            jQuery.each( dataFormaPagamento, function( key, value ) {
                //if(value.co_seq_forma_pagamento==jQuery(obj).find(":selected").val()){
                    var html = '';
                    //html += '<div class="6u remove-linha">';
                    html += '   <select id="nu_vezes" name="nu_vezes" class="input-block-level">';
                    html += '       <option name="0" value="0">Selecione o Número de Vezes</option>';
                    for(var i=1; i<=value.nu_vezes; i++){
                        var vezes = ' vez';
                        if(i>1){
                            vezes = ' vezes';
                        }
                        html += '       <option name="'+i+'" value="'+i+'">'+i+vezes+'</option>';
                    }
                    html += '   </select>';
                    //html += '</div>';
                    jQuery("#html-boleto").html(html);
                //}
            });
            getHtmlBoletoSicoob();
            jQuery("#enviar-forma-pagamento").html('<button type="submit" onclick="submitBoletoSicoob();" style="float:right;" class="btn btn-primary btn-large pull-right">Gerar Boleto(s)</button>');
        }else if(jQuery(obj).find(":selected").val()=="3" || jQuery(obj).find(":selected").val()==3){
            jQuery("#btns").html(htmlBtns());
            htmlFormaPagamento += '<div style="color: #373435; float: left;">';
            htmlFormaPagamento += '     <h4>Valor do Contrato:</h4>  ';
            htmlFormaPagamento += '</div>';
            htmlFormaPagamento += '<div style="color: #373435; float: right;">';
            htmlFormaPagamento += '     <h4>R$ '+priceContratoGog+'</h4>';
            htmlFormaPagamento += '</div>';
            jQuery("#price-vantagem").html(htmlFormaPagamento);
            jQuery("#enviar-forma-pagamento").html('<button type="submit" onclick="goPagSeguro();" style="float:right;" class="btn btn-primary btn-large pull-right">PagSeguro</button>');
            jQuery("#main").css("height", "587px");
            jQuery("#html-boleto").html('');
        }

    });
    insertMask();
}

function submitBoletoSicoob(){
    jQuery("#formBoleto").submit();
}

function getHtmlBoletoSicoob(){
    var nuTelefone = arrayTelefone.nu_celular.substring(5, arrayTelefone.nu_celular.length+1).replace("-","");
    var nuDDD = arrayTelefone.nu_celular.substring(1, 3);
    var days = 30;
    var daysValid = 5;
    //console.debug(getDate(daysValid));
    //console.debug(priceContratoGog);
    //console.debug(getDate((days*1)+daysValid));
    //console.debug(getDate((days*2)+daysValid));
    var html = '';
    html += '<form onSubmit="return validaBoletoSicoob(this);" action="javascript:void(0);" method="post" class="contact-form" id="formBoleto" name="contact-form">';
    /*html += '   <input name="numCliente" type="hidden" value="19" size="15" />';
    html += '   <input name="coopCartao" type="hidden" value="5004" size="15" />';
    html += '   <input name="chaveAcessoWeb" type="hidden" value="65A8D271-D61E-4FB2-ACD6-68281CD3EED0" size="25" />';
    html += '   <input name="numContaCorrente" type="hidden" value="21601" size="15" />';
    html += '   <input name="codMunicipio" type="hidden" value="26242" size="15" />';
    html += '   <input name="bolRecebeBoletoEletronico" type="hidden" value="1" size="3" />';
    html += '   <input name="codTipoVencimento" type="hidden" value="1" size="5" />';
    html += '   <input name="valorAbatimento" type="hidden" value="0" size="5" />';
    html += '   <input name="bolAceite" type="hidden" value="1" size="5" />';
    html += '   <input name="percTaxaMulta" type="hidden" value="0" size="5" />';
    html += '   <input name="percTaxaMora" type="hidden" value="0" size="5" />';
    html += '   <input name="codEspDocumento" type="hidden" value="DM" size="5" />';
    html += '   <input name="valorPrimDesconto" type="hidden" value="0" size="5" />';
    html += '   <input name="valorSegDesconto" type="hidden" value="0" size="5" />';*/

    html += '   <input name="nomeSacado" type="hidden" value="'+arrayCliente.nm_cliente+'" />';
    html += '   <input name="cpfCGC" type="hidden" value="'+arrayCliente.nu_cpf.replace(".","").replace(".","").replace("-","")+'" />';
    html += '   <input name="dataNascimento" type="hidden" size="5" value="'+getFormattedDate(arrayCliente.dt_nascimento)+'" />';
    html += '   <input name="endereco" size="15" type="hidden" value="'+dataEndereco.nm_logradouro+' '+dataEndereco.nm_complemento+' '+dataEndereco.nu_endereco+'" />';
    html += '   <input name="bairro" size="10" maxlength="15" type="hidden" value="'+dataEndereco.nm_bairro+'" />';
    html += '   <input name="cidade" size="15" maxlength="15" type="hidden" value="'+dataEndereco.nm_localidade+'" />';
    html += '   <input name="cep" size="8" maxlength="8" type="hidden" value="'+dataEndereco.nu_cep+'" />';
    html += '   <input name="uf" size="5" maxlength="2" type="hidden" value="'+dataEndereco.nm_uf+'" />';
    html += '   <input name="telefone" type="hidden" size="10" value="'+nuTelefone+'" />';
    html += '   <input name="ddd" type="hidden" size="5" value="'+nuDDD+'" />';
    html += '   <input name="ramal" type="hidden" size="5" value="13" />';
    html += '   <input name="email" type="hidden" size="25" value="'+arrayCliente.nm_email+'" />';
    //html += '   <input name="dataEmissao" type="hidden" size="5" value="'+getDate()+'" />';
    /*html += '   <input name="seuNumero" type="hidden" size="25" value="6120261313" />';
    html += '   <input name="nomeSacador" type="hidden" size="25" value="Q Saúde Vantagens" />';
    html += '   <input name="numCGCCPFSacador" type="hidden" size="25" value="29139123000190" />';*/
    html += '   <input name="qntMonetaria" type="hidden" size="5" value="'+priceContratoGog+'" />';
    html += '   <input name="valorTitulo" type="hidden" size="5" value="'+priceContratoGog+'" />';
    //html += '   <input name="dataVencimentoTit" type="hidden" size="5" value="'+getDate(daysValid)+'" />';
    //html += '   <input name="dataPrimDesconto" type="hidden" size="5" value="'+getDate()+'" />';
    //html += '   <input name="dataSegDesconto" type="hidden" size="5" value="'+getDate()+'" />';
    html += '   <input name="descInstrucao1" type="hidden" size="25"/>';
    html += '   <input name="descInstrucao2" type="hidden" size="25"/>';
    html += '   <input name="descInstrucao3" type="hidden" size="25"/>';
    html += '   <input name="descInstrucao4" type="hidden" size="25"/>';
    html += '</form>';
    jQuery("#form-boleto").html(html);
}

function validaBoletoSicoob(obj){
    var html = "";
    if($("#nu_vezes").val()==0 || $("#nu_vezes").val()=="0"){
        html += "Selecione o número de vezes!";
    }
    if(html == ""){
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
        $(window).ready(function() {
            $('#loading').show();
        });
        $("#enviar-forma-pagamento button").attr("disabled","disabled");
        var arraySession = createArraySession($("#nu_vezes").val());
        ajaxPost(funcaoValidaBoletoSicoob, arraySession, "/cartao-marq/ajax-session-register/", "/default");
        arrayBoleto = {"nomeSacado":obj.nomeSacado.value, "cpfCGC":obj.cpfCGC.value, "dataNascimento":obj.dataNascimento.value, "endereco":obj.endereco.value, "bairro":obj.bairro.value, "cidade":obj.cidade.value, "cep":obj.cep.value, "uf":obj.uf.value, "telefone":obj.telefone.value, "ddd":obj.ddd.value, "email":obj.email.value, "co_seq_contrato_gog":dataContratoGog, "nu_vezes":$("#nu_vezes").val()};
    }else{
        alert(html);
    }
    return false;
}

var funcaoValidaBoletoSicoob = function(json){
    if(json != null){
        createBoletoSicoob();
    }
};

function createBoletoSicoob(){
    ajaxPost(funcaoCreateBoletoSicoob, arrayBoleto, "/cartao-marq/ajax-boleto/", "/default");
    return false;
}

var funcaoCreateBoletoSicoob = function(json){
    if(json != null){
        overlay.remove();
        $(window).ready(function() {
            $('#loading').hide();
        });
        alert("Foi enviado o(s) boleto(s) para seu email!");
        window.location.href = getUrlController() + "/default/cartao-marq/return";
    }
};

funcaoValidaCartao = function(json){
    var validCard = false;
    var html = htmlValidaPagamento;
    if(json != null){
        validCard = json.valid;
        if(json.valid == null){
            validCard = false;
        }else{
            if(json.valid == false){
                validCard = false;
            }else {
                validCard = json.valid.type_valid;
            }
        }
    }else{
        validCard = false;
    }
    if(validCard==false){
        html += "Número de Cartão inválido!\n";
    }
    if (html == "") {
        arrayAcordo = {"co_contrato_gog": dataContratoGog};
        //ajaxPost(funcaoSaveSession, dataDependentes, "/cartao-marq/ajax-dependente-session/", "/default");
        ajaxPost(funcaoSaveSession, arrayCliente, "/cartao-marq/ajax-cliente-session/", "/default");
        ajaxPost(funcaoSaveSession, endereco, "/cartao-marq/ajax-cep-session/", "/default");
        ajaxPost(funcaoSaveSession, arrayTelefone, "/cartao-marq/ajax-telefone-session/", "/default");
        ajaxPost(funcaoSaveSession, arrayAcordo, "/cartao-marq/ajax-acordo-session/", "/default");
        ajaxPost(funcaoSaveSession, arrayPagamento, "/cartao-marq/ajax-pagamento-session/", "/default");
        if (arrayPagamento.co_forma_pagamento == "4" || arrayPagamento.co_forma_pagamento == 4 || arrayPagamento.co_forma_pagamento == "5" || arrayPagamento.co_forma_pagamento == 5) {
            var tp_cartao;
            if (arrayPagamento.co_forma_pagamento == 5 || arrayPagamento.co_forma_pagamento == "5") {
                tp_cartao = "D";
            } else {
                tp_cartao = "C";
            }
            arrayCartao = {
                "nu_cartao": objFormaPagamento.nu_cartao.value,
                "tp_cartao": tp_cartao,
                "tp_operadora": jQuery('#tp_operadora').find(":selected").val(),
                "dt_validade": jQuery('#dt_validade').val(),
                "nm_impresso": jQuery('#nm_impresso').val()
            };
            ajaxPost(funcaoSaveSession, arrayCartao, "/cartao-marq/ajax-cartao-session/", "/default");
        }else{
            arrayCartao = {};
            ajaxPost(funcaoSaveSession, arrayCartao, "/cartao-marq/ajax-cartao-session/", "/default");
        }
        //console.debug(arrayPagamento);
        if(detectmob()==true) {
            window.location.href = getUrlController() + "/default/assinatura/index";
        }else{
            window.open(getUrlController() + "/default/assinatura/index", "_blank");
        }
    } else {
        alert(html);
        htmlValidaPagamento="";
    }
    return false;
};

var funcaoSaveSession = function(json){
    if (json != false) {
        if(json.retorna != undefined && json.retorna == 1) {
            window.location.href = getUrlController() + "/default/pag-seguro/pagar";
        }
    }
};

function goPagSeguro(){
    var arraySession = createArraySession();
    /*ajaxPost(funcaoSaveSession, dataDependentes, "/cartao-marq/ajax-dependente-session/", "/default");
    ajaxPost(funcaoSaveSession, arrayCliente, "/cartao-marq/ajax-cliente-session/", "/default");
    ajaxPost(funcaoSaveSession, dataEndereco, "/cartao-marq/ajax-cep-session/", "/default");
    ajaxPost(funcaoSaveSession, arrayTelefone, "/cartao-marq/ajax-telefone-session/", "/default");
    ajaxPost(funcaoSaveSession, arrayAcordo, "/cartao-marq/ajax-acordo-session/", "/default");
    ajaxPost(funcaoSaveSession, arrayPagamento, "/cartao-marq/ajax-pagamento-session/", "/default");*/
    ajaxPost(funcaoSaveSession, arraySession, "/cartao-marq/ajax-session-register/", "/default");
}

function getPrice(){
    var arrayContratoGog = {"co_seq_contrato_gog":dataContratoGog};
    ajaxPost(funcaoGetPrice, arrayContratoGog, "/cartao-marq/ajax-get-price/", "/default");
}

var funcaoGetPrice = function(json){
    if (json != false) {
        priceContratoGog = json.price;
    }
};

function createArraySession(nuVezes){
    arrayAcordo = {"co_contrato_gog": dataContratoGog};
    arrayPagamento = {
        "co_forma_pagamento": jQuery("#forma_pagamento").find(":selected").val()
    };
    if(dataDependentes.length != 0){
        dataDependentes = toObject(dataDependentes);
    }
    var arraySession = {"cliente": arrayCliente, "endereco":dataEndereco, "telefone": arrayTelefone, "acordo": arrayAcordo, "pagamento":arrayPagamento, "dependentes":dataDependentes, "nu_vezes":nuVezes};
    return arraySession;
}

function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i){
        rv[i] = toObject2(arr[i], i);
    }
    return rv;
}

function toObject2(arr, i) {
    i++;
    var rv = {};
    rv["dt_nascimento"] = arr["dt_nascimento"+i];
    rv["nm_dependente"] = arr["nm_dependente"+i];
    rv["nm_email"] = arr["nm_email"+i];
    rv["nu_cpf"] = arr["nu_cpf"+i];
    rv["nu_rg"] = arr["nu_rg"+i];
    rv["co_tipo_dependentes"] = arr["tipo_dependente"+i];
    return rv;
}

getFormaPagamento();
getHtmlTipoDependencias();