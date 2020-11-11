/**
 * Created by tony on 16/11/17.
 */


function validaDependentes(obj){
    var html = "";
    var objFinal = {};
    var inputs = obj.getElementsByTagName('input');
    if (inputs[0].value == "") {
        html += "Nome do Dependente vazio!\n";
    }
    if (inputs[1].value == "") {
        html += "RG do Dependente vazio!\n";
    }
    if (inputs[2].value == "") {
        html += "Data de Nascimento do Dependente vazio!\n";
    }
    if (inputs[3].value == "") {
        html += "CPF do Dependente vazio!\n";
    }else{
        if(validarCPF(inputs[3].value)==false){
            html += "CPF inválido. Tente novamente!\n";
        }
    }
    if ($("#tipo_dependente").val() == 0) {
        html += "É necessario selecionar um tipo do dependente!\n";
    }
    if (inputs[4].value == "") {
        html += "Email do Dependente vazio!\n";
    }
    objFinal = getAllInput(obj);
    //objFinal["logradouro"] = $(".logradouro-cep div").html();
    //objFinal["bairro"] = $(".bairro-cep div").html();
    //objFinal["localidade"] = $(".localidade-cep div").html();
    //objFinal["uf"] = $(".uf-cep div").html();
    if (html != "") {
        alert(html);
    } else {
        var array = objFinal;
        ajaxPost(submitCadastroDependentes, array, "/dependente/ajax-add-cliente/", "/admin");
    }
    return false;
}

var submitCadastroDependentes = function(json){
    if(json!=null){
        if(json.st_dependentes == 2){
            alert("Não pode cadastrar mais dependentes!");
            window.location.href = getUrlController() + "/admin/dependente/cliente";
        }else{
            alert("Cadastrado com sucesso!");
            window.location.href = getUrlController() + "/admin/dependente/index";
        }
    }
};

function submitCadastroDependenteCliente(){
    jQuery("#dependenteCliente").submit();
}

$(function () {
    $("#mais-dependentes").click(function () {
        insertDependente(0);
    });
    $("#menos-dependentes").click(function () {
        removeDependencia();
    });
    $(".tipo_dependente").change(function(){
        if($(this).find("option:selected").attr("value")==0){
            $(this).parent().find(".st_agregado").html("");
        }else {
            if ($(this).find("option:selected").attr("for") == 1) {
                $(this).parent().find(".st_agregado").html("&nbsp;&nbsp; Agregado");
            } else {
                $(this).parent().find(".st_agregado").html("&nbsp;&nbsp; Dependente");
            }
        }
    });
    insertMask();
});
var funcaoGetTipoDependente = function(json){
    if(json!=null){
        dataTipoDependentes = json.data;
        var html = '<option name="0" value="0">Selecione Tipo Dependente</option>';
        jQuery.each( dataTipoDependentes, function( key, value ) {
            html += '<option for="'+value["st_agregado"]+'" name="'+value["co_seq_tipo_dependentes"]+'" value="'+value["co_seq_tipo_dependentes"]+'">'+value["nm_tipo_dependente"]+'</option>';
        });
        $("#tipo_dependente").html(html);
    }
};
ajaxPost(funcaoGetTipoDependente, array, "/dependente/ajax-get-tipo-dependente/", "/admin");

function insertMask() {
    jQuery('.date-picker').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "-100:+0",
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior',
        currentText: 'Mês Atual',
        closeText: 'Atualizar'
    });
    jQuery(".nu_cpf").mask("999.999.999-99");
    jQuery(".nu_cep").mask("99.999-999");
    jQuery(".nu_rg").mask("999999999999");
    jQuery(".nu_endereco").mask("9999999");
}

function validarCPF(cpf){
    var filtro = /^\d{3}.\d{3}.\d{3}-\d{2}$/i;
    if(!filtro.test(cpf)){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }

    cpf = remove(cpf, ".");
    cpf = remove(cpf, "-");

    if(cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" ||
        cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" ||
        cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" ||
        cpf == "88888888888" || cpf == "99999999999"){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }

    soma = 0;
    for(i = 0; i < 9; i++)
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    resto = 11 - (soma % 11);
    if(resto == 10 || resto == 11)
        resto = 0;
    if(resto != parseInt(cpf.charAt(9))){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }
    soma = 0;
    for(i = 0; i < 10; i ++)
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    if(resto == 10 || resto == 11)
        resto = 0;
    if(resto != parseInt(cpf.charAt(10))){
        //window.alert("CPF inválido. Tente novamente.");
        return false;
    }
    return true;
}

function remove(str, sub) {
    i = str.indexOf(sub);
    r = "";
    if (i == -1) return str;
    r += str.substring(0,i) + remove(str.substring(i + sub.length), sub);
    return r;
}