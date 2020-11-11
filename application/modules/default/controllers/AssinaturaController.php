<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 18/03/17
 * Time: 11:00
 */

class Default_AssinaturaController extends Zend_Controller_Action
{

    public $session_login;
    public $posts;

    public function init()
    {

        $this->session_login = new Zend_Session_Namespace('Login');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->_helper->layout->setLayout("layout-blank");

    }

    public function indexAction()
    {

    }

}