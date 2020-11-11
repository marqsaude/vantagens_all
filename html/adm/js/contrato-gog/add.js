/**
 * Created by tony on 01/09/17.
 */

var procedimentos = [];
var OSName = "Unknown";

function validaCadastroContratoGog(obj){
    var html = "";
    if(obj.nm_contrato_gog.value==""){
        html += "Nome do Contrato Gog vazio!\n";
    }
    if(obj.nu_meses.value==""){
        html += "Número de meses vazio!\n";
    }
    if(obj.nu_valor.value==""){
        html += "Valor vazio!\n";
    }
    if(obj.nu_dependentes.value==""){
        html += "Número de dependentes vazio!\n";
    }
    if(procedimentos.length==0){
        html += "Não foi inserido nenhum procedimento!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        uploadImg(obj);
        var array = {"nm_contrato_gog": obj.nm_contrato_gog.value, "nu_meses": obj.nu_meses.value, "nu_valor": obj.nu_valor.value, "nu_dependentes": obj.nu_dependentes.value, "lk_contrato_gog": obj.lk_contrato_gog.value, "lk_img_contrato_gog": obj.lk_img_contrato_gog.value, "tx_contrato_gog": obj.tx_contrato_gog.value, "procedimento": procedimentos};
        ajaxPost(funcaoCadastroContratoGog, array, "/contrato-gog/ajax-add/", "/admin");
    }
    return false;
}

function uploadImg(obj){
    if(obj.lk_contrato_gog.files[0]!="" && obj.lk_contrato_gog.files[0]!=undefined){
        var form = new FormData();
        form.append('fileUpload', obj.lk_contrato_gog.files[0]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', getUrlController() + '/admin/contrato-gog/ajax-upload');
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
    if(obj.lk_img_contrato_gog.files[0]!="" && obj.lk_img_contrato_gog.files[0]!=undefined){
        var form = new FormData();
        form.append('fileUpload', obj.lk_img_contrato_gog.files[0]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', getUrlController() + '/admin/contrato-gog/ajax-upload-img');
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
}

var funcaoCadastroContratoGog = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/contrato-gog/index";
    }
};

function submitCadastroContratoGog(){
    jQuery("#addContratoGog").submit();
}

function addProcedimento(){
    var te = jQuery(".content-procedimento").find(".mais").html();
    if(typeof te != "undefined") {
        var idProcedimento=jQuery(".mais").attr("id");
        var nmProcedimento=jQuery(".mais span").html();
        var html = '';
        html += '<tr class="procedimento-table">';
        html += '   <td width="5%">' + idProcedimento + '</td>';
        html += '   <td width="82%">' + nmProcedimento + '</td>';
        html += '   <td width="13%">';
        html += '       <a href="' + getUrlController() + '/admin/procedimento/view/id/' + idProcedimento + '"><i class="icon-eye-open" title="Visualizar"></i></a>&nbsp;&nbsp;';
        html += '       <a href="javascript:void(0);" onclick="removeProcedimento(this);" style="color: #d9534f;" title="Excluir"><i class="icon-trash"></i></a>&nbsp;&nbsp;';
        html += '   </td>';
        html += '</tr>';
        jQuery(".table tbody tr").last().after(html);
        jQuery(".mais").remove();
        var procedimento = {"id": idProcedimento, "nome": nmProcedimento};
        procedimentos.push(procedimento);
    }
}

function removeProcedimento(obj){
    var idProcedimento=jQuery(obj).parent().parent().find("td").first().html();
    var nmProcedimento=jQuery(obj).parent().parent().find("td:eq( 1 )").html();
    var html = '';
    html += '<div class="procedimento" id="'+idProcedimento+'" onclick="procedimentoSelect(this);">';
    html += idProcedimento;
    html += '<span>'+nmProcedimento+'</span>';
    html += '</div>';
    jQuery(".content-procedimento div").last().after(html);
    if(jQuery(".content-procedimento div").length==0){
        jQuery(".content-procedimento").html(html);
    }else {
        jQuery(".content-procedimento div").last().after(html);
    }
    init();
    var i=0;
    $.each( procedimentos, function( key, value ) {
        if(idProcedimento==value.id){
            procedimentos.splice(i,1);
        }
        i++;
    });
}

$(document).ready(function() {
    $("#nu_meses").mask('99');
    $("#nu_dependentes").mask('99');
    $('input[type=file]').change(function(e){
        $in=$(this);
        $("#uploadFile").val($in.val());
    });
});

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
    var charCode = (evt.which) ? evt.which : evt.keyCode;
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

function procedimentoSelect(obj){
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

init();

function HandleBrowseClick()
{
    var fileinput = document.getElementById("pdf_file");
    fileinput.click();
}
function Handlechange()
{
    var fileinput = document.getElementById("pdf_file");
    var res="";
    res = fileinput.value.split("\\");
    var value=res.slice(-1).pop();
    $("#fileLabel").html(value);
}

function HandleBrowseClick2()
{
    var fileinput = document.getElementById("pdf_file2");
    fileinput.click();
}
function Handlechange2()
{
    var fileinput = document.getElementById("pdf_file2");
    var res="";
    res = fileinput.value.split("\\");
    var value=res.slice(-1).pop();
    $("#fileLabel2").html(value);
}