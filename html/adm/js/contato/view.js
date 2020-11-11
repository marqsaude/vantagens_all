/**
 * Created by tony on 16/01/18.
 */

var hasModal = false;
var i = 0;
var idContato;

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

function closeModal(){
    $('.modal-conheca').hide();
}

function init(){
    $(function(){
        $('#modal-conheca1').hover(function(){
            hasModal=true;
        }, function(){
            hasModal=false;
        });

        $("body").mouseup(function(){
            if(! hasModal) $('.modal-conheca').hide();
            if(! hasModal) $('.modal-conheca-dinheiro').hide();
        });
    });
}

init();

function respondeEmailCliente(obj){
    var html = "";
    if(obj.nm_assunto.value==""){
        html += "Assunto não preenchido!\n";
    }
    if(obj.tx_mensagem.value==""){
        html += "É necessário informa o corpo do email!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        idContato = obj.co_seq_contato.value;
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
        $(window).ready(function() {
            $('#loading').show();
        });
        $(".btn-responder-cliente").attr("disabled","disabled");
        var array = {"nm_assunto": obj.nm_assunto.value, "tx_mensagem": obj.tx_mensagem.value, "co_seq_contato": obj.co_seq_contato.value, "nm_email": obj.nm_email.value};
        ajaxPost(funcaoRespondeEmailCliente, array, "/contato/ajax-responder/", "/admin");
    }
    return false;
}

var funcaoRespondeEmailCliente = function(json){
    if(json!=null){
        overlay.remove();
        $(window).ready(function() {
            $('#loading').hide();
        });
        alert("Respondido com sucesso!");
        window.location.href = getUrlController() + "/admin/contato/view/id/"+idContato;
    }
};

function submitRespondeEmailCliente(){
    jQuery("#respondeEmail").submit();
}