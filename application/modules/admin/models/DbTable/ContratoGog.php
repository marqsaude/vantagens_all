<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 01/09/17
 * Time: 15:20
 */

class Admin_Model_DbTable_ContratoGog  extends Zend_Db_Table_Abstract{

    public $contratoGog;

    public function init()
    {
        $this->contratoGog = new Util_ZendModelGeneric();
        $this->contratoGog->construtor("contrato_gog");
    }

    public function getAllContratoGog(){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->where('cg.st_registro = ?', 1);
        $this->contratoGog->query->order('cg.dt_inclusao ASC');
        $data = $this->contratoGog->returnQuery();
        return $data;
    }

    public function getContratoGog($id){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->where('cg.co_seq_contrato_gog = ?', $id);
        $this->contratoGog->query->where('cg.st_registro = 1');
        $data = $this->contratoGog->returnQuery();
        return $data;
    }

    public function getAcordo($id){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->join(array("a" => "tb_acordo"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->contratoGog->query->where('cg.co_seq_contrato_gog = ?', $id);
        $this->contratoGog->query->where('cg.st_registro = 1');
        $this->contratoGog->query->where('a.st_registro = 1');
        $data = $this->contratoGog->returnQuery();
        return $data;
    }

    public function getContratoByCliente($idCliente){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('*'));
        $this->contratoGog->query->join(array("a" => "tb_acordo"), "cg.co_seq_contrato_gog=a.co_contrato_gog");
        $this->contratoGog->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=a.co_cliente");
        $this->contratoGog->query->join(array("cep" => "tb_cep"), "cep.co_seq_cep=c.co_cep");
        $this->contratoGog->query->where('c.co_seq_cliente = ?', $idCliente);
        $this->contratoGog->query->where('cg.st_registro = 1');
        $this->contratoGog->query->where('a.st_registro = 1');
        $data = $this->contratoGog->returnQuery();
        return $data[0];
    }

    public function getContratoGogProcedimento($id){
        $this->contratoGog->query->from(array("cg" => "tb_contrato_gog"), array('valor_contrato'=>'cg.nu_valor', '*'));
        $this->contratoGog->query->joinLeft(array("rcgp" => "rl_contrato_gog_procedimento"), "rcgp.co_contrato_gog=cg.co_seq_contrato_gog");
        $this->contratoGog->query->joinLeft(array("p" => "tb_procedimento"), "p.co_seq_procedimento=rcgp.co_procedimento");
        $this->contratoGog->query->joinLeft(array("e" => "tb_exame"), "e.co_seq_exame=p.co_exame");
        $this->contratoGog->query->joinLeft(array("c" => "tb_consulta"), "c.co_seq_consulta=p.co_consulta");
        $this->contratoGog->query->where('cg.co_seq_contrato_gog = ?', $id);
        $this->contratoGog->query->where('cg.st_registro = 1');
        //$this->contratoGog->query->where('rcgp.st_registro = 1');
        //$this->contratoGog->query->where('p.st_registro = 1');
        //$this->contratoGog->query->where('e.st_registro = 1');
        //$this->contratoGog->query->where('c.st_registro = 1');
        $dataContratoGog = $this->contratoGog->returnQuery();
        $data = array();
        $i=0;
        foreach($dataContratoGog as $value){
            $data["procedimento"][$i]["nu_procedimento"] = count($dataContratoGog);
            if($value["co_exame"]==null && $value["co_consulta"]==null && $value["co_laboratorio"]==null){
                $data["procedimento"][$i]["tipo"] = null;
                $data["procedimento"][$i]["nome"] = null;
            }else {
                $data["procedimento"][$i]["tipo"] = ($value["co_exame"] == null) ? ($value["co_consulta"] == null) ? "Laboratório" : "Consulta" : "Exame";
                $data["procedimento"][$i]["nome"] = ($value["co_exame"] == null) ? ($value["co_consulta"] == null) ? $value["nm_laboratorio"] : $value["nm_consulta"] : $value["nm_exame"];
            }
            $i++;
        }
        $data["contrato_gog"] = $dataContratoGog[0];
        return $data;
    }

}