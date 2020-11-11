<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 19/09/17
 * Time: 15:26
 */

class Admin_Model_DbTable_Prestador  extends Zend_Db_Table_Abstract{

    public $prestador;

    public function init()
    {
        $this->prestador = new Util_ZendModelGeneric();
        $this->prestador->construtor("prestador");
    }

    public function getAllPrestador($notIn = null){
        $this->prestador->query->from(array("p" => "tb_prestador"), array('*'));
        $this->prestador->query->where('p.st_registro = ?', 1);
        if($notIn!=null){
            $this->prestador->query->where('p.co_seq_prestador NOT IN (?)', $notIn);
        }
        $this->prestador->query->order('p.dt_inclusao ASC');
        $data = $this->prestador->returnQuery();
        return $data;
    }

    public function getPrestador($id){
        $this->prestador->query->from(array("p" => "tb_prestador"), array('*'));
        $this->prestador->query->where('p.st_registro = ?', 1);
        $this->prestador->query->where('p.co_seq_prestador = ?', $id);
        $this->prestador->query->order('p.dt_inclusao ASC');
        $data = $this->prestador->returnQuery();
        return (isset($data[0]))?$data[0]:null;
    }

}