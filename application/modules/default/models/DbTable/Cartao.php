<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/09/17
 * Time: 11:53
 */

class Default_Model_DbTable_Cartao extends Zend_Db_Table_Abstract{

    public $cartao;

    public function init()
    {
        $this->cartao = new Util_ZendModelGeneric();
        $this->cartao->construtor("cartao");
    }

    public function getByCliente($idCliente){
        $this->cartao->query->from(array("c" => "tb_cartao"), array('*'));
        $this->cartao->query->order('c.dt_inclusao ASC');
        $this->cartao->query->where('c.co_cliente = ?', $idCliente);
        $this->cartao->query->where('c.st_registro = ?', 1);
        $data = $this->cartao->returnQuery();
        return (!empty($data) && isset($data[0]))?$data[0]:null;
    }

    public function getCartao($idCartao){
        $this->cartao->query->from(array("c" => "tb_cartao"), array('*'));
        $this->cartao->query->order('c.dt_inclusao ASC');
        $this->cartao->query->where('c.co_seq_cartao = ?', $idCartao);
        $this->cartao->query->where('c.st_registro = ?', 1);
        $data = $this->cartao->returnQuery();
        return (!empty($data) && isset($data[0]))?$data[0]:null;
    }

    public function clean(){
        $this->init();
    }

}