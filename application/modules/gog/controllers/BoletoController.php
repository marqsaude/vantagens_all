<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 11/04/17
 * Time: 09:32
 */

class Gog_BoletoController extends Zend_Controller_Action {

    private $session_gog;
    private $session_login;
    private $boleto="cef";

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("layout-boleto-gog");

    }

    public function indexAction(){
        $boletoPHP = new Boletophp_Boletophp($this->boleto, $this->getFrontController()->getBaseUrl());
        $mountBoleto = $boletoPHP->mountBoleto();
        $this->view->dadosboleto = $mountBoleto[0];
        $this->view->boleto = $mountBoleto[1];
        $this->view->type = $this->boleto;
        $this->view->data_venc = $mountBoleto[2];
    }

}