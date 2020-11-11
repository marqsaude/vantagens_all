<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/01/18
 * Time: 09:45
 */

class Default_MaisVantagensController extends Zend_Controller_Action {

    private $session_login;
    private $session_gog;
    private $modelProcedimento;

    public function init(){

        $this->session_gog = new Zend_Session_Namespace('Gog');
        $this->session_login = new Zend_Session_Namespace('Login');
        $this->_helper->layout->setLayout("layout");
        $this->modelProcedimento = new Default_Model_DbTable_Procedimento();
        $this->view->isMobile = Util_Util::isMobile();

    }

    public function indexAction(){
        $dataProcedimento = $this->modelProcedimento->getProcedimentos();
        $dataProcedimentoExame = array();
        $dataProcedimentoConsulta = array();
        $dataProcedimentoLaboratorio = array();
        $dataProcedimentoExameRadio = array();
        $i=0;
        $j=0;
        foreach($dataProcedimento as $procedimento){
            if($procedimento["co_exame"]!=null){
                if($procedimento["co_tipo_exame"]==1){
                    $dataProcedimentoExame[$i] = $procedimento;
                    $i++;
                }else if($procedimento["co_tipo_exame"]==2){
                    $dataProcedimentoExameRadio[$j] = $procedimento;
                    $j++;
                }
            }
        }
        $i=0;
        foreach($dataProcedimento as $procedimento){
            if($procedimento["co_consulta"]!=null){
                $dataProcedimentoConsulta[$i] = $procedimento;
                $i++;
            }
        }
        $i=0;
        foreach($dataProcedimento as $procedimento){
            if($procedimento["co_laboratorio"]!=null){
                $dataProcedimentoLaboratorio[$i] = $procedimento;
                $i++;
            }
        }
        $this->view->dataProcedimentoExame = $dataProcedimentoExame;
        $this->view->dataProcedimentoExameRadio = $dataProcedimentoExameRadio;
        $this->view->dataProcedimentoConsulta = $dataProcedimentoConsulta;
        $this->view->dataProcedimentoLaboratorio = $dataProcedimentoLaboratorio;
        $this->view->session_login = $this->session_login;
    }

    public function updateColumnAction(){
        //$this->modelProcedimento->updateProcedimentoExame();
        echo 'Foi!';
        exit;
    }

}