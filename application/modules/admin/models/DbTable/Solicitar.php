<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/02/16
 * Time: 14:55
 */

class Admin_Model_DbTable_Solicitar extends Zend_Db_Table_Abstract{

    public $solicitar;

    public function init()
    {
        $this->solicitar = new Util_ZendModelGeneric();
        $this->solicitar->construtor("solicitar");
    }

    public function getAllSolicitar($coSolicitacao){
        $this->solicitar->query->from(array("s" => "tb_solicitar"), array('*'));
        $this->solicitar->query->where('s.co_paciente='.$coSolicitacao.' AND s.st_registro=1');
        $data = $this->solicitar->returnQuery();
        return $data;
    }


}