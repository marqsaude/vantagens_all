<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 16:21
 */

class Default_NewsletterController extends Zend_Controller_Action {

    private $session_login;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("nova");
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $modelNewsletter = new Default_Model_DbTable_Newsletter();
        $idNewsletter = $modelNewsletter->newsletter->insertOne($post);
        $modelUsuario = new Default_Model_DbTable_Usuario();
        $dataNotificacaoNewsletter=array();
        $i=0;
        foreach($modelUsuario->getUsuarioNotificadoNewsletter() as $key=>$value){
            $dataNotificacaoNewsletter[$i]["co_usuario"] = $value["co_seq_usuario"];
            $dataNotificacaoNewsletter[$i]["co_newsletter"] = $idNewsletter;
            $dataNotificacaoNewsletter[$i]["st_visualizado"] = 2;
            $i++;
        }
        $modelNotificacaoNewsletter = new Default_Model_DbTable_NotificacaoNewsletter();
        $modelNotificacaoNewsletter->notificacaoNewsletter->insertsTeste($dataNotificacaoNewsletter);
        die(json_encode(array("msn"=>"200 ok" , "data"=>"")));
    }

}