<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 08:44
 */

class Admin_Model_DbTable_Procedimento  extends Zend_Db_Table_Abstract{

    public $procedimento;

    public function init()
    {
        $this->procedimento = new Util_ZendModelGeneric();
        $this->procedimento->construtor("procedimento");
    }

    public function getAllProcedimento(){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->where('p.st_registro=?', 1);
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function getProcedimento($idProcedimento){
        $this->procedimento->query->from(array("pd" => "tb_procedimento"), array('*'));
        $this->procedimento->query->joinLeft(array("e" => "tb_exame"), "pd.co_exame=e.co_seq_exame");
        $this->procedimento->query->joinLeft(array("c" => "tb_consulta"), "pd.co_consulta=c.co_seq_consulta");
        $this->procedimento->query->joinLeft(array("l" => "tb_laboratorio"), "pd.co_laboratorio=l.co_seq_laboratorio");
        $this->procedimento->query->where('pd.co_seq_procedimento=?', $idProcedimento);
        $this->procedimento->query->where('pd.st_registro=?', 1);
        $data = $this->procedimento->returnQuery();
        return $data[0];
    }

    public function getEditProcedimentoPrestador($idProcedimento){
        $data = array();
        $data["procedimento"] = $this->getProcedimento($idProcedimento);
        $data["prestador"] = null;
        $this->init();
        $dataProcedimento = $this->getProcedimentoPrestador($idProcedimento);
        $i=0;
        foreach($dataProcedimento as $value){
            $data["prestador"][$i]["nm_prestador"] = $value["nm_prestador"];
            $data["prestador"][$i]["co_seq_prestador"] = $value["co_seq_prestador"];
            $i++;
        }
        return $data;
    }

    public function getProcedimentoPrestador($idProcedimento){
        $this->procedimento->query->from(array("pd" => "tb_procedimento"), array('*'));
        $this->procedimento->query->joinLeft(array("rpp" => "rl_prestador_procedimento"), "pd.co_seq_procedimento=rpp.co_procedimento");
        $this->procedimento->query->joinLeft(array("pt" => "tb_prestador"), "pt.co_seq_prestador=rpp.co_prestador");
        $this->procedimento->query->where('rpp.st_registro=?', 1);
        $this->procedimento->query->where('pd.co_seq_procedimento=?', $idProcedimento);
        $this->procedimento->query->where('pd.st_registro=?', 1);
        $this->procedimento->query->where('pt.st_registro=?', 1);
        return $this->procedimento->returnQuery();
    }

    public function getAllProcedimentoFull($arrayIn=null){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->joinLeft(array("e" => "tb_exame"), "p.co_exame=e.co_seq_exame");
        $this->procedimento->query->joinLeft(array("c" => "tb_consulta"), "p.co_consulta=c.co_seq_consulta");
        $this->procedimento->query->joinLeft(array("l" => "tb_laboratorio"), "p.co_laboratorio=l.co_seq_laboratorio");
        if($arrayIn!=null){
            $this->procedimento->query->where('p.co_seq_procedimento NOT IN (?)', $arrayIn);
        }
        $this->procedimento->query->where('p.st_registro=?', 1);
        $this->procedimento->query->order(array('e.nm_exame ASC', 'c.nm_consulta ASC', 'l.nm_laboratorio ASC'));
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function checkProcedimentoExame($idExame){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("e" => "tb_exame"), "p.co_exame=e.co_seq_exame");
        $this->procedimento->query->where('p.co_exame=?', $idExame);
        $this->procedimento->query->where('p.st_registro=?', 1);
        $data = $this->procedimento->returnQuery();
        return (isset($data[0]))?$data[0]:null;
    }

    public function checkProcedimentoConsulta($idConsulta){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("c" => "tb_consulta"), "p.co_consulta=c.co_seq_consulta");
        $this->procedimento->query->where('p.co_consulta=?', $idConsulta);
        $this->procedimento->query->where('p.st_registro=?', 1);
        $data = $this->procedimento->returnQuery();
        return (isset($data[0]))?$data[0]:null;
    }

    public function checkProcedimentoLaboratorio($idLaboratorio){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("l" => "tb_laboratorio"), "p.co_laboratorio=l.co_seq_laboratorio");
        $this->procedimento->query->where('p.co_laboratorio=?', $idLaboratorio);
        $this->procedimento->query->where('p.st_registro=?', 1);
        $data = $this->procedimento->returnQuery();
        return (isset($data[0]))?$data[0]:null;
    }

    public function getProcedimentoExame(){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("e" => "tb_exame"), "p.co_exame=e.co_seq_exame");
        $this->procedimento->query->where('p.st_registro=?', 1);
        $this->procedimento->query->where('e.st_registro=?', 1);
        $this->procedimento->query->order('e.nm_exame ASC');
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function getProcedimentoLaboratorio(){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("l" => "tb_laboratorio"), "p.co_laboratorio=l.co_seq_laboratorio");
        $this->procedimento->query->where('p.st_registro=?', 1);
        $this->procedimento->query->where('l.st_registro=?', 1);
        $this->procedimento->query->order('l.nm_laboratorio ASC');
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function getProcedimentoConsulta(){
        $this->procedimento->query->from(array("p" => "tb_procedimento"), array('*'));
        $this->procedimento->query->join(array("c" => "tb_consulta"), "p.co_consulta=c.co_seq_consulta");
        $this->procedimento->query->where('p.st_registro=?', 1);
        $this->procedimento->query->where('c.st_registro=?', 1);
        $this->procedimento->query->order('c.nm_consulta ASC');
        $data = $this->procedimento->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}