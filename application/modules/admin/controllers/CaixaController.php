<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 11:43
 */

class Admin_CaixaController extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $modelCaixa;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->_helper->layout->setLayout("layoutAdmin");
            $this->modelCaixa = new Admin_Model_DbTable_Caixa();
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
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function indexAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $this->view->dataCaixa = $this->modelCaixa->getAllCaixa();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $idCaixa = $this->getParam("id");
            $this->view->dataCaixa = $this->modelCaixa->getCaixa($idCaixa);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function extratoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $modelExtrato = new Admin_Model_DbTable_Extrato();
            $this->view->dataExtrato = $modelExtrato->getExtrato($this->view->dataCaixaE["co_seq_caixa"]);
            $this->view->totalDinheiro = 0;
            $this->view->totalBoleto = 0;
            $this->view->totalPagSeguro = 0;
            $i=0;
            foreach($this->view->dataExtrato as $value){
                if($value["st_pagamento"]==1 && $value["co_seq_forma_pagamento"]==6){
                    $this->view->totalDinheiro = ($value["st_pagamento"]==1)?$this->view->totalDinheiro+$value["nu_valor_transacao"]:$this->view->totalDinheiro;
                }
                if($value["st_pagamento"]==1 && $value["co_seq_forma_pagamento"]==1){
                    $this->view->totalBoleto = ($value["st_pagamento"]==1)?$this->view->totalBoleto+$value["nu_valor_transacao"]:$this->view->totalBoleto;
                }
                if($value["co_seq_forma_pagamento"]==1){
                    $modelBoleto = new Admin_Model_DbTable_Boleto();
                    $dataBoleto = $modelBoleto->getBoleto($this->view->dataExtrato[$i]["nu_id_boleto"]);
                    $this->view->dataExtrato[$i]["dt_vencimento"] = $dataBoleto["dt_vencimento"];
                }else{
                    $this->view->dataExtrato[$i]["dt_vencimento"] = "---";
                }
                if($value["st_pagamento"]==1 && $value["co_seq_forma_pagamento"]==3){
                    $this->view->totalPagSeguro = ($value["st_pagamento"]==1)?$this->view->totalPagSeguro+$value["nu_valor_transacao"]:$this->view->totalPagSeguro;
                }
                $i++;
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function addAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $modelEmpresa = new Admin_Model_DbTable_Empresa();
            $this->view->dataEmpresa = $modelEmpresa->getAllEmpresa();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $idCaixa = $this->getParam("id");
            $this->view->dataCaixa = $this->modelCaixa->getCaixa($idCaixa);
            $modelEmpresa = new Admin_Model_DbTable_Empresa();
            $this->view->dataEmpresa = $modelEmpresa->getAllEmpresa();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxEditAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $this->modelCaixa->caixa->edit($post, $post["co_seq_caixa"]);
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxAddAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $dataCaixa = $post;
            $dataCaixa["nu_saldo"] = 0;
            $dataCaixa["nu_procedimento"] = 0;
            $dataCaixa["st_ativo"] = 2;
            $this->modelCaixa->caixa->insertOne($dataCaixa);
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxActiveAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $post = $this->_request->getPost();
            $this->modelCaixa->caixa->edit(array("st_ativo"=>2), array("st_registro"=>1));
            $modelCaixa = new Admin_Model_DbTable_Caixa();
            $modelCaixa->caixa->edit(array("st_ativo"=>1), array("co_seq_caixa"=>$post["co_seq_caixa"]));
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

}