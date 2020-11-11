var htmlSimulacao = "";

$(document).ready(function () {
    $("#dataTables-example_wrapper .row:first-child").remove();
    $("#dataTables-example_wrapper .row:last-child").remove();
});

function changePerPage(obj){
    window.location.href = getUrlController() + "/admin/simulacao/index/page/1/per/"+jQuery(obj).val();
}

function searchSimulacao(obj){
    var array = {"search":obj.searchName.value};
    ajaxPost(funcaoSearchSimulacao, array, "/simulacao/ajax-search-name/", "/admin");
    return false;
}

var funcaoSearchSimulacao = function(json){
    var i=0;
    htmlCliente="";
    mountHtmlInitClient();
    jQuery.each( json.data, function( key, value ) {
        mountHtmlBodyClient(value, i);
    });
    mountHtmlEndClient();
    mountHtmlCliente();
};