<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/01/18
 * Time: 16:08
 */

class Admin_Model_DbTable_TipoExame extends Zend_Db_Table_Abstract {

    public $tipoExame;

    public function init(){
        $this->tipoExame = new Util_ZendModelGeneric();
        $this->tipoExame->construtor("tipo_exame");
    }

    public function getAllTipoExame(){
        $this->tipoExame->query->from(array("te" => "tb_tipo_exame"), array('*'));
        $this->tipoExame->query->where('te.st_registro = ?', 1);
        $data = $this->tipoExame->returnQuery();
        return $data;
    }

}