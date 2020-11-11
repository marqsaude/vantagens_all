<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 18:13
 */

class Admin_ContratoGogController  extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $file;
    private $modelContratoGog;
    private $modelContato;
    private $permissions = array(1);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $controller = Zend_Controller_Front::getInstance();
        $actionName = $controller->getRequest()->getActionName();
        if(in_array($this->session_login->coTipoLogin, $this->permissions) || $actionName=="cancel" || $actionName=="ajax-cancel" || $actionName=="print") {
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
        $this->view->dataContratoGog = $this->modelContratoGog->getAllContratoGog();
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
        $idContratoGog = $this->getParam("id");
        $this->view->dataContratoGog = $this->modelContratoGog->getContratoGog($idContratoGog);
    }

    public function viewAction(){
        $idContratoGog = $this->getParam("id");
        $this->view->dataContratoGog = $this->modelContratoGog->getContratoGogProcedimento($idContratoGog);
    }

    public function cancelAction(){
        $idUsuario = $this->getParam("id");
        $modelAcordo = new Admin_Model_DbTable_Acordo();
        $this->view->dataAcordo = $modelAcordo->getAcordoPlanoByUsuario($idUsuario);
    }

    public function printAction(){
        $permissions = array(1,2,3,6);
        if(in_array($this->session_login->coTipoLogin, $permissions)){
            $idCliente = $this->getParam("id");
            $geraContratoGog = new Util_GeraContratoGog($idCliente);
            $dataContratoGog = $geraContratoGog->gerar();
            $this->redirect('/site/pdf/contrato/'.$dataContratoGog["nm_contrato_gog"].$idCliente.'.pdf');
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxCancelAction(){
        $post = $this->_request->getPost();
        $modelAcordo = new Admin_Model_DbTable_Acordo();
        $modelAcordo->acordo->excluir($post["co_seq_acordo"], "co_seq_acordo");
        $modelCliente = new Admin_Model_DbTable_Cliente();
        $modelCliente->cliente->edit(array("st_cliente"=>2), $post["co_seq_cliente"]);
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxEditAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $files = explode("\\", $post["lk_contrato_gog"]);
            $file = "";
            foreach ($files as $value) {
                $file = $value;
            }
            $post["lk_contrato_gog"] = $file;
            $files = explode("\\", $post["lk_img_contrato_gog"]);
            $file = "";
            foreach ($files as $value) {
                $file = $value;
            }
            $post["lk_img_contrato_gog"] = $file;
            $this->modelContratoGog->contratoGog->edit($post, $post["co_seq_contrato_gog"]);
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxAddAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
            $post = $this->_request->getPost();
            $files = explode("\\", $post["lk_contrato_gog"]);
            $file = "";
            foreach ($files as $value) {
                $file = $value;
            }
            $post["lk_contrato_gog"] = $file;
            $files = explode("\\", $post["lk_img_contrato_gog"]);
            $file = "";
            foreach ($files as $value) {
                $file = $value;
            }
            $post["lk_img_contrato_gog"] = $file;
            $procedimentos = $post["procedimento"];
            unset($post["procedimento"]);
            $post["nu_valor"] = doubleval(str_replace(",", ".", $post["nu_valor"]));
            $idContratoGog = $this->modelContratoGog->contratoGog->insertOne($post);
            $modelRLContratoGogProcedimento = new Admin_Model_DbTable_RLContratoGogProcedimento();
            foreach ($procedimentos as $value) {
                $modelRLContratoGogProcedimento->contratoGogProcedimento->insertOne(array("co_contrato_gog" => $idContratoGog, "co_procedimento" => trim($value["id"])));
            }
        }
        die(json_encode(array("msn"=>"200 ok")));
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $this->modelContratoGog->contratoGog->excluir($post["id"], "co_seq_contrato_gog");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxVerifyExcluirAction(){
        $post = $this->_request->getPost();
        if(count($this->modelContratoGog->getAcordo($post["id"]))>0){
            die(json_encode(array("msn"=>"200 ok" , "id"=>$post["id"], "verify"=>true)));
        }else{
            die(json_encode(array("msn"=>"200 ok" , "id"=>$post["id"], "verify"=>false)));
        }
    }

    public function ajaxUploadAction(){
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
        if(Util_Util::whichOS()) {
            $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/contrato/" . $nomeFile . "." . $data[count($data) - 1];
            //$facebook->lk_img = $this->file;
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }else{
            if($osClient=='Windows'){
                $explodeNomeFile=explode('\\', $nomeFile);
                $last = ($explodeNomeFile[count($explodeNomeFile) - 1]=="")?$explodeNomeFile[count($explodeNomeFile) - 2]:$explodeNomeFile[count($explodeNomeFile) - 1];
                $this->file = "/var/www/html/adm/contrato/" . $last . "." . $data[count($data) - 1];
            }else {
                $this->file = "/var/www/html/adm/contrato/" . $nomeFile . "." . $data[count($data) - 1];
            }
            //$facebook->lk_img = $this->file;
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }
    }

    public function ajaxUploadImgAction(){
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
        if(Util_Util::whichOS()) {
            $this->file = $dataConfiguracao[0]["nm_url_absoluta"] . "/adm/contrato/img/" . $nomeFile . "." . $data[count($data) - 1];
            //$facebook->lk_img = $this->file;
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }else{
            if($osClient=='Windows'){
                $explodeNomeFile=explode('\\', $nomeFile);
                $last = ($explodeNomeFile[count($explodeNomeFile) - 1]=="")?$explodeNomeFile[count($explodeNomeFile) - 2]:$explodeNomeFile[count($explodeNomeFile) - 1];
                $this->file = "/var/www/html/adm/contrato/img/" . $last . "." . $data[count($data) - 1];
            }else {
                $this->file = "/var/www/html/adm/contrato/img/" . $nomeFile . "." . $data[count($data) - 1];
            }
            //$facebook->lk_img = $this->file;
            if (move_uploaded_file($files["fileUpload"]['tmp_name'], $this->file))
                die(json_encode(true));
            else
                die(json_encode(false));
        }
    }

}