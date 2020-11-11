<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/08/17
 * Time: 11:39
 */

class Admin_Model_DbTable_RLClienteTelefone extends Zend_Db_Table_Abstract{

    public $clienteTelefone;

    public function init()
    {
        $this->clienteTelefone = new Util_ZendModelGeneric();
        $this->clienteTelefone->construtorRL("cliente_telefone");
    }

}