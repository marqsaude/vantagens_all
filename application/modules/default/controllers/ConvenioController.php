<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/02/16
 * Time: 11:06
 */

class Default_ConvenioController extends Zend_Controller_Action {

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        exit;
    }

}