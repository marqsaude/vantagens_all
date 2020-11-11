<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/08/17
 * Time: 14:43
 */

class Default_Model_DbTable_Acordo extends Zend_Db_Table_Abstract{

    public $acordo;

    public function init()
    {
        $this->acordo = new Util_ZendModelGeneric();
        $this->acordo->construtor("acordo");
    }

    public function getAcordoBYCliente($idCliente){
        $this->acordo->query->from(array("a" => "tb_acordo"), array('*'));
        $this->acordo->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->acordo->query->where('c.st_registro=?', 1);
        $this->acordo->query->where('c.co_seq_cliente=?', $idCliente);
        $data = $this->acordo->returnQuery();
        return $data[0];
    }

}