<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 20/03/17
 * Time: 15:17
 */

class Gog_CartaoMarqController extends Zend_Controller_Action
{

    private $session_login;
    private $session_gog;
    public $posts;

    public function init()
    {

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('LoginGog');
        if ($this->session_login->logado == NULL) {
            $this->session_login->logado = false;
        }
        $this->view->session_login = $this->session_login;
        $this->_helper->layout->setLayout("layout-gog");

    }

    public function indexAction()
    {

    }

    public function addClienteAction(){

    }

    public function finalizarAction(){

    }

    public function ajaxVerifyVantagensAction(){
        $modelContratoGog = new Gog_Model_DbTable_ContratoGog();
        $dataContratoGog = $modelContratoGog->getAllContratoGog();
        if(count($dataContratoGog)>0){
            die(json_encode(array("registro" => true, "count" => count($dataContratoGog), "data" => $dataContratoGog)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

    public function ajaxDependenteSessionAction(){
        $post = $this->_request->getPost();
        $j=0;
        $i=0;
        $dependente = array();
        foreach($post as $key => $value){
            if($i==7){
                $this->session_gog->dependentes[$j]=$dependente;
                $j++;
                $i=0;
                $dependente[preg_replace('/[0-9]+/', '', $key)] = $value;
            }else{
                $dependente[preg_replace('/[0-9]+/', '', $key)] = $value;
                $i++;
            }
        }
        $this->session_gog->dependentes[$j]=$dependente;
        die(json_encode(array("session" => true)));
    }

    public function ajaxClienteSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cliente = $post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxTelefoneSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->telefone=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxCartaoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cartao=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxPagamentoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->pagamento=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxCepSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->cep=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxAcordoSessionAction(){
        $post = $this->_request->getPost();
        $this->session_gog->acordo=$post;
        die(json_encode(array("session" => true)));
    }

    public function ajaxGetFormaPagamentoAction(){
        $modelFormaPagamento = new Gog_Model_DbTable_FormaPagamento();
        $dataFormaPagamento = $modelFormaPagamento->getAllFormaPagamento();
        if(count($dataFormaPagamento)>0){
            die(json_encode(array("registro" => true, "count" => count($dataFormaPagamento), "data" => $dataFormaPagamento)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

    public function ajaxGetTipoDependentesAction(){
        $modelTipoDependentes = new Gog_Model_DbTable_TipoDependentes();
        $dataTipoDependentes = $modelTipoDependentes->getAllTipoDependentes();
        if(count($dataTipoDependentes)>0){
            die(json_encode(array("registro" => true, "count" => count($dataTipoDependentes), "data" => $dataTipoDependentes)));
        }else{
            die(json_encode(array("registro" => false, "count" => 0, "data" => "")));
        }
    }

}