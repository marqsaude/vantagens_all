/**
 * Created by tony on 31/08/17.
 */

function submitEditarCaixa(){
    jQuery("#editCaixa").submit();
}

function validaEditarCaixa(obj){
    var html = "";
    if(obj.nm_caixa.value==""){
        html += "Nome do Caixa vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_caixa": obj.nm_caixa.value, "co_seq_caixa": obj.co_seq_caixa.value};
        ajaxPost(funcaoEditarCaixa, array, "/caixa/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarCaixa = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/caixa/index";
    }
};