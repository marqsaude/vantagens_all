/**
 * Created by tony on 28/09/17.
 */

function submitCadastroVendedorCliente(){
    jQuery("#vendedorCliente").submit();
}

function validaVendedorCliente(obj){
    var html = "";
    if(obj.co_usuario.value==0){
        html += "Selecione um Usuário!\n";
    }
    if(html != "") {
        alert(html);
    }else{
        dataVendedor = obj.co_usuario.value;
        mountHtmlCliente();
        for(var i=0; i<7; i++) {
            $(".icon-circle-blank:eq(0)").addClass("icon-circle");
            $(".icon-circle-blank:eq(0)").removeClass("icon-circle-blank");
        }
    }
    return false;
}

function mountHtmlVendedor(){
    var htmlVendedor = '';
    htmlVendedor += '<form role="form" onSubmit="return validaVendedorCliente(this);" name="vendedorCliente" id="vendedorCliente">';
    htmlVendedor += '   <div id="dataTables-example_wrapper2" class="dataTables_wrapper form-inline" role="grid">';
    htmlVendedor += '       <div class="col-sm-12">&nbsp;</div>';
    htmlVendedor += '       <div class="col-sm-12">&nbsp;</div>';
    htmlVendedor += '       <div class="row">';
    htmlVendedor += '           <div class="col-sm-12">';
    htmlVendedor += '               <center>';
    htmlVendedor += '                   Selecione um Vendedor ou o sistema se o cadastro foi feita pela gerencia Q-Saúde.';
    htmlVendedor += '               </center>';
    htmlVendedor += '           </div>';
    htmlVendedor += '           <div class="col-sm-12">&nbsp;</div>';
    htmlVendedor += '           <div class="col-sm-2">&nbsp;</div>';
    htmlVendedor += '           <div class="col-sm-8">';
    htmlVendedor += '               <select class="form-control co_usuario" name="co_usuario">';
    htmlVendedor +=                     selectVendedor;
    htmlVendedor += '               </select>';
    htmlVendedor += '           </div>';
    htmlVendedor += '           <div class="col-sm-2">&nbsp;</div>';
    htmlVendedor += '       </div>';
    htmlVendedor += '       <div class="col-sm-12">&nbsp;</div>';
    htmlVendedor += '       <div class="col-sm-12">&nbsp;</div>';
    htmlVendedor += '       <div class="row">';
    htmlVendedor += '           <div class="col-lg-6">';
    htmlVendedor += '               <a href="'+getUrlController()+'/admin/cliente/index" class="btn btn-warning btn-lg btn-rect"><i class="icon-reply"></i>&nbsp;Clientes</a>';
    htmlVendedor += '           </div>';
    htmlVendedor += '           <div class="col-lg-6">';
    htmlVendedor += '               <a href="javascript:void(0);" style="float: right;" class="btn btn-info btn-lg btn-rect" onclick="submitCadastroVendedorCliente();">Próximo&nbsp;<i class="icon-share-alt"></i></a>';
    htmlVendedor += '           </div>';
    htmlVendedor += '       </div>';
    htmlVendedor += '   </div>';
    htmlVendedor += '</form>';

    $("#cartao-vantagem").html(htmlVendedor);
    $(".co_usuario option").removeAttr("selected");
    $(".co_usuario option[value="+selectedVendedor+"]").attr("selected", "selected");
}