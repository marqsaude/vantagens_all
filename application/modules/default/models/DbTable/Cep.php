<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 14/08/17
 * Time: 18:06
 */

class Default_Model_DbTable_Cep extends Zend_Db_Table_Abstract{

    public $cep;

    public function init()
    {
        $this->cep = new Util_ZendModelGeneric();
        $this->cep->construtor("cep");
    }

    public function getByCep($nuCep){
        $this->cep->query->from(array("c" => "tb_cep"), array('*'));
        $this->cep->query->where('c.st_registro=?', 1);
        $this->cep->query->where('c.nu_cep=?', $nuCep);
        $data = $this->cep->returnQuery();
        return $data;
    }

}