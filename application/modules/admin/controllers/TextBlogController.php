<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 23/11/17
 * Time: 11:02
 */

class Admin_TextBlogController extends Zend_Controller_Action{

    public function init(){
        $this->_helper->layout->setLayout("layoutAdminBlank");
    }

    public function indexAction(){
        $this->view->text = $this->getParam("text");
    }

}