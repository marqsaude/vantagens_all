<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 01/11/17
 * Time: 17:35
 */

class Admin_CorpoClinicoController  extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $modelCorpoClinico;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelCorpoClinico = new Admin_Model_DbTable_CorpoClinico();
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
        $this->view->dataCorpoClinico = $this->modelCorpoClinico->getAllCorpoClinico();
        $this->view->session_login = $this->session_login;
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3) {
            $modelTipoCorpoClinico = new Admin_Model_DbTable_TipoCorpoClinico();
            $this->view->dataTipoCorpoClinico=$modelTipoCorpoClinico->getAllTipoCorpoClinico();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idCorpoClinico = $this->getParam("id");
        $this->view->dataCorpoClinico = $this->modelCorpoClinico->getCorpoClinico($idCorpoClinico);
    }

    public function editAction(){
        $idCorpoClinico = $this->getParam("id");
        $modelTipoCorpoClinico = new Admin_Model_DbTable_TipoCorpoClinico();
        $this->view->dataTipoCorpoClinico=$modelTipoCorpoClinico->getAllTipoCorpoClinico();
        $this->view->dataCorpoClinico = $this->modelCorpoClinico->getCorpoClinico($idCorpoClinico);
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        $this->modelCorpoClinico->corpoClinico->edit($post, $post["co_seq_corpo_clinico"]);
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $this->modelCorpoClinico->corpoClinico->insertOne($post);
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $this->modelCorpoClinico->corpoClinico->excluir($post["id"], "co_seq_corpo_clinico");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

}