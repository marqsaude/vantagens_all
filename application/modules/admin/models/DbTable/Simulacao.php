<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 30/04/2018
 * Time: 17:47
 */

class Admin_Model_DbTable_Simulacao extends Zend_Db_Table_Abstract{

    public $simulacao;

    public function init()
    {
        $this->simulacao = new Util_ZendModelGeneric();
        $this->simulacao->construtor("simulacao");
    }

    public function getAllSimulacao($search="", $page=1, $per=Util_PerPage::simulacaoIndex){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $page = ($page-1)*Util_PerPage::simulacaoIndex;
        $sql = "SELECT `s`.co_seq_simulacao, `s`.nm_cliente, `s`.st_validado, `s`.nm_email, `s`.nu_vezes, `s`.nu_telefone FROM `tb_simulacao` AS `s` WHERE (s.st_registro = 1) AND (s.nm_cliente LIKE '%".$search."%' ) ORDER BY `s`.`dt_inclusao` DESC LIMIT ".intval($per)." OFFSET ".$page;
        $stmt = $db->query($sql);
        $data["data"] = $stmt->fetchAll();
        $data["count"] = $this->getCount();
        return $data;
    }

    public function getSimulacao($id){
        $this->simulacao->query->from(array("s" => "tb_simulacao"), array('dt_inclusao_simulacao'=>'s.dt_inclusao', '*'));
        $this->simulacao->query->joinLeft(array("cg" => "tb_contrato_gog"), "s.co_contrato_gog=cg.co_seq_contrato_gog");
        $this->simulacao->query->joinLeft(array("fp" => "tb_forma_pagamento"), "s.co_forma_pagamento=fp.co_seq_forma_pagamento");
        $this->simulacao->query->order('s.dt_inclusao ASC');
        $this->simulacao->query->where('s.co_seq_simulacao = ?', $id);
        $this->simulacao->query->where('s.st_registro = 1');
        $data = $this->simulacao->returnQuery();
        return $data[0];
    }

    private function getCount(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "select count(*) as contador from tb_simulacao where st_registro=1 ";
        $stmt = $db->query($sql);
        $users =  $stmt->fetchAll();
        return $users[0]["contador"];
    }

}