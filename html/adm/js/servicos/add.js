/**
 * Created by tony on 01/09/17.
 */

function validaCadastroServicos(obj){
    alert('teete!');
    var html = "";
    if(obj.lk_servicos.files[0]!="" && obj.lk_servicos.files[0]!=undefined){
        var form = new FormData();
        form.append('fileUpload', obj.lk_servicos.files[0]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', getUrlController() + '/admin/servicos/ajax-upload');
        // quando o upload estiver completo
        xhr.upload.addEventListener("load", function () {
            console.log('upload complete!');
        }, false);
        // progresso
        xhr.upload.addEventListener("progress", function (evt) {
            if (evt.lengthComputable) {
                console.log(( evt.loaded / evt.total) * 100);
            }
            else {
                console.log("Error uploading.");
            }
        }, false);
        // envia o formulário
        xhr.send(form);
    }
    if(obj.nm_servicos.value==""){
        html += "Nome do Serviço vazio!\n";
    }
    if(obj.tx_servicos.value==""){
        html += "Fale sobre o Serviço!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"lk_servicos": obj.lk_servicos.value, "nm_servicos": obj.nm_servicos.value, "tx_servicos": obj.tx_servicos.value};
        ajaxPost(funcaoCadastroServicos, array, "/servicos/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroServicos = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/servicos/index";
    }
};

function submitCadastroServicos(){
    jQuery("#addServicos").submit();
}