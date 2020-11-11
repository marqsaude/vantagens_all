<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 18/09/17
 * Time: 15:11
 */

class Default_PrestadorController extends Zend_Controller_Action {

    private $session_login;
    private $session_gog;
    private $modelPrestador;

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->modelPrestador = new Default_Model_DbTable_Prestador();
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $this->view->dataPrestador = $this->modelPrestador->prestador->getAllOptions();
        $this->view->session_login = $this->session_login;
    }

    public function ajaxViewAction(){
        $post = $this->_request->getPost();
        $dataPrestador = $this->modelPrestador->prestador->busca($post["co_seq_prestador"]);
        $this->view->session_login = $this->session_login;
        die(json_encode(array("msn" => "200 ok", "data"=>array($dataPrestador))));
    }

}