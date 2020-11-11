<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 31/01/17
 * Time: 16:05
 */

class Admin_Model_DbTable_Categoria extends Zend_Db_Table_Abstract{

    public $categoria;

    public function init()
    {
        $this->categoria = new Util_ZendModelGeneric();
        $this->categoria->construtor("categoria");
    }

}