/**
 * Created by tony on 24/08/17.
 */
var __obj;

function validaCadastroProcedimento(obj){
    __obj = obj;
    return checkIfExist();
}

var funcaoCadastroProcedimento = function(json){
    if(json!=null){
        alert("Cadastrado com sucesso!");
        window.location.href = getUrlController() + "/admin/procedimento/add";
    }
};

function submitCadastroProcedimento(){
    jQuery("#addProcedimento").submit();
}

function checkIfExist(){
    var array = {"procedimento": __obj.procedimento_select.value, "tipo_procedimento": __obj.tipo_procedimento.value};
    ajaxPost(funcaoCheckIfExist, array, "/procedimento/ajax-check/", "/admin");
    return false;
}

var funcaoCheckIfExist = function(json){
    if(json!=null){
        var html = "";
        if(json.data != null){
            html += "Procedimento já existe!\n";
        }else{
            if(__obj.nu_valor.value==0.00 || __obj.nu_valor.value=="" || __obj.nu_valor.value==0 || __obj.nu_valor.value=="0.00"){
                html += "É necessário inserir algum valor no procedimento!\n";
            }
            if(__obj.tipo_procedimento.value==0){
                html += "É necessário selecionar um tipo de procedimento!\n";
            }
            if(__obj.procedimento_select == null){
                html += "É necessário selecionar um procedimento!";
            }else {
                if (__obj.procedimento_select.value == 0) {
                    html += "É necessário selecionar um procedimento!";
                }
            }
        }
        if(html!=""){
            alert(html);
        }else{
            var array = {"procedimento": __obj.procedimento_select.value, "tipo_procedimento": __obj.tipo_procedimento.value, "nu_valor": __obj.nu_valor.value};
            ajaxPost(funcaoCadastroProcedimento, array, "/procedimento/ajax-add/", "/admin");
        }
    }
    return false;
};

function maskIt(component, e, mascara) {
    // Cancela se o evento for Backspace
    if (!e)
        var e = window.event;
    if (e.keyCode)
        code = e.keyCode;
    else if (e.which)
        code = e.which;

    // Variaveis da função
    var txt = component.value.replace(/[^\d]+/gi, '').reverse();
    var mask = mascara.reverse();
    var ret = "";
    txt = removeLastZeros(txt);
    // Loop na mascara para aplicar os caracteres
    for ( var x = 0, y = 0, z = mask.length; x < z && y < txt.length;) {
        if (mask.charAt(x) != '#' && mask.charAt(x) != '9') {
            ret += mask.charAt(x);
            x++;
        } else {
            ret += txt.charAt(y);
            y++;
            x++;
        }
    }
    component.value = ret.reverse();
    addZero(component);
}

function validaTeclado(component, evt, mascara) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //se for backspace sempre permite a ação do botão
    if(charCode == 8) {
        return true;
    }
    //Verifica se o valor do caractere nao corresponde a um numero
    //Caso nao corresponda retorna false
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    //verifica o tamanho do campo com a mascara
    //primeiro remove os caracteres especiais da mascara (fica apenas
    //o 9 e o #
    var maskClear = mascara.replace(/[^#9]+/gi, '');
    var txt = component.value.replace(/[^\d]+/gi, '');
    if(txt.length >= maskClear.length) {
        return false;
    }
    //caso não haja problema, aceita
    return true;
}

function addZero(component) {
    var value = component.value;
    if(value.length > 2) {
        return;
    }

    switch (value.length) {
        case 0:
            component.value = '0.00';
            break;
        case 1:
            component.value = '0.0' + value;
            break;
        case 2:
            component.value = '0.' + value;
            break;
    }
}

function removeLastZeros(valueReverse) {
    var returnNotReverse = "";
    var encontrouDifZero = false;
    for(x = (valueReverse.length - 1) ; x >= 0; x--) {

        if(valueReverse.charAt(x) == "0" && !encontrouDifZero) {
            continue;
        }
        encontrouDifZero = true;
        returnNotReverse += valueReverse.charAt(x);
    }
    return returnNotReverse.reverse();
}

function setFieldPosition(field) {
    field.selectionStart = field.value.length;
    field.selectionEnd = field.value.length;
}

String.prototype.reverse = function() {
    return this.split('').reverse().join('');
};

function validaTipoProcedimento(obj){
    if(jQuery(obj).val()==1){
        var array = {};
        ajaxPost(funcaoGetExame, array, "/exame/ajax-get/", "/admin");
    }
    if(jQuery(obj).val()==2){
        var array = {};
        ajaxPost(funcaoGetConsulta, array, "/consulta/ajax-get/", "/admin");
    }
    if(jQuery(obj).val()==3){
        var array = {};
        ajaxPost(funcaoGetLaboratorio, array, "/laboratorio/ajax-get/", "/admin");
    }
}

var funcaoGetExame = function(json){
    if(json!=null){
        var html = '<select class="form-control" name="procedimento_select" id="select-exame">';
        html += '<option value="0">Selecione um exame...</option>';
        $.each( json.data, function( key, value ) {
            html +=     '<option value="'+value["co_seq_exame"]+'">'+value["nm_exame"]+'</option>';
        });
        html += '</select>';
        jQuery("#procedimento_add").html(html);
    }
};

var funcaoGetConsulta = function(json){
    if(json!=null){
        var html = '<select class="form-control" name="procedimento_select" id="select-consulta">';
        html +=         '<option value="0">Selecione uma consulta...</option>';
        $.each( json.data, function( key, value ) {
            html +=     '<option value="'+value["co_seq_consulta"]+'">'+value["nm_consulta"]+'</option>';
        });
        html += '</select>';
        jQuery("#procedimento_add").html(html);
    }
};

var funcaoGetLaboratorio = function(json){
    if(json!=null){
        var html = '<select class="form-control" name="procedimento_select" id="select-laboratorio">';
        html +=         '<option value="0">Selecione um exame laboratorial...</option>';
        jQuery.each( json.data, function( key, value ) {
            html +=     '<option value="'+value.co_seq_laboratorio+'">'+value.nm_laboratorio+'</option>';
        });
        html += '</select>';
        jQuery("#procedimento_add").html(html);
    }
};