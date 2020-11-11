<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/10/17
 * Time: 09:13
 */

class Default_Model_DbTable_Perguntas extends Zend_Db_Table_Abstract{

    public $perguntas;

    public function init()
    {
        $this->perguntas = new Util_ZendModelGeneric();
        $this->perguntas->construtor("perguntas");
    }

}