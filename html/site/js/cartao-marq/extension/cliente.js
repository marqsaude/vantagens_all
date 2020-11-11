/**
 * Created by tony on 03/08/17.
 */

var checkCPF = false;
var objClientForm = null;

function validaCliente(obj){
    objClientForm = obj;
    isExistCPF();
    return false;
}

var funcaoValidDDD = function(json){
    var html ="";
    if(json != ""){
        var data = json.data;
        if(data.telefone==false){
            html += "DDD informado do Telefone não existe!\n";
        }
        if(data.celular==false){
            html += "DDD informado do Celular não existe!\n";
        }
        if(arrayTelefone.nu_whatsapp!="") {
            if (data.whatsapp == false) {
                html += "DDD informado do WhatsApp não existe!\n";
            }
        }
        if(html != ""){
            alert(html);
        }else{
            checkVantagens();
        }
    }else{

    }
};

function validDDD(){
    var telefone = arrayTelefone.nu_telefone;
    var celular = arrayTelefone.nu_celular;
    var whatsapp = arrayTelefone.nu_whatsapp;
    var dddTelefone = telefone.substring(telefone.lastIndexOf("(")+1,telefone.lastIndexOf(")"));
    var dddCelular = celular.substring(celular.lastIndexOf("(")+1,celular.lastIndexOf(")"));
    var dddWhatsapp = whatsapp.substring(whatsapp.lastIndexOf("(")+1,whatsapp.lastIndexOf(")"));
    var array = {"dddTelefone":dddTelefone, "dddCelular":dddCelular, "dddWhatsapp":dddWhatsapp};
    ajaxPost(funcaoValidDDD, array, "/cartao-marq/ajax-verify-ddd/", "/default");
}

function validaEmail(field) {
    usuario = field.value.substring(0, field.value.indexOf("@"));
    dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);

    if ((usuario.length >=1) &&
        (dominio.length >=3) &&
        (usuario.search("@")==-1) &&
        (dominio.search("@")==-1) &&
        (usuario.search(" ")==-1) &&
        (dominio.search(" ")==-1) &&
        (dominio.search(".")!=-1) &&
        (dominio.indexOf(".") >=1)&&
        (dominio.lastIndexOf(".") < dominio.length - 1)) {
        return true;
    }
    else{
        return false;
    }
}

function isExistCPF() {
    var array = {"cpf":objClientForm.nu_cpf.value};
    ajaxPost(funcaoIsExistCPF, array, "/cliente/ajax-is-exist-cpf/", "/default");
}

var funcaoIsExistCPF = function (json) {
    if(json != ""){
        var html = "";
        if(objClientForm.nm_cliente.value==""){
            html += "Nome do Cliente vazio!\n";
        }
        if(objClientForm.dt_nascimento.value==""){
            html += "Data de Nascimento do Cliente vazio!\n";
        }
        if(objClientForm.nu_rg.value==""){
            html += "RG do Cliente vazio!\n";
        }
        if(objClientForm.nu_cpf.value==""){
            html += "CPF do Cliente vazio!\n";
        }
        if(objClientForm.nu_celular.value==""){
            html += "Número do Celular vazio!\n";
        }
        if(objClientForm.nm_email.value==""){
            html += "Email do Cliente vazio!\n";
        }
        if(validarCPF(objClientForm.nu_cpf.value) == false){
            html += "CPF inválido. Tente novamente!\n";
        }
        if(json.check == 2){
            html += "Cliente já cadastrado, por gentileza entrar em contato com a nossa Central (61) 3561-3649!\n";
        }
        if(objClientForm.nu_cep.value==""){
            html += "CEP do Cliente não informado!\n";
        }else{
            if($(".logradouro-cep").html()==""){
                html += "CEP inválido. Tente novamente!\n";
            }
        }
        if(objClientForm.tp_sexo.value==0){
            html += "Sexo não informado!\n";
        }
        if(validaEmail(objClientForm.nm_email)==false){
            html += "Email inválido. Tente novamente!\n";
        }
        if(html != "") {
            alert(html);
        }else{
            dataEndereco.nm_complemento = objClientForm.nm_complemento.value;
            dataEndereco.nu_endereco = objClientForm.nu_endereco.value;
            arrayCliente = {"nm_cliente":objClientForm.nm_cliente.value, "dt_nascimento":objClientForm.dt_nascimento.value, "nu_rg":objClientForm.nu_rg.value, "nu_cpf":objClientForm.nu_cpf.value, "nm_email":objClientForm.nm_email.value, "tp_sexo":objClientForm.tp_sexo.value};
            arrayCep = {"nu_cep":objClientForm.nu_cep.value, "nm_complemento":objClientForm.nm_complemento.value, "nu_endereco":objClientForm.nu_endereco.value, "nm_logradouro":$(".logradouro-cep td").last().html(), "nm_bairro":$(".bairro-cep td").last().html(), "nm_localidade":$(".localidade-cep td").last().html(), "nm_uf":$(".uf-cep td").last().html()};
            arrayTelefone = {"nu_telefone":objClientForm.nu_telefone.value, "nu_celular":objClientForm.nu_celular.value, "nu_whatsapp":objClientForm.nu_whatsapp.value};
            validDDD();
        }
    }
};

