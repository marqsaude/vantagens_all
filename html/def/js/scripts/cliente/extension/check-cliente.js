/**
 * Created by tony on 11/09/17.
 */

jQuery(function($) {

    var msg="";
    var elements = document.getElementsByTagName("INPUT");

    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid =function(e) {
            if (!e.target.validity.valid) {
                switch(e.target.id){
                    case 'nm_cliente' :
                        e.target.setCustomValidity("Cliente não pode ser vazio!");break;
                    case 'nu_rg' :
                        e.target.setCustomValidity("RG não pode ser vazio!");break;
                    case 'dt_nascimento' :
                        e.target.setCustomValidity("Data de Nascimento não pode ser vazio!");break;
                    case 'nu_telefone' :
                        e.target.setCustomValidity("Telefone não pode ser vazio!");break;
                    case 'nu_cpf' :
                        e.target.setCustomValidity("CPF não pode ser vazio!");break;
                    case 'nu_celular' :
                        e.target.setCustomValidity("Celular não pode ser vazio!");break;
                    case 'nm_email' :
                        e.target.setCustomValidity("Email não pode ser vazio!");break;
                    case 'nu_cep' :
                        e.target.setCustomValidity("CEP não pode ser vazio!");break;
                    default : e.target.setCustomValidity("");break;
                }
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity(msg);
        };
    }

});