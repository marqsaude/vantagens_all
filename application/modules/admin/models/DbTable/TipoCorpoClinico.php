<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 01/11/17
 * Time: 18:02
 */

class Admin_Model_DbTable_TipoCorpoClinico  extends Zend_Db_Table_Abstract{

    public $tipoCorpoClinico;

    public function init()
    {
        $this->tipoCorpoClinico = new Util_ZendModelGeneric();
        $this->tipoCorpoClinico->construtor("tipo_corpo_clinico");
    }

    public function getAllTipoCorpoClinico(){
        $this->tipoCorpoClinico->query->from(array("tcc" => "tb_tipo_corpo_clinico"), array('*'));
        $this->tipoCorpoClinico->query->where('tcc.st_registro=?', 1);
        $data = $this->tipoCorpoClinico->returnQuery();
        return $data;
    }
}