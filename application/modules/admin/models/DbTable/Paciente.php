<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 26/08/15
 * Time: 11:57
 */

class Admin_Model_DbTable_Paciente extends Zend_Db_Table_Abstract{

    public $paciente;

    public function init()
    {
        $this->paciente = new Util_ZendModelGeneric();
        $this->paciente->construtor("paciente");
    }

    public function getAllPaciente(){
        $this->paciente->query->from(array("p" => "tb_paciente"), array('*'));
        $this->paciente->query->where('p.st_registro = ?', 1);
        $this->paciente->query->order('p.dt_inclusao ASC');
        $data = $this->paciente->returnQuery();
        return $data;
    }


}