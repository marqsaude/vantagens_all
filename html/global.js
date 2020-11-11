/**
 * Created by tony on 26/08/15.
 */

/***** Set timer *****/
var myVar;
var objRemove=null;

/**
 * Ajax com post
 */
function ajaxPost(funcao, array, action, model){
    if(model == undefined){model="";}
    jQuery(function(){
        jQuery.ajax({
            url: getUrlController()+model+action,
            dataType: "json",
            type: "post",
            data:array,
            beforeSend: function() {
            },
            success: function(json){
                funcao(json);
            }
        });
    });
    return false;
}

/**
 * Ajax url direto
 */
function ajaxGetDirect(funcao,url){
    jQuery(function(){
        jQuery.ajax({
            url: url,
            dataType: "json",
            type: "get",
            beforeSend: function() {
            },
            success: function(json){
                funcao(json);
            }
        });
    });
    return false;
}

/**
 * Ajax adm com post
 */
function ajaxPostAdmin(funcao, array, action){
    jQuery(function(){
        jQuery.ajax({
            url: getUrlController()+"/admin"+action,
            dataType: "json",
            type: "post",
            data:array,
            beforeSend: function() {
            },
            success: function(json){
                funcao(json);
            }
        });
    });
    return false;
}

/**
 * Ajax com get
 */
function ajaxGet(funcao, array, action){
    jQuery(function(){
        jQuery.ajax({
            url: getUrlController()+action,
            dataType: "json",
            type: "get",
            data:array,
            success: function(json){
                funcao(json);
            }
        });
    });
    return false;
}

/**
 * Recupera o caminho url
 */
function getUrlController(){
    var t = jQuery("#url-page").html();
    return t;
    //var split = t.split("/");
    //console.debug(t.replace("/"+split[split.length-1], "/ajax-"+split[split.length-1]));
    //return t.replace("/"+split[split.length-1], "/ajax-"+split[split.length-1]);
}

/**
 * Incluir JavaScript
 */
function includeJS(url){document.write('<script type="text/javascript" src="'+getUrlController()+url+'"></script>')}

/**
 * Excluir Genérico
 */
function excluirRegistro(id, obj){
    var url = "/"+jQuery(obj).attr("for")+"/ajax-remove/";
    var array = {"id": id};
    objRemove=jQuery(obj).parent().parent();
    ajaxPost(funcaoExcluirRegistro, array, url, "/admin");
}

funcaoExcluirRegistro = function(json){
    if(json!=null){
        alert("Removido com Sucesso!");
        objRemove.remove();
    }
};

/**
 * Pega todos inputs do formulário
 */
function getAllInput(obj){
    var inputs = obj.getElementsByTagName('input');
    var select = obj.getElementsByTagName('select');
    var objFinal = {};
    for (var index = 0; index < inputs.length; ++index) {
        var iipptt = inputs[index].getAttribute("name");
        var value = inputs[index].value;
        objFinal[iipptt] = value;
    }
    for (var index = 0; index < select.length; ++index) {
        var iipptt = select[index].getAttribute("name");
        var value = select[index].value;
        objFinal[iipptt] = value;
    }
    return objFinal;

}

/**
 * Retorna para última página
 */
function goBack() {
    history.go(-1);
}

/**
 * Retorna a data atual do servidor
 */
function getDate(more){
    var today = new Date();
    if(more != undefined || more != null){
        today.setDate(today.getDate() + more);
    }
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd = '0'+dd
    }

    if(mm<10) {
        mm = '0'+mm
    }

    today = yyyy+''+mm+''+dd;
    return today;
}

function getFormattedDate(date) {
    var d = date.split('/');
    return d[2]+''+d[1]+''+d[0];
}

function getDateClient(date) {
    var d = date.split('-');
    return d[2]+'/'+d[1]+'/'+d[0];
}

/**
 * Verifica se é um browser mobile
 * @returns {boolean}
 */
function isMobile() {
    if( navigator.userAgent.match(/Android/i)
        || navigator.userAgent.match(/webOS/i)
        || navigator.userAgent.match(/iPhone/i)
        || navigator.userAgent.match(/iPad/i)
        || navigator.userAgent.match(/iPod/i)
        || navigator.userAgent.match(/BlackBerry/i)
        || navigator.userAgent.match(/Windows Phone/i)
    ){
        return true;
    }
    else {
        return false;
    }
}