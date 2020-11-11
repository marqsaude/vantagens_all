<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 09:52
 */

class Admin_PerguntasController extends Zend_Controller_Action {

    private $post;
    private $modelPerguntas;
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelPerguntas = new Admin_Model_DbTable_Perguntas();
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
        $this->view->dataPerguntas = $this->modelPerguntas->getAllPerguntas();
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {

        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $idPerguntas = $this->getParam("id");
            $this->view->dataPerguntas = $this->modelPerguntas->getPerguntas($idPerguntas);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idPerguntas = $this->getParam("id");
        $this->view->dataPerguntas = $this->modelPerguntas->getPerguntas($idPerguntas);
    }

    public function ajaxEditAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $this->modelPerguntas->perguntas->edit($post, $post["co_seq_perguntas"]);
            die(json_encode(array("msn" => "200 ok")));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

    public function ajaxRemoveAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $this->modelPerguntas->parceiro->excluir($post["id"], "co_seq_perguntas");
            die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

    public function ajaxAddAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $post["co_usuario"] = $this->session_login->coSeqPaciente;
            $this->modelPerguntas->perguntas->insertOne($post);
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

}