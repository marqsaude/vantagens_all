<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 17/10/17
 * Time: 15:38
 */

class Admin_Model_DbTable_Laboratorio  extends Zend_Db_Table_Abstract{

    public $laboratorio;

    public function init()
    {
        $this->laboratorio = new Util_ZendModelGeneric();
        $this->laboratorio->construtor("laboratorio");
    }

    public function getAllLaboratorio(){
        $this->laboratorio->query->from(array("l" => "tb_laboratorio"), array('*'));
        $this->laboratorio->query->where('l.st_registro = 1');
        $this->laboratorio->query->order('l.nm_laboratorio ASC');
        $data = $this->laboratorio->returnQuery();
        return $data;
    }

    public function getAllLaboratorioProcedimentoAtivo(){
        $this->laboratorio->query->from(array("l" => "tb_laboratorio"), array('*'));
        $this->laboratorio->query->where('l.st_registro = 1');
        $this->laboratorio->query->where('l.st_procedimento = 2');
        $this->laboratorio->query->order('l.nm_laboratorio ASC');
        $data = $this->laboratorio->returnQuery();
        return $data;
    }

    public function getLaboratorio($id){
        $this->laboratorio->query->from(array("l" => "tb_laboratorio"), array('*'));
        $this->laboratorio->query->joinLeft(array("p" => "tb_procedimento"), "p.co_laboratorio=l.co_seq_laboratorio");
        $this->laboratorio->query->where('l.co_seq_laboratorio = ?', $id);
        $this->laboratorio->query->where('l.st_registro = 1');
        $dataLaboratorio = $this->laboratorio->returnQuery();
        return $dataLaboratorio[0];
    }

    public function editLaboratorioProcedimento($id){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "UPDATE tb_laboratorio AS l INNER JOIN tb_procedimento p ON p.co_laboratorio = l.co_seq_laboratorio SET l.st_procedimento = 1 where l.co_seq_laboratorio=".$id;
        $stmt = $db->query($sql);
        return $stmt;
    }

}