/**
 * Created by tony on 31/08/17.
 */

function activeCaixa(id){
    var array = {"co_seq_caixa": id};
    ajaxPost(funcaoActiveCaixa, array, "/caixa/ajax-active/", "/admin");
}

var funcaoActiveCaixa = function(json){
    if(json!=null){
        alert("Ativado com Sucesso!");
        window.location.href = getUrlController() + "/admin/caixa/index";
    }
};