/**
 * Created by tony on 13/10/17.
 */

function submitEditarMaisVoce(){
    jQuery("#editMaisVoce").submit();
}

function validaEditarMaisVoce(obj){
    var html = "";
    if(obj.nm_title.value==""){
        html += "Título Mais Você vazio!\n";
    }
    if(obj.nm_code_color.value==0){
        html += "Código da cor HTML vazia!\n";
    }
    if(obj.nm_code_color.value<3){
        html += "Código da cor HTML inválido!\n";
    }
    if(obj.tx_mais_voce.value==0){
        html += "Texto mais você vazia!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_title": obj.nm_title.value, "nm_code_color": obj.nm_code_color.value, "tx_mais_voce": obj.tx_mais_voce.value, "co_seq_mais_voce": obj.co_seq_mais_voce.value};
        ajaxPost(funcaoEditarMaisVoce, array, "/mais-voce/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarMaisVoce = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/mais-voce/index";
    }
};