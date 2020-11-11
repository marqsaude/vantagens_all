<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/04/16
 * Time: 17:36
 */

class Admin_ConsultaController extends Zend_Controller_Action {

    public $session_login;
    private $modelContato;
    private $modelConsulta;
    private $permissions = array(1, 2, 3);

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->session_login = $this->session_login;
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelConsulta = new Admin_Model_DbTable_Consulta();
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
        $this->view->dataConsulta = $this->modelConsulta->getAllConsulta();
    }

    public function addAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $modelPrestador = new Admin_Model_DbTable_Prestador();
            $this->view->dataPrestador = $modelPrestador->getAllPrestador();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $idConsulta = $this->getParam("id");
            $this->view->dataConsulta = $this->modelConsulta->getConsulta($idConsulta);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idConsulta = $this->getParam("id");
        $this->view->dataConsulta = $this->modelConsulta->getConsulta($idConsulta);
        $modelProcedimento = new Admin_Model_DbTable_Procedimento();
        $this->view->dataProcedimentoPrestador = $modelProcedimento->getProcedimentoPrestador($this->view->dataConsulta["co_seq_procedimento"]);
    }

    public function ajaxEditAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $post = $this->_request->getPost();
            $this->modelConsulta->consulta->edit($post, $post["co_seq_consulta"]);
            $dataProcedimento["nm_procedimento"] = $post["nm_consulta"];
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $modelProcedimento->procedimento->edit($dataProcedimento, array("co_consulta"=>$post["co_seq_consulta"]));
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxRemoveAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $post = $this->_request->getPost();
            $this->modelConsulta->consulta->excluir($post["id"], "co_seq_consulta");
            die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxAddAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $post = $this->_request->getPost();
            $procedimento["nu_valor"] = Util_Util::organizePrice($post["nu_valor"]);
            unset($post["nu_valor"]);
            $procedimento["nu_valor_real"] = Util_Util::organizePrice($post["nu_valor_real"]);
            unset($post["nu_valor_real"]);
            $prestadores = $post["prestadores"];
            unset($post["prestadores"]);
            $idConsulta = $this->modelConsulta->consulta->insertOne($post);
            $procedimento["co_consulta"] = $idConsulta;
            $procedimento["nm_procedimento"] = $post["nm_consulta"];
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $idProcedimento=$modelProcedimento->procedimento->insertOne($procedimento);
            foreach($prestadores as $key=>$value){
                $modelRLPrestadorProcedimento = new Admin_Model_DbTable_RLPrestadorProcedimento();
                $modelRLPrestadorProcedimento->prestadorProcedimento->insertOne(array("co_prestador"=>$value["id"], "co_procedimento"=>$idProcedimento));
            }
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxGetAction(){
        $data = $this->modelConsulta->getAllConsultaProcedimentoAtivo();
        die(json_encode(array("msn"=>"200 ok", "data"=>$data)));
    }

}