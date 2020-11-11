<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 30/04/2018
 * Time: 17:47
 */

class Default_Model_DbTable_Simulacao extends Zend_Db_Table_Abstract{

    public $simulacao;

    public function init()
    {
        $this->simulacao = new Util_ZendModelGeneric();
        $this->simulacao->construtor("simulacao");
    }

    public function getAllSimulacao(){
        $this->simulacao->query->from(array("s" => "tb_simulacao"), array('*'));
        $this->simulacao->query->order('s.dt_inclusao ASC');
        $this->simulacao->query->where('s.st_registro = 1');
        $data = $this->simulacao->returnQuery();
        return $data;
    }

    public function getSimulacao($id){
        $this->simulacao->query->from(array("s" => "tb_simulacao"), array('*'));
        $this->simulacao->query->order('s.dt_inclusao ASC');
        $this->simulacao->query->where('s.co_seq_simulacao = ?', $id);
        $this->simulacao->query->where('s.st_registro = 1');
        $data = $this->simulacao->returnQuery();
        return $data[0];
    }

}