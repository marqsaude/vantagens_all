<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 09:11
 */

class Default_PerguntasController extends Zend_Controller_Action {

    private $session_login;
    private $modelPerguntas;

    public function init()
    {
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->modelPerguntas = new Default_Model_DbTable_Perguntas();
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $this->view->dataPerguntas = $this->modelPerguntas->perguntas->getAllOptions();
        $this->view->session_login = $this->session_login;
    }

}