<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/04/17
 * Time: 10:08
 */

class Gog_ContratoController extends Zend_Controller_Action
{

    public $session_login;
    public $posts;
    private $session_gog;
    private $isMobile = false;
    private $modelContratoGog;

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->modelContratoGog = new Gog_Model_DbTable_ContratoGog();
        $this->isMobile = Util_Util::isMobile();
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("layout-gog");

    }

    public function indexAction()
    {
        //$this->session_gog = new Zend_Session_Namespace('Gog');

    }

}