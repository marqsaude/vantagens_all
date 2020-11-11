<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 22/09/17
 * Time: 09:33
 */

class Default_Model_DbTable_Caixa  extends Zend_Db_Table_Abstract{

    public $caixa;

    public function init()
    {
        $this->caixa = new Util_ZendModelGeneric();
        $this->caixa->construtor("caixa");
    }

    public function getCaixaAtivo(){
        $this->caixa->query->from(array("c" => "tb_caixa"), array('*'));
        $this->caixa->query->where('c.st_registro=?', 1);
        $this->caixa->query->where('c.st_ativo=?', 1);
        $data = $this->caixa->returnQuery();
        return $data;
    }

}