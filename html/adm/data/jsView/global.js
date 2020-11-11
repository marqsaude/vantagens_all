$.getScript("../../../global.js", function(){

});

/**
 * Created by tonyanderson on 19/05/14.
 */
function ajaxPost(funcao, array, action){
    ajaxPost(funcao, array, action, "/admin");
    return false;
}

function ajaxGet(funcao, array, action){
    $(function(){
        $.ajax({
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

function getUrlController(){
    var t = $("#url-page").html();
    var split = t.split("/");
    return t.replace("/"+split[split.length-1], "/ajax-"+split[split.length-1]);
}

function somente_numero(campo){
    var digits="0123456789";
    var campo_temp;
    for (var i=0;i<campo.value.length;i++){
        campo_temp=campo.value.substring(i,i+1);
        if (digits.indexOf(campo_temp)==-1){
            campo.value = campo.value.substring(0,i);
        }
    }
}

function maskElements() {
    $(function () {
        $(".elemento-preco").maskMoney({symbol: 'R$ ', showSymbol: true, thousands: '.', decimal: ',', symbolStay: true});
        $(".elemento-numero").attr("onkeyup", "javascript:somente_numero(this);");
        $(".elemento-data").mask("99/99/9999");
        $(".elemento-documento").focusout(function(){
            var phone, element;
            element = $(this);
            element.unmask();
            phone = element.val().replace(/\D/g, '');
            if(phone.length < 12) {
                element.mask("999.999.999-99?999");
            } else {
                element.mask("99.999.999/9999-99");
                if(phone.length < 14){
                    element.unmask();
                    element.mask("999.999.999-99?999");
                }
            }
        }).trigger('focusout');
    });
}

function autoCompletar(){
    jQuery(document).ready(function(){

        // Chosen Select
        jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});

        // Tags Input
        jQuery('#tags').tagsInput({width:'auto'});

        // Textarea Autogrow
        jQuery('#autoResizeTA').autogrow();

        // Color Picker
        if(jQuery('#colorpicker').length > 0) {
            jQuery('#colorSelector').ColorPicker({
                onShow: function (colpkr) {
                    jQuery(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    jQuery(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
                    jQuery('#colorpicker').val('#'+hex);
                }
            });
        }

        // Color Picker Flat Mode
        jQuery('#colorpickerholder').ColorPicker({
            flat: true,
            onChange: function (hsb, hex, rgb) {
                jQuery('#colorpicker3').val('#'+hex);
            }
        });

        // Date Picker
        jQuery('#datepicker').datepicker();

        jQuery('#datepicker-inline').datepicker();

        jQuery('#datepicker-multiple').datepicker({
            numberOfMonths: 3,
            showButtonPanel: true
        });

        // Spinner
        var spinner = jQuery('#spinner').spinner();
        spinner.spinner('value', 0);

        // Input Masks
        jQuery("#date").mask("99/99/9999");
        jQuery("#phone").mask("(999) 999-9999");
        jQuery("#ssn").mask("999-99-9999");

        // Time Picker
        jQuery('#timepicker').timepicker({defaultTIme: false});
        jQuery('#timepicker2').timepicker({showMeridian: false});
        jQuery('#timepicker3').timepicker({minuteStep: 15});


    });
}


function runRequired(){
    maskElements();
    autoCompletar();
}

runRequired();


