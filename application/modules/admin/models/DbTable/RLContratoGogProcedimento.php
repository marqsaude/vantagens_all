<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/10/17
 * Time: 17:28
 */

class Admin_Model_DbTable_RLContratoGogProcedimento  extends Zend_Db_Table_Abstract{

    public $contratoGogProcedimento;

    public function init()
    {
        $this->contratoGogProcedimento = new Util_ZendModelGeneric();
        $this->contratoGogProcedimento->construtorRL("contrato_gog_procedimento");
    }

}