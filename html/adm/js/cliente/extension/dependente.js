/**
 * Created by tony on 03/08/17.
 */

function validaDependentes(obj){
    var html = "";
    if(back==false) {
        var objFinal = {};
        var inputs = obj.getElementsByTagName('input');
        if (countDependentes == 1) {
            if (inputs[0].value == "" && inputs[1].value == "" && inputs[2].value == "" && inputs[3].value == "" && inputs[4].value == "" && inputs[5].value == "" && inputs[6].value == "") {

            } else {
                if (inputs[0].value == "") {
                    html += "Nome do Dependente vazio!\n";
                }
                if (inputs[1].value == "") {
                    html += "Data de Nascimento do Dependente vazio!\n";
                }
                if (inputs[2].value == "") {
                    html += "RG do Dependente vazio!\n";
                }
                if (inputs[3].value == "") {
                    html += "CPF do Dependente vazio!\n";
                }
                if ($("#tipo_dependente-1").val() == 0) {
                    html += "É necessario selecionar um tipo do dependente!\n";
                }
                if (inputs[5].value == "") {
                    html += "Número do Celular do Dependente vazio!\n";
                }
                if (inputs[6].value == "") {
                    html += "Email do Dependente vazio!\n";
                }
                for (var index = 0; index < inputs.length; ++index) {
                    var iipptt = inputs[index].getAttribute("name").split("-");
                    //http://localhost:8888/sitemarquesaude/gog/assinatura/indexhttp://localhost:8888/sitemarquesaude/gog/assinatura/index
                    var value = inputs[index].value;
                    var nome = "";
                    nome = iipptt[0] + iipptt[1];
                    objFinal[nome] = value;
                    //console.debug(value);
                }
            }
        } else {
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
                if (iipptt[0] == "nu_celular" && value == "") {
                    html += "Número do Celular do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "nm_email" && value == "") {
                    html += "Email do Dependente " + iipptt[1] + " vazio!\n";
                }
                if (iipptt[0] == "tipo_dependente" && value == 0) {
                    html += "É necessario selecionar um tipo do dependente!\n";
                }
                objFinal[nome] = value;
            }
        }
        if (html != "") {
            //if(validAlertDependentes>0){
            //validAlertDependentes=0;
            //}else {
            alert(html);
            //validAlertDependentes++;
            //}
        } else {
            //if(validAlertDependentes>0){
            //validAlertDependentes=0;
            //}else {
            dataDependentes = objFinal;
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
            mountHtmlUmTipoVantagem();
            for(var i=0; i<14; i++) {
                $(".icon-circle:last").addClass("icon-circle-blank");
                $(".icon-circle:last").removeClass("icon-circle");
            }
        } else {
            mountHtmlTipoVantagem();
            for(var i=0; i<14; i++) {
                $(".icon-circle:last").addClass("icon-circle-blank");
                $(".icon-circle:last").removeClass("icon-circle");
            }
        }
        back = false;
    }
    return false;
}

