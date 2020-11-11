/**
 * Created by tony on 10/08/15.
 */

var objContatoForm;

var funcaoValidSendContato = function (json) {
    if (json != false) {
        if(json != undefined){
            objContatoForm.nu_telefone.value = "";
            objContatoForm.nu_whatsapp.value = "";
            objContatoForm.nm_nome.value = "";
            objContatoForm.nm_email.value = "";
            objContatoForm.tx_mensagem.value = "";
            alert("Enviado com sucesso!");
        }
    }
};

function validSendContato(obj){
    var html = "";
    objContatoForm = obj;
    if(obj.nm_nome.value==""){
        html += "Nome não informado!\n";
    }
    if(obj.nm_email.value==""){
        html += "Email não informado!\n";
    }else {
        if (validaEmail(obj.nm_email) == false) {
            html += "Email não é válido\n"
        }
    }
    if(obj.nu_telefone.value==""){
        html += "Telefone não informado!\n";
    }
    if(obj.tx_mensagem.value==""){
        html += "Mensagem não informada!";
    }
    if(html==""){
        var array = {"nm_nome":obj.nm_nome.value, "nm_email":obj.nm_email.value, "nu_telefone":obj.nu_telefone.value, "tx_mensagem":obj.tx_mensagem.value, "nu_whatsapp":obj.nu_whatsapp.value};
        ajaxPost(funcaoValidSendContato, array, "/contato/ajax-send-contato/", "/default");
    }else {
        alert(html);
    }
    return false;
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

function maskContato(){
    jQuery(function(){
        jQuery("#nu_telefone").mask("(00) 0000-00009");
        jQuery("#nu_telefone").keyup(function(event) {
            if(jQuery(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                jQuery('#nu_telefone').mask('(00) 00000-0009');
            }else{
                jQuery('#nu_telefone').mask('(00) 0000-00009');
            }
        });
        jQuery("#nu_whatsapp").mask("(00) 0000-00009");
        jQuery("#nu_whatsapp").keyup(function(event) {
            if(jQuery(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                jQuery('#nu_whatsapp').mask('(00) 00000-0009');
            }else{
                jQuery('#nu_whatsapp').mask('(00) 0000-00009');
            }
        });
    });
}

maskContato();