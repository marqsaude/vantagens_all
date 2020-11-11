<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 30/04/2018
 * Time: 10:14
 */

class Default_SimulacaoController extends Zend_Controller_Action {

    public $session_login;
    public $posts;
    private $modelPost;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        if($this->session_login->logado==NULL){
            $this->session_login->logado=false;
        }
        $this->_helper->layout->setLayout("layout");
        $this->posts = new Zend_Session_Namespace('Post');
        $this->modelPost = new Admin_Model_DbTable_Post();
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

        $modelFormaPagamento = new Default_Model_DbTable_FormaPagamento();
        $this->view->dataFormaPagamento = $modelFormaPagamento->getAllFormaPagamento(array(1, 3));

        $modelContratoGog = new Default_Model_DbTable_ContratoGog();
        $this->view->dataContratoGog = $modelContratoGog->getAllContratoGog();
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $modelSimulacao = new Default_Model_DbTable_Simulacao();
        $idSimulacao = $modelSimulacao->simulacao->insertOne($post);
        die(json_encode(array("session" => true, "data" => "Registrado com sucesso! 200")));
    }


}