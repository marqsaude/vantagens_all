/**
 * Created by tony on 14/09/17.
 */

function validaCadastroSenha(obj) {
    var html = "";
    if (obj.nm_senha.value == "") {
        html += "Senha não pode esta vazia!\n";
    }
    if (obj.nm_confirma_senha.value == "") {
        html += "Confirma Senha não pode esta vazia!\n";
    }
    if (obj.nm_confirma_senha.value != obj.nm_senha.value) {
        html += "Senha e Confirma Senha não são iguais!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_senha":obj.nm_senha.value, "nm_code":obj.nm_code.value};
        ajaxPost(funcaoValidaCadastroSenha, array, "/cliente/ajax-change-password/", "/default");
    }
    return false;
}

var funcaoValidaCadastroSenha = function(json) {
    if (json != null) {
        if (json.check == 1) {
            var html = '';
            html += '<div class="row-fluid" style="border-bottom: 17px solid #f5f5f5; border-top: 7px solid #f5f5f5;">';
            html += '   <div class="span12">';
            html += '       <h3 style="font-family:Tobago; margin-top:7px; text-align:center; color:#972a2b; text-shadow: 0 4px 1px #ffffff, 0 -4px 1px #ffffff, -4px 0 1px #ffffff, 4px 0 1px #ffffff;">Cadastro de Senha</h3>';
            html += '   </div>';
            html += '</div>';
            html += '<div class="row-fluid" style="height: 97px;">';
            html += '   <div class="span12">';
            html += '       &nbsp;';
            html += '   </div>';
            html += '</div>';
            html += '<div class="row-fluid">';
            html += '   <div class="span2"></div>';
            html += '   <div class="span8">';
            html += '       <div style="text-align: center;">';
            html += '           <h4>Senha salva com sucesso!</h4></br></br>';
            html += '           Logue clicando no ícone &nbsp;<a data-toggle="modal" href="#loginForm"><i class="icon-lock icon-2x"></i></a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <div class="span2"></div>';
            html += '</div>';
            jQuery("#main-senha").html(html);
        } else {
            alert("Ocorreu um erro, tente novamente, porfavor!");
        }
    }
};
