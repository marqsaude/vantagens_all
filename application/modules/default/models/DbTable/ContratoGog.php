<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 30/03/17
 * Time: 17:06
 */

class Default_Model_DbTable_ContratoGog extends Zend_Db_Table_Abstract{

    public $contratoGog;

    public function init()
    {
        $this->contratoGog = new Util_ZendModelGeneric();
        $this->contratoGog->construtor("contrato_gog");
    }

    public function getAllContratoGog(){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->order('cg.dt_inclusao ASC');
        $this->contratoGog->query->where('cg.st_registro=?', 1);
        $data = $this->contratoGog->returnQuery();
        return $data;
    }

    public function getContratoGog($id){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->where('cg.st_registro=?', 1);
        $this->contratoGog->query->where('cg.co_seq_contrato_gog=?', $id);
        $data = $this->contratoGog->returnQuery();
        return $data;
    }


}