function mountHtmlDependentes(){
    var htmlDependentes = "";

    htmlDependentes += '<form id="dependenteCliente" onSubmit="return validaDependentes(this);" action="javascript:void(0);" method="post" class="contact-form">';
    //htmlDependentes += '    <div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
    //htmlDependentes += '        <div class="span12">';
    //htmlDependentes += '            <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Dependentes</h3>';
    //htmlDependentes += '        </div>';
    //htmlDependentes += '    </div>';
    htmlDependentes += '    <div id="dataTables-example_wrapper2" class="dataTables_wrapper form-inline" role="grid">';
    htmlDependentes += '        <div class="row">';
    htmlDependentes += '            <div class="col-sm-12">';
    htmlDependentes += '                &nbsp;';
    htmlDependentes += '            </div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '        <div class="row">';
    htmlDependentes += '            <div class="col-sm-12">';
    htmlDependentes += '                <div class="status alert alert-success" style="display: none"></div>';
    htmlDependentes += '            </div>';
    htmlDependentes += '        </div>';
    htmlDependentes += insertDependente(1);
    htmlDependentes += '        <br/>';
    htmlDependentes += '        <div class="row">';
    htmlDependentes += '            <div class="col-sm-2"></div>';
    htmlDependentes += '            <div class="col-sm-2">';
    htmlDependentes += '                <a href="javascript:void(0);" class="btn btn-primary btn-rect" id="menos-dependentes">-</a>';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div class="col-sm-2">';
    htmlDependentes += '                <a href="javascript:void(0);" class="btn btn-primary btn-rect" id="mais-dependentes">+</a>';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div class="col-sm-2"></div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '        <div class="row">';
    htmlDependentes += '            <div class="col-sm-12">';
    htmlDependentes += '                <br/><br/>';
    htmlDependentes += '            </div>';
    htmlDependentes += '        </div>';
    htmlDependentes += '         <div class="row">';
    htmlDependentes += '            <div class="col-sm-6">';
    htmlDependentes += '                <a href="javascript:void(0);" class="btn btn-warning btn-lg btn-rect" onclick="voltarVantagemCliente();"><i class="icon-reply"></i>&nbsp;Voltar</a>';
    htmlDependentes += '            </div>';
    htmlDependentes += '            <div class="col-lg-6">';
    htmlDependentes += '                <a href="javascript:void(0);" style="float: right;" class="btn btn-info btn-lg btn-rect" onclick="submitCadastroDependenteCliente();">Próximo&nbsp;<i class="icon-share-alt"></i></a>';
    htmlDependentes += '            </div>';
    htmlDependentes += '         </div>';
    htmlDependentes += '    </div>';
    htmlDependentes += '</form>';

    $(function(){
        $("#cartao-vantagem").html(htmlDependentes);
        $(".nu_cep").mask("99999-999");
        $("#main").css("height", "1227px");
        for(var i=0; i<7; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    });
    init("dependentes");
}

function insertDependente(start){
    var tt = 0;
    if(start==0) {
        tt = countDependentes + 1;
        //numeroDependentes++;
    }else{
        numeroDependentes=1;
        tt = start;
    }
    if(numeroDependentes>=tt) {
        if(start==0) {
            countDependentes++;
        }else{
            countDependentes=1;
        }
        var htmlDependente = "";
        //htmlDependente += '         <div id="dependencia' + countDependentes + '" class="12u$">';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <br/><br/>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div id="count-dependentes" class="col-sm-8">' + countDependentes + ' Dependente</div>';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <br/>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div class="col-sm-8">';
        htmlDependente += '         <input type="text" name="nm_dependente-' + countDependentes + '" id="nm_cliente' + countDependentes + '" value="" class="form-control" size="30" maxlength="80" placeholder="Nome"/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '</div><br/>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <input type="text" name="nu_rg-' + countDependentes + '" id="nu_rg' + countDependentes + '" value="" class="form-control nu_rg" size="30" placeholder="RG"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <input type="text" name="dt_nascimento-' + countDependentes + '" id="dt_nascimento' + countDependentes + '" value="" class="form-control date-picker" size="30" placeholder="Data Nascimento"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <input type="text" name="nu_telefone-' + countDependentes + '" id="nu_telefone' + countDependentes + '" value="" class="form-control nu_telefone" size="30" placeholder="Telefone Residêncial"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <input type="text" name="nu_whatsapp-' + countDependentes + '" id="nu_whatsapp' + countDependentes + '" value="" class="form-control nu_whatsapp" size="30" placeholder="Telefone Whatsapp"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <input type="text" name="nu_cpf-' + countDependentes + '" id="nu_cpf' + countDependentes + '" value="" class="form-control nu_cpf" size="30" placeholder="CPF"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <select name="tipo_dependente-' + countDependentes + '" id="tipo_dependente-' + countDependentes + '" class="form-control tipo_dependente" style="float: left;">';
        htmlDependente += '             <option name="0" value="0">Selecione Tipo Dependente</option>';
        jQuery.each( dataTipoDependentes, function( key, value ) {
                htmlDependente += '     <option for="'+value["st_agregado"]+'" name="' + value["co_seq_tipo_dependentes"] + '" value="' + value["co_seq_tipo_dependentes"] + '">' + value["nm_tipo_dependente"] + '</option>';
        });
        htmlDependente += '         </select>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <input type="text" name="nu_celular-' + countDependentes + '" id="nu_celular' + countDependentes + '" value="" class="form-control nu_celular" size="30" placeholder="Telefone Celular"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '         <input type="text" name="nm_email-' + countDependentes + '" id="nm_email' + countDependentes + '" value="" class="form-control" size="30" maxlength="50" placeholder="Email"/>';
        htmlDependente += '         <br/><br/>';
        htmlDependente += '     </div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div class="col-sm-8">';
        htmlDependente += '         <input type="text" name="nu_cep" id="nu_cep" value="" class="form-control nu_cep" size="30" placeholder="CEP" onkeydown="cepKeyDown(this)" onkeyup="cepKeyUp(this)"/>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <div class="load-cep"></div>';
        htmlDependente += '         <div class="logradouro-cep form-linha"></div>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <div class="bairro-cep form-linha"></div>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '</div>';
        htmlDependente += '<div class="row dependencia'+countDependentes+'">';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <div class="localidade-cep form-linha"></div>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-4">';
        htmlDependente += '         <div class="uf-cep form-linha"></div>';
        htmlDependente += '     </div>';
        htmlDependente += '     <div class="col-sm-2"></div>';
        htmlDependente += '</div>';



        /*htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                 <input type="text" name="nu_rg-' + countDependentes + '" id="nu_rg' + countDependentes + '" value="" class="required nu_rg" size="30" placeholder="RG"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                 <input type="text" name="nu_cpf-' + countDependentes + '" id="nu_cpf' + countDependentes + '" value="" class="required nu_cpf" size="30" placeholder="CPF"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                 <input type="text" name="dt_nascimento-' + countDependentes + '" id="dt_nascimento' + countDependentes + '" value="" class="required date-picker" size="30" placeholder="Data Nascimento"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                 <select name="tp_sexo" id="tp_sexo">';
        htmlDependente += '                     <option value="0">Selecione o Sexo</option>';
        htmlDependente += '                     <option value="1">Masculino</option>';
        htmlDependente += '                     <option value="2">Feminino</option>';
        htmlDependente += '                 </select>';
        htmlDependente += '             </div>'
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                        <input type="text" name="nu_telefone-' + countDependentes + '" id="nu_telefone' + countDependentes + '" value="" class="required nu_telefone" size="30" placeholder="Telefone Residêncial"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                        <input type="text" name="nu_celular-' + countDependentes + '" id="nu_celular' + countDependentes + '" value="" class="required nu_celular" size="30" placeholder="Telefone Celular"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                 <select name="tipo_dependente-' + countDependentes + '" id="tipo_dependente-' + countDependentes + '" class="tipo_dependente" style="float: left;">';
        htmlDependente += '                     <option name="0" value="0">Selecione Tipo Dependente</option>';
        jQuery.each( dataTipoDependentes, function( key, value ) {
            if(dataContratoGog==value["co_seq_contrato_gog"]){
                htmlDependente += '             <option for="'+value["st_agregado"]+'" name="' + value["co_seq_tipo_dependentes"] + '" value="' + value["co_seq_tipo_dependentes"] + '" selected="selected">' + value["nm_tipo_dependente"] + '</option>';
            }else {
                htmlDependente += '             <option for="'+value["st_agregado"]+'" name="' + value["co_seq_tipo_dependentes"] + '" value="' + value["co_seq_tipo_dependentes"] + '">' + value["nm_tipo_dependente"] + '</option>';
            }
        });
        htmlDependente += '                 </select>';
        //htmlDependente += '                        <div class="st_agregado" style="float: left;"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u 12u$(mobile) dependencia'+countDependentes+'">';
        htmlDependente += '                        <input type="text" name="nm_email-' + countDependentes + '" id="nm_email' + countDependentes + '" value="" class="required" size="30" maxlength="50" placeholder="Email"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="12u$ dependencia'+countDependentes+'">';
        htmlDependente += '                 <input type="text" name="nu_cep" id="nu_cep" value="" class="required nu_cep" size="30" placeholder="CEP" onkeydown="cepKeyDown(this)" onkeyup="cepKeyUp(this)"/>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u dependencia'+countDependentes+'">';
        htmlDependente += '                 <div class="logradouro-cep form-linha"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u dependencia'+countDependentes+'">';
        htmlDependente += '                 <div class="bairro-cep form-linha"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u dependencia'+countDependentes+'">';
        htmlDependente += '                 <div class="localidade-cep form-linha"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="6u dependencia'+countDependentes+'">';
        htmlDependente += '                 <div class="uf-cep form-linha"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="12u$ dependencia'+countDependentes+'">';
        htmlDependente += '                 <div class="load-cep"></div>';
        htmlDependente += '             </div>';
        htmlDependente += '             <div class="load-cep dependencia'+countDependentes+'"></div>';
        htmlDependente += '             <div class="12u$ dependencia'+countDependentes+'" style="display:none;"></div>';*/
        //htmlDependente += '         </div>';
        if(start==0) {
            $("#insert-mais").before(htmlDependente);
            $(".nu_cep").mask("99999-999");
            //var sizeHeight = 1167+((countDependentes-1)*737);
            //$("#main").css("height", sizeHeight+"px");
            insertMask();
        }else{
            return htmlDependente;
        }
    }else{
        alert("Não é possivel inserir mais dependentes!");
        return "";
    }
}

function removeDependencia(){
    $(".dependencia"+countDependentes).remove();
    countDependentes--;
    var sizeHeight = 1167+((countDependentes-1)*737);
    $("#main").css("height", sizeHeight+"px");
}

function submitCadastroDependenteCliente(){
    jQuery("#dependenteCliente").submit();
}
