<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 23/08/17
 * Time: 16:45
 */

class Admin_Model_DbTable_Empresa extends Zend_Db_Table_Abstract{

    public $empresa;

    public function init()
    {
        $this->empresa = new Util_ZendModelGeneric();
        $this->empresa->construtor("empresa");
    }

    public function getAllEmpresa(){
        $this->empresa->query->from(array("e" => "tb_empresa"), array('*'));
        $this->empresa->query->where('e.st_registro = ?', 1);
        $this->empresa->query->order('e.dt_inclusao ASC');
        $data = $this->empresa->returnQuery();
        return $data;
    }

}