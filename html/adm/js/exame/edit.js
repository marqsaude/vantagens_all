/**
 * Created by tony on 31/08/17.
 */

function submitEditarExame(){
    jQuery("#editExame").submit();
}

function validaEditarExame(obj){
    var html = "";
    if(obj.nm_exame.value==""){
        html += "Nome do Exame vazio!\n";
    }
    if(obj.tipoExame.value==0){
        html += "É necessário selecionar um tipo de exame!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"co_seq_exame": obj.co_seq_exame.value, "nm_exame": obj.nm_exame.value, "co_tipo_exame":obj.tipoExame.value};
        ajaxPost(funcaoEditarExame, array, "/exame/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarExame = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/exame/index";
    }
};