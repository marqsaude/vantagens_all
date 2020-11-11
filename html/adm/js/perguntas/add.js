/**
 * Created by tony on 31/10/17.
 */

function validaCadastroPerguntas(obj){
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
        var array = {"tx_pergunta": obj.tx_pergunta.value, "tx_resposta": obj.tx_resposta.value};
        ajaxPost(funcaoCadastroPerguntas, array, "/perguntas/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroPerguntas = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/perguntas/index";
    }
};

function submitCadastroPerguntas(){
    jQuery("#addPerguntas").submit();
}