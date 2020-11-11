/**
 * Created by tony on 01/09/17.
 */

function submitEditarCorpoClinico(){
    jQuery("#editCorpoClinico").submit();
}

function validaEditarCorpoClinico(obj){
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
        var array = {"co_seq_corpo_clinico": obj.co_seq_corpo_clinico.value, "nm_corpo_clinico": obj.nm_corpo_clinico.value, "co_tipo_corpo_clinico": obj.tipoCorpoClinico.value};
        ajaxPost(funcaoEditarCorpoClinico, array, "/corpo-clinico/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarCorpoClinico = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/corpo-clinico/index";
    }
};