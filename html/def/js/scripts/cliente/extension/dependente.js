/**
 * Created by tony on 03/08/17.
 */
var objFinal = [];

function insereTipoDependente(id){
    if($("#tipo_dependente-"+id).find('option:selected').val()==0){
        return "É necessario selecionar um tipo do dependente "+id+"!\n";
    }else{
        objFinal["tipo_dependente"+id] = $("#tipo_dependente-"+id).find('option:selected').val();
        return "";
    }
}

function validaDependentes(obj){
    var html = "";
    if(back==false) {
        objFinal = [];
        var inputs = obj.getElementsByTagName('input');
        if ($('#nao_insere_dependente').is(':checked') != true) {
            var iTipoDependente=1;
            for (var index = 0; index < inputs.length; ++index) {
                var iipptt = inputs[index].getAttribute("name").split("-");
                var value = inputs[index].value;
                var nome = "";
                nome = iipptt[0] + iipptt[1];
                if (iipptt[0] == "nm_dependente" && value == "") {
                    html += "Nome do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "dt_nascimento" && value == "") {
                    html += "Data de Nascimento do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "nu_rg" && value == "") {
                    html += "RG do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "nu_cpf" && value == "") {
                    html += "CPF do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "nm_email" && value == "") {
                    html += "Email do Dependente " + iipptt[1] + " vazio!\n";
                }
                objFinal[nome] = value;
                if(iipptt[0] == "nm_email"){
                    html += insereTipoDependente(iTipoDependente);
                    iTipoDependente++;

                    dataDependentes.push(objFinal);
                }
            }
        }
        if (html != "") {
            //if(validAlertDependentes>0){
            //validAlertDependentes=0;
            //}else {
            dataDependentes = [];
            alert(html);
            //validAlertDependentes++;
            //}
        } else {
            //if(validAlertDependentes>0){
            //validAlertDependentes=0;
            //}else {
            //ajaxPost(funcaoSaveSession, objFinal, "/cartao-marq/ajax-dependente-session/", "/gog");
            //ajaxPost(funcaoSaveSession, arrayCliente, "/cartao-marq/ajax-cliente-session/", "/gog");
            //ajaxPost(funcaoSaveSession, arrayTelefone, "/cartao-marq/ajax-telefone-session/", "/gog");
            mountHtmlFormaPagamento();
            //window.location.href = getUrlController() + "/gog/assinatura/index";
            //validAlertDependentes++;
            //}
        }
    }else{
        if (voltaDependencia == false) {
            //mountHtmlCliente();
            //alert("so1");
            mountHtmlUmTipoVantagem();
            for(var i=0; i<18; i++) {
                $(".fa-circle:last").addClass("fa-circle-o");
                $(".fa-circle:last").removeClass("fa-circle");
            }
        } else {
            mountHtmlTipoVantagem();
            //alert("so2");
            for(var i=0; i<18; i++) {
                $(".fa-circle:last").addClass("fa-circle-o");
                $(".fa-circle:last").removeClass("fa-circle");
            }
        }
        back = false;
    }
    return false;
}

function mountHtmlDependentes(){
    var htmlDependentes = "";

    htmlDependentes += '<form id="dependencias-form" onSubmit="return validaDependentes(this);" action="javascript:void(0);" method="post" class="contact-form">';
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span12">';
    htmlDependentes += '            &nbsp;';
    htmlDependentes += '        </div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span12">';
    htmlDependentes += '            <div class="status alert alert-success" style="display: none"></div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span2"></div>';
    htmlDependentes += '        <div class="span8">';
    htmlDependentes += '            <div>';
    htmlDependentes += '                <input type="checkbox" name="nao_insere_dependente" id="nao_insere_dependente"> &nbsp;&nbsp;Selecione esta opção, se acaso não deseje inserir agora seu(s) dependente(s).';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div>';
    htmlDependentes += '                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os dependentes podem ser inseridos dentro da sua conta no site, depois de validada.';
    htmlDependentes += '            </div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '        <div class="span2"></div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span12"></div>';
    htmlDependentes += '    </div>';
    if(dataContratoGog==13){
        htmlDependentes += insertDependente(1);
    }else if(dataContratoGog==14){
        htmlDependentes += insertDependente(4);
    }
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span12"></div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '    <div class="row-fluid">';
    htmlDependentes += '        <div class="span2"></div>';
    htmlDependentes += '            <div class="span4">';
    htmlDependentes += '                <button type="submit" onclick="comeBack();" style="float:left;" class="pull-right btn-contato" id="voltar-cliente-tipo-vantagem"><< Voltar</button>';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div class="span4">';
    htmlDependentes += '                <button type="submit" style="float:right;" id="enviar-contrato" class="pull-right btn-contato">Próximo >></button>';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div class="span2"></div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '</form>';

    $(function(){
        $("#cartao-vantagem").html(htmlDependentes);
        $(".nu_cep").mask("99999-999");
        $("#main").css("height", "1227px");
        for(var i=0; i<9; i++) {
            $(".fa-circle-o:eq(0)").addClass("fa-circle");
            $(".fa-circle-o:eq(0)").removeClass("fa-circle-o");
        }
    });
    init("dependentes");
}

