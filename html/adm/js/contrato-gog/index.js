/**
 * Created by tony on 01/09/17.
 */

var objGeneral;

function excluirContratoGog(id, obj){
    objGeneral = obj;
    var array = {"id": id};
    ajaxPost(funcaoExcluirContratoGog, array, "/contrato-gog/ajax-verify-excluir/", "/admin");
}

var funcaoExcluirContratoGog = function(json){
    if(json!=null){
        if(json.verify==false) {
            excluirRegistro(json.id, objGeneral);
        }else{
            alert("Contrato não pode ser excluido!");
        }
    }
};