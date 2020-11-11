<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 17/10/17
 * Time: 16:30
 */

class Admin_SobreController extends Zend_Controller_Action{

    private $modelSobre;
    public $session_login;
    private $permissions = array(1, 2);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->_helper->layout->setLayout("layoutAdmin");
            $this->modelSobre = new Admin_Model_DbTable_Sobre();
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

    public function editAction(){
        $this->view->dataSobre = $this->modelSobre->getAllSobre();
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        $this->modelSobre->sobre->edit($post, $post["co_seq_sobre"]);
        die(json_encode(array("msn"=>"200 ok")));
    }

}