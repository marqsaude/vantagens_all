/**
 * Created by tony on 31/10/17.
 */

function submitEditarPerguntas(){
    jQuery("#editPergunta").submit();
}

function validaEditarPerguntas(obj){
    var html = "";
    if(obj.tx_pergunta.value==""){
        html += "Pergunta esta vazio!\n";
    }
    if(obj.tx_resposta.value==""){
        html += "Resposta esta vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"tx_pergunta": obj.tx_pergunta.value, "tx_resposta": obj.tx_resposta.value, "co_seq_perguntas": obj.co_seq_perguntas.value};
        ajaxPost(funcaoEditarPerguntas, array, "/perguntas/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarPerguntas = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/perguntas/index";
    }
};