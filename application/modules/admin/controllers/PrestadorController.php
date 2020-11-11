<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 19/09/17
 * Time: 15:25
 */

class Admin_PrestadorController extends Zend_Controller_Action {

    private $post;
    private $modelPrestador;
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelPrestador = new Admin_Model_DbTable_Prestador();
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
        $this->view->dataPrestador = $this->modelPrestador->getAllPrestador();
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getAllProcedimentoFull();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $idPrestador = $this->getParam("id");
            $this->view->dataPrestador = $this->modelPrestador->getPrestador($idPrestador);
            $modelPrestadorProcedimento = new Admin_Model_DbTable_RLPrestadorProcedimento();
            $dataPrestadorProcedimento = $modelPrestadorProcedimento->getAllProcedimentoFull($idPrestador);
            $arrayIn = array();
            //var_dump($dataPrestadorProcedimento);exit;
            foreach($dataPrestadorProcedimento as $value){
                array_push($arrayIn, $value["co_procedimento"]);
            }
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getAllProcedimentoFull($arrayIn);
            $this->view->dataPrestadorProcedimento = $dataPrestadorProcedimento;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idPrestador = $this->getParam("id");
        $this->view->dataPrestador = $this->modelPrestador->getPrestador($idPrestador);
    }

    public function ajaxEditAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $procedimentos = $post["procedimento"];
            unset($post["procedimento"]);
            $arrayProcedimentos=array();
            foreach($procedimentos as $value){
                array_push($arrayProcedimentos, array("co_procedimento"=>$value["id"]));
            }
            $this->modelPrestador->prestador->edit($post, $post["co_seq_prestador"]);
            $modelRLPrestadorProcedimento = new Admin_Model_DbTable_RLPrestadorProcedimento();
            $modelRLPrestadorProcedimento->prestadorProcedimento->excluir(array("co_prestador"=>$post["co_seq_prestador"]));
            $modelRLPrestadorProcedimento->clean();
            foreach($procedimentos as $value){
                $modelRLPrestadorProcedimento->prestadorProcedimento->insertOne(array("co_prestador"=>$post["co_seq_prestador"], "co_procedimento"=>trim($value["id"])));
            }
            die(json_encode(array("msn" => "200 ok")));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

    public function ajaxRemoveAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $this->modelPrestador->prestador->excluir($post["id"], "co_seq_prestador");
            die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

    public function ajaxAddAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $procedimentos = $post["procedimento"];
            unset($post["procedimento"]);
            $files = explode("\\", $post["lk_prestador"]);
            $file="";
            foreach($files as $value){
                $file=$value;
            }
            $post["lk_prestador"] = $file;
            $idPrestador=$this->modelPrestador->prestador->insertOne($post);
            $modelRLPrestadorProcedimento = new Admin_Model_DbTable_RLPrestadorProcedimento();
            foreach($procedimentos as $value){
                $modelRLPrestadorProcedimento->prestadorProcedimento->insertOne(array("co_prestador"=>$idPrestador, "co_procedimento"=>trim($value["id"])));
            }
            die(json_encode(array("msn"=>"200 ok")));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

    public function ajaxUploadAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/Linux/',$agent)) $osClient = 'Linux';
            elseif(preg_match('/Win/',$agent)) $osClient = 'Windows';
            elseif(preg_match('/Mac/',$agent)) $osClient = 'Mac';
            else $osClient = 'UnKnown';

            $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getAll();

            $upload = new Zend_File_Transfer();
            // Returns all known internal file information
            $files = $upload->getFileInfo();
            $data = explode('.', $files["fileUpload"]["name"]);
            $nomeFile="";
            for($i=0; $i<(count($data)-1); $i++){
                $nomeFile.=$data[$i];
            }
            //$facebook = new Zend_Session_Namespace('Facebook');
            $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/images/prestador/" . $nomeFile . "." . $data[count($data) - 1];
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

}