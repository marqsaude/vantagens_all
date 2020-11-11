/**
 * Created by tony on 09/11/17.
 */

function clickImg(obj){
    var img = obj.src.replace("thumbnails/", "");
    $(function() {
        $("#myModal").css("display", "block");
        $("#img01").attr("src",img);
    });
}

function closeModall(){
    $("#myModal").css("display", "none");
}

function init() {
    $(".item").hover(function () {
        $(".active");
    });
}

init();