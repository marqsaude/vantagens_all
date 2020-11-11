<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/08/17
 * Time: 17:32
 */

class Admin_Model_DbTable_TipoUsuario extends Zend_Db_Table_Abstract {

    public $tipoUsuario;

    public function init()
    {
        $this->tipoUsuario = new Util_ZendModelGeneric();
        $this->tipoUsuario->construtor("tipo_usuario");
    }

    public function getAllTipoUsuario(){
        $this->tipoUsuario->query->from(array("tu" => "tb_tipo_usuario"), array('*'));
        $this->tipoUsuario->query->where('tu.st_registro = ?', 1);
        $data = $this->tipoUsuario->returnQuery();
        return $data;
    }

    public function getTipoUsuarioPermissao($id=null){
        $session_login = new Zend_Session_Namespace('Login');
        $array = array();
        for($i=0; $i<$session_login->coTipoLogin; $i++){
            array_push($array, ($i+1));
        }
        //if($id!=null) {
            array_push($array, 4);
        //}
        $this->tipoUsuario->query->from(array("tu" => "tb_tipo_usuario"), array('*'));
        $this->tipoUsuario->query->where('tu.co_seq_tipo_usuario NOT IN (?)', $array);
        $this->tipoUsuario->query->where('tu.st_registro = ?', 1);
        $this->tipoUsuario->query->order('tu.co_seq_tipo_usuario ASC');
        $data = $this->tipoUsuario->returnQuery();
        return $data;
    }

}