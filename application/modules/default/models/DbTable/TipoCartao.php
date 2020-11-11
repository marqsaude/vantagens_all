<?php
/**
 * Created by IntelliJ IDEA.
 * User: tony
 * Date: 01/08/17
 * Time: 16:28
 */

class Default_Model_DbTable_TipoCartao extends Zend_Db_Table_Abstract{

    public $tipoCartao;

    public function init()
    {
        $this->tipoCartao = new Util_ZendModelGeneric();
        $this->tipoCartao->construtor("tipo_cartao");
    }

    public function getAll(){
        $this->tipoCartao->query->from(array("tc" => "tb_tipo_cartao"), array('*'));
        $this->tipoCartao->query->order('tc.dt_inclusao ASC');
        $this->tipoCartao->query->where('tc.st_registro=?', 1);
        $data = $this->tipoCartao->returnQuery();
        return $data;
    }


}