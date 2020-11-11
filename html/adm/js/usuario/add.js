/**
 * Created by tony on 22/08/17.
 */


function validaCadastroUsuario(obj){
    var html="";
    if(obj.nm_usuario.value==""){
        html += "Nome do Usuário não informado!\n";
    }
    if(obj.nm_login.value==""){
        html += "Nome do Login não informado!\n";
    }
    if(obj.nm_senha.value==""){
        html += "Senha não informada!\n";
    }
    if(obj.nm_confirma_senha.value==""){
        html += "Confirmação de Senha não informada!\n";
    }
    if(obj.nm_senha.value!=obj.nm_confirma_senha.value){
        html += "Senha e Confirma Senha estão diferente!\n";
    }
    if(obj.tipoUsuario.value==0){
        html += "É necessario selecionar um tipo de usuário!\n";
    }
    if(html==""){
        var array = {"nm_senha":obj.nm_senha.value, "nm_usuario":obj.nm_usuario.value, "nm_login":obj.nm_login.value, "co_tipo_usuario": obj.tipoUsuario.value};
        ajaxPost(funcaoCadastraUsuario, array, "/usuario/ajax-add/", "/admin");
    }else{
        alert(html);
    }
    return false;
}

function submitCadastroUsuario(){
    jQuery("#addUsuario").submit();
}

var funcaoCadastraUsuario = function(json) {
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/usuario/add";
    }
};