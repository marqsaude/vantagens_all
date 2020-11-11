/**
 * Created by tony on 03/08/17.
 */

function insertMask(){
    jQuery(".nu_telefone").mask("(00) 0000-00009");
    jQuery("#nu_telefone").keyup(function(event) {
        if(jQuery(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            jQuery('.nu_teefone').mask('(00) 00000-0009');
        }else{
            jQuery('.nu_telefone').mask('(00) 0000-00009');
        }
    });
    jQuery(".nu_celular").mask("(99) 99999-9999");
    jQuery(".nu_whatsapp").mask("(99) 99999-9999");
    jQuery('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        yearRange: "-100:+0",
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior',
        currentText: 'Mês Atual',
        closeText: 'Atualizar'
    });
    jQuery(".nu_cpf").mask("999.999.999-99");
    jQuery(".nu_cep").mask("99.999-999");
    jQuery(".nu_endereco").mask("9999999");
}