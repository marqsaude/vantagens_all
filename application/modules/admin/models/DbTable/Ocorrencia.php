<?php
/**
 * Created by IntelliJ IDEA.
 * User: tonyandersonbrinckxavier
 * Date: 02/05/2018
 * Time: 18:26
 */

class Admin_Model_DbTable_Ocorrencia extends Zend_Db_Table_Abstract{

    public $ocorrencia;

    public function init()
    {
        $this->ocorrencia = new Util_ZendModelGeneric();
        $this->ocorrencia->construtor("ocorrencia");
    }

    public function getOcorrenciaByCliente($idCliente){
        $this->ocorrencia->query->from(array("o" => "tb_ocorrencia"), array('*'));
        $this->ocorrencia->query->join(array("c" => "tb_cliente"), "c.co_seq_cliente=o.co_cliente");
        $this->ocorrencia->query->join(array("u" => "tb_usuario"), "u.co_seq_usuario=o.co_usuario");
        $this->ocorrencia->query->where('c.co_seq_cliente=?', $idCliente);
        $this->ocorrencia->query->where('o.st_registro=?', 1);
        $data = $this->ocorrencia->returnQuery();
        return $data;
    }

}