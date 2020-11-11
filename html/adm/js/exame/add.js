/**
 * Created by tony on 24/08/17.
 */

var prestadores = [];
var OSName = "Unknown";

function validaCadastroExame(obj){
    var html = "";
    if(obj.nm_exame.value==""){
        html += "Nome do Exame vazio!\n";
    }
    if(obj.nu_valor.value==0.00 || obj.nu_valor.value=="" || obj.nu_valor.value==0 || obj.nu_valor.value=="0.00"){
        html += "É necessário inserir algum valor no exame!\n";
    }
    if(obj.nu_valor_real.value==0.00 || obj.nu_valor_real.value=="" || obj.nu_valor_real.value==0 || obj.nu_valor_real.value=="0.00"){
        html += "É necessário inserir algum valor real no exame!\n";
    }
    if(obj.tipoExame.value==0){
        html += "É necessário selecionar um tipo de exame!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        var array = {"nm_exame": obj.nm_exame.value, "nu_valor":obj.nu_valor.value, "nu_valor_real":obj.nu_valor_real.value, "co_tipo_exame":obj.tipoExame.value, "prestadores":prestadores };
        ajaxPost(funcaoCadastroExame, array, "/exame/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroExame = function(json){
    if(json!=null){
        alert("Cadastrado com Sucesso!");
        window.location.href = getUrlController() + "/admin/exame/add";
    }
};

function submitCadastroExame(){
    jQuery("#addExame").submit();
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
        jQuery(".content-data-prestador").html("&nbsp;");
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