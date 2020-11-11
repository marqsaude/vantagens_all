<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 06/10/17
 * Time: 09:33
 */

class Admin_Model_DbTable_TipoDependentes extends Zend_Db_Table_Abstract{

    public $tipoDependentes;

    public function init()
    {
        $this->tipoDependentes = new Util_ZendModelGeneric();
        $this->tipoDependentes->construtor("tipo_dependentes");
    }

    public function getAllTipoDependentes(){
        $this->tipoDependentes->query->from(array("td" => "tb_tipo_dependentes"), array('*'));
        $this->tipoDependentes->query->order('td.dt_inclusao ASC');
        $this->tipoDependentes->query->where('td.st_registro=?', 1);
        $data = $this->tipoDependentes->returnQuery();
        return $data;
    }


}