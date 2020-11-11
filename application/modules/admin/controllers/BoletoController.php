<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 18/12/17
 * Time: 15:00
 */

class Admin_BoletoController extends Zend_Controller_Action {

    public $session_login;
    private $permissions = array(1, 2, 3, 6);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $controller = Zend_Controller_Front::getInstance();
        $actionName = $controller->getRequest()->getActionName();
        if(in_array($this->session_login->coTipoLogin, $this->permissions) || $actionName=="cancel" || $actionName=="ajax-cancel") {
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->_helper->layout->setLayout("layoutAdmin");
            $this->modelContratoGog = new Admin_Model_DbTable_ContratoGog();
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
                }else if($this->session_login->coTipoLogin==4){
                        $modelCliente = new Admin_Model_DbTable_Cliente();
                        $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
                }
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function printAction(){
        $idBoleto = $this->getParam("id");
        $this->redirect('/site/pdf/boleto/'.$idBoleto.'.pdf');
    }

}