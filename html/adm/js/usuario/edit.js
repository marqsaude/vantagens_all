/**
 * Created by tony on 22/08/17.
 */
var idUsuario=jQuery("#co_seq_usuario").val();

function validaEditarUsuario(obj){
    var html = "";
    if(obj.nm_senha.value!=""){
        if(obj.nm_senha.value!=obj.nm_confirma_senha.value){
            html += "Senha e Confirma Senha estão diferente!\n";
        }
        if(obj.tipoUsuario.value==0){
            html += "É necessario selecionar um tipo de usuário!\n";
        }
    }
    if(html==""){
        idUsuario=obj.co_seq_usuario.value;
        var array = {"nm_senha":obj.nm_senha.value, "co_tipo_usuario": obj.tipoUsuario.value, "co_seq_usuario": obj.co_seq_usuario.value};
        ajaxPost(funcaoEditarUsuario, array, "/usuario/ajax-edit/", "/admin");
    }else{
        alert(html);
    }
    return false;
}

function submitEditarUsuario(){
    jQuery("#editUsuario").submit();
}

var funcaoEditarUsuario = function(json){
    if(json!=null){
        alert("Editado com Sucesso!");
        window.location.href = getUrlController() + "/admin/usuario/edit/id/"+idUsuario;
    }
};