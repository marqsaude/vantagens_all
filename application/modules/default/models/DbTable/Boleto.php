<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 07/12/17
 * Time: 18:01
 */

class Default_Model_DbTable_Boleto  extends Zend_Db_Table_Abstract{

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

    public function clean(){
        $this->init();
    }

}