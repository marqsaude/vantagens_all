<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 10:07
 */

class Default_Model_DbTable_Exame extends Zend_Db_Table_Abstract{

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

    public function getExame($id){
        $this->exame->query->from(array("e" => "tb_exame"), array('*'));
        $this->exame->query->joinLeft(array("rep" => "rl_exame_prestador"), "rep.co_exame=e.co_seq_exame");
        $this->exame->query->joinLeft(array("p" => "tb_prestador"), "p.co_seq_prestador=rep.co_prestador");
        $this->exame->query->joinLeft(array("tp" => "tb_tipo_prestador"), "p.co_tipo_prestador=tp.co_seq_tipo_prestador");
        $this->exame->query->where('e.co_seq_exame = ?', $id);
        $this->exame->query->where('e.st_registro = 1');
        $dataExame = $this->exame->returnQuery();
        $data = array();
        $i=0;
        foreach($dataExame as $value){
            $data["prestador"][$i][$value["nm_prestador"]] = $value["nm_prestador"];
            $data["prestador"][$i][$value["nm_tipo_prestador"]] = $value["nm_tipo_prestador"];
            $data["prestador"][$i][$value["nu_login"]] = $value["nu_login"];
            $i++;
        }
        $data["exame"] = $dataExame[0];
        return $data;
    }

    public function getExameAddProcedimento(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "select * from tb_exame e where not exists (select * from tb_procedimento p where e.co_seq_exame = p.co_exame)";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

}