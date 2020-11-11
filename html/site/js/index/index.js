/**
 * Created by tony on 18/08/17.
 */

var hasModal = false;
var i = 0;

$(function() {
    var Page = (function() {

        var $navArrows = $( '#nav-arrows' ),
            slitslider = $( '#slider' ).slitslider( {
                autoplay : true
            } ),

            init = function() {
                initEvents();
            },
            initEvents = function() {
                $navArrows.children( ':last' ).on( 'click', function() {
                    slitslider.next();
                    return false;
                });

                $navArrows.children( ':first' ).on( 'click', function() {
                    slitslider.previous();
                    return false;
                });
            };

        return { init : init };

    })();

    Page.init();
});

$(function() {

    var Page = (function() {
        var $navArrows = $( '#nav-arrows' ),
            $nav = $( '#nav-dots > span' ),
            slitslider = $( '#slider' ).slitslider( {
                onBeforeChange : function( slide, pos ) {
                    $nav.removeClass( 'nav-dot-current' );
                    $nav.eq( pos ).addClass( 'nav-dot-current' );
                }
            } ),
            init = function() {
                initEvents();

            },
            initEvents = function() {
                // add navigation events
                $navArrows.children( ':last' ).on( 'click', function() {
                    slitslider.next();
                    return false;
                } );
                $navArrows.children( ':first' ).on( 'click', function() {

                    slitslider.previous();
                    return false;
                } );
                $nav.each( function( i ) {

                    $( this ).on( 'click', function( event ) {

                        var $dot = $( this );

                        if( !slitslider.isActive() ) {
                            $nav.removeClass( 'nav-dot-current' );
                            $dot.addClass( 'nav-dot-current' );

                        }

                        slitslider.jump( i + 1 );
                        return false;

                    } );

                } );
            };
        return { init : init };
    })();
    Page.init();
    /**
     * Notes:
     *
     * example how to add items:
     */

    var html = '';

    html += '<div class="sl-slide bg-4 sl-slide-vertical" data-orientation="vertical" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2" style="display: none; z-index: 1;">';
    html += '   <div class="sl-content-wrapper" style="width: 1429px; height: 570px;">';
    html += '       <div class="sl-content">';
    html += '           <div class="sl-slide-inner" id="felipe4">';
    html += '               <div class="container">';
    html += '                   <h2>&nbsp;</h2>';
    html += '                   <h3 class="gap title-slide-felipe">QUERO +Saúde para Você</h3>';
    html += '               </div>';
    html += '           </div>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';

    //jQuery(".sl-slides-wrapper").append(html);
    $("body").click(function(){
        if(hasModal==true && i%2==0) {
            $(".modal-conheca").hide();
            hasModal = false;
        }else{
            i++;
        }
    });

});

function openModal(obj){
    $(function(){
        var relConhece = $(obj).attr('rel');
        if(hasModal==false) {
            $("#" + relConhece).show();
            hasModal = true;
        }else{
            $("#" + relConhece).hide();
            hasModal = false;
        }
        i++;
    });
}

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