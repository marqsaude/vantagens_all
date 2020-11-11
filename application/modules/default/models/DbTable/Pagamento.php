<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/08/17
 * Time: 15:28
 */

class Default_Model_DbTable_Pagamento extends Zend_Db_Table_Abstract{

    public $pagamento;

    public function init()
    {
        $this->pagamento = new Util_ZendModelGeneric();
        $this->pagamento->construtor("pagamento");
    }

}