function insertDependente(start){
    countDependentes = 1;
    var htmlDependente = "";
    for(var i=0; i<start; i++) {
        htmlDependente += '<div class="row-fluid">';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '     <div id="count-dependentes" class="span8 dependencia'+countDependentes+'">Dependente ' + countDependentes + '</div>';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row-fluid">';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '     <div class="span8 dependencia'+countDependentes+'">';
        htmlDependente += '         <input type="text" name="nm_dependente-' + countDependentes + '" id="nm_cliente' + countDependentes + '" value="" class="input-block-level" size="30" maxlength="80" placeholder="Nome"/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row-fluid">';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '     <div class="span4 dependencia'+countDependentes+'">';
        htmlDependente += '         <input type="text" name="nu_rg-' + countDependentes + '" id="nu_rg' + countDependentes + '" value="" class="input-block-level nu_rg" size="30" placeholder="RG"/>';
        htmlDependente += '         <input type="text" name="dt_nascimento-' + countDependentes + '" id="dt_nascimento' + countDependentes + '" value="" class="input-block-level date-picker" size="30" placeholder="Data Nascimento"/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="span4 dependencia'+countDependentes+'">';
        htmlDependente += '         <input type="text" name="nu_cpf-' + countDependentes + '" id="nu_cpf' + countDependentes + '" value="" class="input-block-level nu_cpf" size="30" placeholder="CPF"/>';
        htmlDependente += '         <i class="icon fa-angle-down select-fa"></i>';
        htmlDependente += '         <select name="tipo_dependente-' + countDependentes + '" id="tipo_dependente-' + countDependentes + '" class="input-block-level tipo_dependente" style="float: left;">';
        htmlDependente += '             <option name="0" value="0">Selecione Tipo Dependente</option>';
        jQuery.each( dataTipoDependentes, function( key, value ) {
            if(dataContratoGog==value["co_seq_contrato_gog"]){
                htmlDependente += '     <option for="'+value["st_agregado"]+'" name="' + value["co_seq_tipo_dependentes"] + '" value="' + value["co_seq_tipo_dependentes"] + '" selected="selected">' + value["nm_tipo_dependente"] + '</option>';
            }else {
                htmlDependente += '     <option for="'+value["st_agregado"]+'" name="' + value["co_seq_tipo_dependentes"] + '" value="' + value["co_seq_tipo_dependentes"] + '">' + value["nm_tipo_dependente"] + '</option>';
            }
        });
        htmlDependente += '         </select>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row-fluid">';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '     <div class="span8 dependencia'+countDependentes+'">';
        htmlDependente += '         <input type="text" name="nm_email-' + countDependentes + '" id="nm_email' + countDependentes + '" value="" class="input-block-level" size="30" maxlength="50" placeholder="Email"/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="span2"></div>';
        htmlDependente += '</div>';
        countDependentes++;
    }
    if(start==0) {
        $("#menos-dependentes").before(htmlDependente);
        $(".nu_cep").mask("99999-999");
        //var sizeHeight = 1167+((countDependentes-1)*737);
        //$("#main").css("height", sizeHeight+"px");
        insertMask();
    }else{
        return htmlDependente;
    }
}

function removeDependencia(){
    $(".dependencia"+countDependentes).remove();
    countDependentes--;
    var sizeHeight = 1167+((countDependentes-1)*737);
    $("#main").css("height", sizeHeight+"px");
}