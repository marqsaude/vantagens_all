<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 16/11/17
 * Time: 09:31
 */

class Admin_Model_DbTable_Acordo extends Zend_Db_Table_Abstract{

    public $acordo;

    public function init()
    {
        $this->acordo = new Util_ZendModelGeneric();
        $this->acordo->construtor("acordo");
    }

    public function getAllAcordo(){
        $this->acordo->query->from(array("a" => "tb_acordo"), array('*'));
        $this->acordo->query->order('a.dt_inclusao ASC');
        $this->acordo->query->where('a.st_registro = ?', 1);
        $data = $this->acordo->returnQuery();
        return $data;
    }

    public function getAcordo($idAcordo){
        $this->acordo->query->from(array("a" => "tb_acordo"), array('*'));
        $this->acordo->query->order('a.dt_inclusao ASC');
        $this->acordo->query->where('a.st_registro = ?', 1);
        $this->acordo->query->where('a.co_seq_acordo = ?', $idAcordo);
        $data = $this->acordo->returnQuery();
        return $data;
    }

    public function getAcordoByUsuario($idUsuario){
        $this->acordo->query->from(array("a" => "tb_acordo"), array('*'));
        $this->acordo->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->acordo->query->join(array("u" => "tb_usuario"), "u.co_seq_usuario=c.co_usuario");
        $this->acordo->query->order('a.dt_inclusao ASC');
        $this->acordo->query->where('a.st_registro = ?', 1);
        $this->acordo->query->where('u.co_seq_usuario = ?', $idUsuario);
        $data = $this->acordo->returnQuery();
        return $data;
    }

    public function getAcordoPlanoByUsuario($idUsuario){
        $this->acordo->query->from(array("a" => "tb_acordo"), array('*'));
        $this->acordo->query->join(array("cg" => "tb_contrato_gog"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->acordo->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->acordo->query->join(array("u" => "tb_usuario"), "u.co_seq_usuario=c.co_usuario");
        $this->acordo->query->order('a.dt_inclusao ASC');
        $this->acordo->query->where('a.st_registro = ?', 1);
        $this->acordo->query->where('u.co_seq_usuario = ?', $idUsuario);
        $data = $this->acordo->returnQuery();
        return $data;
    }

}