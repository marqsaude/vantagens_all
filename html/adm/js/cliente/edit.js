/**
 * Created by tony on 30/08/17.
 */
insertMask();

function validaEditarCliente(obj){
    var html = "";
    var array = new Array(3);
    if(obj.nm_cliente.value==""){
        html += "Nome do Cliente vazio!\n";
    }
    if(obj.dt_nascimento.value==""){
        html += "Data de Nascimento do Cliente vazio!\n";
    }
    if(obj.nu_rg.value==""){
        html += "RG do Cliente vazio!\n";
    }
    if(obj.nu_cpf.value==""){
        html += "CPF do Cliente vazio!\n";
    }
    if(obj.nu_celular.value==""){
        html += "Número do Celular vazio!\n";
    }
    if(obj.nm_email.value==""){
        html += "Email do Cliente vazio!\n";
    }
    if(obj.nu_cep.value==""){
        html += "CEP do Cliente não informado!\n";
    }else{
        if($(".logradouro-cep").html()==""){
            html += "CEP inválido. Tente novamente!\n";
        }
    }
    if(validarCPF(obj.nu_cpf.value)==false){
        html += "CPF inválido. Tente novamente!\n";
    }
    if(obj.tp_sexo.value==0){
        html += "Sexo não informado!\n";
    }
    if(validaEmail(obj.nm_email)==false){
        html += "Email inválido. Tente novamente!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var arrayCliente = {"nm_cliente":obj.nm_cliente.value, "dt_nascimento":obj.dt_nascimento.value, "nu_rg":obj.nu_rg.value, "nu_cpf":obj.nu_cpf.value, "nm_email":obj.nm_email.value, "tp_sexo":obj.tp_sexo.value, "co_usuario":obj.co_usuario.value};
        var arrayCep = {"nu_cep":obj.nu_cep.value, "nm_logradouro":obj.nm_logradouro.value, "nm_bairro":obj.nm_bairro.value, "nm_localidade":obj.nm_localidade.value, "nm_uf":obj.nm_uf.value};
        var arrayTelefone = {"nu_telefone":obj.nu_telefone.value, "nu_celular":obj.nu_celular.value, "nu_whatsapp":obj.nu_whatsapp.value};
        var arrayIds = {"co_seq_cep":obj.co_seq_cep.value, "co_seq_cliente":obj.co_seq_cliente.value};
        array = {"cliente": arrayCliente, "cep": arrayCep, "telefone": arrayTelefone, "ids": arrayIds};
        ajaxPost(funcaoEditUsuario, array, "/cliente/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditUsuario = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/index";
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

function validaRG(numero){

}

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

function submitEditCliente(){
    jQuery("#editCliente").submit();
}

function remove(str, sub) {
    i = str.indexOf(sub);
    r = "";
    if (i == -1) return str;
    r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
    return r;
}