<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 15/08/17
 * Time: 10:03
 */

class Default_Model_DbTable_Telefone extends Zend_Db_Table_Abstract{

    public $telefone;

    public function init()
    {
        $this->telefone = new Util_ZendModelGeneric();
        $this->telefone->construtor("telefone");
    }

    public function getByTelefone($nuTelefone, $nuDDD){
        $this->telefone->query->from(array("t" => "tb_telefone"), array('*'));
        $this->telefone->query->where('t.st_registro=?', 1);
        $this->telefone->query->where('t.nu_telefone=?', $nuTelefone);
        $this->telefone->query->where('t.nu_ddd=?', $nuDDD);
        return $this->telefone->returnQuery();
    }

}