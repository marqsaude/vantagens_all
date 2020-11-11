<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 11:54
 */

class Admin_DependenteController extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $modelContato;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
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

    public function indexAction(){
        $idCliente = $this->getParam("id");
        $modelCliente = new Admin_Model_DbTable_Cliente();
        if($this->session_login->coTipoLogin==4){
            $dataCliente = $modelCliente->getClienteByUsuario($this->session_login->coSeqPaciente);
        }else{
            $dataCliente = $modelCliente->getClienteDefault($idCliente);
        }
        $modelDependentes = new Admin_Model_DbTable_Dependentes();
        $this->view->dataDependentes = $modelDependentes->getDependentes($dataCliente["co_seq_cliente"]);
    }

    public function addAction(){

    }

    public function clienteAction(){
        $idCliente = $this->getParam("page");
        $perPage = $this->getParam("per");
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $idCliente = ($idCliente == null) ? 1 : $idCliente;
            $perPage = ($perPage == null) ? 10 : ($perPage != 10 && $perPage != 25 && $perPage != 50 && $perPage != 100) ? 10 : $perPage;
            $dataCliente = $modelCliente->getClientes("", $idCliente, $perPage);
            $count = ($dataCliente["count"] / $perPage);
            $countInt = intval($count);
            $count = ($count == $countInt) ? $count : $count + 1;
            $this->view->dataCliente = $dataCliente["data"];
            $this->view->dataCount = intval($count);
            $this->view->id = $idCliente;
            $this->view->perPage = $perPage;
            $this->view->arrayPerPage = array(10, 25, 50, 100);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function clienteDependenteAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $idCliente = $this->getParam("id");
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $dataDependentes = $modelDependentes->getDependentesCliente($idCliente);
            $modelCliente = new Admin_Model_DbTable_Cliente();
            $this->view->dataCliente = $modelCliente->getClienteDependente($idCliente);
            $this->view->insertDependente = true;
            if(count($dataDependentes) == $this->view->dataCliente[0]["nu_dependentes"]){
                $this->view->insertDependente = false;
                $this->view->nuDependentes = $this->view->dataCliente[0]["nu_dependentes"];
                $this->view->dependentesRegistrados = $this->view->dataCliente[0]["nu_dependentes"];
            }else{
                $this->view->insertDependente = true;
                $this->view->nuDependentes = $this->view->dataCliente[0]["nu_dependentes"];
                $this->view->dependentesRegistrados = count($dataDependentes);
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        //if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $idDependente = $this->getParam("id");
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $this->view->dataDependentes = $modelDependentes->getDependente($idDependente);
            $this->view->stDependente = $this->view->dataDependentes["st_registro"];
            $modelBoleto = new Admin_Model_DbTable_Boleto();
            $this->view->dataBoleto = $modelBoleto->getBoletoByCliente($this->view->dataDependentes["co_seq_cliente"]);
        //}else{
            //$this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        //}
    }

    public function editAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $idDependente = $this->getParam("id");
            $modelTipoDependentes = new Admin_Model_DbTable_TipoDependentes();
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $this->view->dataDependentes = $modelDependentes->getDependente($idDependente);
            $this->view->dataDependentes["nascimento_dependente"] = substr(Util_Util::getDataClient($this->view->dataDependentes["nascimento_dependente"]), 0, 10);
            $this->view->stDependente = $this->view->dataDependentes["st_registro"];
            $this->view->dataTipoDependentes = $modelTipoDependentes->getAllTipoDependentes();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxGetTipoDependenteAction(){
        $modelTipoDependentes = new Admin_Model_DbTable_TipoDependentes();
        $dataTipoDependentes = $modelTipoDependentes->getAllTipoDependentes();
        die(json_encode(array("msn"=>"200 ok", "data"=>$dataTipoDependentes)));
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $modelDependentes = new Admin_Model_DbTable_Dependentes();
        $modelDependentes->dependentes->excluir($post["id"], "co_seq_dependentes");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        if(in_array($this->session_login->coTipoLogin, $this->authLight)) {
            $modelAcordo = new Admin_Model_DbTable_Acordo();
            if ($modelAcordo->getAcordo($post["co_seq_acordo"]) == null) {
                $this->_helper->redirector("index", "error", 'admin', array('code' => '403'));
            } else {
                $modelDependentes = new Admin_Model_DbTable_Dependentes();
                $dataCheckDependentes = $modelDependentes->checkDependentes($post["co_seq_acordo"]);
                $countDependentes = count($dataCheckDependentes);
                if (($dataCheckDependentes != null) && ($countDependentes == $dataCheckDependentes[0]["nu_dependentes"])) {
                    die(json_encode(array("msn" => "200 ok", "st_dependentes" => 2)));
                } else {
                    $dataDependentes["co_tipo_dependentes"] = $post["tipo_dependente"];
                    $dataDependentes["co_acordo"] = $post["co_seq_acordo"];
                    $dataDependentes["nm_dependente"] = $post["nm_dependente"];
                    $dataDependentes["dt_nascimento"] = str_replace("'", "", Util_Util::changeDateToSql($post["dt_nascimento"]));
                    $dataDependentes["nu_rg"] = $post["nu_rg"];
                    $dataDependentes["nu_cpf"] = $post["nu_cpf"];
                    $dataDependentes["nm_email"] = $post["nm_email"];
                    $modelDependentes->clean();
                    $modelDependentes->dependentes->insertOne($dataDependentes);
                    die(json_encode(array("msn" => "200 ok", "data" => array("st_dependentes" => 1, "id"=>$post["co_seq_cliente"]))));
                }
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        if(in_array($this->session_login->coTipoLogin, $this->authMedium)) {
            $post["dt_nascimento"] = str_replace("'", "", Util_Util::changeDateToSql($post["dt_nascimento"]));
            $idCliente = $post["co_seq_cliente"];
            unset($post["co_seq_cliente"]);
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $modelDependentes->dependentes->edit($post, $post["co_seq_dependentes"]);
            die(json_encode(array("msn" => "200 ok", "st_dependentes" => 1, "data" => array("idCliente"=>$idCliente))));
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxAddClienteAction(){
        $post = $this->_request->getPost();
        $modelAcordo = new Admin_Model_DbTable_Acordo();
        $dataAcordo = $modelAcordo->getAcordoByUsuario($this->session_login->coSeqPaciente);
        if($dataAcordo == null){
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }else {
            $modelDependentes = new Admin_Model_DbTable_Dependentes();
            $dataCheckDependentes = $modelDependentes->checkDependentes($dataAcordo[0]["co_seq_acordo"]);
            $countDependentes = count($dataCheckDependentes);
            if (($dataCheckDependentes != null) && ($countDependentes == $dataCheckDependentes[0]["nu_dependentes"])) {
                die(json_encode(array("msn" => "200 ok", "st_dependentes" => 2)));
            } else {
                $dataDependentes["co_tipo_dependentes"] = $post["tipo_dependente"];
                $dataDependentes["co_acordo"] = $dataAcordo[0]["co_seq_acordo"];
                $dataDependentes["nm_dependente"] = $post["nm_dependente"];
                $dataDependentes["dt_nascimento"] = str_replace("'", "", Util_Util::changeDateToSql($post["dt_nascimento"]));
                $dataDependentes["nu_rg"] = $post["nu_rg"];
                $dataDependentes["nu_cpf"] = $post["nu_cpf"];
                $dataDependentes["nm_email"] = $post["nm_email"];
                $modelDependentes->clean();
                $modelDependentes->dependentes->insertOne($dataDependentes);
                die(json_encode(array("msn" => "200 ok", "st_dependentes" => 1)));
            }
        }
    }

}