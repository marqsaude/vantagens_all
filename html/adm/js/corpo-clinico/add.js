/**
 * Created by tony on 24/08/17.
 */

function validaCadastroCorpoClinico(obj){
    var html = "";
    if(obj.nm_corpo_clinico.value==""){
        html += "Nome do Corpo Clínico vazio!\n";
    }
    if(obj.tipoCorpoClinico.value==0){
        html += "Tipo do Corpo Clínico não foi selecinado!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_corpo_clinico": obj.nm_corpo_clinico.value, "co_tipo_corpo_clinico": obj.tipoCorpoClinico.value, "nu_login": 0};
        ajaxPost(funcaoCadastroCorpoClinico, array, "/corpo-clinico/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroCorpoClinico = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/corpo-clinico/index";
    }
};

function submitCadastroCorpoClinico(){
    jQuery("#addCorpoClinico").submit();
}