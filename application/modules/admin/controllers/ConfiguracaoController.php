<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 06/09/17
 * Time: 09:03
 */

class Admin_ConfiguracaoController extends Zend_Controller_Action{

    public $data;
    public $session_login;
    private $permissions = array(1);

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $this->view->coTipoLogin = $this->session_login->coTipoLogin;
            $this->_helper->layout->setLayout("layoutAdmin");
            $this->modelContato = new Admin_Model_DbTable_Contato();
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
        $modelTipoUsuario = new Admin_Model_DbTable_TipoUsuario();
        $this->view->dataTipoUsuario = $modelTipoUsuario->getAllTipoUsuario();
        $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
        $dataConfiguracao = $modelConfiguracao->getAll();
        $this->view->dataConfiguracao = $dataConfiguracao[0];
    }

}