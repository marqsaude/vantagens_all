<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 12/12/17
 * Time: 17:08
 */

class Admin_Model_DbTable_Boleto extends Zend_Db_Table_Abstract{

    public $boleto;

    public function init()
    {
        $this->boleto = new Util_ZendModelGeneric();
        $this->boleto->construtor("boleto");
    }

    public function getCountBoletoByCliente($idCliente){
        $this->boleto->query->from(array("b" => "tb_boleto"), array('count(*) as q'));
        $this->boleto->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=b.co_cliente");
        $this->boleto->query->where('c.co_seq_cliente=?', $idCliente);
        $this->boleto->query->where('b.st_registro=?', 1);
        $data = $this->boleto->returnQuery();
        return $data[0];
    }

    public function getBoletoByCliente($idCliente){
        $this->boleto->query->from(array("b" => "tb_boleto"), array('*'));
        $this->boleto->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=b.co_cliente");
        $this->boleto->query->where('c.co_seq_cliente=?', $idCliente);
        $this->boleto->query->where('b.st_gerado=?', 1);
        $this->boleto->query->where('b.st_registro=?', 1);
        $data = $this->boleto->returnQuery();
        return $data;
    }

    public function getBoletoByClienteNaoPago($idCliente){
        $this->boleto->query->from(array("b" => "tb_boleto"), array('*'));
        $this->boleto->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=b.co_cliente");
        $this->boleto->query->join(array("p" => "tb_pagamento"), "p.co_seq_pagamento=b.co_pagamento");
        $this->boleto->query->where('c.co_seq_cliente=?', $idCliente);
        $this->boleto->query->where('b.st_gerado=?', 1);
        $this->boleto->query->where('b.st_registro=?', 1);
        $data = $this->boleto->returnQuery();
        return $data;
    }

    public function getBoleto($idBoleto){
        $this->boleto->query->from(array("b" => "tb_boleto"), array('*'));
        $this->boleto->query->where('b.co_seq_boleto=?', $idBoleto);
        $this->boleto->query->where('b.st_registro=?', 1);
        $data = $this->boleto->returnQuery();
        return isset($data[0])?$data[0]:null;
    }

    public function getNextBoleto($idCliente){
        $this->boleto->query->from(array("b" => "tb_boleto"), array('*'));
        $this->boleto->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=b.co_cliente");
        $this->boleto->query->join(array("rlct" => "rl_cliente_telefone"), "c.co_seq_cliente=rlct.co_cliente");
        $this->boleto->query->join(array("t" => "tb_telefone"), "t.co_seq_telefone=rlct.co_telefone");
        $this->boleto->query->join(array("d" => "tb_ddd"), "d.co_seq_ddd=t.co_ddd");
        $this->boleto->query->join(array("ce" => "tb_cep"), "ce.co_seq_cep=c.co_cep");
        $this->boleto->query->where('c.co_seq_cliente=?', $idCliente);
        $this->boleto->query->where('b.st_gerado=?', 2);
        $this->boleto->query->where('b.st_registro=?', 1);
        $this->boleto->query->order('b.dt_vencimento ASC');
        $this->boleto->query->limit(1);
        $data = $this->boleto->returnQuery();
        return isset($data[0])?$data[0]:null;
    }

    public function clean(){
        $this->init();
    }

}