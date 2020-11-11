<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 07/05/2018
 * Time: 11:14
 */

class Admin_SimulacaoController extends Zend_Controller_Action
{

    public $session_login;
    private $modelSimulacao;

    public function init() {
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->session_login = $this->session_login;
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelSimulacao = new Admin_Model_DbTable_Simulacao();
        if (!Util_Util::isAjax()) {
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if ($this->session_login->coTipoLogin == 1 || $this->session_login->coTipoLogin == 2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            } else if ($this->session_login->coTipoLogin == 3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            } else if ($this->session_login->coTipoLogin == 5) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteVendedor($this->session_login->coSeqPaciente);
            } else
                if ($this->session_login->coTipoLogin == 4) {
                    $modelCliente = new Admin_Model_DbTable_Cliente();
                    $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
                }
        }
    }

    public function indexAction(){
        $page = $this->getParam("page");
        $perPage = $this->getParam("per");
        if(in_array($this->session_login->coTipoLogin, Util_Permissao::authMedium)) {
            $page = ($page == null) ? 1 : $page;
            $perPage = ($perPage == null) ? Util_PerPage::simulacaoIndex : ($perPage != Util_PerPage::simulacaoIndex && $perPage != 25 && $perPage != 50 && $perPage != 100) ? Util_PerPage::simulacaoIndex : $perPage;
            $dataSimulacao = $this->modelSimulacao->getAllSimulacao("", $page, $perPage);
            $count = ($dataSimulacao["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $this->view->dataSimulacao = $dataSimulacao["data"];
            $this->view->dataCount = intval($count);
            $this->view->id = $page;
            $this->view->perPage = $perPage;
            $this->view->arrayPerPage = array(Util_PerPage::simulacaoIndex, 25, 50, 100);
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        if(in_array($this->session_login->coTipoLogin, Util_Permissao::authMedium)) {
            $idSimulacao = $this->getParam("id");
            $this->view->dataSimulacao = $this->modelSimulacao->getSimulacao($idSimulacao);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxValidAction(){
        $post = $this->_request->getPost();
        $idSimulacao = $post["co_seq_simulacao"];
        unset($post["co_seq_simulacao"]);
        $this->modelSimulacao->simulacao->edit($post, $idSimulacao);
        die(json_encode(array("msn"=>"200 ok", "id"=>$idSimulacao)));
    }

    public function ajaxSearchNameAction(){
        $post = $this->_request->getPost();
        $dataSimulacao = $this->modelSimulacao->getAllSimulacao($post["search"]);
        die(json_encode(array("msn"=>"200 ok", "data"=>$dataSimulacao["data"])));
    }

}