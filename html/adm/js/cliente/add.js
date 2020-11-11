/**
 * Created by tony on 28/09/17.
 */

//Dados dos cadastros
var arrayCliente = null;
var arrayTelefone = null;
var arrayCep = null;
var arrayAcordo = null;
var arrayPagamento = null;
var arrayCartao = null;
var dataContratoGog=null;
var dataFormaPagamento=null;
var dataTipoVantagem=null;
var dataDependentes=null;
var dataEndereco=null;
var dataTipoDependentes=null;
var dataVantagem=null;
var urlContrato=null;
var dataVendedor=null;
var selectVendedor=null;
var selectedVendedor=null;

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
includeJS("/adm/js/cliente/extension/vendedor.js");
includeJS("/adm/js/cliente/extension/check-cliente.js");
includeJS("/site/js/cartao-marq/extension/insert-mask.js");
includeJS("/adm/js/cliente/extension/is-mobile.js");
includeJS("/adm/js/cliente/extension/init-cadastro.js");
includeJS("/adm/js/cliente/extension/forma-pagamento.js");
includeJS("/adm/js/cliente/extension/cep.js");
includeJS("/adm/js/cliente/extension/cliente.js");
includeJS("/adm/js/cliente/extension/dependente.js");
includeJS("/adm/js/cliente/extension/vantagem.js");
includeJS("/adm/js/cliente/extension/finaliza.js");