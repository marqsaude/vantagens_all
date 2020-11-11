<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 23/08/17
 * Time: 15:53
 */

class Admin_Model_DbTable_Caixa extends Zend_Db_Table_Abstract{

    public $caixa;

    public function init()
    {
        $this->caixa = new Util_ZendModelGeneric();
        $this->caixa->construtor("caixa");
    }

    public function getAllCaixa(){
        $this->caixa->query->from(array("c" => "tb_caixa"), array('*'));
        $this->caixa->query->joinLeft(array("e" => "tb_empresa"), "e.co_seq_empresa=c.co_empresa");
        $this->caixa->query->order('c.dt_inclusao ASC');
        $this->caixa->query->where('c.st_registro = 1');
        $data = $this->caixa->returnQuery();
        return $data;
    }

    public function getCaixa($id){
        $this->caixa->query->from(array("c" => "tb_caixa"), array('*'));
        $this->caixa->query->joinLeft(array("e" => "tb_empresa"), "e.co_seq_empresa=c.co_empresa");
        $this->caixa->query->order('c.dt_inclusao ASC');
        $this->caixa->query->where('c.co_seq_caixa = ?', $id);
        $this->caixa->query->where('c.st_registro = 1');
        $data = $this->caixa->returnQuery();
        return $data;
    }

    public function getCaixaAtivo(){
        $this->caixa->query->from(array("c" => "tb_caixa"), array('*'));
        $this->caixa->query->where('c.st_registro=?', 1);
        $this->caixa->query->where('c.st_ativo=?', 1);
        $data = $this->caixa->returnQuery();
        return isset($data[0])?$data[0]:null;
    }

}