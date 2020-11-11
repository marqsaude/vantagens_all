<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 17/08/17
 * Time: 15:49
 */


class Default_Model_DbTable_Ddd extends Zend_Db_Table_Abstract{

    public $ddd;

    public function init()
    {
        $this->ddd = new Util_ZendModelGeneric();
        $this->ddd->construtor("ddd");
    }

    public function getDdd($nuDdd){
        $this->ddd->query->from(array("d" => "tb_ddd"), array('*'));
        $this->ddd->query->where('d.st_registro=?', 1);
        $this->ddd->query->where('d.nu_ddd=?', $nuDdd);
        $data = $this->ddd->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}