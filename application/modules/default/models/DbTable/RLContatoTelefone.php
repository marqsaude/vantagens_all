<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/09/17
 * Time: 17:42
 */

class Default_Model_DbTable_RLContatoTelefone extends Zend_Db_Table_Abstract{

    public $contatoTelefone;

    public function init()
    {
        $this->contatoTelefone = new Util_ZendModelGeneric();
        $this->contatoTelefone->construtorRL("contato_telefone");
    }

}