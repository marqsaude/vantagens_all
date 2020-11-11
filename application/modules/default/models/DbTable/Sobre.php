<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 17/10/17
 * Time: 17:45
 */

class Default_Model_DbTable_Sobre  extends Zend_Db_Table_Abstract{

    public $sobre;

    public function init()
    {
        $this->sobre = new Util_ZendModelGeneric();
        $this->sobre->construtor("sobre");
    }

    public function getAllSobre(){
        $this->sobre->query->from(array("s" => "tb_sobre"), array('*'));
        $this->sobre->query->where('s.st_registro=1');
        $data = $this->sobre->returnQuery();
        return $data[0];
    }

}