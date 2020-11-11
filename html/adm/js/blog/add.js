/**
 * Created by tony on 21/11/17.
 */

var procedimentos = [];
var OSName = "Unknown";

function submitAddBlog(){
    jQuery("#addBlog").submit();
}

function validaCadastroBlog(obj){
    var html = "";
    if(obj.nm_blog.value==""){
        html += "Nome do blog vazio!\n";
    }
    if(obj.tx_blog.value==""){
        html += "Texto do blog vazio!\n";
    }
    if(obj.tp_visualizacao.value==0){
        html += "Tipo da Visualização vazia!\n";
    }
    if(obj.lk_img_blog.files.length == 0){
        html += "" +
        "Nenhuma imagem selecionada!\n";
    }
    if(html!=""){
        alert(html);
    }else{
        if(obj.lk_img_blog.files[0]!="" && obj.lk_img_blog.files[0]!=undefined){
            var form = new FormData();
            form.append('fileUpload', obj.lk_img_blog.files[0]);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', getUrlController() + '/admin/blog/ajax-upload-img');
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
        var array = {"nm_blog": obj.nm_blog.value, "tx_blog": obj.tx_blog.value, "tp_visualizacao": obj.tp_visualizacao.value, "lk_img_blog": obj.lk_img_blog.value, "procedimentos": procedimentos};
        ajaxPost(funcaoCadastroBlog, array, "/blog/ajax-add/", "/admin");
    }
    return false;
}

var funcaoCadastroBlog = function(json){
    if(json!=null){
        alert("Salvo com sucesso!");
        window.location.href = getUrlController() + "/admin/index";
    }
};

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
    //jQuery(".content-procedimento div").last().after(html);
    if(jQuery(".content-procedimento div").length==0){
        jQuery(".content-procedimento").html(html);
    }else {
        jQuery(".content-procedimento div").last().after(html);
    }
    $(jQuery(obj).parent().parent()).remove();
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