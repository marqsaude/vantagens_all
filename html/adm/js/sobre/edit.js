/**
 * Created by tony on 31/08/17.
 */

function submitEditarSobre(){
    jQuery("#editSobre").submit();
}

function validaEditarSobre(obj){
    var html = "";
    if(obj.tx_sobre.value==""){
        html += "Texto do Sobre vazio!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"co_seq_sobre": obj.co_seq_sobre.value, "tx_sobre": obj.tx_sobre.value};
        ajaxPost(funcaoEditarSobre, array, "/sobre/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditarSobre = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/sobre/edit";
    }
};