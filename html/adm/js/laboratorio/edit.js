/**
 * Created by tony on 31/08/17.
 */

function submitEditarLaboratorio(){
    jQuery("#editLaboratorio").submit();
}

function validaEditarLaboratorio(obj){
    var html = "";
    if(obj.nm_laboratorio.value==""){
        html += "Nome do Laboratorio vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"co_seq_laboratorio": obj.co_seq_laboratorio.value, "nm_laboratorio": obj.nm_laboratorio.value};
        ajaxPost(funcaoEditarLaboratorio, array, "/laboratorio/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarLaboratorio = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/laboratorio/index";
    }
};