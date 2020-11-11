/**
 * Created by tony on 20/09/17.
 */

var userType=0;
var labelSuccess=0;
var availableTags = [];

jQuery(function(){
    userType = jQuery("#user-type").html();
    if(jQuery("#label-success").html()!=""){
        var htmlLabelSuccess = jQuery("#label-success .label-success").html();
        if(htmlLabelSuccess != undefined) {
            labelSuccess = htmlLabelSuccess.trim();
        }
    }
    if(userType!="4") {
        setInterval(function () {
            verificarNotificacaoContato();
        }, 7000);
        function verificarNotificacaoContato() {
            var funcaoNotificacaoContato = function (json) {
                var html = '';
                if (json != false) {
                    if(json.data.length > 0) {
                        if(json.data[0]["n"].trim()!=labelSuccess && json.data[0]["n"].trim()!=0) {
                            jQuery("#label-success").html('<span class="label label-success">'+json.data[0]["n"]+'</span>');
                            jQuery.each(json.data, function (key, value) {
                                html += '<li>';
                                html += '   <a href="'+getUrlController()+'/admin/contato/view/id/' + value.co_seq_contato + '">';
                                html += '       <div>';
                                html += '           <strong>' + value.nm_nome + '</strong>';
                                html += '           <span class="pull-right text-muted">';
                                html += '               <em>' + value.dt_inclusao + '</em>';
                                html += '           </span>';
                                html += '       </div>';
                                html += '       <div>';
                                html += '           ' + value.tx_mensagem;
                                html += '           <br />';
                                html += '       </div>';
                                html += '   </a>';
                                html += '</li>';
                                html += '<li class="divider"></li>';
                            });
                            html += '<li>';
                            html += '   <a class="text-center" href="'+getUrlController()+'/admin/contato/index">';
                            html += '       <strong>Ver todos os Contatos</strong>';
                            html += '       <i class="icon-angle-right"></i>';
                            html += '   </a>';
                            html += '</li>';
                            jQuery("#dropdown-messages").html(html);
                        }
                    }
                }
            };
            var array = {};
            ajaxPost(funcaoNotificacaoContato, array, "/admin/notificacao/ajax-notificacao-contato");
        }
    }
});

function clearCount(){
    jQuery("#label-success").html("");
    var array = {};
    ajaxPost(funcaoClearCount, array, "/admin/notificacao/ajax-clear-notificacao-contato");
}

var funcaoClearCount = function(json){
    if (json != false) {

    }
};

function searchText(obj){
    var array = {"key": obj.value};
    ajaxPost(funcaoSearchText, array, "/busca/ajax-busca-auto-incremento/", "/admin");
}
var funcaoSearchText = function(json){
    if(json != null){
        availableTags = [];
        jQuery.each( json.data, function( i, val ) {
            availableTags.push({"label": val["nome"], "id": val["id"], "tipo": val["tipo"]});
        });
        $(function () {
            $("#tags").autocomplete({
                source: availableTags,
                select: function (event, ui) {
                    $("#tags").val(ui.item.label);
                    window.location.assign(jQuery("#url-page").html() + "/admin/" + ui.item.tipo + "/view/id/" + ui.item.id);
                    return false;
                }
            });
        });
    }
};