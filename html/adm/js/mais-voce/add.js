/**
 * Created by tony on 13/10/17.
 */

function validaCadastroMaisVoce(obj){
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
        var array = {"nm_title": obj.nm_title.value, "nm_code_color": obj.nm_code_color.value, "tx_mais_voce": obj.tx_mais_voce.value};
        ajaxPost(funcaoCadastroMaisVoce, array, "/mais-voce/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroMaisVoce = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/mais-voce/index";
    }
};

function submitCadastroMaisVoce(){
    jQuery("#addMaisVoce").submit();
}