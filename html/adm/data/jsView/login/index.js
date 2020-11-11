/**
 * Created by tony on 26/08/15.
 */

var pathAdmin = "";
if(jQuery("#valida").html()=="1"){
    pathAdmin = "/admin";
}else{
    pathAdmin = "admin";
}

var funcaoLogar = function (json) {
    if (json != false) {
        if(json.type==2){
            jQuery(function() {
                jQuery("#erroMessage").css("color", "red");
                jQuery("#erroMessage").html("Erro ao tentar fazer o login!");
            });
        }else{
            window.location.assign(getUrlController()+"/admin");
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
            ajaxPostt(funcaoLogar, array, "/login/logar/");
        }else {
            alert(html);
        }
    }
    return false;
}

/**
 * Ajax com post
 */
function ajaxPostt(funcao, array, action, model){
    if(model == undefined){model="";}
    jQuery(function(){
        jQuery.ajax({
            url: getUrlController()+"/admin"+action,
            dataType: "json",
            type: "post",
            data:array,
            beforeSend: function() {
            },
            success: function(json){
                funcao(json);
            }
        });
    });
    return false;
}