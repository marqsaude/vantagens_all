<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/09/17
 * Time: 09:14
 */

class Admin_ErrorController extends Zend_Controller_Action {

    public function init(){
        $this->_helper->layout->setLayout("layoutBlank");
    }

    public function indexAction(){
        $code = $this->getParam("code");
        $this->render($code);
    }

}