<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 13/10/17
 * Time: 15:45
 */

class Admin_MaisVoceController  extends Zend_Controller_Action {

    private $post;
    private $modelMaisVoce;
    public $session_login;
    private $permissions = array(1, 2);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->_helper->layout->setLayout("layoutAdmin");
            $this->modelMaisVoce = new Admin_Model_DbTable_MaisVoce();
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
        $this->view->dataMaisVoce = $this->modelMaisVoce->getAllMaisVoce();
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {

        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idMaisVoce = $this->getParam("id");
        $this->view->dataMaisVoce = $this->modelMaisVoce->getMaisVoce($idMaisVoce);
    }

    public function editAction(){
        $idMaisVoce = $this->getParam("id");
        $this->view->dataMaisVoce = $this->modelMaisVoce->getMaisVoce($idMaisVoce);
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $this->modelMaisVoce->maisVoce->excluir($post["id"], "co_seq_mais_voce");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        $this->modelMaisVoce->maisVoce->edit($post, $post["co_seq_mais_voce"]);
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $post["co_usuario"] = $this->session_login->coSeqPaciente;
        $this->modelMaisVoce->maisVoce->insertOne($post);
        die(json_encode(array("msn"=>"200 ok")));
    }

}