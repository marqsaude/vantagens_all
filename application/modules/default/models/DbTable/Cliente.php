<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 29/03/17
 * Time: 10:16
 */

class Default_Model_DbTable_Cliente extends Zend_Db_Table_Abstract{

    public $cliente;

    public function init()
    {
        $this->cliente = new Util_ZendModelGeneric();
        $this->cliente->construtor("cliente");
    }

    public function getAllCliente(){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return $data;
    }

    public function getClienteByEmail($email){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('c.nm_email = ?', $email);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return $data;
    }

    public function isExistCpf($cpf){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->where('c.nu_cpf = ?', $cpf);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return (!empty($data) && isset($data[0]))?2:1;
    }

    public function getClienteByIdPagSeguro($idPagSeguro){
        $this->cliente->query->from(array("c" => "tb_cliente"), array('*'));
        $this->cliente->query->join(array("a" => "tb_acordo"), "a.co_cliente=c.co_seq_cliente");
        $this->cliente->query->join(array("cg" => "tb_contrato_gog"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->cliente->query->join(array("p" => "tb_pagamento"), "p.co_acordo=a.co_seq_acordo");
        $this->cliente->query->order('c.dt_inclusao ASC');
        $this->cliente->query->where('p.tx_id_pagseguro = ?', $idPagSeguro);
        $this->cliente->query->where('c.st_registro = ?', 1);
        $data = $this->cliente->returnQuery();
        return (!empty($data) && isset($data[0]))?$data[0]:null;
    }

    public function editClienteUserByCodeEmail($code, $senha){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_usuario u ";
            $sql .= "inner join tb_cliente c on u.co_seq_usuario=c.co_usuario ";
            $sql .= "inner join tb_email e on c.co_seq_cliente=e.co_cliente ";
            $sql .= "set u.nm_senha='" . $senha . "', c.st_muda_senha=2 ";
            $sql .= "where e.nm_code='" . $code . "'";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function clean(){
        $this->init();
    }

}