<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 06/04/17
 * Time: 15:13
 */

class Default_Model_DbTable_FormaPagamento extends Zend_Db_Table_Abstract{

    public $formaPagamento;

    public function init()
    {
        $this->formaPagamento = new Util_ZendModelGeneric();
        $this->formaPagamento->construtor("forma_pagamento");
    }

    public function getAllFormaPagamento($arrayIds){
        $this->formaPagamento->query->from(array("fp" => "tb_forma_pagamento"), array('*'));
        $this->formaPagamento->query->order('fp.dt_inclusao ASC');
        $this->formaPagamento->query->where('fp.st_registro=?', 1);
        $this->formaPagamento->query->where('fp.co_seq_forma_pagamento IN (?)', $arrayIds);
        $data = $this->formaPagamento->returnQuery();
        return $data;
    }


}