<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/10/17
 * Time: 16:11
 */

class Default_Model_DbTable_Dependentes  extends Zend_Db_Table_Abstract{

    public $dependentes;

    public function init()
    {
        $this->dependentes = new Util_ZendModelGeneric();
        $this->dependentes->construtor("dependentes");
    }

    public function clean(){
        $this->init();
    }

}