<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/10/17
 * Time: 14:37
 */

class Admin_Model_DbTable_BuscaAutoincrementoCliente extends Zend_Db_Table_Abstract{

    public $buscaAutoincrementoCliente;

    public function init()
    {
        $this->buscaAutoincrementoCliente = new Util_ZendModelGeneric();
        $this->buscaAutoincrementoCliente->construtorView("busca_autoincremento_cliente");
    }

    public function getAllAutoIncremento(){
        $select = $this->buscaAutoincrementoCliente->select();
        $select1 = "SELECT co_seq_exame as id, nm_exame as nome, 'exame' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_exame WHERE st_registro=1";
        $select2 = "SELECT co_seq_consulta as id, nm_consulta as nome, 'consulta' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_consulta WHERE st_registro=1";
        $select3 = "SELECT co_seq_cliente as id, nm_cliente as nome, 'cliente' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_cliente WHERE st_registro=1";
        $select4 = "SELECT co_seq_caixa as id, nm_caixa as nome, 'caixa' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_caixa WHERE st_registro=1";
        $select5 = "SELECT co_seq_prestador as id, nm_prestador as nome, 'prestador' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_prestador WHERE st_registro=1";
        $select6 = "SELECT co_seq_contrato_gog as id, nm_contrato_gog as nome, 'contrato-gog' as tipo, nm_inclusao, dt_inclusao, nm_alteracao, dt_alteracao, st_registro FROM tb_contrato_gog WHERE st_registro=1";
        $s = $select->union(array($select1,$select2,$select3,$select4, $select5, $select6), Zend_Db_Select::SQL_UNION_ALL);
        $stmt = $s->query();
        return $stmt->fetchAll();
    }

    public function getAutoIncremento($key){
        $this->buscaAutoincrementoCliente->query->from(array("vwbac" => "vw_busca_autoincremento_cliente"), array('*'));
        $this->buscaAutoincrementoCliente->query->order('vwbac.dt_inclusao ASC');
        $this->buscaAutoincrementoCliente->query->where("vwbac.st_registro = ?", 1);
        $this->buscaAutoincrementoCliente->query->where("vwbac.nome LIKE '%".$key."%'");
        $data = $this->buscaAutoincrementoCliente->returnQuery();
        return $data;
    }

}