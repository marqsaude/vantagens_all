<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 09:40
 */

class Admin_Model_DbTable_Perguntas extends Zend_Db_Table_Abstract{

    public $perguntas;

    public function init()
    {
        $this->perguntas = new Util_ZendModelGeneric();
        $this->perguntas->construtor("perguntas");
    }

    public function getAllPerguntas(){
        $this->perguntas->query->from(array("p" => "tb_perguntas"), array('*'));
        $this->perguntas->query->where('p.st_registro = ?', 1);
        $this->perguntas->query->order('p.dt_inclusao ASC');
        $data = $this->perguntas->returnQuery();
        return $data;
    }

    public function getPerguntas($id){
        $this->perguntas->query->from(array("p" => "tb_perguntas"), array('*'));
        $this->perguntas->query->where('p.st_registro = ?', 1);
        $this->perguntas->query->where('p.co_seq_perguntas = ?', $id);
        $this->perguntas->query->order('p.dt_inclusao ASC');
        $data = $this->perguntas->returnQuery();
        return (isset($data[0]))?$data[0]:null;
    }

}