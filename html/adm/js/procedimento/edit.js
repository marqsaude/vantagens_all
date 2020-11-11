/**
 * Created by tony on 26/10/17.
 */


function submitEditProcedimento(){
    jQuery("#editProcedimento").submit();
}

function validaEditProcedimento(obj){
    var html = "";
    if(obj.nu_valor.value==0.00 || obj.nu_valor.value=="" || obj.nu_valor.value==0 || obj.nu_valor.value=="0.00"){
        html += "É necessário inserir algum valor no procedimento!\n";
    }
    if(obj.nu_valor_real.value==0.00 || obj.nu_valor_real.value=="" || obj.nu_valor_real.value==0 || obj.nu_valor_real.value=="0.00"){
        //html += "É necessário inserir algum valor no procedimento real!\n";
    }
    if(html!=""){
        alert(html);
    }else{
        var valor = obj.nu_valor.value;
        valor = valor.replace(",", ".");
        var valorReal = obj.nu_valor_real.value;
        valorReal = valorReal.replace(",", ".");
        var array = {"nu_valor": valor, "nu_valor_real":valorReal, "co_seq_procedimento": obj.co_seq_procedimento.value, "prestadores": prestadores};
        ajaxPost(funcaoEditProcedimento, array, "/procedimento/ajax-edit/", "/admin");
    }
    return false;
}

var funcaoEditProcedimento = function(json){
    if(json!=null){
        alert("Editado com sucesso!");
        window.location.href = getUrlController() + "/admin/procedimento/index";
    }
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

function validaCadastroBlog(obj){

}

function addPrestador(){
    var te = jQuery(".content-prestador").find(".mais").html();
    if(typeof te != "undefined") {
        $(".mais").each(function( i ) {
            var idPrestador = jQuery(this).attr("id");
            var nmPrestador = jQuery(this).find("span").html();
            var html = '';
            html += '<tr class="prestador-table">';
            html += '   <td width="5%">' + idPrestador + '</td>';
            html += '   <td width="82%">' + nmPrestador + '</td>';
            html += '   <td width="13%">';
            html += '       <a href="' + getUrlController() + '/admin/prestador/view/id/' + idPrestador + '"><i class="icon-eye-open" title="Visualizar"></i></a>&nbsp;&nbsp;';
            html += '       <a href="javascript:void(0);" onclick="removePrestador(this);" style="color: #d9534f;" title="Excluir"><i class="icon-trash"></i></a>&nbsp;&nbsp;';
            html += '   </td>';
            html += '</tr>';
            jQuery(".table tbody tr").last().after(html);
            jQuery(".mais").remove();
            var prestador = {"id": idPrestador, "nome": nmPrestador};
            prestadores.push(prestador);
        });
    }
}

function removePrestador(obj){
    var idPrestador=jQuery(obj).parent().parent().find("td").first().html();
    var nmPrestador=jQuery(obj).parent().parent().find("td:eq( 1 )").html();
    var html = '';
    html += '<div class="prestador" id="'+idPrestador+'" onclick="prestadorSelect(this);">';
    html += idPrestador;
    html += '<span>'+nmPrestador+'</span>';
    html += '</div>';
    //jQuery(".content-prestador div").last().after(html);
    if(jQuery(".content-prestador div").length==0){
        jQuery(".content-prestador").html(html);
    }else {
        jQuery(".content-prestador div").last().after(html);
    }
    $(jQuery(obj).parent().parent()).remove();
    var i=0;
    $.each( prestadores, function( key, value ) {
        if(idPrestador==value.id){
            prestadores.splice(i,1);
        }
        i++;
    });
}

function prestadorSelect(obj){
    //console.debug(jQuery(this).attr("background-color", "rgb(255, 255, 255)"));
    if(jQuery(obj).css("background-color") == "rgb(255, 255, 255)"){
        jQuery(obj).css("background-color", "#30445f");
        jQuery(".content-data-procedimento").html("&nbsp;");
        jQuery(obj).removeClass("mais");
    }else {
        jQuery(".procedimento").css("background-color", "#30445f");
        jQuery(obj).css("background-color", "#ffffff");
        jQuery(".procedimento").removeClass("mais");
        jQuery(obj).addClass("mais");
    }
}

function init(){

    jQuery(function() {
        var heightSelect = jQuery("#content-select").height();
        jQuery("#content-mais").height(heightSelect);
    });

    if (window.navigator.userAgent.indexOf("Windows NT 10.0")!= -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Windows NT 6.2") != -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Windows NT 6.1") != -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Windows NT 6.0") != -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Windows NT 5.1") != -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Windows NT 5.0") != -1) OSName="Windows";
    if (window.navigator.userAgent.indexOf("Mac")            != -1) OSName="Mac";
    if (window.navigator.userAgent.indexOf("X11")            != -1) OSName="Unix";
    if (window.navigator.userAgent.indexOf("Linux")          != -1) OSName="Linux";

}

init();