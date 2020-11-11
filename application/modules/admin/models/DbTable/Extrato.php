<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 13/12/17
 * Time: 12:14
 */

class Admin_Model_DbTable_Extrato extends Zend_Db_Table_Abstract{

    public $extrato;

    public function init()
    {
        $this->extrato = new Util_ZendModelGeneric();
        $this->extrato->construtor("extrato");
    }

    public function getExtrato($idCaixa){
        /*$this->extrato->query->from(array("e" => "tb_extrato"), array('*'));
        $this->extrato->query->join(array("c" => "tb_caixa"), "e.co_caixa=c.co_seq_caixa");
        $this->extrato->query->join(array("p" => "tb_pagamento"), "e.co_pagamento=p.co_seq_pagamento");
        $this->extrato->query->join(array("fp" => "tb_forma_pagamento"), "p.co_forma_pagamento=fp.co_seq_forma_pagamento");
        $this->extrato->query->join(array("a" => "tb_acordo"), "p.co_acordo=a.co_seq_acordo");
        $this->extrato->query->join(array("cl" => "tb_cliente"), "a.co_cliente=cl.co_seq_cliente");
        $this->extrato->query->order('e.dt_inclusao DESC');
        $this->extrato->query->where('c.co_seq_caixa = ?', $idCaixa);
        $this->extrato->query->where('e.st_registro = 1');
        $this->extrato->query->where('c.st_registro = 1');
        $data = $this->extrato->returnQuery();*/

        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql  = "";
            $sql .= "select e.co_seq_extrato, e.st_pagamento, e.nu_valor_transacao, e.nu_id_boleto, e.dt_inclusao as 'data_extrato', fp.nm_forma_pagamento, fp.co_seq_forma_pagamento, p.co_status_pagamento, cl.nm_cliente, cl.st_cliente ";
            $sql .= "from tb_extrato e ";
            $sql .= "inner join tb_caixa c on e.co_caixa=c.co_seq_caixa ";
            $sql .= "inner join tb_pagamento p on e.co_pagamento=p.co_seq_pagamento ";
            $sql .= "inner join tb_forma_pagamento fp on p.co_forma_pagamento=fp.co_seq_forma_pagamento ";
            $sql .= "inner join tb_acordo a on p.co_acordo=a.co_seq_acordo ";
            $sql .= "inner join tb_cliente cl on a.co_cliente=cl.co_seq_cliente ";
            $sql .= "where c.co_seq_caixa =".$idCaixa." AND e.st_registro = 1 AND c.st_registro = 1 ";
            $sql .= "order by e.dt_inclusao DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoBoleto($idPagamento, $idBoleto){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.nu_id_boleto=" . $idBoleto . " and e.st_pagamento=2 and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoBoletoRemove($idPagamento, $idBoleto){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=2, c.nu_saldo=(select SUM(c.nu_saldo - e.nu_valor_transacao)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.nu_id_boleto=" . $idBoleto . " and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editByCodePagSeguro($code){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where p.tx_id_pagseguro='" . $code . "' and e.st_pagamento=2 and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editByCodePagSeguroRemove($code){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=2, c.nu_saldo=(select SUM(c.nu_saldo - e.nu_valor_transacao)) ";
            $sql .= " where p.tx_id_pagseguro='" . $code . "' and e.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoDinheiro($idPagamento){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.st_pagamento=2 and e.st_registro=1 and p.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoDinheiroRemove($idPagamento){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=2, c.nu_saldo=(select SUM(c.nu_saldo - e.nu_valor_transacao)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.st_registro=1 and p.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoCartaoPresencial($idPagamento){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.st_pagamento=2 and e.st_registro=1 and p.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoCartaoPresencialRemove($idPagamento){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=2, c.nu_saldo=(select SUM(c.nu_saldo - e.nu_valor_transacao)) ";
            $sql .= " where p.co_seq_pagamento=" . $idPagamento . " and e.st_registro=1 and p.st_registro=1";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

    public function editExtratoDinheiroAll(){
        try {
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "";
            $sql .= "update tb_extrato e ";
            $sql .= " inner join tb_pagamento p on p.co_seq_pagamento=e.co_pagamento ";
            $sql .= " inner join tb_caixa c on c.co_seq_caixa=e.co_caixa ";
            $sql .= " set e.st_pagamento=1, c.nu_saldo=(select SUM(e.nu_valor_transacao + c.nu_saldo)) ";
            $sql .= " where e.st_pagamento=2 and e.st_registro=1 and p.st_registro=1 and p.co_forma_pagamento=6";
            $stmt = $db->query($sql);
            return 1;
        }catch (Exception $e){
            echo $e->getMessage();
            return 2;
        }
    }

}