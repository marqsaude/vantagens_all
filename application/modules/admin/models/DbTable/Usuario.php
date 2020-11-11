<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 20/04/16
 * Time: 15:48
 */

class Admin_Model_DbTable_Usuario extends Zend_Db_Table_Abstract{

    public $usuario;

    public function init()
    {
        $this->usuario = new Util_ZendModelGeneric();
        $this->usuario->construtor("usuario");
    }

    public function getAllUsuario(){
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro = ?', 1);
        $this->usuario->query->order('u.dt_inclusao ASC');
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function getAllUsuarioSistema(){
        $array = array(1,2,3,5,6);
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro = ?', 1);
        $this->usuario->query->where('u.co_tipo_usuario IN (?)', $array);
        $this->usuario->query->order('u.dt_inclusao ASC');
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function getAllUsuarioFuncionario(){
        $array = array(6);
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro = ?', 1);
        $this->usuario->query->where('u.co_tipo_usuario IN (?)', $array);
        $this->usuario->query->order('u.dt_inclusao ASC');
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function checkLogin($nm_login, $nm_senha){
        $this->usuario->query->from(array("u" => "tb_usuario"), array('registro_acordo'=>'a.st_registro', '*'));
        $this->usuario->query->joinLeft(array("c" => "tb_cliente"), "c.co_usuario=u.co_seq_usuario");
        $this->usuario->query->joinLeft(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->usuario->query->where('u.nm_login = ?', $nm_login);
        $this->usuario->query->where('u.nm_senha = ?', $nm_senha);
        //$this->usuario->query->where('c.st_cliente = ?', 1);
        //$this->usuario->query->where('a.st_registro = ?', 1);
        $this->usuario->query->where('u.st_registro = ?', 1);
        $data = $this->usuario->returnQuery();
        //$dataLogin = array("valid"=> (count($data)>0)?true:false, "data"=>$data);
        return $data;
    }

    public function getVendedor(){
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro = ?', 1);
        $this->usuario->query->where('u.co_tipo_usuario = ?', 5);
        $this->usuario->query->orwhere('u.co_seq_usuario = ?', 5);
        $this->usuario->query->order('u.dt_inclusao ASC');
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function getUsuarioPermissao($id=null){
        $session_login = new Zend_Session_Namespace('Login');
        $array = array();
        for($i=0; $i<$session_login->coTipoLogin; $i++){
            array_push($array, ($i+1));
        }
        if($session_login->coTipoLogin==4){
            array_push($array, 4);
            array_push($array, 5);
        }else{
            array_push($array, 4);
        }
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->joinLeft(array("tu" => "tb_tipo_usuario"), "u.co_tipo_usuario=tu.co_seq_tipo_usuario");
        if($id!=null) {
            $this->usuario->query->where('u.co_seq_usuario = ?', $id);
        }
        $this->usuario->query->where('tu.co_seq_tipo_usuario NOT IN (?)', $array);
        $this->usuario->query->where('u.st_registro = ?', 1);
        $this->usuario->query->order('u.dt_inclusao ASC');
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}