/**
 * Created by tony on 22/03/17.
 */

//Dados dos cadastros
var arrayCliente = {};
var arrayTelefone = {};
var arrayCep = {};
var arrayAcordo = {};
var arrayPagamento = {};
var arrayCartao = {};
var dataContratoGog=null;
var dataFormaPagamento=null;
var dataTipoVantagem=null;
var dataDependentes=[];
var dataEndereco=null;
var dataTipoDependentes=null;
var dataVantagem=null;
var urlContrato=null;

//Pré Variáveis
var urlPdf = getUrlController()+'/adm/contrato/';

//Verificações
var countDependentes=1;
var countVantagem=0;
var numeroDependentes=1;
var voltaDependencia=false;
var cep="";
var cartao="";
var objCep=null;
var objFormaPagamento = null;
var htmlValidaPagamento="";
var priceContratoGog=null;
var back=false;

//Includes
includeJS("/def/js/scripts/cliente/extension/check-cliente.js");
includeJS("/def/js/scripts/cliente/extension/insert-mask.js");
includeJS("/def/js/scripts/cliente/extension/is-mobile.js");
includeJS("/def/js/scripts/cliente/extension/init-cadastro.js");
includeJS("/def/js/scripts/cliente/extension/forma-pagamento.js");
includeJS("/def/js/scripts/cliente/extension/cep.js");
includeJS("/def/js/scripts/cliente/extension/cliente.js");
includeJS("/def/js/scripts/cliente/extension/dependente.js");
includeJS("/def/js/scripts/cliente/extension/vantagem.js");
includeJS("/def/js/scripts/cliente/extension/finaliza.js");