<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 30/01/17
 * Time: 15:51
 */

class Default_BlogController extends Zend_Controller_Action {

    public $session_login;
    public $posts;
    private $modelPost;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        if($this->session_login->logado==NULL){
            $this->session_login->logado=false;
        }
        $this->_helper->layout->setLayout("layout");
        $this->posts = new Zend_Session_Namespace('Post');
        $this->modelPost = new Admin_Model_DbTable_Post();
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $back = $this->getParam("back");
        if($back=="") {
            $this->posts->page = 0;
            $dataPost = $this->modelPost->getPosts();
        }else{
            $dataPost = $this->modelPost->getPosts($this->posts->page);
        }
        $this->view->dataPost = $dataPost["data"];
        $this->view->countPost = $dataPost["count"];
        $this->view->posts = $this->posts;
    }

    public function viewAction(){
        $idBlog = $this->getParam("id");
        $this->view->dataPost=$this->modelPost->getPost($idBlog);
    }

    public function ajaxChangePaginaAction(){
        $post = $this->_request->getPost();
        $dataPost = $this->modelPost->getPosts($post["pagina"]);
        $this->posts->page=$post["pagina"];
        die(json_encode(array("data"=>$dataPost["data"], "count"=>$dataPost["count"], "page"=>$post["pagina"])));
    }

}