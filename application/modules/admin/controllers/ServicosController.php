<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 13/10/17
 * Time: 15:45
 */

class Admin_ServicosController  extends Zend_Controller_Action {

    private $post;
    private $modelServicos;
    public $session_login;
    private $file;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelServicos = new Admin_Model_DbTable_Servicos();
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
        $this->view->dataServicos = $this->modelServicos->getAllServicos();
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {

        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idServicos = $this->getParam("id");
        $this->view->dataServicos = $this->modelServicos->getServicos($idServicos);
    }

    public function editAction(){
        $idServicos = $this->getParam("id");
        $this->view->dataServicos = $this->modelServicos->getServicos($idServicos);
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $this->modelServicos->servicos->excluir($post["id"], "co_seq_servicos");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        $this->modelServicos->maisVoce->edit($post, $post["co_seq_servicos"]);
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $post["co_usuario"] = $this->session_login->coSeqPaciente;
        $files = explode("\\", $post["lk_servicos"]);
        $file="";
        foreach($files as $value){
            $file=$value;
        }
        $post["lk_servicos"] = $file;
        $this->modelServicos->servicos->insertOne($post);
        die(json_encode(array("msn"=>"200 ok")));
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
            if(Util_Util::whichOS()) {
                $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/images/servicos/" . $nomeFile . "." . $data[count($data) - 1];
            }else{
                if($osClient=='Windows'){
                    $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/images/servicos/" . $nomeFile . "." . $data[count($data) - 1];
                }else {
                    $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/site/images/servicos/" . $nomeFile . "." . $data[count($data) - 1];
                }
            }
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }else{
            die(json_encode(array("msn" => "403 sem permissão")));
        }
    }

}