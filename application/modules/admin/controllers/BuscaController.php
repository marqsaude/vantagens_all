<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 05/09/17
 * Time: 11:27
 */

class Admin_BuscaController extends Zend_Controller_Action {

    private $post;
    private $modelBuscaAutoincremento;
    private $permissions = array(1, 2, 3, 6, 7);
    private $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $this->modelBuscaAutoincremento = new Admin_Model_DbTable_BuscaAutoincremento();
        }else{
            $this->modelBuscaAutoincremento = new Admin_Model_DbTable_BuscaAutoincrementoCliente();
        }
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoContatoUsuario($this->session_login->coSeqPaciente);
            $modelCaixa = new Admin_Model_DbTable_Caixa();
            $this->view->dataCaixaAtivo = $modelCaixa->getCaixaAtivo();
        }
    }

    public function ajaxBuscaAutoIncrementoAction(){
        $post = $this->_request->getPost();
        if(in_array($this->session_login->coTipoLogin, $this->permissions)) {
            $dataAutoIncremento = $this->modelBuscaAutoincremento->getAutoIncremento($post["key"]);
            die(json_encode(array("msn" => "200 ok", "data" => $dataAutoIncremento)));
        }else{
            $dataAutoIncremento = $this->modelBuscaAutoincremento->getAutoIncremento($post["key"]);
            die(json_encode(array("msn"=>"200 ok" , "data"=>$dataAutoIncremento)));
        }
    }

    public function ajaxBuscaAutoIncrementoClienteAction(){
        $post = $this->_request->getPost();
        $dataAutoIncremento = $this->modelBuscaAutoincremento->getAutoIncremento($post["key"]);
        die(json_encode(array("msn"=>"200 ok" , "data"=>$dataAutoIncremento)));
    }

}