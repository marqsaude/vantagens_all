/**
 * Created by tony on 29/11/17.
 */

function validaCancelContrato(obj){
    var html = "";
    var agree = false;
    if(obj.cancel.value == "1"){
        agree=confirm("Seu contrato será cancelado...");
    }
    if(html=="" && agree==true){
        var array = {"co_seq_acordo": obj.co_seq_acordo.value, "co_seq_cliente": obj.co_seq_cliente.value};
        ajaxPost(funcaoCancelContrato, array, "/contrato-gog/ajax-cancel/", "/admin");
    }else{
        if(agree == false){
            window.location.href = getUrlController() + "/admin/index";
        }else{
            alert(html);
        }
    }
    return false;
}

function submitCancelContrato(){
    jQuery("#cancelContrato").submit();
}

var funcaoCancelContrato = function(json){
    if(json!=null){
        alert("Contrato cancelado com Sucesso!");
        window.location.href = getUrlController() + "/admin/login/logout";
    }
};