/**
 * Created by tony on 22/01/18.
 */

var __pago = 1;

/** Pagamento **/
function pagamentoPage(page){
    var array = {"page": page};
    ajaxPost(funcaoPagamentoPage, array, "/relatorio/ajax-pagamento/", "/admin");
}

var funcaoPagamentoPage = function(json){
    if(json!=null){
        mountHtmlTable(json.data["cliente"], true);
        mountHtmlPagination(json.data["page"], json.data["count"], true);
        moutHtmlCountPagamento(json.data["n"]);
        $("#pago_input").val("1");
    }
};
/** END Pagamento **/

/** Não Pagamento **/
function naoPagamentoPage(page){
    var array = {"page": page};
    ajaxPost(funcaoNaoPagamentoPage, array, "/relatorio/ajax-pagamento-nao/", "/admin");
}

var funcaoNaoPagamentoPage = function(json){
    if(json!=null){
        mountHtmlTable(json.data["cliente"], false);
        mountHtmlPagination(json.data["page"], json.data["count"], false);
        moutHtmlCountPagamento(json.data["n"]);
        $("#pago_input").val("2");
    }
};
/** END Não Pagamento **/

/** Monta Html Count **/
function moutHtmlCountPagamento(n){
    $(function() {
        $(".count-pagamento").html(n);
    });
}
/** END Monta Html Count **/

/** Monta Html Paginação **/
function mountHtmlPagination(page, dataCount, pago){
    var html = '';
    var funcaoPago = '';
    if(pago==true){
        funcaoPago = 'pagamentoPage';
    }else{
        funcaoPago = 'naoPagamentoPage';
    }
    var pMais  = parseInt(page)+1;
    var pMenos = parseInt(page)-1;
    if(page == 1){
        html += '<li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">';
        html += '   <a href="javascript:void(0);">Anterior</a>';
    } else {
        html += '<li class="paginate_button previous" aria-controls="dataTables-example" tabindex="0" id="dataTabes-example_previous">';
        html += '   <a href="javascript:void(0);" onclick="'+funcaoPago+'('+pMenos+')">Anterior</a>';
    }
    html += '</li>';
    for(var i=1; i<=dataCount; i++) {
        if (i == page) {
            html += '<li class="paginate_button active" aria-controls="dataTables-example" tabindex="0">';
            html += '   <a href="javascript:void(0);">'+i+'</a>';
        } else {
            html += '<li class="paginate_button" aria-controls="dataTables-example" tabindex="0">';
            html += '   <a href="javascript:void(0);" onclick="'+funcaoPago+'('+i+')">'+i+'</a>';
        }
        html += '</li>';
    }
    if(page == dataCount){
        html += '<li class="paginate_button next disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">';
        html += '   <a href="javascript:void(0);">Próxima</a>';
    } else {
        html += '<li class="paginate_button next" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">';
        html += '   <a href="javascript:void(0);" onclick="'+funcaoPago+'('+pMais+')">Próxima</a>';
    }
    html += '</li>';
    $(function() {
        $(".pagination").html(html);
    });
}
/** END Monta Html Paginação **/

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

function mountHtmlNaoPago(dataCliente){
    var html = "";
    html += mountHtmlHead();
    html += mountHtmlBody(dataCliente);
    return html;
}

function mountHtmlHead(){
    var html = "";
    html += "<thead>";
    html +=     "<tr>";
    html +=         "<th>Cliente</th>";
    html +=         "<th>Forma Pagamento</th>";
    html +=         "<th>Contrato</th>";
    html +=         "<th>Ação</th>";
    html +=     "</tr>";
    html += "</thead>";
    return html;
}

function mountHtmlBody(dataCliente){
    var html = "";
    html += "<tbody>";
    $.each(dataCliente, function( index, value ) {
        html += "<tr>";
        html += "   <td width='55%'>"+value["nm_cliente"]+"</td>";
        html += "   <td width='20%'>"+value["nm_forma_pagamento"]+"</td>";
        html += "   <td width='20%'>"+value["nm_contrato_gog"]+"</td>";
        html += "   <td width='5%'><a href='"+getUrlController()+"/admin/cliente/view/id/"+value["co_seq_cliente"]+"'><i class='icon-eye-open'></i></a></td>";
        html += "</tr>";
    });
    html += "</tbody>";
    return html;
}
/** END Monta Html Tabela **/

/** Controle de Btns **/
function clickPago(){
    $(function() {
        if(!$("#btn-pago").hasClass("btn-desativo")){
            pagamentoPage(1);
            $("#recebeu-pagamento").show();
            $("#nao-recebeu-pagamento").hide();
            onAllBtn();
            $(".btn-pago").addClass("btn-desativo");
        }
    });
}

function clickNaoPago(){
    $(function() {
        if(!$("#btn-aguardando-pagamento").hasClass("btn-desativo")) {
            naoPagamentoPage(1);
            $("#recebeu-pagamento").hide();
            $("#nao-recebeu-pagamento").show();
            onAllBtn();
            $(".btn-aguardando-pagamento").addClass("btn-desativo");
        }
    });
}

function onAllBtn(){
    $(".btn-pago").removeClass("btn-desativo");
    $(".btn-aguardando-pagamento").removeClass("btn-desativo");
}
/** END Controle de Btns **/

/** Pagamento Busca **/
function buscaNomePagamento(obj){
    var array = {"nome": obj.nome_busca.value, "pago": obj.pago.value};
    __pago = obj.pago.value;
    ajaxPost(funcaoBuscaNomePagamento, array, "/relatorio/ajax-pagamento-busca/", "/admin");
    return false;
}

var funcaoBuscaNomePagamento = function(json){
    if(json!=null){
        if(__pago==1){
            mountHtmlTable(json.data["cliente"], true);
            mountHtmlPagination(json.data["page"], json.data["count"], true);
        }else{
            mountHtmlTable(json.data["cliente"], false);
            mountHtmlPagination(json.data["page"], json.data["count"], false);
        }
        moutHtmlCountPagamento(json.data["n"]);
    }
};

function submitBuscaPagamento() {
    jQuery("#btnBuscaPagamento").submit();
}
/** END Pagamento Busca **/

/** Imprime Relatório **/
function imprimeRelatorio(){
    var array = {"pago": $("#pago_input").val()};
    ajaxPost(funcaoImprimeRelatorio, array, "/relatorio/ajax-print/", "/admin");
    return false;
}

var funcaoImprimeRelatorio = function(json){
    if(json != null){
        window.open(getUrlController()+'/adm/pdf/relatorio/'+$("#id-session").html()+'.pdf', '_blank');
    }
};
/** END Imprime Relatório **/