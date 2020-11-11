<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/11/16
 * Time: 11:32
 */

class Admin_UsuarioController extends Zend_Controller_Action{

    private $modelUsuario;
    private $modelContato;
    public $session_login;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->view->coSeqLogin = $this->session_login->coSeqPaciente;
        $this->_helper->layout->setLayout("layoutAdmin");
        $this->modelUsuario = new Admin_Model_DbTable_Usuario();
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            }else if($this->session_login->coTipoLogin==3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            }else if($this->session_login->coTipoLogin==5){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteVendedor($this->session_login->coSeqPaciente);
            }else
            if($this->session_login->coTipoLogin==4){
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataClienteDependentes = $modelCliente->getClienteDependentes($this->session_login->coSeqPaciente);
            }
        }

    }

    public function indexAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3){
            $this->view->dataUsuario = $this->modelUsuario->getAllUsuarioSistema();
            $this->modelUsuario->clean();
            $dataUsuarioP = $this->modelUsuario->getUsuarioPermissao();
            foreach($this->view->dataUsuario as $key=>$value){
                $this->view->dataUsuario[$key]["permission"] = 2;
                foreach($dataUsuarioP as $key2=>$value2){
                    if($this->view->dataUsuario[$key]["co_seq_usuario"]==$dataUsuarioP[$key2]["co_seq_usuario"]){
                        $this->view->dataUsuario[$key]["permission"] = 1;
                    }
                }
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function viewAction(){
        $idUsuario = $this->getParam("id");
        if(($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3) || $idUsuario==$this->session_login->coSeqPaciente){
            $this->view->dataUsuario = $this->modelUsuario->usuario->get($idUsuario);
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function editAction(){
        $idUsuario = $this->getParam("id");
        $dataUsuarioP = $this->modelUsuario->getUsuarioPermissao($idUsuario);
        $verifyYS = ($idUsuario==$this->session_login->coSeqPaciente);
        if($dataUsuarioP!=null || $verifyYS) {
            $this->modelUsuario->clean();
            $this->view->dataUsuario = $this->modelUsuario->usuario->get($idUsuario);
            $modelTipoUsuario = new Admin_Model_DbTable_TipoUsuario();
            if($verifyYS){
                $this->view->dataTipoUsuario = array(0=>$modelTipoUsuario->tipoUsuario->get($this->view->dataUsuario["co_tipo_usuario"]));
            }else {
                $this->view->dataTipoUsuario = $modelTipoUsuario->getTipoUsuarioPermissao();
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
        if($idUsuario == $this->session_login->coSeqPaciente){
            $this->view->euMesmo = 1;
        }else{
            $this->view->euMesmo = 2;
        }
    }

    public function editFuncionarioAction(){
        $idUsuario = $this->getParam("id");
        $dataUsuarioP = $this->modelUsuario->getUsuarioPermissao($idUsuario);
        $verifyYS = ($idUsuario==$this->session_login->coSeqPaciente);
        if($dataUsuarioP!=null || $verifyYS) {
            $this->modelUsuario->clean();
            $this->view->dataUsuario = $this->modelUsuario->usuario->get($idUsuario);
            $modelTipoUsuario = new Admin_Model_DbTable_TipoUsuario();
            if($verifyYS){
                $this->view->dataTipoUsuario = array(0=>$modelTipoUsuario->tipoUsuario->get($this->view->dataUsuario["co_tipo_usuario"]));
            }else {
                $this->view->dataTipoUsuario = $modelTipoUsuario->getTipoUsuarioPermissao();
            }
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
        if($idUsuario == $this->session_login->coSeqPaciente){
            $this->view->euMesmo = 1;
        }else{
            $this->view->euMesmo = 2;
        }
    }

    public function addAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3) {
            $modelTipoUsuario = new Admin_Model_DbTable_TipoUsuario();
            $this->view->dataTipoUsuario = $modelTipoUsuario->getTipoUsuarioPermissao();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function funcionarioAction(){
        if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2 || $this->session_login->coTipoLogin==3) {
            $this->view->dataUsuario = $this->modelUsuario->getAllUsuarioFuncionario();
        }else{
            $this->_helper->redirector("index", "error", 'admin', array('code'=>'403'));
        }
    }

    public function ajaxAddAction(){
        $post = $this->_request->getPost();
        $this->modelUsuario->usuario->insertOne($post);
        die(json_encode(array("msn"=>"200 ok" , "cadastro"=>1)));
    }

    public function ajaxEditAction(){
        $post = $this->_request->getPost();
        $array = array("nm_senha"=>$post["nm_senha"], "co_tipo_usuario"=>$post["co_tipo_usuario"]);
        $this->modelUsuario->usuario->edit($array, $post["co_seq_usuario"]);
        die(json_encode(array("msn"=>"200 ok" , "editado"=>1)));
    }

    public function ajaxRemoveAction(){
        $post = $this->_request->getPost();
        $this->modelUsuario->usuario->excluir($post["id"], "co_seq_usuario");
        die(json_encode(array("msn"=>"200 ok" , "excluido"=>1)));
    }

    public function ajaxChangeAction(){
        $post = $this->_request->getPost();
        try {
            $this->modelUsuario->usuario->edit($post, array("nm_login" => $this->view->session_login->nmLogin));
            die(json_encode(true));
        }catch (Exception $e) {
            die(json_encode(false));
        }
    }

}