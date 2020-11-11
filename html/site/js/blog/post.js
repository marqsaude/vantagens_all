/**
 * Created by tony on 01/02/17.
 */

function changePagina(pagina){
    if(pagina==-1){
        pagina = getPage();
    }else if(pagina==-2){
        pagina = getPage()-2;
    }
    var array = {"pagina":pagina};
    ajaxPost(funcaoChangePagina, array, "/blog/ajax-change-pagina/", "/default");
}

var funcaoChangePagina = function(json){
    if (json != false) {
        var html = '';
        var htmlPage = '';
        html += '<div class="content_title"><h2></h2></div>';
        jQuery.each( json.data, function( key, value ) {
            html += '<div class="clearfix single_content">';
            html +=     '<div class="clearfix post_date floatleft">';
            html +=         '<div class="date">';
            html +=             '<h3>27</h3>';
            html +=             '<p>January</p>';
            html +=         '</div>';
            html +=     '</div>';
            html +=     '<div class="clearfix post_detail">';
            html +=         '<h2><a href="">'+value["nm_post"]+'</a></h2>';
            html +=         '<div class="clearfix post-meta">';
            html +=             '<p>';
            if(jQuery("#logado-blog").html()=="true"){
                html +=             '<span><i class="fa fa-user"></i> '+value["nm_usuario"]+'</span>';
            }
            html +=                 '<span><i class="fa fa-clock-o"></i> '+value["dt_registro"]+'</span><span><i class="fa fa-folder"></i> '+value["nm_categoria"]+'</span>';
            html +=             '</p>';
            html +=         '</div>';
            html +=         '<div class="clearfix post_excerpt">';
            if(value["lk_img"]=="") {
                html += '<img src="'+getUrlController()+'/site/images/confortavel.png" alt=""/>';
            }else {
                html += '<img src="'+getUrlController()+'/site/images/blog/'+value["lk_img"]+'" alt=""/>';
            }
            if(parseInt(value["tx_post"].length)>200) {
                html +=     '<p>' + value["tx_post"].substr(0, 200)+'...</p>';
            }else {
                html +=     '<p>' + value["tx_post"] + '</p>';
            }
            html +=         '</div>';
            html +=         '<a href="'+getUrlController()+'/blog/view/id/'+value["co_seq_post"]+'">Continue Lendo</a>';
            html +=     '</div>';
            html += '</div>';
        });
        htmlPage += '<div>';
        htmlPage += '<ul>';
        if(json.page > 0) {
            htmlPage += '<li><a href="javascript:void(0);" onclick="changePagina(-2);"> << </a></li>';
        }
        var merge = isInt(json.count/5)?json.count/5:(parseInt(json.count/5)+1);
        for(var i=0; i<merge; i++) {
            var pg = i+1;
            if (json.page == i) {
                htmlPage += '<li><a href="javascript:void(0);" class="select_post">' + pg + '</a></li>';
            } else {
                htmlPage += '<li><a href="javascript:void(0);" onclick="changePagina(' + i + ');">' + pg + '</a></li>';
            }
        }
        if(json.page < (merge-1)) {
            htmlPage += '<li><a href="javascript:void(0);" onclick="changePagina(-1);"> >> </a></li>';
        }
        htmlPage += '</ul>';
        htmlPage += '</div>';
        jQuery("#content_post").html(html);
        jQuery("#page_post").html(htmlPage);
    }
};

function isInt(value) {
    return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
}

function getPage(){
    return parseInt(jQuery(".select_post").html());
}

function removePost(id){
    var array = {"id":id};
    ajaxPostAdmin(funcaoremovePost, array, "/blog/ajax-remove/");
}

var funcaoremovePost = function(json){
    if (json != false) {
        window.location.href = getUrlController() + "/blog/";
    }
};