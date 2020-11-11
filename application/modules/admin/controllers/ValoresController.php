<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/10/17
 * Time: 09:28
 */

class Admin_ValoresController extends Zend_Controller_Action {

    private $post;
    private $permissions = array(1, 2, 3, 4, 6);
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->session_login = $this->session_login;
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

    public function exameAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getProcedimentoExame();
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function laboratorioAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getProcedimentoLaboratorio();
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function consultaAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getProcedimentoConsulta();
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

}