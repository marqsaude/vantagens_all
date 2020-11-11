<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 24/08/17
 * Time: 18:08
 */

class Admin_Model_DbTable_TipoPrestador  extends Zend_Db_Table_Abstract{

    public $tipoPrestador;

    public function init()
    {
        $this->tipoPrestador = new Util_ZendModelGeneric();
        $this->tipoPrestador->construtor("tipo-prestador");
    }

    public function getAllPrestador(){
        $this->tipoPrestador->query->from(array("tp" => "tb_tipo_prestador"), array('*'));
        $this->tipoPrestador->query->where('tp.st_registro=?', 1);
        $data = $this->tipoPrestador->returnQuery();
        return $data;
    }

}