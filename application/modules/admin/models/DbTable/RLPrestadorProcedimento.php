<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 03/11/17
 * Time: 12:29
 */

class Admin_Model_DbTable_RLPrestadorProcedimento extends Zend_Db_Table_Abstract{

    public $prestadorProcedimento;

    public function init()
    {
        $this->prestadorProcedimento = new Util_ZendModelGeneric();
        $this->prestadorProcedimento->construtorRL("prestador_procedimento");
    }

    public function getAllProcedimentoFull($idPrestador){
        $this->prestadorProcedimento->query->from(array("rpp" => "rl_prestador_procedimento"), array('*'));
        $this->prestadorProcedimento->query->join(array("p" => "tb_procedimento"), "rpp.co_procedimento=p.co_seq_procedimento");
        $this->prestadorProcedimento->query->joinLeft(array("e" => "tb_exame"), "p.co_exame=e.co_seq_exame");
        $this->prestadorProcedimento->query->joinLeft(array("c" => "tb_consulta"), "p.co_consulta=c.co_seq_consulta");
        $this->prestadorProcedimento->query->joinLeft(array("l" => "tb_laboratorio"), "p.co_laboratorio=l.co_seq_laboratorio");
        $this->prestadorProcedimento->query->where('rpp.co_prestador=?', $idPrestador);
        $this->prestadorProcedimento->query->where('p.st_registro=?', 1);
        $this->prestadorProcedimento->query->where('rpp.st_registro=?', 1);
        $data = $this->prestadorProcedimento->returnQuery();
        return $data;
    }

    public function clean(){
        $this->init();
    }

}