function validarCPF(cpf){
    var filtro = /^\d{3}.\d{3}.\d{3}-\d{2}$/i;
    if(!filtro.test(cpf)){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }

    cpf = remove(cpf, ".");
    cpf = remove(cpf, "-");

    if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
        cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
        cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
        cpf == "88888888888" || cpf == "99999999999"){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }

    soma = 0;
    for(i = 0; i < 9; i++)
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    resto = 11 - (soma % 11);
    if(resto == 10 || resto == 11)
        resto = 0;
    if(resto != parseInt(cpf.charAt(9))){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }
    soma = 0;
    for(i = 0; i < 10; i ++)
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    if(resto == 10 || resto == 11)
        resto = 0;
    if(resto != parseInt(cpf.charAt(10))){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }
    return true;
}

function mountHtmlCliente(){
    var htmlCliente = "";
    htmlCliente += '<form onSubmit="return validaCliente(this);" action="javascript:void(0);" method="post" class="contact-form" id="main-contact-form" name="contact-form">';
    //htmlCliente += '    <div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
    //htmlCliente += '        <div class="span12">';
    //htmlCliente += '            <h3 style="font-family:Tobago; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Cadastro</h3>';
    //htmlCliente += '        </div>';
    //htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span12">';
    htmlCliente += '            &nbsp;';
    htmlCliente += '        </div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span12">';
    htmlCliente += '            <div class="status alert alert-success" style="display: none"></div>';
    htmlCliente += '        </div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span8">';
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nm_cliente" id="nm_cliente" value="" class="input-block-level nm_cliente" required="required" maxlength="80" placeholder="Nome" />';
    }else{
        htmlCliente += '            <input type="text" name="nm_cliente" id="nm_cliente" value="'+arrayCliente.nm_cliente+'" class="input-block-level nm_cliente" required="required" maxlength="80" placeholder="Nome" />';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span4">';
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nu_rg" id="nu_rg" value="" class="input-block-level nu_rg" size="30" required="required" placeholder="RG"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_rg" id="nu_rg" value="'+arrayCliente.nu_rg+'" class="input-block-level nu_rg" size="30" required="required" placeholder="RG"/>';
    }
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="dt_nascimento" id="dt_nascimento" value="" class="input-block-level date-picker" size="30" placeholder="Data Nascimento" required="required"/>';
    }else{
        htmlCliente += '            <input type="text" name="dt_nascimento" id="dt_nascimento" value="'+arrayCliente.dt_nascimento+'" class="input-block-level date-picker" size="30" placeholder="Data Nascimento" required="required"/>';
    }
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nu_telefone" id="nu_telefone" value="" class="required nu_telefone input-block-level" size="30" placeholder="Telefone Residêncial" required="required"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_telefone" id="nu_telefone" value="'+arrayTelefone.nu_telefone+'" class="required nu_telefone input-block-level" size="30" placeholder="Telefone Residêncial" required="required"/>';
    }
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nu_whatsapp" id="nu_whatsapp" value="" class="required nu_whatsapp input-block-level" size="30" placeholder="WhatsApp"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_whatsapp" id="nu_whatsapp" value="'+arrayTelefone.nu_whatsapp+'" class="required nu_whatsapp input-block-level" size="30" placeholder="WhatsApp"/>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span4">';
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nu_cpf" id="nu_cpf" value="" class="input-block-level nu_cpf" size="30" required="required" placeholder="CPF"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_cpf" id="nu_cpf" value="'+arrayCliente.nu_cpf+'" class="input-block-level nu_cpf" size="30" required="required" placeholder="CPF"/>';
    }
    htmlCliente += '            <select name="tp_sexo" id="tp_sexo" class="input-block-level" required="required">';
    if(arrayCliente==null) {
        htmlCliente += '                <option value="0">Selecione o Sexo</option>';
        htmlCliente += '                <option value="1">Masculino</option>';
        htmlCliente += '                <option value="2">Feminino</option>';
    }else{
        htmlCliente += '                <option value="0">Selecione o Sexo</option>';
        if(arrayCliente.tp_sexo==1){
            htmlCliente += '                <option value="1" selected>Masculino</option>';
        }else {
            htmlCliente += '                <option value="1">Masculino</option>';
        }
        if(arrayCliente.tp_sexo==2){
            htmlCliente += '                <option value="2" selected>Feminino</option>';
        }else{
            htmlCliente += '                <option value="2">Feminino</option>';
        }
    }
    htmlCliente += '            </select>';
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nu_celular" id="nu_celular" value="" class="input-block-level nu_celular" size="30" placeholder="Telefone Celular" required="required"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_celular" id="nu_celular" value="'+arrayTelefone.nu_celular+'" class="input-block-level nu_celular" size="30" placeholder="Telefone Celular" required="required"/>';
    }
    if(arrayCliente==null) {
        htmlCliente += '            <input type="text" name="nm_email" id="nm_email" value="" class="input-block-level nm_email" size="30" maxlength="50" placeholder="Email" required="required"/>';
    }else{
        htmlCliente += '            <input type="text" name="nm_email" id="nm_email" value="'+arrayCliente.nm_email+'" class="input-block-level nm_email" size="30" maxlength="50" placeholder="Email" required="required"/>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span8">';
    if(dataEndereco.nu_cep==null) {
        htmlCliente += '            <input type="text" name="nu_cep" id="nu_cep" value="" class="input-block-level nu_cep" size="30" placeholder="CEP" onkeydown="cepKeyDown(this)" onkeyup="cepKeyUp(this)"  required="required"/>';
    }else{
        htmlCliente += '            <input type="text" name="nu_cep" id="nu_cep" value="'+dataEndereco.nu_cep+'" class="input-block-level nu_cep" size="30" placeholder="CEP" onkeydown="cepKeyDown(this)" onkeyup="cepKeyUp(this)"  required="required"/>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span4">';
    htmlCliente += '            <div class="load-cep"></div>';
    if(dataEndereco.nm_logradouro!=null) {
        htmlCliente += '            <div class="logradouro-cep form-linha"><b class="address-cep">Logradouro: </b><div class="address-cep">' + dataEndereco.nm_logradouro +'</div></div>';
    }else{
        htmlCliente += '            <div class="logradouro-cep form-linha"></div>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span4">';
    if(dataEndereco.nm_bairro!=null) {
        htmlCliente += '            <div class="bairro-cep form-linha"><b class="address-cep">Bairro: </b><div class="address-cep">' + dataEndereco.nm_bairro +'</div></div>';
    }else{
        htmlCliente += '            <div class="bairro-cep form-linha"></div>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span4">';
    if(dataEndereco.nm_localidade!=null) {
        htmlCliente += '            <div class="localidade-cep form-linha"><b class="address-cep">Localidade: </b><div class="address-cep">' + dataEndereco.nm_localidade +'</div></div>';
    }else{
        htmlCliente += '            <div class="localidade-cep form-linha"></div>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span4">';
    if(dataEndereco.nm_uf!=null) {
        htmlCliente += '            <div class="uf-cep form-linha"><b class="address-cep">UF: </b><div class="address-cep">' + dataEndereco.nm_uf +'</div></div>';
    }else{
        htmlCliente += '            <div class="uf-cep form-linha"></div>';
    }
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '        <div class="span4">';
    htmlCliente += '            <input type="text" name="nm_complemento" id="nm_complemento" value="'+dataEndereco.nm_complemento+'" class="input-block-level nm_complemento" size="30" placeholder="Complemento Endereço"/>';
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span4">';
    htmlCliente += '            <input type="text" name="nu_endereco" id="nu_endereco" value="'+dataEndereco.nu_endereco+'" class="input-block-level nu_endereco" size="30" placeholder="Número Endereço"/>';
    htmlCliente += '        </div>';
    htmlCliente += '        <div class="span2"></div>';
    htmlCliente += '    </div>';
    htmlCliente += '    <div class="row-fluid">';
    htmlCliente += '        <div class="span6"></div>';
    htmlCliente += '        <div class="span6">';
    htmlCliente += '            <button type="submit" class="btn btn-primary btn-large pull-right" style="margin-right: 200px;">Próximo >></button>';
    htmlCliente += '        </div>';
    htmlCliente += '    </div>';
    htmlCliente += '</form>';

    $(function(){
        $("#cartao-vantagem").html(htmlCliente);
    });
    init("cliente");
}

$(window).ready(function() {
    $('#loading').hide();
});