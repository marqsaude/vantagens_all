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
includeJS("/site/js/cartao-marq/extension/check-cliente.js");
includeJS("/site/js/cartao-marq/extension/insert-mask.js");
includeJS("/site/js/cartao-marq/extension/is-mobile.js");
includeJS("/site/js/cartao-marq/extension/init-cadastro.js");
includeJS("/site/js/cartao-marq/extension/forma-pagamento.js");
includeJS("/site/js/cartao-marq/extension/cep.js");
includeJS("/site/js/cartao-marq/extension/cliente.js");
includeJS("/site/js/cartao-marq/extension/dependente.js");
includeJS("/site/js/cartao-marq/extension/vantagem.js");
includeJS("/site/js/cartao-marq/extension/finaliza.js");