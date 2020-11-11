<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 08/09/17
 * Time: 16:22
 */

class Default_SobreController extends Zend_Controller_Action {

    private $session_login;
    private $session_gog;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $modelSobre = new Default_Model_DbTable_Sobre();
        $this->view->dataSobre = $modelSobre->getAllSobre();
        $this->view->session_login = $this->session_login;
    }

    public function missaoVisaoValoresAction(){
        $this->view->session_login = $this->session_login;
    }

}