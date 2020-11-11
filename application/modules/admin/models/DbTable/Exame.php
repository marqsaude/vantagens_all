<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 10:07
 */

class Admin_Model_DbTable_Exame extends Zend_Db_Table_Abstract{

    public $exame;

    public function init()
    {
        $this->exame = new Util_ZendModelGeneric();
        $this->exame->construtor("exame");
    }

    public function getAllExame(){
        $this->exame->query->from(array("e" => "tb_exame"), array('*'));
        $this->exame->query->where('e.st_registro = 1');
        $this->exame->query->order('e.nm_exame ASC');
        $data = $this->exame->returnQuery();
        return $data;
    }

    public function getAllExameProcedimentoAtivo(){
        $this->exame->query->from(array("e" => "tb_exame"), array('*'));
        $this->exame->query->where('e.st_registro = 1');
        $this->exame->query->where('e.st_procedimento = 2');
        $this->exame->query->order('e.nm_exame ASC');
        $data = $this->exame->returnQuery();
        return $data;
    }

    public function getExame($id){
        $this->exame->query->from(array("e" => "tb_exame"), array('*'));
        $this->exame->query->joinLeft(array("p" => "tb_procedimento"), "p.co_exame=e.co_seq_exame");
        //$this->exame->query->joinLeft(array("rpp" => "rl_prestador_procedimento"), "rpp.co_procedimento=p.co_seq_procedimento");
        //$this->exame->query->joinLeft(array("pr" => "tb_prestador"), "pr.co_seq_prestador=rpp.co_prestador");
        $this->exame->query->where('e.co_seq_exame = ?', $id);
        $this->exame->query->where('e.st_registro = 1');
        $dataExame = $this->exame->returnQuery();
        /*$data = array();
        $i=0;
        foreach($dataExame as $value){
            $data["prestador"][$i]["nm_prestador"] = $value["nm_prestador"];
            $data["prestador"][$i]["co_seq_prestador"] = $value["co_seq_prestador"];
            $i++;
        }
        $data["exame"] = $dataExame[0];*/
        return $dataExame[0];
    }

    public function getExameAddProcedimento(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "select * from tb_exame e where not exists (select * from tb_procedimento p where e.co_seq_exame = p.co_exame)";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public function editExameProcedimento($id){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "UPDATE tb_exame AS e INNER JOIN tb_procedimento p ON p.co_exame = e.co_seq_exame SET e.st_procedimento = 1 where e.co_seq_exame=".$id;
        $stmt = $db->query($sql);
        return $stmt;
    }

}