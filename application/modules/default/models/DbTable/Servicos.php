<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 13/10/17
 * Time: 15:46
 */

class Default_Model_DbTable_Servicos extends Zend_Db_Table_Abstract{

    public $servicos;

    public function init()
    {
        $this->servicos = new Util_ZendModelGeneric();
        $this->servicos->construtor("servicos");
    }

    public function getAllServicos(){
        $this->servicos->query->from(array("s" => "tb_servicos"), array('*'));
        $this->servicos->query->order('s.dt_inclusao ASC');
        $this->servicos->query->where('s.st_registro = 1');
        $data = $this->servicos->returnQuery();
        return $data;
    }

    public function getServicos($id){
        $this->servicos->query->from(array("s" => "tb_servicos"), array('*'));
        $this->servicos->query->join(array("u" => "tb_usuario"), "u.co_seq_usuario=s.co_usuario");
        $this->servicos->query->order('s.dt_inclusao ASC');
        $this->servicos->query->where('s.co_seq_servicos = ?', $id);
        $this->servicos->query->where('s.st_registro = 1');
        $data = $this->servicos->returnQuery();
        return $data[0];
    }

}