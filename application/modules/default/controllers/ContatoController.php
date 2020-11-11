<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/02/16
 * Time: 11:06
 */

class Default_ContatoController extends Zend_Controller_Action {

    private $post;
    private $isMobile;
    private $session_login;
    private $contato;
    private $notificacaoContato;
    private $rlContatoTelefone;
    private $telefone;

    public function init(){
        // Verifica se é mobile
        $this->isMobile = Util_Util::isMobile();
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->view->isMobile = $this->isMobile;
    }

    public function indexAction(){
        $this->view->session_login = $this->session_login;
    }

    public function ajaxSendContatoAction(){
        $this->post = $this->_request->getPost();
        $modelContato = new Default_Model_DbTable_Contato();
        if(isset($this->session_login->coSeqPaciente) && $this->session_login->logado){
            $this->post["co_cliente"] = $this->session_login->coSeqPaciente;
        }
        $this->post["tp_envio"]=($this->isMobile)?2:1;
        $arrayTelefone = array("nu_telefone"=>$this->post["nu_telefone"], "nu_whatsapp"=>$this->post["nu_whatsapp"]);
        unset($this->post["nu_telefone"]);
        unset($this->post["nu_whatsapp"]);
        $idContato = $modelContato->contato->insertOne($this->post);

        $modelUsuario = new Default_Model_DbTable_Usuario();
        $dataNotificacaoContato=array();
        $i=0;
        foreach($modelUsuario->getUsuarioNotificadoContato() as $key=>$value){
            $dataNotificacaoContato[$i]["co_usuario"] = $value["co_seq_usuario"];
            $dataNotificacaoContato[$i]["co_contato"] = $idContato;
            $dataNotificacaoContato[$i]["st_visualizado"] = 2;
            $i++;
        }
        $modelNotificacaoContato = new Default_Model_DbTable_NotificacaoContato();
        $modelNotificacaoContato->notificacaoContato->insertsTeste($dataNotificacaoContato);

        $utilTelefone = new Util_Telefone();
        $telefonesExistentes=null;
        $telefonesExistentes=$utilTelefone->registraTelefone($arrayTelefone, "contato", $idContato);
        die(json_encode(array("registro" => ($telefonesExistentes==null)?true:false, "data" => $telefonesExistentes)));
    }

}