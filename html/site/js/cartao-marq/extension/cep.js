/**
 * Created by tony on 03/08/17.
 */


function cepKeyUp(obj){
    $(function() {
        var cepNow = $(obj).val();
        objCep = obj;
        cepNow = cepNow.replace("_", "");
        cepNow = cepNow.replace("-", "");
        cepNow = cepNow.replace(".", "");
        if ($(obj).parent().parent().parent().parent().find(".uf-cep").html() == "") {
            cep = "";
        }
        if (cepNow.length > 7 && cepNow != cep) {
            $(".load-cep").html("<img src='" + getUrlController() + "/gog/imagens/load.gif' width='77' />");
            ajaxGetDirect(funcaoBuscaCep, "https://viacep.com.br/ws/" + cepNow + "/json/");
            cep = cepNow;
        }
    });
}

function cepKeyDown(obj){
    $(function() {
        var cepNow = $(obj).val();
        cepNow = cepNow.replace("_", "");
        cepNow = cepNow.replace("-", "");
        cepNow = cepNow.replace(".", "");
        if (cepNow == "" || cepNow == "_______") {
            $(".logradouro-cep").html("");
            $(".bairro-cep").html("");
            $(".localidade-cep").html("");
            $(".uf-cep").html("");
            $(".complemento-cep").html("");
            $(".numero-cep").html("");
        }
    });
}

var funcaoBuscaCep = function(json){
    if (json != false) {
        if(json.erro != true) {
            if(json.logradouro==""){
                json.logradouro = "Sem Logradouro ";
            }
            if(json.bairro==""){
                json.bairro = "Sem Bairro";
            }
            $(".logradouro-cep").html("<b class='address-cep'>Logradouro: </b><div class='address-cep'>" + json.logradouro + "</div>");
            $(".bairro-cep").html("<b class='address-cep'>Bairro: </b><div class='address-cep'>" + json.bairro + "</div>");
            $(".localidade-cep").html("<b class='address-cep'>Localidade: </b><div class='address-cep'>" + json.localidade + "</div>");
            $(".uf-cep").html("<b class='address-cep'>UF: </b><div class='address-cep'>" + json.uf + "</div>");
            $(".complemento-cep").html('<input type="text" name="nm_complemento" id="nm_complemento" value="" class="input-block-level nm_complemento" size="30" placeholder="Complemento Endereço"/>');
            $(".numero-cep").html('<input type="text" name="nu_endereco" id="nu_endereco" value="" class="input-block-level nu_endereco" size="30" placeholder="Número Endereço"/>');
            dataEndereco = {"nm_complemento":"", "nu_endereco": "", "nm_logradouro": json.logradouro, "nm_bairro": json.bairro, "nm_localidade": json.localidade, "nm_uf": json.uf, "nu_cep": cep};
        }else{
            alert("CEP errado!");
            $(".logradouro-cep").html("");
            $(".bairro-cep").html("");
            $(".localidade-cep").html("");
            $(".uf-cep").html("");
            $(".complemento-cep").html("");
            $(".numero-cep").html("");
            dataEndereco = {};
        }
    }
    $(".load-cep").html("");
};