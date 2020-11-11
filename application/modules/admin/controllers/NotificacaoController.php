<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 23/09/17
 * Time: 10:56
 */

class Admin_NotificacaoController extends Zend_Controller_Action {

    private $post;
    public $session_login;

    public function init(){
        $this->session_login = new Zend_Session_Namespace('Login');
    }

    public function ajaxNotificacaoContatoAction(){
        if($this->session_login->coTipoLogin!=4) {
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $dataNotificacaoContato = $modelNotificacaoContato->getNotificacaoVisualizado($this->session_login->coSeqPaciente);
            foreach($dataNotificacaoContato as $key=>$value){
                $dataNotificacaoContato[$key]["dt_inclusao"] = Util_Util::getDataClient($value["dt_inclusao"]);
            }
            die(json_encode(array("msn"=>"200 ok" , "data"=>$dataNotificacaoContato)));
        }else{
            die(json_encode(array("msn"=>"Sem permissão de acesso!" , "data"=>"")));
        }
    }

    public function ajaxClearNotificacaoContatoAction(){
        if($this->session_login->coTipoLogin!=4) {
            $modelNotificacaoContato = new Admin_Model_DbTable_NotificacaoContato();
            $array = array("st_visualizado"=>1);
            $arrayWhere = array("co_usuario"=>$this->session_login->coSeqPaciente);
            $modelNotificacaoContato->notificacaoContato->edit($array, $arrayWhere);
            die(json_encode(array("msn"=>"200 ok" , "data"=>"")));
        }else{
            die(json_encode(array("msn"=>"Sem permissão de acesso!" , "data"=>"")));
        }
    }

}