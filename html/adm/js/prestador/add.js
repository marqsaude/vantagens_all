/**
 * Created by tony on 01/09/17.
 */

var procedimentos = [];
var OSName = "Unknown";

function validaCadastroPrestador(obj){
    var html = "";
    if(obj.lk_prestador.files[0]!="" && obj.lk_prestador.files[0]!=undefined){
        var form = new FormData();
        form.append('fileUpload', obj.lk_prestador.files[0]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', getUrlController() + '/admin/prestador/ajax-upload');
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
    if(obj.nm_prestador.value==""){
        html += "Nome do Prestador vazio!\n";
    }
    if(obj.nm_site.value==""){
        html += "Site do Prestador vazio!\n";
    }
    if(obj.tx_sobre.value==""){
        html += "Fale sobre o Prestador!\n";
    }
    if(procedimentos.length==0){
        html += "Não foi inserido nenhum procedimento!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"lk_prestador": obj.lk_prestador.value, "nm_prestador": obj.nm_prestador.value, "tx_sobre": obj.tx_sobre.value, "nm_site": obj.nm_site.value, "procedimento": procedimentos};
        ajaxPost(funcaoCadastroPrestador, array, "/prestador/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroPrestador = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/prestador/index";
    }
};

function submitCadastroPrestador(){
    jQuery("#addPrestador").submit();
}

$(document).ready(function() {
    $("#nu_meses").mask('99');
    $("#nu_dependentes").mask('99');
    $('input[type=file]').change(function(e){
        $in=$(this);
        $("#uploadFile").val($in.val());
    });
});

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
    if(jQuery(".content-procedimento div").length==0){
        jQuery(".content-procedimento").html(html);
    }else {
        jQuery(".content-procedimento div").last().after(html);
    }
    jQuery(jQuery(obj).parent().parent()).remove();
    init();
    var i=0;
    $.each( procedimentos, function( key, value ) {
        if(idProcedimento==value.id){
            procedimentos.splice(i,1);
        }
        i++;
    });
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