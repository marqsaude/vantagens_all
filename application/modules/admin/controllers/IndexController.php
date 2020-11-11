<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/08/15
 * Time: 02:22
 */

class Admin_IndexController extends Zend_Controller_Action{

    public $data;
    private $modelContato;
    public $session_login;

    public function init(){

        $this->session_login = new Zend_Session_Namespace('Login');
        $this->view->coTipoLogin = $this->session_login->coTipoLogin;
        $this->_helper->layout->setLayout("layoutAdmin");
        if(!Util_Util::isAjax()){
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $this->view->dataContatoN = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            if($this->session_login->coTipoLogin==1 || $this->session_login->coTipoLogin==2) {
                $modelCaixa = new Admin_Model_DbTable_Caixa();
                $this->view->dataCaixaE = $modelCaixa->getCaixaAtivo();
            }else
            if($this->session_login->coTipoLogin==3) {
                $modelCliente = new Admin_Model_DbTable_Cliente();
                $this->view->dataCaixaE = $modelCliente->getClienteFuncionario($this->session_login->coSeqPaciente);
            }else
            if($this->session_login->coTipoLogin==5){
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
        //$this->view->dataContatoV = $this->modelContato->getContatoVisualizado();
        //var_dump($cardNumver->getNumberCard());exit;
        /*$numero = new Util_Cript();
        $valueCript=$numero->encrypt("8371481176838284");
        $tete = $numero->decrypt($valueCript);
        $aux  = $this->view->baseUrl().'/adm/qr_img0.50j/php/qr_img.php?';
        $aux .= 'd='.$valueCript;
        $aux .= 'e=H&';
        $aux .= 's=7&';
        $aux .= 't=P';

        echo '<div style="float: left; border: 1px solid;">';
		echo	'<img src="'.$aux.'" /';
		echo '</div>';
        exit;*/
        $tpVisualizacao = array(1);
        switch($this->session_login->coTipoLogin){
            case 1:
                array_push($tpVisualizacao, 2);
                array_push($tpVisualizacao, 3);
                break;
            case 2:
                array_push($tpVisualizacao, 2);
                break;
            case 3:
                array_push($tpVisualizacao, 2);
                break;
            case 4:
                array_push($tpVisualizacao, 3);
                break;
            case 5:
                array_push($tpVisualizacao, 3);
                break;
        }
        $modelBlog = new Admin_Model_DbTable_Blog();
        $this->view->dataBlog = $modelBlog->getBlogs($tpVisualizacao);
        //var_dump(Util_Util::getDateNameDayNameMonth("2016-06-24"));exit;
        //var_dump($this->view->dataBlog);exit;

    }

    public function viewAction(){
        $idBlog = $this->getParam("id");
        $modelBlog = new Admin_Model_DbTable_Blog();
        $this->view->dataBlog = $modelBlog->blog->get($idBlog);
        $modelBlog->clean();
        $this->view->dataProcedimentoBlog = $modelBlog->getProcedimentos($idBlog);
    }

}