/**
 * Created by tony on 29/01/18.
 */


var htmlCliente = "";

$(document).ready(function () {
    //$('#dataTables-example').dataTable();
    $("#dataTables-example_wrapper .row:first-child").remove();
    $("#dataTables-example_wrapper .row:last-child").remove();
});

function changePerPage(obj){
    window.location.href = getUrlController() + "/admin/cliente/index/page/1/per/"+jQuery(obj).val();
}

function searchClient(obj){
    var array = {"search":obj.searchName.value};
    ajaxPost(funcaoSearchClient, array, "/cliente/ajax-search-name/", "/admin");
    return false;
}

var funcaoSearchClient = function(json){
    var i=0;
    htmlCliente="";
    mountHtmlInitClient();
    jQuery.each( json.data, function( key, value ) {
        mountHtmlBodyClient(value, i);
    });
    mountHtmlEndClient();
    mountHtmlCliente();
};

function submitSearchClient(){
    jQuery("#searchCliente").submit();
}

function mountHtmlInitClient(){
    htmlCliente += '<thead>';
    htmlCliente += '    <tr role="row">';
    htmlCliente += '        <th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 300px;">Nome Cliente</th>';
    htmlCliente += '        <th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 200px;">Login</th>';
    htmlCliente += '        <th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 200px;">Nascimento</th>';
    htmlCliente += '        <th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 90px;">Ação</th>';
    htmlCliente += '    </tr>';
    htmlCliente += '</thead>';
    htmlCliente += '<tbody>';
}

function mountHtmlEndClient(){
    htmlCliente += '</tbody>';
}

function mountHtmlBodyClient(value, i){
    var classRow = "";
    if(i%2==0){
        classRow="odd";
    }else{
        classRow="even";
    }
    htmlCliente += '<tr class="gradeA '+classRow+'">';
    htmlCliente += '<td class="sorting_1">'+value["nm_cliente"]+'</td>';
    htmlCliente += '<td class=" ">'+value["nm_login"]+'</td>';
    htmlCliente += '<td class=" ">'+getDateClient(value["dt_nascimento"])+'</td>';
    htmlCliente += '<td class="center" style="text-align: center;">';
    if(value["st_cliente"]==1) {
        htmlCliente += '<a href="'+getUrlController()+'/admin/dependente/index/id/'+value["co_seq_cliente"]+'"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;';
    }else{
        htmlCliente += '<i class="icon-eye-open" style="color: #c3c3c3;" title="Desativado"></i>&nbsp;&nbsp;';
    }
    if(value["st_cliente"]==1) {
        htmlCliente += '<a href="'+getUrlController()+'/admin/dependente/cliente-dependente/id/'+value["co_seq_cliente"]+'"><i class="icon-sitemap" title="Inserir Dependentes"></i></a>';
    }else {
        htmlCliente += '<i class="icon-sitemap" style="color: #c3c3c3;" title="Desativado"></i>';
    }
    htmlCliente += '</td>';
    htmlCliente += '</tr>';
}

function mountHtmlCliente(){
    jQuery("#dataTables").html("");
    jQuery("#dataTables").html(htmlCliente);
}

function disableClient(id){
    var array = {"co_seq_cliente": id};
    ajaxPost(funcaoDisableCliente, array, "/cliente/ajax-disable-cliente/", "/admin");
}

funcaoDisableCliente = function(json){
    if(json!=null){
        alert("Cliente Desativado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/index/page/1";
    }
};

function enableClient(id){
    var array = {"co_seq_cliente": id};
    ajaxPost(funcaoEnableCliente, array, "/cliente/ajax-enable-cliente/", "/admin");
}

funcaoEnableCliente = function(json){
    if(json!=null){
        alert("Cliente Ativado com sucesso!");
        window.location.href = getUrlController() + "/admin/cliente/index/page/1";
    }
};