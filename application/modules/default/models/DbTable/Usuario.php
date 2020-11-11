<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/08/15
 * Time: 11:57
 */

class Default_Model_DbTable_Usuario extends Zend_Db_Table_Abstract{

    public $usuario;

    public function init()
    {
        $this->usuario = new Util_ZendModelGeneric();
        $this->usuario->construtor("usuario");
    }

    public function getUsuarioNotificadoContato(){
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro=?', 1);
        $this->usuario->query->where('u.co_tipo_usuario IN(?)', array(1,2,3));
        $data = $this->usuario->returnQuery();
        return $data;
    }

    public function getUsuarioNotificadoNewsletter(){
        $this->usuario->query->from(array("u" => "tb_usuario"), array('*'));
        $this->usuario->query->where('u.st_registro=?', 1);
        $this->usuario->query->where('u.co_tipo_usuario IN(?)', array(1,2,3));
        $data = $this->usuario->returnQuery();
        return $data;
    }

}