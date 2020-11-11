/**
 * Created by tony on 29/03/17.
 */

var pathAdmin = "";
if(jQuery("#valida").html()=="1"){
    pathAdmin = "/gog";
}else{
    pathAdmin = "gog";
}

var funcaoLogar = function (json) {
    if (json != false) {
        if(json.type==2){
            jQuery(function() {
                jQuery("#erroMessage").css("color", "red");
                jQuery("#erroMessage").html("Erro ao tentar fazer o login!");
            });
        }else{
            window.location.assign(getUrlController()+"/gog");
        }
    }
};

function validLogin(obj){
    var html = "";
    var teste = false;
    if(teste==true){
        alert("Logo, estaremos disponibilizando esta funcionalidade!");
    }else{
        if(obj.usuarioLogin.value==""){
            html += "Não foi informado o usuário!\n";
        }
        if(obj.senhaLogin.value==""){
            html += "Não foi informado a senha!";
        }
        if(html==""){
            var array = {"nm_login":obj.usuarioLogin.value, "nm_senha":obj.senhaLogin.value, "requisicao":"normal"};
            ajaxPost(funcaoLogar, array, "/login/logar/", "/gog");
        }else {
            alert(html);
        }
    }
    return false;
}