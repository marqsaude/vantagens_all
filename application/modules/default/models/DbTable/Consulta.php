<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 10:09
 */

class Default_Model_DbTable_Consulta extends Zend_Db_Table_Abstract{

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
        $this->consulta->query->joinLeft(array("rcp" => "rl_consulta_prestador"), "rcp.co_consulta=c.co_seq_consulta");
        $this->consulta->query->joinLeft(array("p" => "tb_prestador"), "p.co_seq_prestador=rcp.co_prestador");
        $this->consulta->query->joinLeft(array("tp" => "tb_tipo_prestador"), "p.co_tipo_prestador=tp.co_seq_tipo_prestador");
        $this->consulta->query->where('c.co_seq_consulta = ?', $id);
        $this->consulta->query->where('c.st_registro = 1');
        $dataConsulta = $this->consulta->returnQuery();
        $data = array();
        $i=0;
        foreach($dataConsulta as $value){
            $data["prestador"][$i][$value["nm_prestador"]] = $value["nm_prestador"];
            $data["prestador"][$i][$value["nm_tipo_prestador"]] = $value["nm_tipo_prestador"];
            $data["prestador"][$i][$value["nu_login"]] = $value["nu_login"];
            $i++;
        }
        $data["consulta"] = $dataConsulta[0];
        return $data;
    }

    public function geConsultaAddProcedimento(){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $sql =  "";
        $sql .= "select * from tb_consulta c where not exists (select * from tb_procedimento p where c.co_seq_consulta = p.co_consulta)";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

}