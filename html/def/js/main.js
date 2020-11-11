/*
	Spectral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

var subMenu = false;

(function($) {
    if(!isMobile()) {
        skel.breakpoints({
            xlarge: '(max-width: 1680px)',
            large: '(max-width: 1280px)',
            medium: '(max-width: 980px)',
            small: '(max-width: 736px)',
            xsmall: '(max-width: 480px)'
        });
    }

	$(function() {

		var	$window = $(window),
			$body = $('body'),
			$wrapper = $('#page-wrapper'),
			$banner = $('#banner'),
			$header = $('#header');

		// Disable animations/transitions until the page has loaded.
			$body.addClass('is-loading');

			$window.on('load', function() {
				window.setTimeout(function() {
					$body.removeClass('is-loading');
				}, 100);
			});

		// Mobile?
			if (skel.vars.mobile)
				$body.addClass('is-mobile');
			else{
                if(!isMobile()) {
                    skel
                        .on('-medium !medium', function() {
                            $body.removeClass('is-mobile');
                        })
                        .on('+medium', function() {
                            $body.addClass('is-mobile');
                        });
                }
            }

		// Fix: Placeholder polyfill.
			$('form').placeholder();

		// Prioritize "important" elements on medium.
			skel.on('+medium -medium', function() {
				$.prioritize(
					'.important\\28 medium\\29',
					skel.breakpoint('medium').active
				);
			});

		// Scrolly.
			$('.scrolly')
				.scrolly({
					speed: 1500,
					offset: $header.outerHeight()
				});

		// Menu.
			$('#menu')
				.append('<a href="#menu" class="close"></a>')
				.appendTo($body)
				.panel({
					delay: 500,
					hideOnClick: true,
					hideOnSwipe: true,
					resetScroll: true,
					resetForms: true,
					side: 'right',
					target: $body,
					visibleClass: 'is-menu-visible'
				});

		// Header.
			if (skel.vars.IEVersion < 9)
				$header.removeClass('alt');

			if ($banner.length > 0
			&&	$header.hasClass('alt')) {

				$window.on('resize', function() { $window.trigger('scroll'); });

				$banner.scrollex({
					bottom:		$header.outerHeight() + 1,
					terminate:	function() { $header.removeClass('alt'); },
					enter:		function() { $header.addClass('alt');menuScrollUp();},
					leave:		function() { $header.removeClass('alt');menuScrollDown();}
				});

			}

	});

})(jQuery);

;(function (window, $, undefined) {
    "use strict";

    $.fn.rotate = function (degrees, options) {

        var settings = $.extend({}, $.fn.rotate.defaults, options),
            endDeg = 0;

        degrees = degrees || $.fn.rotate.degrees;

        return this.each(function (i, el) {
            if ($(el).is(':animated')) { return;}

            endDeg = (el.deg || endDeg) + degrees;
            settings.step = function (now) {
                $(el).css('transform', 'rotate(' + now + 'deg)');
            };

            $(el).animate({deg: endDeg}, settings);
        });

    };

    $.fn.rotate.degrees = 360;

    $.fn.rotate.defaults = {
        duration: 1000,
        easing: 'swing',
        complete: function () { }
    };


})(window, jQuery);

function createModalDialogs(){
    $("#dialog_login").dialog({
        show: "fade",
        hide: "fade",
        width: "47%",
        height: 277,
        dialogClass: "modal-login",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_consultas").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-servicos",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_exames").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-servicos",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_laboratoriais").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-servicos",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_Single").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-preco",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_Plus").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-preco",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
    $("#dialog_Master").dialog({
        show: "fade",
        hide: "fade",
        width: "70%",
        height: 637,
        dialogClass: "modal-preco",
        resizable: false,
        draggable: false,
        autoOpen: false,
        open: function () {
            $(".modal-backdrop").show();
        },
        close: function () {
            $(".modal-backdrop").hide();
        }
    });
}

function menuScrollDown(){
	$("#nav ul .item a").hover(function(){
        if($(this).parent().hasClass("active")==false) {
            $(this).css('color', '#ffffff');
            $(this).css('background', '#bd2026');
            if($(this).parent().parent().hasClass("sub-menu")==true){
                $(this).css('background', '#bd2026');
            }else {
                $(".active").css('background', 'transparent');
                $(".active").parent().css('border', 'none');
                $(".active a").css('background', 'transparent');
                $(".active a").parent().css('border', 'none');
            }
        }
	}).mouseout(function(){
        if($(this).parent().hasClass("active")==true){
            $(this).css('color', '#ffffff');
            $(this).css('background', '#bd2026');
		}else{
            $(this).css('color', '#ffffff');
            $(this).css('background', 'transparent');
		}
        $(".active").css('background', '#bd2026');
	});
	$(".has-sub-menu").addClass("has-sub-menu-black");
    $(".has-sub-menu-black").removeClass("has-sub-menu");
    $("#nav ul").css({"background":"#4a7d7e","color":"#fff"});
    $(".active").css({"background":"#bd2026","color":"#fff"});
}

function menuScrollUp(){
	$("#nav ul .item a").hover(function(){
		$(this).css('color', '#bd2026');
       	$(this).css('background', 'transparent');
       	$(this).css('border', '1px solid #bd2026');
        $(".active").css('border', '0px none');
        $(".active a").css('border', '0px none');
	}).mouseout(function(){
		$(this).css('color', '#ffffff');
       	$(this).css('background', 'transparent');
       	$(this).css('border', '0px');
		$(".active").css('color', '#ffffff');
		$(".active").css('background', 'transparent');
        $(".active a").css('background', 'transparent');
        $(".active").css('border', '1px solid #bd2026');
	});
    $(".has-sub-menu-black").addClass("has-sub-menu");
    $(".has-sub-menu").removeClass("has-sub-menu-black");
    $("#nav ul .item a").css("background","transparent");
	$("#nav ul").css({"background":"transparent","color":"#fff"});
    $(".active").css({"background":"transparent","color":"#fff"});
}

if($("#controller").html()!="index"){
    $('#header').removeClass('alt');
    menuScrollDown();
}

$(function() {
    createModalDialogs();
    $("#black-mask").click(function () {
        $(".modal-backdrop").hide();
        $("#dialog_consultas").dialog("close");
        $("#dialog_exames").dialog("close");
        $("#dialog_laboratoriais").dialog("close");
        $("#dialog_Single").dialog("close");
        $("#dialog_Plus").dialog("close");
        $("#dialog_Master").dialog("close");
        $("#dialog_login").dialog("close");
    });
});

function openLogin(type) {
    $(function () {
        if(type==1) {
            $("#dialog_login").dialog("open");
        }
    });
}

function closeLogin(type){
    if(type==1) {
        $("#dialog_login").dialog("close");
    }
}

function login(obj){
    var array = {"nm_login":obj.user.value, "nm_senha":obj.passwd.value};
    ajaxPost(funcaoLogin, array, "/login/logar/", "/admin");
    return false;
}

var funcaoLogin = function(json){
    if(json != ""){
        if(json.type==2){
            alert(json.msg);
        }else{
            window.location.href = getUrlController() + "/admin/index";
        }
    }
};

function validaNewsletter(obj){
    var html="";
    if(obj.nm_newsletter.value==""){
        html += "Email não informado!";
    }
    if(html!=""){
        alert(html);
    }else{
        var array = {"nm_email":obj.nm_newsletter.value};
        ajaxPost(funcaoNewsletter, array, "/newsletter/ajax-add/", "/default");
    }
    return false;
}

var funcaoNewsletter = function(json){
    if(json != ""){
        alert("Email registrado com sucesso!\n Em breve, entraremos em contato.");
        window.location.href = getUrlController() + "/index";
    }
};

function validaEsquecerSenha(obj){
    var html="";
    if(obj.email.value==""){
        html += "Email não informado!";
    }
    if(html!=""){
        alert(html);
    }else{
        $("#load-enviar").html("<img src='" + getUrlController() + "/gog/imagens/load.gif' width='77' />");
        var array = {"nm_email":obj.email.value};
        ajaxPost(funcaoValidaEsquecerSenha, array, "/esqueceu-senha/ajax-index/", "/default");
    }
    return false;
}

var funcaoValidaEsquecerSenha = function(json){
    if(json != ""){
        if(json.achou==1) {
            $("#load-enviar").html('<button type="submit" class="btn btn-primary" style="padding: 10px 21px; margin-top: 2px;">Enviar</button>');
            alert("Foi enviado uma solicitação de senha para o seu email!");
            window.location.href = getUrlController() + "/index";
        }else{
            $("#load-enviar").html('<button type="submit" class="btn btn-primary" style="padding: 10px 21px; margin-top: 2px;">Enviar</button>');
            alert("Email não registrado ainda!");
        }
    }
};

function esquecerSenha(){
    var html = '';
    html += '<div class="modal-body">';
    html += '   <div class="title-modal-login">';
    html += '       <div class="text-esqueceu-senha">Trocar senha da sua conta MarqSaúde + Vantagens</div>';
    html += '   </div>';
    html += '   <br/><br/>';
    //html += '	<a onclick="voltarLogin();" href="javascript:void(0);"><div><i class="icon-mail-reply"></i>&nbsp; Voltar para Login</div></a>';
    html += '	<div class="text-esqueceu-senha">Digite o email da sua conta.</div>';
    html += '	<form class="form-inline" method="post" id="form-esqueceu-senha" onSubmit="return validaEsquecerSenha(this);">';
    html += '		<div style="width: 70%; float: left; padding: 0 27px 0 0;"><input type="text" class="input-small" placeholder="Digite o seu email" name="email" required="required" /></div>';
    html += '		<div style="width: 20%; float: left;" id="load-enviar"><button type="submit" class="btn btn-primary" style="padding: 10px 21px; margin-top: 2px;">Enviar</button></div>';
    html += '	</form>';
    html += '</div>';
    $(function(){
        $("#modal_logar").html(html);
    });
}

function voltarLogin(){
    var html = '';
    if(isMobile()==true){
        html += '<form class="form-inline w3-container" method="post" id="form-login" onSubmit="return login(this);">';
        html += '	<div class="w3-section">';
        html += '		<label><b>Login (Email)</b></label>';
        html += '		<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Entre com o Login" name="user" required>';
        html += '		<label><b>Senha</b></label>';
        html += '		<input class="w3-input w3-border" type="password" placeholder="Entre com a Senha" name="passwd" required>';
        html += '		<button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>';
        html += '	</div>';
        html += '</form>';

        html += '<div class="w3-container w3-border-top w3-padding-16 w3-light-grey">';
        html += '	<a href="javascript:void(0);" onclick="esquecerSenha();" class="w3-button w3-red">Esqueceu a senha?</a>';
        html += '	<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>';
        html += '</div>';
    }else{
        html += '<div class="modal-header">';
        html += '	<i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>';
        html += '	<div class="text-esqueceu-senha">Logar com sua conta QSaúde</div>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += '	<form class="form-inline" method="post" id="form-login" onSubmit="return login(this);">';
        html += '		<input type="text" class="input-small" placeholder="Email" name="user" required="required" style="width: 34%;" />';
        html += '		<input type="password" class="input-small" placeholder="Senha" name="passwd" required="required" style="width: 34%;" />';
        html += '		<button type="submit" class="btn btn-primary" style="padding: 10px 21px; margin-top: 2px;">Entrar</button>';
        html += '	</form>';
        html += '	<a href="javascript:void(0);" onclick="esquecerSenha();">Esqueceu a senha?</a>';
        html += '</div>';
    }
    $(function(){
        $("#loginForm").html(html);
    });
}

$('.menu-anchor').on('click touchstart', function(e){
    //$('html').toggleClass('menu-active');
    //e.preventDefault();
});

function ajustaMenu(obj){
    if(subMenu==false){
        $(obj).parent().find(".sub-menu").toggle();
        $(".separador-menu").show();
        subMenu=true;
    }else{
        $(obj).parent().find(".sub-menu").toggle();
        $(".separador-menu").hide();
        subMenu=false;
    }
    return false;
}