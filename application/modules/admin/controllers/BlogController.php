<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 21/11/17
 * Time: 11:19
 */

class Admin_BlogController  extends Zend_Controller_Action {

    private $post;
    private $modelBlog;
    public $session_login;
    private $file;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelBlog = new Admin_Model_DbTable_Blog();
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
        $tpVisualizacao = array(1);
        switch($this->session_login->coTipoLogin){
            case 1:
                array_push($tpVisualizacao, 2);
                array_push($tpVisualizacao, 3);
                break;
            case 2:
                array_push($tpVisualizacao, 2);
                break;
            case 3:
                array_push($tpVisualizacao, 2);
                break;
            case 4:
                array_push($tpVisualizacao, 3);
                break;
            case 5:
                array_push($tpVisualizacao, 3);
                break;
        }
        $modelBlog = new Admin_Model_DbTable_Blog();
        $this->view->dataBlog = $modelBlog->getAllBlog($tpVisualizacao);
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
            $idBlog = $this->getParam("id");
            $modelBlog = new Admin_Model_DbTable_Blog();
            $this->view->dataBlog = $modelBlog->blog->get($idBlog);
            $modelBlog->clean();
            $this->view->dataProcedimentoBlog = $modelBlog->getProcedimentos($idBlog);
            $arrayIn = array(0);
            foreach($this->view->dataProcedimentoBlog as $value){
                array_push($arrayIn, $value["co_seq_procedimento"]);
            }
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getAllProcedimentoFull($arrayIn);
            $this->view->idBlog = $idBlog;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $idBlog = $this->getParam("id");
            $modelBlog = new Admin_Model_DbTable_Blog();
            $this->view->dataBlog = $modelBlog->blog->get($idBlog);
            $modelBlog->clean();
            $this->view->dataProcedimentoBlog = $modelBlog->getProcedimentos($idBlog);
            $arrayIn = array(0);
            foreach($this->view->dataProcedimentoBlog as $value){
                array_push($arrayIn, $value["co_seq_procedimento"]);
            }
            $modelProcedimento = new Admin_Model_DbTable_Procedimento();
            $this->view->dataProcedimento = $modelProcedimento->getAllProcedimentoFull($arrayIn);
            $this->view->idBlog = $idBlog;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $files = explode("\\", $post["lk_img_blog"]);
            $file = "";
            foreach ($files as $value) {
                $file = $value;
            }
            $post["lk_img_blog"] = $file;
            $post["co_usuario"] = $this->session_login->coSeqPaciente;
            $procedimentos = $post["procedimentos"];
            unset($post["procedimentos"]);
            $idBlog = $this->modelBlog->blog->insertOne($post);
            $modelBlogProcedimento = new Admin_Model_DbTable_RLBlogProcedimento();
            foreach ($procedimentos as $value) {
                $modelBlogProcedimento->blogProcedimento->insertOne(array("co_blog" => $idBlog, "co_procedimento" => trim($value["id"])));
            }
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            if($post["lk_img_blog"] != "" || $post["lk_img_blog"] != null) {
                $files = explode("\\", $post["lk_img_blog"]);
                $file = "";
                foreach ($files as $value) {
                    $file = $value;
                }
                $post["lk_img_blog"] = $file;
            }else{
                unset($post["lk_img_blog"]);
            }
            $idBlog = $post["co_seq_blog"];
            unset($post["co_seq_blog"]);
            $post["co_usuario"] = $this->session_login->coSeqPaciente;
            $procedimentos = (isset($post["procedimentos"]))?$post["procedimentos"]:null;
            unset($post["procedimentos"]);
            $this->modelBlog->blog->edit($post, $idBlog);
            $modelBlogProcedimento = new Admin_Model_DbTable_RLBlogProcedimento();
            $modelBlogProcedimento->deleta($idBlog);
            //$modelBlogProcedimento->blogProcedimento->excluir(array("co_blog"=>$idBlog));
            $modelBlogProcedimento->clean();
            if($procedimentos != null) {
                foreach ($procedimentos as $value) {
                    $modelBlogProcedimento->blogProcedimento->insertOne(array("co_blog" => $idBlog, "co_procedimento" => trim($value["id"])));
                }
            }
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxRemoveAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $this->modelBlog->blog->excluir($post["id"], "co_seq_blog");
        }
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxUploadImgAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/Linux/', $agent)) $osClient = 'Linux';
            elseif (preg_match('/Win/', $agent)) $osClient = 'Windows';
            elseif (preg_match('/Mac/', $agent)) $osClient = 'Mac';
            else $osClient = 'UnKnown';

            $modelConfiguracao = new Admin_Model_DbTable_Configuracao();
            $dataConfiguracao = $modelConfiguracao->getAll();

            $upload = new Zend_File_Transfer();
            // Returns all known internal file information
            $files = $upload->getFileInfo();
            $data = explode('.', $files["fileUpload"]["name"]);
            $nomeFile = "";
            for ($i = 0; $i < (count($data) - 1); $i++) {
                $nomeFile .= $data[$i];
            }
            if (Util_Util::whichOS()) {
                $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/blog/img/" . $nomeFile . "." . $data[count($data) - 1];
                if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                    die(json_encode(true));
                else
                    die(json_encode(false));
            } else {
                if ($osClient == 'Windows') {
                    $explodeNomeFile = explode('\\', $nomeFile);
                    $last = ($explodeNomeFile[count($explodeNomeFile) - 1] == "") ? $explodeNomeFile[count($explodeNomeFile) - 2] : $explodeNomeFile[count($explodeNomeFile) - 1];
                    $this->file = "/var/www/html/adm/blog/img/" . $last . "." . $data[count($data) - 1];
                } else {
                    $this->file = "/var/www/html/adm/blog/img/" . $nomeFile . "." . $data[count($data) - 1];
                }
                if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                    die(json_encode(true));
                else
                    die(json_encode(false));
            }
        }
    }

}