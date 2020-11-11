<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/02/16
 * Time: 11:07
 */

class Default_ExameController extends Zend_Controller_Action {

    public function init(){

        $this->view->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");

    }

    public function indexAction(){
        exit;
    }

}