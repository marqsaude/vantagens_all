/**
 * Created by tony on 01/09/17.
 */

function submitEditarConsulta(){
    jQuery("#editConsulta").submit();
}

function validaEditarConsulta(obj){
    var html = "";
    if(obj.nm_consulta.value==""){
        html += "Nome da Consulta vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"co_seq_consulta": obj.co_seq_consulta.value, "nm_consulta": obj.nm_consulta.value};
        ajaxPost(funcaoEditarConsulta, array, "/consulta/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarConsulta = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/consulta/index";
    }
};