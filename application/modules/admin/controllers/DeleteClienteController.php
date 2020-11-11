<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 12/01/18
 * Time: 11:41
 */

class Admin_DeleteClienteController extends Zend_Controller_Action {

    private $post;
    public $session_login;
    private $authHard = array(1, 2);
    private $authMedium = array(1, 2, 3);
    private $authLight = array(1, 2, 3, 6);
    private $arrayIdCliente = array(577);

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {

        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
        exit;
    }

    public function deletaUmAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $idCliente = $this->getParam("id");
            $pathFile = realpath(dirname(__FILE__))."/../../../../banco/delete_cliente.sql";
            $sql = file_get_contents($pathFile);
            $newSql = str_replace("???", $idCliente, $sql);
            $modelDeleteCliente = new Admin_Model_DbTable_DeleteCliente();
            $modelDeleteCliente->deleta($newSql);
            echo "Deletado";exit;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function deletaVariosAction(){
        if(in_array($this->session_login->coTipoLogin, $this->authHard)) {
            $pathFile = realpath(dirname(__FILE__))."/../../../../banco/delete_cliente.sql";
            $sql = file_get_contents($pathFile);
            foreach($this->arrayIdCliente as $value){
                $newSql = str_replace("???", $value, $sql);
                $modelDeleteCliente = new Admin_Model_DbTable_DeleteCliente();
                $modelDeleteCliente->deleta($newSql);
            }
            echo "Deletados";exit;
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

}