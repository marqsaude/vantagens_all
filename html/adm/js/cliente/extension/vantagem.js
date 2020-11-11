/**
 * Created by tony on 03/08/17.
 */

function verifyVantagens(){
    var array = {"verify":true};
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
    if (countVantagem > 1) {
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
        if (!document.getElementById('check-vantagem').checked) {
            html += 'Não foi concordado o "termo de uso/contrao"!\n';
        }
        if (obj.contrato_gog.value == 0) {
            html += 'Não foi selecionado um contrato!\n'
        }
        if (html != '') {
            alert(html);
        } else {
            dataContratoGog = obj.contrato_gog.value;
            mountHtmlFormaPagamento();

        }
    }else{
        back = false;
    }
    return false;
}

function mountHtmlUmTipoVantagem(){
    var urlPdf = getUrlController()+'/gog/contrato/'+dataVantagem[0].lk_contrato_gog;
    var htmlUmTipoVantagem = '';
    htmlUmTipoVantagem += '<form role="form" id="vantagemCliente" onSubmit="return validaContratoVantagem(this);" action="javascript:void(0);" method="post">';
    //htmlUmTipoVantagem += '   <div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
    //htmlUmTipoVantagem += '       <div class="span12">';
    //htmlUmTipoVantagem += '           <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Tipo de Vantagem</h3>';
    //htmlUmTipoVantagem += '       </div>';
    //htmlUmTipoVantagem += '   </div>';
    htmlUmTipoVantagem += '     <div id="dataTables-example_wrapper2" class="dataTables_wrapper form-inline" role="grid">';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-12">';
    htmlUmTipoVantagem += '                 &nbsp;';
    htmlUmTipoVantagem += '             </div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-12">';
    htmlUmTipoVantagem += '                 <div class="status alert alert-success" style="display: none"></div>';
    htmlUmTipoVantagem += '             </div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-1"></div>';
    htmlUmTipoVantagem += '             <div class="col-sm-10" style="text-align: center;" id="contrato-pdf">';
    htmlUmTipoVantagem += '                 <object data="'+urlPdf+'" type="application/pdf" width="100%" height="400px">';
    htmlUmTipoVantagem += '                     <embed src="'+urlPdf+'" type="application/pdf" />';
    htmlUmTipoVantagem += '                 </object>';
    htmlUmTipoVantagem += '                 <input type="hidden" name="contrato_gog" value="'+dataVantagem[0].co_seq_contrato_gog+'">';
    htmlUmTipoVantagem += '             </div>';
    htmlUmTipoVantagem += '             <div class="col-sm-1"></div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-12"></div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-1"></div>';
    htmlUmTipoVantagem += '             <div class="col-sm-11" style="color: #373435;" id="check-contract">';
    htmlUmTipoVantagem += '                 <input type="checkbox" name="check-vantagem" id="check-vantagem" /> <b>Li e concordo com o contrato e o termo de uso.</b>';
    htmlUmTipoVantagem += '             </div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '             <div class="col-sm-12"><br/></div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '         <div class="row">';
    htmlUmTipoVantagem += '            <div class="col-sm-6">';
    htmlUmTipoVantagem += '                <a href="javascript:void(0);" class="btn btn-warning btn-lg btn-rect" onclick="voltarClienteCliente();"><i class="icon-reply"></i>&nbsp;Voltar</a>';
    htmlUmTipoVantagem += '            </div>';
    htmlUmTipoVantagem += '            <div class="col-lg-6">';
    htmlUmTipoVantagem += '                <a href="javascript:void(0);" style="float: right;" class="btn btn-info btn-lg btn-rect" onclick="submitCadastroVantagemCliente();">Próximo&nbsp;<i class="icon-share-alt"></i></a>';
    htmlUmTipoVantagem += '            </div>';
    htmlUmTipoVantagem += '         </div>';
    htmlUmTipoVantagem += '     </div>';
    htmlUmTipoVantagem += '</form>';


    $(function() {
        $("#cartao-vantagem").html(htmlUmTipoVantagem);
        for(var i=0; i<7; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    });
    init("tipo_vantagem");
}

function mountHtmlTipoVantagem(){
    var htmlTipoVantagem = '';

    htmlTipoVantagem += '<form id="vantagemCliente" onSubmit="return validaContratoVantagem(this);" action="javascript:void(0);" method="post" class="contact-form">';
    htmlTipoVantagem += '       <div class="row" style="border-bottom: 17px inset #f5f5f5;">';
    htmlTipoVantagem += '           <div class="col-sm-12">';
    htmlTipoVantagem += '               <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Tipo de Vantagem</h3>';
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12">';
    htmlTipoVantagem += '               &nbsp;';
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12">';
    htmlTipoVantagem += '               <div class="status alert alert-success" style="display: none"></div>';
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12" style="text-align: center;">';
    htmlTipoVantagem += '               <h4>Selecione um Contrato</h4>';
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-2"></div>';
    htmlTipoVantagem += '           <div class="col-sm-8" style="text-align: center;">';
    htmlTipoVantagem += '               <select name="contrato_gog" id="contrato_gog" class="form-control" onchange="setContrato(this)">';
    htmlTipoVantagem += '                   <option data="" name="0" value="0" onchange="">Selecione um contrato...</option>';
    jQuery.each( dataTipoVantagem, function( key, value ) {
        if(dataContratoGog==value["co_seq_contrato_gog"]){
            htmlTipoVantagem += '                   <option data="' + value["lk_contrato_gog"] + '" name="' + value["co_seq_contrato_gog"] + '" value="' + value["co_seq_contrato_gog"] + '" selected="selected">' + value["nm_contrato_gog"] + '</option>';
        }else {
            htmlTipoVantagem += '                   <option data="' + value["lk_contrato_gog"] + '" name="' + value["co_seq_contrato_gog"] + '" value="' + value["co_seq_contrato_gog"] + '">' + value["nm_contrato_gog"] + '</option>';
        }
    });
    htmlTipoVantagem += '               </select>';
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '           <div class="col-sm-2"></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12"></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-2"></div>';
    htmlTipoVantagem += '           <div class="col-sm-8" style="text-align: center;" id="contrato-pdf">';
    if(urlContrato!=null){
        htmlTipoVantagem += '             <object data="'+urlContrato+'" type="application/pdf" width="100%" height="400px">';
        htmlTipoVantagem += '                 <embed src="'+urlContrato+'" type="application/pdf" />';
        htmlTipoVantagem += '             </object>';
    }
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '           <div class="col-sm-2"></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12"></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-2"></div>';
    htmlTipoVantagem += '           <div class="col-sm-10" style="color: #373435;" id="check-contract">';
    if(urlContrato!=null) {
        htmlTipoVantagem += '           <input type="checkbox" name="check-vantagem" id="check-vantagem" class="form-control" /> <b>Li e concordo com o contrato e o termo de uso.</b>';
    }
    htmlTipoVantagem += '           </div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '       <div class="row">';
    htmlTipoVantagem += '           <div class="col-sm-12"><br/></div>';
    htmlTipoVantagem += '       </div>';
    htmlTipoVantagem += '        <div class="row">';
    htmlTipoVantagem += '            <div class="col-sm-6">';
    htmlTipoVantagem += '                <a href="javascript:void(0);" class="btn btn-warning btn-lg btn-rect" onclick="voltarClienteCliente();"><i class="icon-reply"></i>&nbsp;Voltar</a>';
    htmlTipoVantagem += '            </div>';
    htmlTipoVantagem += '            <div class="col-lg-6">';
    htmlTipoVantagem += '                <a href="javascript:void(0);" style="float: right;" class="btn btn-info btn-lg btn-rect" onclick="submitCadastroVantagemCliente();">Próximo&nbsp;<i class="icon-share-alt"></i></a>';
    htmlTipoVantagem += '            </div>';
    htmlTipoVantagem += '        </div>';
    htmlTipoVantagem += '    </div>';
    htmlTipoVantagem += '</form>';

    $(function(){
        $("#cartao-vantagem").html(htmlTipoVantagem);
        for(var i=0; i<7; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    });
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
    }
}

function submitCadastroVantagemCliente(){
    jQuery("#vantagemCliente").submit();
}