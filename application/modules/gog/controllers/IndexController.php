<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 29/03/17
 * Time: 11:55
 */

class Gog_IndexController extends Zend_Controller_Action{

    public $session_login;
    private $post;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("layout-gog");

    }

    public function indexAction()
    {

    }



}