/**
 * Created by tony on 03/08/17.
 */

function verifyVantagens(){
    var array = {"verify":true, "setContratoGog":setContratoGog};
    ajaxPost(funcaoVantagens, array, "/cartao-marq/ajax-verify-vantagens/", "/default");
}

var funcaoVantagens = function(json){
    if (json != false) {
        countVantagem = json.count;
        dataVantagem = json.data;
    }else{
        alert("Ocorreu algum erro!");
    }
};

function checkVantagens(){
    if (countVantagem > 1 && setContratoGog==false) {
        voltaDependencia = true;
        dataTipoVantagem=dataVantagem;
        mountHtmlTipoVantagem();
    }else{
        if(countVantagem == 0){
            alert("Não existe contrato!");
        }else{
            voltaDependencia = false;
            numeroDependentes=dataVantagem[0].nu_dependentes;
            dataContratoGog=dataVantagem[0].co_seq_contrato_gog;
            //mountHtmlDependentes();
            mountHtmlUmTipoVantagem();
        }
    }
}

function validaTipoVantagem(obj){
    //var e = document.getElementById("contrato_gog");
    dataContratoGog=obj.contrato_gog.value;
    mountHtmlFormaPagamento();
    return false;
}

function validaContratoVantagem(obj){
    var html = '';
    if(back==false) {
        if (obj.contrato_gog.value == 0) {
            html += 'Não foi selecionado um contrato!\n'
        }else{
            if (!document.getElementById('check-vantagem').checked) {
                html += 'Não foi concordado o "termo de uso/contrao"!\n';
            }
        }
        if (html != '') {
            alert(html);
        } else {
            if(obj.contrato_gog.value==0){

            }else if(obj.contrato_gog.value==12){
                dataContratoGog = obj.contrato_gog.value;
                mountHtmlFormaPagamento();
            }else{
                dataContratoGog = obj.contrato_gog.value;
                mountHtmlDependentes();
            }
        }
    }else{
        back = false;
    }
    return false;
}

