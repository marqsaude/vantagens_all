<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/11/17
 * Time: 10:30
 */

class Default_PorDentroController extends Zend_Controller_Action {

    private $session_login;
    private $session_page;
    private $modelBlog;

    public function init(){
        $this->session_page = new Zend_Session_Namespace('Page');
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->modelBlog = new Default_Model_DbTable_Blog();
        $this->view->isMobile = Util_Util::isMobile();
    }

    public function indexAction(){
        $page = $this->getParam("page");
        $jump = $this->getParam("jump");
        $page = (isset($page))?$page:1;
        $jump = (isset($jump))?$jump:"qsaude";
        if(is_numeric($jump)){
            $page = ($jump*5)+1;
        }
        $this->session_page->page = $page;
        $tpVisualizacao = array(1);
        $modelBlog = new Default_Model_DbTable_Blog();
        $this->view->dataBlog = $modelBlog->getBlogs($tpVisualizacao, $page, 5);
        $i=0;
        foreach($this->view->dataBlog["data"] as $value){
            $this->view->dataBlog["data"][$i]["tx_blog"] = $this->getForUrl(strip_tags($value["tx_blog"]));
            $i++;
        }
        $this->view->dataBlog["page"] = $this->session_page->page;
        $this->view->session_login = $this->session_login;
    }

    public function viewAction(){
        $id = $this->getParam("id");
        $tpVisualizacao = array(1);
        $modelBlog = new Default_Model_DbTable_Blog();
        $this->view->dataBlog = $modelBlog->getBlog($tpVisualizacao, $id);
        $this->view->page = $this->session_page->page;
        $this->view->session_login = $this->session_login;
    }

    private function getForUrl($text){
        $text = str_replace("/", "", $text);
        return str_replace("?", "%3F ", $text);
    }

}