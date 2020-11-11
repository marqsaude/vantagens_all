/**
 * Created by tony on 10/01/18.
 */

var hasModal = false;
var i = 0;

function clickRecebeu(obj){
    $(function() {
        $("#recebeu-pagamento").show();
        $("#dinheiro-pagamento").hide();
        $("#boleto-pagamento").hide();
        $("#pag-seguro-pagamento").hide();
        $("#a-receber-pagamento").hide();
        onAllBtn();
        $(".btn-recebeu").addClass("btn-desativo");
    });
}

function clickDinheiro(obj){
    $(function() {
        $("#recebeu-pagamento").hide();
        $("#dinheiro-pagamento").show();
        $("#boleto-pagamento").hide();
        $("#pag-seguro-pagamento").hide();
        $("#a-receber-pagamento").hide();
        onAllBtn();
        $(".btn-dinheiro").addClass("btn-desativo");
    });
}

function clickBoleto(obj){
    $(function() {
        $("#recebeu-pagamento").hide();
        $("#dinheiro-pagamento").hide();
        $("#boleto-pagamento").show();
        $("#pag-seguro-pagamento").hide();
        $("#a-receber-pagamento").hide();
        onAllBtn();
        $(".btn-boleto").addClass("btn-desativo");
    });
}

function clickPagSeguro(obj){
    $(function() {
        $("#recebeu-pagamento").hide();
        $("#dinheiro-pagamento").hide();
        $("#boleto-pagamento").hide();
        $("#pag-seguro-pagamento").show();
        $("#a-receber-pagamento").hide();
        onAllBtn();
        $(".btn-pag-seguro").addClass("btn-desativo");
    });
}

function clickAReceber(obj){
    $(function() {
        $("#recebeu-pagamento").hide();
        $("#dinheiro-pagamento").hide();
        $("#boleto-pagamento").hide();
        $("#pag-seguro-pagamento").hide();
        $("#a-receber-pagamento").show();
        onAllBtn();
        $(".btn-a-receber").addClass("btn-desativo");
    });
}

function init(){
    $(function(){
        $("#dinheiro-pagamento").hide();
        $("#boleto-pagamento").hide();
        $("#pag-seguro-pagamento").hide();
        $("#a-receber-pagamento").hide();

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

function onAllBtn(){
    $(".btn-recebeu").removeClass("btn-desativo");
    $(".btn-dinheiro").removeClass("btn-desativo");
    $(".btn-boleto").removeClass("btn-desativo");
    $(".btn-pag-seguro").removeClass("btn-desativo");
    $(".btn-a-receber").removeClass("btn-desativo");
}

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