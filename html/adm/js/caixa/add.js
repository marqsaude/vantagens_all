/**
 * Created by tony on 23/08/17.
 */

function submitCadastroCaixa(){
    jQuery("#addCaixa").submit();
}

function validaCadastroCaixa(obj){
    var html = "";
    if(obj.nm_caixa.value==""){
        html += "Nome do Caixa vazio!\n";
    }
    if(obj.co_empresa.value==0){
        html += "Selecione uma empresa!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_caixa": obj.nm_caixa.value, "co_empresa": obj.co_empresa.value};
        ajaxPost(funcaoCadastroCaixa, array, "/caixa/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroCaixa = function(json){
    if(json!=null){
        alert("Cadastrado com sucesso!");
        window.location.href = getUrlController() + "/admin/caixa/index";
    }
};