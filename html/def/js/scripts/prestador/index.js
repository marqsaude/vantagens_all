var htmlContainerPrestador = '';

function abrirPrestador(id){
    var array = {"co_seq_prestador": id};
    ajaxPost(funcaoAbrirPrestador, array, "/prestador/ajax-view/", "/default");
}

var funcaoAbrirPrestador = function(json){
    if(json!= null){
        var html  = '';
        html     += '<div class="row-fluid">';
        html     += '   <div class="span1"></div>';
        html     += '   <div class="span10">';
        html     += '       <div class="w100p align-center"><img src="'+getUrlController()+'/site/images/prestador/'+json.data[0]["lk_prestador"]+'" width="197"></div>';
        html     += '       <p>&nbsp;</p><br/>';
        html     += '       <h4>'+json.data[0]["nm_prestador"]+'</h4>';
        html     += '       <p>'+json.data[0]["tx_sobre"]+'</p>';
        html     += '   </div>';
        html     += '   <div class="span1"></div>';
        html     += '</div>';
        html     += '<div class="row-fluid">';
        html     += '   <div class="span1"></div>';
        html     += '   <div class="span2"><a href="javascript:void(0);" onclick="voltarPrestadores();"><span class="icon fa-2x fa-angle-left"></span>&nbsp; Voltar</a></div>';
        html     += '</div>';
        htmlContainerPrestador = $("#container-prestador").html();
        $("#container-prestador").html(html);
        $("#container-prestador").css("padding", "107px 20px 57px 47px");
    }
};

function voltarPrestadores() {
    $("#container-prestador").html(htmlContainerPrestador);
}