<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 11:42
 */

class Admin_ClienteController extends Zend_Controller_Action {

    private $post;
    private $modelCliente;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);
    private $authVeryLight = array(1, 2, 3, 6, 7);
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->view->coSeqCliente = $this->session_login->coSeqPaciente;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelCliente = new Admin_Model_DbTable_Cliente();
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            }else if($this->session_login->coTipoLogin==3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            }else if($this->session_login->coTipoLogin==5){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteVendedor($this->session_login->coSeqPaciente);
            }else
            if($this->session_login->coTipoLogin==4){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
            }
        }
    }

    public function indexAction(){
        $page = $this->getParam("page");
        $perPage = $this->getParam("per");
        if(in_array($this->session_login->coTipoLogin, $this->authVeryLight)) {
            $page = ($page == null) ? 1 : $page;
            $perPage = ($perPage == null) ? 20 : ($perPage != 10 && $perPage != 25 && $perPage != 50 && $perPage != 100) ? 20 : $perPage;
            $dataCliente = $this->modelCliente->getClientes("", $page, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $this->view->dataCliente = $dataCliente["data"];
            $this->view->dataCount = intval($count);
            $this->view->id = $page;
            $this->view->perPage = $perPage;
            $this->view->arrayPerPage = array(10, 25, 50, 100);
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->view->count = $dataCliente["data"][0]["n"];
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $this->view->vidas = $this->view->count+($modelDependentes->getQtdDependentes());
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idCliente = $this->getParam("id");
        if(in_array($this->session_login->coTipoLogin, $this->authVeryLight)) {
            $data=$this->modelCliente->getCliente($idCliente);
            $this->view->dataCliente = $data["cliente"];
            $this->view->dataTelefone = $data["telefone"];
            $this->view->stCliente = $data["cliente"]["st_cliente"];
            $modelBoleto = new Admin_Model_DbTable_Boleto();
            $this->view->dataBoleto = $modelBoleto->getBoletoByCliente($data["cliente"]["co_seq_cliente"]);
            $modelOcorrencia = new Admin_Model_DbTable_Ocorrencia();
            $this->view->dataOcorrencia = $modelOcorrencia->getOcorrenciaByCliente($idCliente);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        $idCliente = $this->getParam("id");
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $data = $this->modelCliente->getClienteEdit($idCliente);
            //var_dump(Util_Util::getDataClient($data["cliente"]["dt_nascimento"]));exit;
            $data["cliente"]["dt_nascimento"]=substr(Util_Util::getDataClient($data["cliente"]["dt_nascimento"]), 0, 10);
            $this->view->dataCliente = $data["cliente"];
            $this->view->dataTelefone = $data["telefone"];
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3 || $this->session_login->coTipoLogin==6) {
            $modelUsuario = new Admin_Model_DbTable_Usuario();
            $this->view->dataUsuario = $modelUsuario->getVendedor();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function excludedAction(){
        $page = $this->getParam("page");
        $perPage = $this->getParam("per");
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $page = ($page == null) ? 1 : $page;
            $perPage = ($perPage == null) ? 20 : ($perPage != 10 && $perPage != 25 && $perPage != 50 && $perPage != 100) ? 20 : $perPage;
            $dataCliente = $this->modelCliente->getClientesExcluido("", $page, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $this->view->dataCliente = $dataCliente["data"];
            $this->view->dataCount = intval($count);
            $this->view->id = $page;
            $this->view->perPage = $perPage;
            $this->view->arrayPerPage = array(10, 25, 50, 100);
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->view->count = $dataCliente["data"][0]["n"];
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $this->view->vidas = $this->view->count+($modelDependentes->getQtdDependentes());
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxEditAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $post = $this->_request->getPost();
            $post["cliente"]["dt_nascimento"] = str_replace("'", "", Util_Util::changeDateToSql($post["cliente"]["dt_nascimento"]));
            $post["cliente"]["nu_rg"] = str_replace(".", "", $post["cliente"]["nu_rg"]);
            $post["cliente"]["nu_rg"] = str_replace("-", "", $post["cliente"]["nu_rg"]);
            $post["cliente"]["nu_cpf"] = str_replace(".", "", $post["cliente"]["nu_cpf"]);
            $post["cliente"]["nu_cpf"] = str_replace("-", "", $post["cliente"]["nu_cpf"]);
            $post["cep"]["nu_cep"] = str_replace("-", "", $post["cep"]["nu_cep"]);
            $post["cep"]["nu_cep"] = str_replace(".", "", $post["cep"]["nu_cep"]);
            $post["ddd"]["nu_telefone"] = substr($post["telefone"]["nu_telefone"], 1, 2);
            $post["ddd"]["nu_celular"] = substr($post["telefone"]["nu_celular"], 1, 2);
            $post["ddd"]["nu_whatsapp"] = substr($post["telefone"]["nu_whatsapp"], 1, 2);
            $post["telefone"]["nu_telefone"] = substr(str_replace("-", "", $post["telefone"]["nu_telefone"]), 5);
            $post["telefone"]["nu_celular"] = substr(str_replace("-", "", $post["telefone"]["nu_celular"]), 5);
            $post["telefone"]["nu_whatsapp"] = substr(str_replace("-", "", $post["telefone"]["nu_whatsapp"]), 5);
            //var_dump($post);exit;
            $modelCep = new Admin_Model_DbTable_Cep();
            $dataCep = $modelCep->getByCep($post["cep"]["nu_cep"]);
            if ($dataCep) {
                $post["cliente"]["co_cep"] = $dataCep[0]["co_seq_cep"];
            } else {
                $post["cliente"]["co_cep"] = $modelCep->cep->insertOne($post["cep"]);
            }

            $modelClienteTelefone = new Admin_Model_DbTable_RLClienteTelefone();
            $modelClienteTelefone->clienteTelefone->edit(array("st_registro" => 2), array("co_cliente" => $post["ids"]["co_seq_cliente"]));

            $this->checkTelefone($post["telefone"]["nu_telefone"], $post["ddd"]["nu_telefone"], $post["ids"]["co_seq_cliente"]);
            $this->checkTelefone($post["telefone"]["nu_celular"], $post["ddd"]["nu_celular"], $post["ids"]["co_seq_cliente"]);
            $this->checkTelefone($post["telefone"]["nu_whatsapp"], $post["ddd"]["nu_whatsapp"], $post["ids"]["co_seq_cliente"]);

            $this->modelCliente->cliente->edit($post["cliente"], $post["ids"]["co_seq_cliente"]);
            $modelUsuario = new Admin_Model_DbTable_Usuario();
            $modelUsuario->usuario->edit(array("nm_login" => $post["cliente"]["nm_email"]), $post["cliente"]["co_usuario"]);
        }
        die(json_encode(array("msn"=>"200 ok" , "data"=>"")));
    }

    public function ajaxGetClientAction(){
        $post = $this->_request->getPost();
        $dataCliente = $this->modelCliente->getClientes($post["page"]);
        die(json_encode(array("msn"=>"200 ok" , "data"=>$dataCliente["data"])));
    }

    public function ajaxSearchNameAction(){
        $post = $this->_request->getPost();
        $number = (is_numeric($post["search"]))?true:false;
        if($number==false) {
            $dataCliente = $this->modelCliente->getClientes($post["search"]);
        }else{
            $dataCliente = $this->modelCliente->getClientesByCPF($post["search"]);
        }
        die(json_encode(array("msn"=>"200 ok", "data"=>$dataCliente["data"])));
    }

    public function ajaxDisableClienteAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $dataCliente = $this->modelCliente->cliente->edit(array("st_cliente" => 2), $post["co_seq_cliente"]);
            die(json_encode(array("msn"=>"200 ok", "data"=>$dataCliente["data"])));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxEnableClienteAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $dataCliente = $this->modelCliente->cliente->edit(array("st_cliente"=>1), $post["co_seq_cliente"]);
            die(json_encode(array("msn"=>"200 ok", "data"=>$dataCliente["data"])));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxNaoPagoBoletoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelBoleto = new Admin_Model_DbTable_Boleto();
            $modelBoleto->boleto->edit(array("st_pago"=>2), $post["co_seq_boleto"]);
            $modelBoleto->clean();
            $dataBoleto = $modelBoleto->getBoleto($post["co_seq_boleto"]);
            $this->changeRemoveValue($dataBoleto["co_pagamento"], $post["co_seq_boleto"]);
            die(json_encode(array("msn"=>"200 ok", "data"=>$post["co_seq_boleto"])));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxPagaBoletoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelBoleto = new Admin_Model_DbTable_Boleto();
            $modelBoleto->boleto->edit(array("st_pago" => 1), $post["co_seq_boleto"]);
            $modelBoleto->clean();
            if($post["antigo"]==1){
                $dataBoleto = $modelBoleto->getBoleto($post["co_seq_boleto"]);
                $this->changePagamento($dataBoleto["co_pagamento"]);
                $this->changeAddValue($dataBoleto["co_pagamento"], $post["co_seq_boleto"]);
                die(json_encode(array("msn"=>"200 ok", "data"=>array("id" => $post["co_seq_boleto"], "gerado"=>2 ))));
            }else {
                $dataBoleto = $modelBoleto->getNextBoleto($post["co_seq_cliente"]);
                $modelBoleto->clean();
                if($dataBoleto == null || $dataBoleto == ""){
                    $modelPagamento = new Admin_Model_DbTable_Pagamento();
                    $dataPagamento = $modelPagamento->getByCliente($post["co_seq_cliente"]);
                    $this->changePagamento($dataPagamento["co_seq_pagamento"]);
                    $this->changeAddValue($dataPagamento["co_seq_pagamento"], $post["co_seq_boleto"]);
                    die(json_encode(array("msn"=>"200 ok", "data"=>array("id" => $post["co_seq_boleto"], "gerado"=>2 ))));
                }else{
                    $this->changePagamento($dataBoleto["co_pagamento"]);
                    $this->changeAddValue($dataBoleto["co_pagamento"], $post["co_seq_boleto"]);
                    $arrayBoleto = $this->setPostBoleto($dataBoleto);
                    $boleto = new Boleto_Boleto($arrayBoleto, array($arrayBoleto["post"]["co_seq_boleto"]), 0, false);
                    $htmlArray = $boleto->gerar();
                    $pdfArray = array();
                    for ($i = 0; $i < count($htmlArray); $i++) {
                        $pdfArray[$i] = $arrayBoleto["post"]["co_seq_boleto"] . ".pdf";
                    }
                    die(json_encode(array("msn"=>"200 ok", "data"=>array("id" => $post["co_seq_boleto"], "gerado"=>1 ))));
                }
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxPagaPagseguroAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            if($post["tx_id_pagseguro"] == null || empty($post["tx_id_pagseguro"])){
                $dataPagamento = $modelPagamento->getByCliente($post["co_seq_cliente"]);
                $arrayEdit = array("tx_id_pagseguro" => $dataPagamento["tx_id_pagseguro"]);
            }else{
                $arrayEdit = array("tx_id_pagseguro" => $post["tx_id_pagseguro"]);
            }
            $modelPagamento->clean();
            $modelPagamento->pagamento->edit(array("co_status_pagamento" => 3), $arrayEdit);
            $this->changeAddValuePS($post["tx_id_pagseguro"]);
            die(json_encode(array("msn" => "200 ok", "data"=>array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxNaoPagaPagseguroAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento"=>6), array("tx_id_pagseguro" => $post["tx_id_pagseguro"]));
            $this->changeRemoveValuePS($post["tx_id_pagseguro"]);
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxPagaDinheiroAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getPagamentoByCliente($post["co_seq_cliente"]);
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento"=>3), $dataCliente["co_seq_pagamento"]);
            $this->changeAddValueDinheiro($dataCliente["co_seq_pagamento"]);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxNaoPagaDinheiroAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getPagamentoByCliente($post["co_seq_cliente"]);
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento"=>6), $dataCliente["co_seq_pagamento"]);
            $this->changeRemoveValueDinheiro($dataCliente["co_seq_pagamento"]);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxPagaCartaoPresencialAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getPagamentoByCliente($post["co_seq_cliente"]);
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento"=>3), $dataCliente["co_seq_pagamento"]);
            $this->changeAddValueCartaoPresencial($dataCliente["co_seq_pagamento"]);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxNaoPagaCartaoPresencialAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataCliente = $modelCliente->getPagamentoByCliente($post["co_seq_cliente"]);
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->pagamento->edit(array("co_status_pagamento"=>6), $dataCliente["co_seq_pagamento"]);
            $this->changeRemoveValueCartaoPresencial($dataCliente["co_seq_pagamento"]);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxReenviarEmailAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium) || $this->session_login->coSeqPaciente==72) {
            $post = $this->_request->getPost();
            $modelEmail = new Admin_Model_DbTable_Email();
            $dataEmail = $modelEmail->getEmailResend($post["co_seq_cliente"]);
            if($dataEmail[0]["co_forma_pagamento"] == 1){
                $modelBoleto = new Admin_Model_DbTable_Boleto();
                $dataBoleto = $modelBoleto->getBoletoByCliente($post["co_seq_cliente"]);
            }else{
                $dataBoleto = array();
            }
            $emailSendEmail = new Email_SendEmail();
            $emailSendEmail->resend($dataEmail, $dataBoleto);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxRegistraCodigoPagseguroAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $modelPagamento->insertCodePagSeguro($post["co_seq_pagamento"], $post["tx_id_pagseguro"]);
            $modelEmail = new Admin_Model_DbTable_Email();
            if(!$modelEmail->checkEmailExist($post["co_seq_cliente"])){
                $this->modelCliente->clean();
                $dataCliente = $this->modelCliente->getClienteDependente($post["co_seq_cliente"])[0];
                $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
                $dataConfiguracao = $modelConfiguracao->getAll();
                $emailSendEmail = new Email_SendEmail($dataCliente, Util_Util::getGenerateCode(), array("nm_contrato_gog"=>$dataCliente["nm_contrato_gog"]), $post["tx_id_pagseguro"]);
                $emailSendEmail->send(null, $dataConfiguracao[0], false);
            }
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_seq_cliente"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxAddOcorrenciaAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $post["co_usuario"] = $this->session_login->coSeqPaciente;
            $modelOcorrencia = new Admin_Model_DbTable_Ocorrencia();
            $modelOcorrencia->ocorrencia->insertOne($post);
            die(json_encode(array("msn"=>"200 ok", "data" => array("id"=>$post["co_cliente"]))));
        }else {
            $this->_helper->redirector("index", "error", 'admin', array('code' => '403'));
        }
    }

    private function changePagamento($idPagamento){
        $modelPagamento = new Admin_Model_DbTable_Pagamento();
        return $modelPagamento->pagamento->edit(array("co_status_pagamento" => 3), $idPagamento);
    }

    private function changeAddValue($coPagamento, $idBoleto){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoBoleto($coPagamento, $idBoleto);
    }

    private function changeRemoveValue($coPagamento, $idBoleto){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoBoletoRemove($coPagamento, $idBoleto);
    }

    private function changeAddValuePS($code){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editByCodePagSeguro($code);
    }

    private function changeRemoveValuePS($code){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editByCodePagSeguroRemove($code);
    }

    private function changeAddValueDinheiro($coPagamento){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoDinheiro($coPagamento);
    }

    private function changeRemoveValueDinheiro($coPagamento){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoDinheiroRemove($coPagamento);
    }

    private function changeAddValueCartaoPresencial($coPagamento){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoCartaoPresencial($coPagamento);
    }

    private function changeRemoveValueCartaoPresencial($coPagamento){
        $modelExtrato = new Admin_Model_DbTable_Extrato();
        $modelExtrato->editExtratoCartaoPresencialRemove($coPagamento);
    }

    private function checkTelefone($telefone, $ddd, $id){
        $dataClienteTelefone=null;
        $dataClienteTelefone["co_cliente"]=$id;
        if($telefone!=false || $telefone!=null) {
            $modelTelefone = new Admin_Model_DbTable_Telefone();
            $dataTelefone = $modelTelefone->getByTelefone($telefone, $ddd);
            if ($dataTelefone) {
                $dataClienteTelefone["co_telefone"] = $dataTelefone[0]["co_seq_telefone"];
            } else {
                $modelDdd = new Admin_Model_DbTable_Ddd();
                $dataDdd = $modelDdd->getDdd($ddd);
                $data = array("co_ddd" => $dataDdd[0]["co_seq_ddd"], "nu_telefone" => $telefone, "nu_ddd" => $ddd, "tp_telefone" => "T");
                $dataClienteTelefone["co_telefone"] = $modelTelefone->telefone->insertOne($data);
            }

            $modelClienteTelefone = new Admin_Model_DbTable_RLClienteTelefone();
            $modelClienteTelefone->clienteTelefone->insertOne($dataClienteTelefone);

        }
    }

    private function setPostBoleto($dataBoleto){
        $arrayBoleto["post"]["co_seq_boleto"] = $dataBoleto["co_seq_boleto"];
        $arrayBoleto["post"]["nomeSacado"] = $dataBoleto["nm_cliente"];
        $arrayBoleto["post"]["cpfCGC"] = $dataBoleto["nu_cpf"];
        $arrayBoleto["post"]["dataNascimento"] = $dataBoleto["dt_nascimento"];
        $arrayBoleto["post"]["endereco"] = $dataBoleto["nm_logradouro"]." ".$dataBoleto["nm_complemento"]." ".$dataBoleto["nu_endereco"];
        $arrayBoleto["post"]["bairro"] = $dataBoleto["nm_bairro"];
        $arrayBoleto["post"]["cidade"] = $dataBoleto["nm_localidade"];
        $arrayBoleto["post"]["cep"] = $dataBoleto["nu_cep"];
        $arrayBoleto["post"]["uf"] = $dataBoleto["nm_uf"];
        $arrayBoleto["post"]["telefone"] = $dataBoleto["nu_telefone"];
        $arrayBoleto["post"]["ddd"] = $dataBoleto["nu_ddd"];
        $arrayBoleto["post"]["email"] = $dataBoleto["nm_email"];
        $arrayBoleto["post"]["dateVencimentoTit"] = $dataBoleto["dt_vencimento"];
        $arrayBoleto["post"]["seuNumero"] = $dataBoleto["nu_boleto"];
        $arrayBoleto["post"]["price"] = $dataBoleto["nu_valor"];
        return $arrayBoleto;
    }

}