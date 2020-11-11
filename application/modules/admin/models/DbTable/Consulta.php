<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 10:09
 */

class Admin_Model_DbTable_Consulta extends Zend_Db_Table_Abstract{

    public $consulta;

    public function init()
    {
        $this->consulta = new Util_ZendModelGeneric();
        $this->consulta->construtor("consulta");
    }

    public function getAllConsulta(){
        $this->consulta->query->from(array("c" => "tb_consulta"), array('*'));
        $this->consulta->query->where('c.st_registro = ?', 1);
        $this->consulta->query->order('c.nm_consulta ASC');
        $data = $this->consulta->returnQuery();
        return $data;
    }

    public function getConsulta($id){
        $this->consulta->query->from(array("c" => "tb_consulta"), array('*'));
        $this->consulta->query->joinLeft(array("p" => "tb_procedimento"), "p.co_consulta=c.co_seq_consulta");
        $this->consulta->query->where('c.co_seq_consulta = ?', $id);
        $this->consulta->query->where('c.st_registro = 1');
        $this->consulta->query->where('p.st_registro = 1');
        $dataConsulta = $this->consulta->returnQuery();
        /*$data = array();
        $i=0;
        foreach($dataConsulta as $value){
            $data["prestador"][$i]["nm_prestador"] = $value["nm_prestador"];
            $data["prestador"][$i]["co_seq_prestador"] = $value["co_seq_prestador"];
            $i++;
        }
        $data["consulta"] = $dataConsulta[0];*/
        return $dataConsulta[0];
    }

    public function geConsultaAddProcedimento(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "select * from tb_consulta c where not exists (select * from tb_procedimento p where c.co_seq_consulta = p.co_consulta)";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllConsultaProcedimentoAtivo(){
        $this->consulta->query->from(array("c" => "tb_consulta"), array('*'));
        $this->consulta->query->where('c.st_registro = ?', 1);
        $this->consulta->query->where('c.st_procedimento = ?', 2);
        $this->consulta->query->order('c.nm_consulta ASC');
        $data = $this->consulta->returnQuery();
        return $data;
    }

    public function editConsultaProcedimento($id){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "UPDATE tb_consulta AS c INNER JOIN tb_procedimento p ON p.co_consulta = c.co_seq_consulta SET c.st_procedimento = 1 where c.co_seq_consulta=".$id;
        $stmt = $db->query($sql);
        return $stmt;
    }

}