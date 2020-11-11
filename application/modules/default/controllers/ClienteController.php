<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 08/09/17
 * Time: 16:20
 */

class Default_ClienteController extends Zend_Controller_Action {

    private $session_login;
    private $session_gog;

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('Login');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $idContrato = ($this->getParam("id")!=false)?$this->getParam("id"):false;
        if($idContrato!=null){
            $this->view->setContrato = true;
        }else{
            $this->view->setContrato = false;
        }
        $this->view->idContrato = $idContrato;
        $this->view->session_login = $this->session_login;
        if($this->session_login->logado){
            //$this->_helper->redirector("add", "cliente", 'admin');
        }
    }

    public function senhaAction(){
        $code = $this->getRequest()->getParam('code');
        $modelEmail = new Default_Model_DbTable_Email();
        $dataEmail = $modelEmail->checkClientByCode($code);
        if($dataEmail!=null) {
            $this->view->esqueceuSenha = ($dataEmail[0]["tp_email"]==1)?false:true;
            $this->view->checkValid = ($dataEmail[0]["st_muda_senha"] == 1) ? true : false;
        }else{
            $this->view->checkValid = false;
        }
        $this->view->code = $code;
    }

    public function ajaxChangePasswordAction(){
        $post = $this->_request->getPost();
        $modelCliente = new Default_Model_DbTable_Cliente();
        $check = $modelCliente->editClienteUserByCodeEmail($post["nm_code"], $post["nm_senha"]);
        die(json_encode(array("session" => true, "check" => $check)));
    }

    public function ajaxIsExistCpfAction(){
        $post = $this->_request->getPost();
        $modelCliente = new Default_Model_DbTable_Cliente();
        $cpf = str_replace(".", "", $post["cpf"]);
        $cpf = str_replace("-", "", $cpf);
        $check = $modelCliente->isExistCpf($cpf);
        die(json_encode(array("session" => true, "check" => $check)));
    }

}