/**
 * Created by tony on 08/02/18.
 */

var htmlCliente = "";
var __pago = 1;

$(document).ready(function () {
    //$('#dataTables-example').dataTable();
    $("#dataTables-example_wrapper .row:first-child").remove();
    $("#dataTables-example_wrapper .row:last-child").remove();
});

function changePerPage(obj){
    window.location.href = getUrlController() + "/admin/cancelamento/cliente/page/1/per/"+jQuery(obj).val();
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
    htmlCliente += '<td class=" ">'+value["dt_nascimento"]+'</td>';
    htmlCliente += '<td class="center" style="text-align: center;">';
    if(value["st_cliente"]==1) {
        //htmlCliente += '<a href="'+getUrlController()+'/admin/cliente/edit/id/'+value["co_seq_cliente"]+'"><i class="icon-edit"></i></a>&nbsp;&nbsp;';
    }else{
        //htmlCliente += '<i class="icon-edit" style="color: #c3c3c3;" title="Desativado"></i>&nbsp;&nbsp;';
    }
    if(value["st_cliente"]==1) {
        htmlCliente += '<a href="'+getUrlController()+'/admin/cliente/view/id/'+value["co_seq_cliente"]+'"><i class="icon-eye-open"></i></a>&nbsp;&nbsp;';
    }else{
        htmlCliente += '<i class="icon-eye-open" style="color: #c3c3c3;" title="Desativado"></i>&nbsp;&nbsp;';
    }
    htmlCliente += '&nbsp;&nbsp;&nbsp;&nbsp;';
    if(value["st_cliente"]==1) {
        htmlCliente += '<a href="javascript:void(0);" onclick="disableClient('+value["co_seq_cliente"]+');"><i class="icon-ban-circle" style="color: #f0ad4e;"></i></a>';
    }else {
        htmlCliente += '<a href="javascript:void(0);" onclick="enableClient('+value["co_seq_cliente"]+');"><i class="icon-ok-circle" style="color: #47a447;"></i></a>';
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
        window.location.href = getUrlController() + "/admin/cancelamento/cliente/page/1";
    }
};

function enableClient(id){
    var array = {"co_seq_cliente": id};
    ajaxPost(funcaoEnableCliente, array, "/cliente/ajax-enable-cliente/", "/admin");
}

funcaoEnableCliente = function(json){
    if(json!=null){
        alert("Cliente Ativado com sucesso!");
        window.location.href = getUrlController() + "/admin/cancelamento/cliente/page/1";
    }
};

function clickAtivos(thiz){
    $(function() {
        if (!$("#btn-ativos").hasClass("btn-desativo")) {
            $(".ativos").show();
            $(".cancelados").hide();
            $("#btn-cancelado").addClass("btn-cancelados");
            $("#btn-cancelado").removeClass("btn-ativos");
            $("#btn-ativo").addClass("btn-ativos");
            $("#btn-ativo").removeClass("btn-cancelados");
        }
    });
}

function clickCancelados(thiz){
    $(function() {
        if (!$("#btn-cancelados").hasClass("btn-desativo")) {
            $(".ativos").hide();
            $(".cancelados").show();
            $("#btn-ativo").addClass("btn-cancelados");
            $("#btn-ativo").removeClass("btn-ativos");
            $("#btn-cancelado").addClass("btn-ativos");
            $("#btn-cancelado").removeClass("btn-cancelados");
        }
    });
}

function onAllBtn(){
    $(".menu-pagamento a").removeClass("btn-cancelados");
    //$(".btn-aguardando-pagamento").removeClass("btn-desativo");
}

/** Ativos **/
function ativosPage(page){
    $(".ativos").show();
    $(".cancelados").hide();
    onAllBtn();
    $(".btn-ativos").addClass("btn-desativo");
    //var array = {"page": page};
    //ajaxPost(funcaoAtivosPage, array, "/relatorio/ajax-pagamento/", "/admin");
}

var funcaoAtivosPage = function(json){
    if(json!=null){
        mountHtmlTable(json.data["cliente"], true);
        mountHtmlPagination(json.data["page"], json.data["count"], true);
        moutHtmlCountPagamento(json.data["n"]);
        $("#pago_input").val("1");
    }
};
/** END Ativos **/

/** Cancelados **/
function canceladosPage(page){
    $(".ativos").hide();
    $(".cancelados").show();
    //var array = {"page": page};
    //ajaxPost(funcaoCanceladosPage, array, "/relatorio/ajax-pagamento-nao/", "/admin");
}

var funcaoCanceladosPage = function(json){
    if(json!=null){
        mountHtmlTable(json.data["cliente"], false);
        mountHtmlPagination(json.data["page"], json.data["count"], false);
        moutHtmlCountPagamento(json.data["n"]);
        $("#pago_input").val("2");
    }
};
/** END Cancelados **/

/** Monta Html Tabela **/
function mountHtmlTable(dataCliente, pago){
    var html = '';
    if(pago==true){
        html = mountHtmlPago(dataCliente);
        $("#recebeu-pagamento table").html(html);
    }else{
        html = mountHtmlNaoPago(dataCliente);
        $("#nao-recebeu-pagamento table").html(html);
    }
}

function mountHtmlPago(dataCliente){
    var html = "";
    html += mountHtmlHead();
    html += mountHtmlBody(dataCliente);
    return html;
}

function mountHtmlHead(){
    var html = '';
    html += '<thead>';
    html +=     '<tr role="row">';
    html +=         '<th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 300px;">Nome Cliente</th>';
    html +=         '<th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 200px;">Login</th>';
    html +=         '<th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 200px;">Nascimento</th>';
    html +=         '<th tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 90px;">Ação</th>';
    html +=     '</tr>';
    html += '</thead>';
    return html;
}

function mountHtmlBody(dataCliente){
    var html = "";
    var i = 0;
    var clazz = "";
    var view = "";
    html += "<tbody>";
    $.each(dataCliente, function( index, value ) {
        if(i%2==0){
            clazz = "odd";
        }else{
            clazz = "even";
        }
        if(value["st_cliente"]==1){
            view = '<a href="'+getUrlController()+'/admin/cliente/view/id/'+value["co_seq_cliente"]+'"><i class="icon-eye-open" title="Visualizar"></i></a>';
        }else{
            view = '<i class="icon-eye-open" style="color: #c3c3c3;" title="Desativado"></i>';
        }
        html += '<tr class="gradeA '+clazz+'">';
        html += '   <td class="sorting_1">'+value["nm_cliente"]+'</td>';
        html += "   <td>"+value["nm_login"]+"</td>";
        html += "   <td>"+value["dt_nascimento"]+"</td>";
        html += '<td class="center" style="text-align: center;"><a href="'+getUrlController()+'/admin/ciente/view/id'+value["co_seq_cliente"]+'"><i class="icon-eye-open"></i></a></td>';
        html += "</tr>";
    });
    html += "</tbody>";
    return html;
}

function printRecibo(idCliente) {
    window.open(getUrlController() + "/admin/recibo/cancelamento/id/"+idCliente,'_blank');
}