function mountHtmlUmTipoVantagem(){
    var urlPdf = getUrlController()+'/adm/contrato/'+dataVantagem[0].lk_contrato_gog;
    var htmlUmTipoVantagem = '';
    htmlUmTipoVantagem += '<form id="tipo-vantagem-form" onSubmit="return validaContratoVantagem(this);" action="javascript:void(0);" method="post" class="contact-form">';
    //htmlUmTipoVantagem += '   <div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
    //htmlUmTipoVantagem += '       <div class="span12">';
    //htmlUmTipoVantagem += '           <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Tipo de Vantagem</h3>';
    //htmlUmTipoVantagem += '       </div>';
    //htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span12">';
    htmlUmTipoVantagem += '           &nbsp;';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span12">';
    htmlUmTipoVantagem += '           <div class="status alert alert-success" style="display: none"></div>';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '       <div class="span8">';
    htmlUmTipoVantagem += '         <span style="text-align: center; font-size: 27px; margin-bottom: 17px; float: left; width: 100%;">';
    htmlUmTipoVantagem +=               dataVantagem[0].nm_contrato_gog;
    htmlUmTipoVantagem += '         </span>';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '       <div class="span8" style="text-align: center;" id="contrato-pdf">';
    htmlUmTipoVantagem += '             <object data="'+urlPdf+'" type="application/pdf" width="100%" height="400px">';
    htmlUmTipoVantagem += '                 <embed src="'+urlPdf+'" type="application/pdf" />';
    htmlUmTipoVantagem += '             </object>';
    htmlUmTipoVantagem += '             <input type="hidden" name="contrato_gog" value="'+dataVantagem[0].co_seq_contrato_gog+'">';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span12"></div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '       <div class="span10" style="color: #373435;" id="check-contract">';
    htmlUmTipoVantagem += '           <input type="checkbox" name="check-vantagem" id="check-vantagem" /> <b>Li e concordo com o contrato e o termo de uso.</b>';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span12"></div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '   <div class="row-fluid">';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '       <div class="span4">';
    htmlUmTipoVantagem += '           <button type="submit" onclick="comeBack();" style="float:left;" class="btn btn-primary btn-large pull-right" id="voltar-cliente-tipo-vantagem"><< Voltar</button>';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '       <div class="span4">';
    htmlUmTipoVantagem += '           <button type="submit" style="float:right;" id="enviar-contrato" class="btn btn-primary btn-large pull-right">Próximo >></button>';
    htmlUmTipoVantagem += '       </div>';
    htmlUmTipoVantagem += '       <div class="span2"></div>';
    htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '</form>';


    $(function() {
        $("#cartao-vantagem").html(htmlUmTipoVantagem);
        for(var i=0; i<9; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    });
    init("tipo_vantagem");
}

function mountHtmlTipoVantagem(){
    var htmlTipoVantagem = '';

    htmlTipoVantagem += '<form id="tipo-vantagem-form" onSubmit="return validaContratoVantagem(this);" action="javascript:void(0);" method="post" class="contact-form">';
    htmlTipoVantagem += '   <div class="row-fluid" style="border-bottom: 17px inset #f5f5f5;">';
    htmlTipoVantagem += '       <div class="span12">';
    htmlTipoVantagem += '           <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Tipo de Vantagem</h3>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12">';
    htmlTipoVantagem += '           &nbsp;';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12">';
    htmlTipoVantagem += '           <div class="status alert alert-success" style="display: none"></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12" style="text-align: center;">';
    htmlTipoVantagem += '           <h4>Selecione um Contrato</h4>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '       <div class="span8" style="text-align: center;">';
    htmlTipoVantagem += '           <select name="contrato_gog" id="contrato_gog" class="input-block-level" onchange="setContrato(this)">';
    htmlTipoVantagem += '               <option data="" name="0" value="0" onchange="">Selecione um contrato...</option>';
    jQuery.each( dataTipoVantagem, function( key, value ) {
        if(dataContratoGog==value["co_seq_contrato_gog"]){
            htmlTipoVantagem += '                   <option data="' + value["lk_contrato_gog"] + '" name="' + value["co_seq_contrato_gog"] + '" value="' + value["co_seq_contrato_gog"] + '" selected="selected">' + value["nm_contrato_gog"] + '</option>';
        }else {
            htmlTipoVantagem += '                   <option data="' + value["lk_contrato_gog"] + '" name="' + value["co_seq_contrato_gog"] + '" value="' + value["co_seq_contrato_gog"] + '">' + value["nm_contrato_gog"] + '</option>';
        }
    });
    htmlTipoVantagem += '           </select>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '       <div class="span8">';
    htmlTipoVantagem += '         <span style="text-align: center; font-size: 27px; margin-bottom: 17px; float: left; width: 100%;" id="title_contrato">';
    htmlTipoVantagem += '         </span>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '       <div class="span8" style="text-align: center;" id="contrato-pdf">';
    if(urlContrato!=null){
        htmlTipoVantagem += '             <object data="'+urlContrato+'" type="application/pdf" width="100%" height="400px">';
        htmlTipoVantagem += '                 <embed src="'+urlContrato+'" type="application/pdf" />';
        htmlTipoVantagem += '             </object>';
    }
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '       <div class="span10" style="color: #373435;" id="check-contract">';
    if(urlContrato!=null) {
        htmlTipoVantagem += '       <input type="checkbox" name="check-vantagem" id="check-vantagem" /> <b>Li e concordo com o contrato e o termo de uso.</b>';
    }
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span12"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '   <div class="row-fluid">';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '       <div class="span4">';
    htmlTipoVantagem += '           <button type="submit" onclick="comeBack();" style="float:left;" class="btn btn-primary btn-large pull-right" id="voltar-cliente-tipo-vantagem"><< Voltar</button>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="span4">';
    htmlTipoVantagem += '           <button type="submit" style="float:right;" id="enviar-contrato" class="btn btn-primary btn-large pull-right">Próximo >></button>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="span2"></div>';
    htmlTipoVantagem += '   </div>';
    htmlTipoVantagem += '</form>';

    $(function(){
        $(".sem-single").show();
        $(".space-icon").css("margin-left", "9%");
        $("#cartao-vantagem").html(htmlTipoVantagem);
        for(var i=0; i<9; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    });
    if(dataContratoGog==12){
        setSingleIcons();
    }
    init("tipo_vantagem");
}

function setContrato(obj){
    var urlPdfFull = urlPdf;
    var html = '';
    html += '<object data="'+urlPdfFull+$(obj).find(":selected").attr("data")+'" type="application/pdf" width="100%" height="400px">';
    html += '   <embed src="'+urlPdfFull+$(obj).find(":selected").attr("data")+'" type="application/pdf" />';
    html += '</object>';
    if($(obj).find(":selected").val() == 0){
        $("#contrato-pdf").html('');
        $("#check-contract").html('');
        $("#main").css("height", "577px");
    }else {
        urlContrato = urlPdfFull+$(obj).find(":selected").attr("data");
        $("#contrato-pdf").html(html);
        $("#check-contract").html('<input type="checkbox" name="check-vantagem" id="check-vantagem" /> Li e concordo com o contrato e o termo de uso.');
        $("#main").css("height", "1037px");
        if($(obj).find(":selected").val()==12){
            setSingleIcons();
        }else{
            $(".sem-single").show();
            $(".space-icon").css("margin-left", "9%");
        }
    }
}

function setSingleIcons(){
    $(".sem-single").hide();
    $(".space-icon").css("margin-left", "7%");
}