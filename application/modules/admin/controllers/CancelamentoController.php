<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 08/02/18
 * Time: 11:31
 */

class Admin_CancelamentoController extends Zend_Controller_Action {

    private $post;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
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

    public function clienteAction(){
        $page = $this->getParam("page");
        $perPage = $this->getParam("per");
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $page = ($page == null) ? 1 : $page;
            $perPage = ($perPage == null) ? 10 : ($perPage != 10 && $perPage != 25 && $perPage != 50 && $perPage != 100) ? 10 : $perPage;
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $dataClienteCancelados = $modelCliente->getClientesCancelaCancelados("", $page, $perPage);
            $countCancelados = ($dataClienteCancelados["count"] / $perPage);
            $countIntCancelado = intval($countCancelados);
            $countCancelados = ($countCancelados == $countIntCancelado) ? $countCancelados : $countCancelados + 1;
            $this->view->dataClienteCancelados = $dataClienteCancelados["data"];
            $this->view->dataCountCancelados = intval($countCancelados);
            $this->view->id = $page;
            $this->view->perPage = $perPage;
            $this->view->arrayPerPage = array(10, 25, 50, 100);
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->view->countCancelados = $dataClienteCancelados["data"][0]["n"];
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxGetPagamentoAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post = $this->_request->getPost();
            $modelPagamento = new Admin_Model_DbTable_Pagamento();
            $dataPagamento = $modelPagamento->getByCliente($post["idCliente"]);
            die(json_encode(array("msn" => "200 ok", "data"=>array("id"=>$dataPagamento["co_seq_pagamento"]))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

}