<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 28/03/17
 * Time: 10:28
 */

class Gog_LoginController extends Zend_Controller_Action
{

    public $session_login;
    private $post;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("login-gog");

    }

    public function indexAction()
    {

    }

    public function logarAction(){

        $this->post = $this->_request->getPost();
        //var_dump($this->post);exit;
        //$form = new Default_Form_Login();
        //var_dump($this->post["nm_login"], $this->post["nm_senha"]);exit;
        if ($this->getRequest()->isPost()) {
            if (isset($this->post["nm_login"]) && isset($this->post["nm_senha"])) {
                $modelCliente = new Gog_Model_DbTable_Cliente();
                $autenticacaoLogin = $modelCliente->cliente->findOptionArray(array(
                    "nm_login" => $this->post["nm_login"],
                    "nm_senha" => $this->post["nm_senha"]
                ));
                //var_dump($autenticacaoLogin);exit;
                if (count($autenticacaoLogin) > 0) {
                    $this->session_login->logado = true;
                    $this->session_login->coSeqCliente = $autenticacaoLogin[0]["co_seq_cliente"];
                    $this->session_login->nmLogin = $autenticacaoLogin[0]["nm_login"];
                    $this->session_login->nmCliente = $autenticacaoLogin[0]["nm_cliente"];
                    $this->session_login->coTipoLogin = $autenticacaoLogin[0]["co_tipo_cliente"];

                    die(json_encode(array("type" => 1, "msg" => "Logado com sucesso!")));
                } else {
                    $modelUsuario = new Admin_Model_DbTable_Usuario();
                    $autenticacaoLogin = $modelUsuario->paciente->findOptionArray(array(
                        "nm_login" => $this->post["nm_login"],
                        "nm_senha" => $this->post["nm_senha"]
                    ));
                    if (count($autenticacaoLogin) > 0) {
                        $this->session_login->logado = true;
                        $this->session_login->coSeqCliente = $autenticacaoLogin[0]["co_seq_usuario"];
                        $this->session_login->nmLogin = $autenticacaoLogin[0]["nm_login"];
                        $this->session_login->nmCliente = $autenticacaoLogin[0]["nm_usuario"];
                        $this->session_login->coTipoLogin = $autenticacaoLogin[0]["co_tipo_usuario"];

                        die(json_encode(array("type" => 1, "msg" => "Logado com sucesso!")));
                    } else {
                        //if(isset($this->post['requisicao']) && $this->post['requisicao']=="ajax"){
                        die(json_encode(array("type" => 2, "msg" => "erro, não existe usuário")));
                    }
                }

            } else {
                if ($this->post['requisicao'] == "normal") {
                    die(json_encode(array("type" => 2, "msg" => "erro, não existe paciente")));
                } else {
                    die(json_encode(array("type" => 2, "msg" => "erro, não existe paciente")));
                }
            }
        }else{
            if($this->post['requisicao']=="normal") {
                die(json_encode(false));
            }else{
                die(json_encode(false));
            }
        }
    }

    public function logoutAction()
    {
        $login = $_POST;
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::destroy(true);
        if($login['requisicao']=="ajax" && isset($login)) {
            die(json_encode(true));
        }else{
            $this->_redirect('gog/login/index');
        }
    }

}