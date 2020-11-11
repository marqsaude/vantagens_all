<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 27/09/17
 * Time: 11:53
 */

class Admin_Model_DbTable_Cartao extends Zend_Db_Table_Abstract{

    public $cartao;

    public function init()
    {
        $this->cartao = new Util_ZendModelGeneric();
        $this->cartao->construtor("cartao");
    }

    public function getByClienteAtivo($idCliente){
        $this->cartao->query->from(array("c" => "tb_cartao"), array('*'));
        $this->cartao->query->order('c.dt_inclusao ASC');
        $this->cartao->query->where('c.co_cliente = ?', $idCliente);
        $this->cartao->query->where('c.st_registro = ?', 1);
        $this->cartao->query->where('c.st_cartao = ?', 1);
        $data = $this->cartao->returnQuery();
        return (!empty($data) && isset($data[0]))?$data[0]:null;
    }

    public function getByDependenteAtivo($idDependente){
        $this->cartao->query->from(array("c" => "tb_cartao"), array('*'));
        $this->cartao->query->join(array("d" => "tb_dependentes"), "d.co_seq_dependentes=c.co_dependentes");
        $this->cartao->query->join(array("a" => "tb_acordo"), "d.co_acordo=a.co_seq_acordo");
        $this->cartao->query->join(array("cl" => "tb_cliente"), "cl.co_seq_cliente=a.co_cliente");
        $this->cartao->query->order('c.dt_inclusao ASC');
        $this->cartao->query->where('c.co_dependentes = ?', $idDependente);
        $this->cartao->query->where('c.st_registro = ?', 1);
        $this->cartao->query->where('c.st_cartao = ?', 1);
        $data = $this->cartao->returnQuery();
        return (!empty($data) && isset($data[0]))?$data[0]:null;
    }

    public function clean(){
        $this->init();
    }

}