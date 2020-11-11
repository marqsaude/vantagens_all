<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 11:42
 */

class Admin_ProcedimentoController extends Zend_Controller_Action {

    private $post;
    private $modelContato;
    private $modelProcedimento;
    private $permissions = array(1, 2, 3);
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->session_login = $this->session_login;
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelProcedimento = new Admin_Model_DbTable_Procedimento();
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
        $modelProcedimento = new Admin_Model_DbTable_Procedimento();
        $this->view->dataProcedimento = $modelProcedimento->getAllProcedimentoFull();
    }

    public function addAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $modelExame = new Admin_Model_DbTable_Exame();
            $this->view->dataExame = $modelExame->getExameAddProcedimento();
            $modelConsulta = new Admin_Model_DbTable_Consulta();
            $this->view->dataConsulta = $modelConsulta->geConsultaAddProcedimento();
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function viewAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $idProcedimento = $this->getParam("id");
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getProcedimento($idProcedimento);
            $modelProcedimento->clean();
            $this->view->dataProcedimentoPrestador = $modelProcedimento->getProcedimentoPrestador($idProcedimento);
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function editAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $idProcedimento = $this->getParam("id");
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $dataProcedimento = $modelProcedimento->getEditProcedimentoPrestador($idProcedimento);
            $this->view->dataProcedimento = (isset($dataProcedimento["procedimento"]))?$dataProcedimento["procedimento"]:array();
            $this->view->dataPrestadorTem = (isset($dataProcedimento["prestador"]))?$dataProcedimento["prestador"]:array();
            $modelPrestador = new Admin_Model_DbTable_Prestador();
            $this->view->dataPrestador = $modelPrestador->getAllPrestador($dataProcedimento["prestador"]);
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxEditAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $post = $this->_request->getPost();
            $post["nu_valor"] = Util_Util::organizePrice($post["nu_valor"]);
            $post["nu_valor_real"] = Util_Util::organizePrice($post["nu_valor_real"]);
            $prestadores = (isset($post["prestadores"]))?$post["prestadores"]:array();
            unset($post["prestadores"]);
            $this->modelProcedimento->procedimento->edit($post, $post["co_seq_procedimento"]);
            $modelPrestadorProcedimento = new Admin_Model_DbTable_RLPrestadorProcedimento();
            $modelPrestadorProcedimento->prestadorProcedimento->edit(array("st_registro"=>2), array("co_procedimento"=>$post["co_seq_procedimento"]));
            foreach($prestadores as $value) {
                $modelPrestadorProcedimento->clean();
                $data = array("co_prestador"=>$value["id"], "co_procedimento"=>$post["co_seq_procedimento"]);
                $modelPrestadorProcedimento->prestadorProcedimento->insertOne($data);
            }
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxRemoveAction(){
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $post = $this->_request->getPost();
            $this->modelProcedimento->procedimento->excluir($post["id"], "co_seq_procedimento");
            die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
        }else{
            die(json_encode(array("msn"=>"403 sem permissão")));
        }
    }

    public function ajaxCheckAction(){
        $post = $this->_request->getPost();
        $data = null;
        $modelProcedimento = new Admin_Model_DbTable_Procedimento();
        if($post["tipo_procedimento"]==1){
            $data = $modelProcedimento->checkProcedimentoExame($post["procedimento"]);
        }else if($post["tipo_procedimento"]==2){
            $data = $modelProcedimento->checkProcedimentoConsulta($post["procedimento"]);
        }else if($post["tipo_procedimento"]==3){
            $data = $modelProcedimento->checkProcedimentoLaboratorio($post["procedimento"]);
        }
        die(json_encode(array("msn"=>"200 ok", "data"=>$data)));
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $data=null;
        if($post["tipo_procedimento"]==1){
            $data["co_exame"] = $post["procedimento"];
        }else if($post["tipo_procedimento"]==2){
            $data["co_consulta"] = $post["procedimento"];
        }else if($post["tipo_procedimento"]==3){
            $data["co_laboratorio"] = $post["procedimento"];
        }
        $data["nu_valor"] = Util_Util::organizePrice($post["nu_valor"]);
        $modelProcedimento = new Admin_Model_DbTable_Procedimento();
        $modelProcedimento->procedimento->insertOne($data);
        if($post["tipo_procedimento"]==1){
            $modelExame = new Admin_Model_DbTable_Exame();
            $modelExame->editExameProcedimento($data["co_exame"]);
        }else if($post["tipo_procedimento"]==2){
            $modelConsulta = new Admin_Model_DbTable_Consulta();
            $modelConsulta->editConsultaProcedimento($data["co_consulta"]);
        }else if($post["tipo_procedimento"]==3){
            $modelLaboratorio = new Admin_Model_DbTable_Laboratorio();
            $modelLaboratorio->editLaboratorioProcedimento($data["co_laboratorio"]);
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

}