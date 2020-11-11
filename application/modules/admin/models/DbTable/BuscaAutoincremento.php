<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 05/09/17
 * Time: 09:36
 */

class Admin_Model_DbTable_BuscaAutoincremento extends Zend_Db_Table_Abstract{

    public $buscaAutoincremento;

    public function init()
    {
        $this->buscaAutoincremento = new Util_ZendModelGeneric();
        $this->buscaAutoincremento->construtorView("busca_autoincremento");
    }

    public function getAllAutoIncremento(){
        $select = $this->buscaAutoincremento->select();
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
        $this->buscaAutoincremento->query->from(array("vwba" => "vw_busca_autoincremento"), array('*'));
        $this->buscaAutoincremento->query->order('vwba.dt_inclusao ASC');
        $this->buscaAutoincremento->query->where("vwba.st_registro = ?", 1);
        $this->buscaAutoincremento->query->where("vwba.tipo<>'usuario'");
        $this->buscaAutoincremento->query->where("vwba.nome LIKE '%".$key."%'");
        $data = $this->buscaAutoincremento->returnQuery();
        return $data;
    }

}