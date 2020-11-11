<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 04/01/18
 * Time: 10:10
 */

class Default_Model_DbTable_Procedimento extends  Zend_Db_Table_Abstract{

    public $procedimento;

    public function init()
    {
        $this->procedimento = new Util_ZendModelGeneric();
        $this->procedimento->construtor("procedimento");
    }

    public function getProcedimentos(){
        $this->procedimento->query->from(array("pd" => "tb_procedimento"), array('*'));
        $this->procedimento->query->joinLeft(array("e" => "tb_exame"), "pd.co_exame=e.co_seq_exame");
        $this->procedimento->query->joinLeft(array("c" => "tb_consulta"), "pd.co_consulta=c.co_seq_consulta");
        $this->procedimento->query->joinLeft(array("l" => "tb_laboratorio"), "pd.co_laboratorio=l.co_seq_laboratorio");
        $this->procedimento->query->where('pd.st_registro=?', 1);
        $this->procedimento->query->order('pd.nm_procedimento ASC');
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function updateProcedimentoExame(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql = "SELECT * FROM `tb_exame` WHERE co_tipo_exame=1 ORDER BY `nm_exame` ASC LIMIT 39,98";
        $stmt = $db->query($sql);
        $data = $stmt->fetchAll();
        foreach($data as $value){
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $sql = "UPDATE `tb_exame` SET co_tipo_exame=2 WHERE co_seq_exame=".$value["co_seq_exame"];
            $stmt = $db->query($sql);
        }
    }

    public function clean(){
        $this->init();
    }

}