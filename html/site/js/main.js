jQuery(function($) {

	//Ajax contact
	/*var form = $('.contact-form');
		form.submit(function () {
			$this = $(this);
			$.post($(this).attr('action'), function(data) {
			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
		},'json');
		return false;
	});*/

	//Goto Top
	$('.gototop').click(function(event) {
		 event.preventDefault();
		 $('html, body').animate({
			 scrollTop: $("body").offset().top
		 }, 500);
	});
	//End goto top

	$("#in-paciente")
		.mouseover(function(){
			$("#nm-paciente a").css("color", "#c9bb5f");
		})
		.mouseout(function() {
			$("#nm-paciente a").css("color", "#333");
		});

	$("#nm-paciente")
		.mouseover(function(){
			$("#in-paciente a").css("color", "#c9bb5f");
		})
		.mouseout(function() {
			$("#in-paciente a").css("color", "#333");
		});

});

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
	html += '	<a onclick="voltarLogin();" href="javascript:void(0);"><div><i class="icon-mail-reply"></i>&nbsp; Voltar para Login</div></a>';
	html += '	<div class="text-esqueceu-senha">Digite o email da sua conta.</div>';
	html += '	<form class="form-inline" method="post" id="form-esqueceu-senha" onSubmit="return validaEsquecerSenha(this);">';
	html += '		<div style="width: 70%; float: left; padding: 0 27px 0 0;"><input type="text" class="input-small" placeholder="Digite o seu email" name="email" required="required" /></div>';
	html += '		<div style="width: 20%; float: left;" id="load-enviar"><button type="submit" class="btn btn-primary" style="padding: 10px 21px; margin-top: 2px;">Enviar</button></div>';
	html += '	</form>';
	html += '</div>';
	$(function(){
		$("#loginForm").html(html);
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

function boleto(){
	var array = {"idCliente":50, "nu_vezes":6, "nu_valor":238.8, "co_seq_contrato_gog": 12};
	ajaxPost(funcaoBoleto, array, "/teste-boleto/ajax-boleto/", "/default");
}

var funcaoBoleto = function(json) {
	if (json != "") {
		alert("Gerados com sucesso!");
	}
};

$(document).ready(function() {
	$("a[rel^='prettyPhoto']").prettyPhoto({
		changepicturecallback: function(){
			$(".pp_details").hide();
			var size = $(".pp_content").height();
			$(".pp_content").height(size*0.89);
		}
	});
});
