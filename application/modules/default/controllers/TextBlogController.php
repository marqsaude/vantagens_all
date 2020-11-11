<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/11/17
 * Time: 17:18
 */

class Default_TextBlogController extends Zend_Controller_Action{

    public function init(){
        $this->_helper->layout->setLayout("layoutAdminBlank");
    }

    public function indexAction(){
        $this->view->text = $this->getParam("text");
    }

}