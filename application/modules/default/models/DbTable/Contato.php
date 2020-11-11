<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 25/08/15
 * Time: 12:11
 */

class Default_Model_DbTable_Contato extends Zend_Db_Table_Abstract{

    public $contato;

    public function init()
    {
        $this->contato = new Util_ZendModelGeneric();
        $this->contato->construtor("contato");
    }

}