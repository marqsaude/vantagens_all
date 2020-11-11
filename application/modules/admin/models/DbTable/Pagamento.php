<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 12/12/17
 * Time: 19:05
 */

class Admin_Model_DbTable_Pagamento extends Zend_Db_Table_Abstract{

    public $pagamento;

    public function init()
    {
        $this->pagamento = new Util_ZendModelGeneric();
        $this->pagamento->construtor("pagamento");
    }

    public function getByCliente($idCliente){
        $this->pagamento->query->from(array("p" => "tb_pagamento"), array('*'));
        $this->pagamento->query->join(array("a" => "tb_acordo"), "p.co_acordo=a.co_seq_acordo");
        $this->pagamento->query->join(array("c" => "tb_cliente"), "a.co_cliente=c.co_seq_cliente");
        $this->pagamento->query->where('c.co_seq_cliente = ?', $idCliente);
        $this->pagamento->query->where('c.st_registro = 1');
        $dataPagamento = $this->pagamento->returnQuery();
        return $dataPagamento[0];
    }

    public function insertCodePagSeguro($idPagamento, $txIdPagseguro){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "UPDATE tb_pagamento SET tx_id_pagseguro='".$txIdPagseguro."' where co_seq_pagamento=".$idPagamento;
        $stmt = $db->query($sql);
        return $stmt;
    }

    public function clean(){
        $this->init();
    }

}